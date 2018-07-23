<?php
  $publicKey = openssl_pkey_get_public(file_get_contents('./public_key.pem'));
  $body = file_get_contents('php://input');

  $signature = base64_decode($_SERVER['HTTP_X_MESSAGEMEDIA_SIGNATURE']); //"g5ciIx+pWaT7p3ZeGmWKFqx3z2LmBdaMweCdL7+Lv0+4TBS4Ccdp7yxbgBOZp8XXwNPlTCnVeV0MDdHia32kvs3s77fLoInR/C0EKQTo+1hD0m5qKE8DzC5jCRtYiBNuoTYjjwrrfuz/0KTTeRzsZt/PC/4lF1u4fcYTkIlEy+4nf/QdRCs2AgFWEGATEx7UCrTPgwxoKXZXEkoicWhFIKnY4mRCITbNYQmPAmbaW1vLzbqJiy7z7zRL+a4qXOvj341dCGieo8Rkq5sfpJUXdv7rz+PINwhJaqWOoK/wj0n2iT3fd0eLRoyDl9YBznJDlME5XgveQuE8gdU1hzIiag==";
  $date = $_SERVER['HTTP_DATE']; // "Wed, 18 Jul 2018 06:33:52 GMT";

  $data = "POST / HTTP/1.1".$date.$body;

  $ok = openssl_verify($data, $signature, $publicKey, OPENSSL_ALGO_SHA256);
  if ($ok == 1) {
      echo "Verification Successful";
  } elseif ($ok == 0) {
      echo "Verification Failed";
  } else {
      echo "Error whilst checking request signature.";
  }
?>
