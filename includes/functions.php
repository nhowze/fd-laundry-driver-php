<?php


//EncryptString
function encryptString($stringToencrypt) {

    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($stringToencrypt, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
  
    return $ciphertext;
  }
  
  
  //DecryptString
  function decryptingString($stringToDecrypting) {
  
    $c = base64_decode($stringToDecrypting);
    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len=32);
    $ciphertext_raw = substr($c, $ivlen+$sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
    if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
    {
      return $original_plaintext;
    }
  
  }
  
  
  
  
  //Difference between dates
  function diffDate($start, $final){
  
    $date1 = new DateTime($start);
    $date2 = new DateTime($final);
    $interval = $date1->diff($date2);
  
    // shows the total amount of days (not divided into years, months and days like above)
    return $interval->days;
  
  }
  
  
  //Generate Random String
  function getRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
  
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
  
    return $string;
  }
  


?>