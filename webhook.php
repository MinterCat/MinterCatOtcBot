<?php
const TOKEN = '1068349430:AAFuZ0FqduRuHOn6-gC8uP_XjaWKqKaGUHE';
$key = 'MinterCatOtcBot';
const BASE_URL = 'http://proxy9747.my-addr.org/myaddrproxy.php/https/api.telegram.org/bot'.TOKEN.'/';
$method = 'setWebhook';
$url = BASE_URL . $method;
$options = [
	'url' => "https://mintercat.com/bot/$key/$key.php",
];

$response = file_get_contents($url . '?' . http_build_query($options));

var_dump($response);
?>





