<?php 

$serveKey = "SB-Mid-server-VTMjzGT9QwM3JjS6x0cAVUMj";

$isProduction = false;

$baseUrl = $isProduction ? 
'https://app.midtrans.com/snap/v1/transactions' :
'https://app.sandbox.midtrans.com/snap/v1/transactions';

if (strpos($_SERVER['REQUEST_URL'],'/charge')) {
  http_response_code(404);
  echo 'Salah Path or Server Error'; exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  http_response_code(404);
  echo 'Halaman tidak ada';
}

$requestBody = file_get_contents('php://input');
header('Content-Type: application/json');

$chargeHasil = chargeAPI($baseUrl,$serveKey,$requestBody);

http_response_code($chargeHasil['http_code']);

echo $chargeHasil['body'];

function chargeAPI($baseUrl,$serveKey,$requestBody) {
  $ch = curl_init();
  $curlOptions = array(
    CURLOPT_URL => $baseUrl,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_PORT => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept : application/json',
      'Authorization: Basic'. base64_decode($serveKey)
    ),
    CURLOPT_POSTFIELDS => $requestBody
  );
  curl_setopt_array($ch,$curlOptions);
  $hasil = array(
    'body' => curl_exec($ch),
    'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
  );
  return $hasil;
}



?>