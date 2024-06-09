<?php
// INCLUDE ACCESS TOKEN FILE
include 'accessToken.php';

date_default_timezone_set('Africa/Nairobi');

$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
$callbackurl = 'https://mydomain.com/path';
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');

// Data encryption to get password
$password = base64_encode($BusinessShortCode . $passkey . $Timestamp);

$phone = '254708374149';
$money = '1';
$PartyA = $phone;
$PartyB = '174379';
$AccountReference = 'CompanyXLTD';
$TransactionDesc = 'Payment of X';
$Amount = $money;

$stkpushheader = array(
    'Content-Type:application/json',
    'Authorization:Bearer ' . $access_token
);

// Initiate curl
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);

$curl_post_data = array(
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $PartyB,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $callbackurl,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
);

$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);

if ($curl_response === false) {
    $error = curl_error($curl);
    echo "cURL error: " . $error;
} else {
    echo $curl_response;
}

curl_close($curl);
?>
