<?php
include('config.php');

const TOKEN = $token;//token telegram bot
$key = 'MinterCatOtcBot';
const BASE_URL = "$link" .TOKEN."/"; //'https://api.telegram.org/bot'.TOKEN.'/';
$method = 'setWebhook';
$url = BASE_URL . $method;
$options = [
	'url' => $url, //"https://YOURSITE/bot/$key.php",
];

$response = file_get_contents($url . '?' . http_build_query($options));

var_dump($response);
?>





