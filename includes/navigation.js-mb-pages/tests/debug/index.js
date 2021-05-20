require('mapbox.js');
require('leaflet-hash');
var request = require('request');
var debounce = require('debounce');
var endpoint = 'https://api.mapbox.com/directions/v5/mapbox/driving/';
var polyline = require('polyline');

// Setup map
L.mapbox.accessToken = 'pk.eyJ1IjoiYm9iYnlzdWQiLCJhIjoiTi16MElIUSJ9.Clrqck--7WmHeqqvtFdYig';
var map = L.mapbox.map('map').setView([39.9229, -75.1351], 14);
L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v8', {
    maxZoom: 21
}).addTo(map);
L.hash(map);
var marker = L.marker([0, 0]).addTo(map);
var routeGeoJSON = L.layerGroup().addTo(map);
var previousUserPoint = { type: 'Feature', properties: {}, geometry: { type: 'Point', coordinates: [] }};
var userLocation = { type: 'Feature', properties: {}, geometry: { type: 'Point', coordinates: [] }};
L.geoJson(require('../fixtures/downtown').routes[0].geometry).addTo(routeGeoJSON);

var activeRoute = require('../fixtures/downtown').routes[0];
var stepDiv = document.getElementById('step');
var userArrow = document.getElementById('user-arrow');
var turnArrow = document.getElementById('turn-arrow');

// Navigation.js can handle both geometries=polyline and geometries=geojson
// However, the Mapbox directions API will default to geometries=geojson
var geometries = 'polyline';
// var geometries = 'geojson';

// Setup navigation.js
var navigation = require('../../')({
    units: 'miles',
    maxReRouteDistance: 0.03,
    maxSnapToLocation: 0.01
});

// Alwats set the initial step to 0
var currentStep = 0;
var userBearing = 0;

var hasSpokenHighAlert = false;
var hasSpokenMediumAlert = false;
var hasSpokenLowAlert = false;

map.on('mousemove', function(e) {
    if (previousUserPoint.geometry.coordinates.length > 1) {
        if ((previousUserPoint.geometry.coordinates[1] !== e.latlng.lat) || (previousUserPoint.geometry.coordinates[0] !== e.latlng.lng)) {
            userBearing = getBearing(previousUserPoint.geometry.coordinates[1], previousUserPoint.geometry.coordinates[0], e.latlng.lat, e.latlng.lng);
        }
    }

    // Rotate the user arrow according to their heading
    rotateImage(userArrow, userBearing);

    userLocation.geometry.coordinates[0] = e.latlng.lng;
    userLocation.geometry.coordinates[1] = e.latlng.lat;

    var stepInfo = navigation.getCurrentStep(userLocation, activeRoute.legs[0], currentStep, false);
    var feetDistance = Math.round(stepInfo.distance * 5280 / 100) * 100;
    var distanceInstruction = feetDistance > 0 ? 'In ' + feetDistance + ' feet ' : '';
    var instruction = activeRoute.legs[0].steps[stepInfo.step + 1].maneuver.instruction;

    // Display whether user should reroute in UI
    document.getElementById('reroute').innerHTML = stepInfo.shouldReRoute;

    // If the user is off the route, `shouldReRoute` will be true
    // In this case, recalculate the route, clear the current route, add the new route
    // and most importantly, reset the currentStep to 0
    if (stepInfo.shouldReRoute) {
        getRoute(e.latlng.lng, e.latlng.lat, -75.118674, 39.94156, userBearing, function(err, route) {
            routeGeoJSON.clearLayers();
            stepDiv.classList.remove('flash');
            stepDiv.classList.remove('flashonce');
            resetAlerts();

            // This example shows how to handle both encoded polylines and GeoJSON
            if (typeof route.routes[0].geometry === 'string') {
                L.geoJson(polyline.toGeoJSON(route.routes[0].geometry)).addTo(routeGeoJSON);
            } else {
                L.geoJson(route.routes[0].geometry).addTo(routeGeoJSON);
            }

            activeRoute = route.routes[0];
            currentStep = 0;
        });
    }

    // Flash the instructions to signal to the user the maneuver is coming up soon
    if (stepInfo.alertUserLevel.high && !hasSpokenHighAlert) {
        hasSpokenHighAlert = true;
        speak(instruction);
        if (!stepDiv.classList.contains('flash')) stepDiv.classList.add('flash');
    } else if (stepInfo.alertUserLevel.medium && !hasSpokenMediumAlert) {
        hasSpokenMediumAlert = true;
        speak(distanceInstruction + ' ' + instruction);
        if (!stepDiv.classList.contains('flashonce')) stepDiv.classList.add('flashonce');
    } else if (stepInfo.alertUserLevel.low && !hasSpokenLowAlert) {
        hasSpokenLowAlert = true;
        speak(distanceInstruction + ' ' + instruction);
        if (!stepDiv.classList.contains('flashonce')) stepDiv.classList.add('flashonce');
    }

    // console.log(hasSpokenLowAlert, hasSpokenMediumAlert, hasSpokenHighAlert);

    // Rotate the next step maneuver angle
    rotateImage(turnArrow, activeRoute.legs[0].steps[stepInfo.step + 1].maneuver.bearing_after);

    // Get the instruction of the next step and display it
    document.getElementById('step').innerHTML = 'In ' + feetDistance + 'ft ' + instruction;
    previousUserPoint = userLocation;
    previousTime = +new Date();
    // Snap the marker to closest point along the route
    marker.setLatLng([stepInfo.snapToLocation.geometry.coordinates[1], stepInfo.snapToLocation.geometry.coordinates[0]]);

    // If the calculated step is greater than the users current step, update it
    // This means the user completed the current step. Also, turn off flashing
    if (stepInfo.step > currentStep) {
        currentStep = stepInfo.step;
        var fullDistance = activeRoute.legs[0].steps[currentStep].distance > 91.44 ? 'In ' + Math.round(activeRoute.legs[0].steps[currentStep].distance / 0.3048 / 100) * 100 + ' feet ' : '';
        speak(fullDistance + instruction);
        resetAlerts();
        stepDiv.classList.remove('flash');
        stepDiv.classList.remove('flashonce');
    }
});

var getRoute = debounce(function(fromLng, fromLat, toLng, toLat, bearing, callback) {
    var b = bearing === 360 ? 359 : bearing;
    request(endpoint + fromLng + ',' + fromLat + ';' + toLng + ',' + toLat + '.json?geometries=' + geometries + '&overview=full&steps=true&bearings=' + b + ',90;&access_token=pk.eyJ1IjoiYm9iYnlzdWQiLCJhIjoiTi16MElIUSJ9.Clrqck--7WmHeqqvtFdYig', function(err, res, body) {
        if (err) return callback(err);
        if (body && res.statusCode === 200) return callback(null, JSON.parse(body));
    });
}, 1000);

var speak = debounce(function(textToSpeak) {
    window.speechSynthesis.speak(new SpeechSynthesisUtterance(textToSpeak));
}, 1000);

function resetAlerts() {
    hasSpokenHighAlert = false;
    hasSpokenMediumAlert = false;
    hasSpokenLowAlert = false;
}

function getBearing(lat1, lng1, lat2, lng2) {
    var dLon = (lng2 - lng1);
    var y = Math.sin(dLon) * Math.cos(lat2);
    var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLon);
    var bearing = Math.atan2(y, x) * 180 / Math.PI;
    return 360 - ((bearing + 360) % 360);
}


function rotateImage(div, bearing) {
    div.style.transform = 'rotate(' + bearing + 'deg)';
    div.style['-webkit-transform'] = 'rotate(' + bearing + 'deg)';
    div.style['-ms-transform'] = 'rotate(' + bearing + 'deg)';
}
