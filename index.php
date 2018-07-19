<?php
  $publicKey = openssl_pkey_get_public(file_get_contents('./key.pem'));

  $body = file_get_contents('php://input');

  $signature = base64_decode($_SERVER['HTTP_X_MESSAGEMEDIA_SIGNATURE']);
  $digest_type = $_SERVER['HTTP_X_MESSAGEMEDIA_DIGEST_TYPE'];
  $date = $_SERVER['HTTP_DATE'];

  $data = "POST /mm-rsa-test/ HTTP/1.1".$date.$body;

  $ok = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA224);
  if ($ok == 1) {
      echo "Verified!";
  } elseif ($ok == 0) {
      echo "Not from MessageMedia";
  } else {
      echo "Error whilst checking request signature.";
  }
?>
