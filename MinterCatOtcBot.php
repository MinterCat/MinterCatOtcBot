<?php
header('Content-Type: text/html; charset=utf-8');
// подрубаем API
require_once("vendor/autoload.php");
// дебаг
if(true){
	error_reporting(E_ALL & ~(E_NOTICE | E_USER_NOTICE | E_DEPRECATED));
	ini_set('display_errors', 1);
}
include('../config.php');
// создаем переменную бота
$bot = new \TelegramBot\Api\Client($token,null);

// обязательное. Запуск бота
$bot->command('start', function ($message) use ($bot) {

$text = 'Здравствуйте!

🐈 Описание котика
Чтобы получить полное описание МинтерКота, отправьте боту его блок.

Пример:
#555555
';

	$bot->sendMessage($message->getChat()->getId(),  $text);
	$bot->answerCallbackQuery($callback->getId()); // можно отослать пустое, чтобы просто убрать "часики" на кнопке
});
//=============================
// Команды бота
$bot->command('myid', function ($message) use ($bot) {
	$getid = $message->getChat()->getId();	
	$bot->sendMessage($getid, $getid);
	$bot->answerCallbackQuery($callback->getId());
});
//=============================
// помощ
$bot->command('help', function ($message) use ($bot) {
    $answer = '
🐈 Описание котика
Чтобы получить полное описание МинтерКота, отправьте боту его блок.

Пример:
#555555
    ';
    $bot->sendMessage($message->getChat()->getId(), $answer);
    $bot->answerCallbackQuery($callback->getId());
});


$bot->on(function($Update) use ($bot){
	
	$message = $Update->getMessage();
	$mtext = $message->getText();
	$cid = $message->getChat()->getId();
//===============================

if(mb_stripos($mtext,"#") !== false)
  {
	include('../config.php');
    $id = explode("#", $mtext)[1];
    $getid = $message->getChat()->getId();
    //--------------------------
	$json1 = file_get_contents("https://api.mintercat.com/cats?id=$id");
	$payloads1 = json_decode($json1,true);

	$addr = $payloads1[0]['addr'];
	$img = $payloads1[0]['img'];

	if ($addr != "") 
		{
			$json4 = file_get_contents("https://api.mintercat.com?img=$img");
			$payloads4 = json_decode($json4,true);

			$pricebd = $payloads1[0]['price'];

			$cats = $payloads4['cats'];
					
			$series = $cats[0]['series'];
			$rarity = $cats[0]['rarity'];
			$rarity = $rarity * 100;
			$price = $cats[0]['price'];
			$name1 = $cats[0]['name'];
			$count = $cats[0]['count'];
			$gender = $cats[0]['gender'];
			
			$name2 = $payloads1[0]['name'];
			if (($name2 != '') and ($name2 != null)) {$name = $name2;} else {$name = $name1;}
			
			$json3 = file_get_contents("https://api.mintercat.com/coin");
			$payloads3 = json_decode($json3,true);
			$bip = $payloads3['estimate']; 

			$bip = $bip * $price;

			$bip = round($bip,2);

			$json2 = file_get_contents($api."/block?height=$id");
			$payloads2 = json_decode($json2,true);

			$data = $payloads2['result']['time'];
			$nd = explode("T", $data)[0];

			$timestamp2 = date('Y-m-d',strtotime("$nd"));
					
			$unixDate = strtotime("$timestamp2");
			$normalDate = date('d', $unixDate);
					
			$unixD = strtotime($timestamp2);
			$nd = date('d.m.Y', $unixD);
			
			if ($gender == '♂') {
			$gender_p = "Мужской ($gender)";
			}
			if ($gender == '♀') {
			$gender_p = "Женский ($gender)";
			}
			if ($gender == '0') {
			$gender_p = "Неопределенный";
			}
			
			$text = "
#$id
$name
-----
Котик создан $nd, в блоке $id
Шанс выпадения: $rarity%
Пол: $gender_p
Количество котов данной породы: $count

Примерная стоимость: $price MINTERCAT

~ $bip BIP
";

			$pic = "https://mintercat.com/img/Cat$img.webp"; //webp or png
			$urlT = "https://mintercat.com/cat?id=$id";
			$keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
				[
					[
						['url' => $urlT, 'text' => 'Connect']
					]
				]
			);
			$bot->sendSticker($getid, $pic);
			$bot->sendMessage($getid, $text, "Markdown", null,null,$keyboard);
			$bot->answerCallbackQuery($callback->getId());
		}
  }
//=============================	
}, function($message) use ($name){
	return true; // когда тут true - команда проходит
});

// запускаем обработку
$bot->run();

echo "бот";