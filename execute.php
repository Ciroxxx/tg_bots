<?php

require_once 'log_debug.php';
require_once 'functions.php';


$content = file_get_contents("php://input");

$update = json_decode($content, true);

log_debug($update, 'logging $update');

if(!$update)
{
  exit;
}
$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['from']['first_name']) ? $message['from']['first_name'] : "";
$lastname = isset($message['from']['last_name']) ? $message['from']['last_name'] : "";
$username = isset($message['from']['username']) ? $message['from']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";
$text = trim($text);
$text = strtolower($text);

header("Content-Type: application/json");

$response = '';

if($message['entities'][0]['type'] === 'bot_command' && $at_pos = strpos($text, '@')) $text = substr($text, 0, $at_pos);

if(strpos($text, "/start") === 0 || $text=="ciao")
{
	$response = "Ciao $firstname, ti stimo";
}
elseif($text=="/kill")
{
	$response = "bang, sei morto stronzo";
}
elseif($text=="/mine")
{
	$response = "Grazie! Con le tue risorse ho creato una monetina, TIN!!!";
}
elseif($text=="/gnocca")
{
    $gnocca = google_images_search("gnocca");
    log_debug($gnocca, 'logging gnocca');
    
    if($gnocca){
        $url = pick_random($gnocca);
    } else {
        $url = "https://miner-killer-bot.herokuapp.com/images/no_gnocca.jpg";
    }

} 
elseif($text == "/killz")
{
    $url = "https://miner-killer-bot.herokuapp.com/audio/killz.mp3";
}


if($text === "/gnocca"){
    $parameters = array('chat_id' => $chatId, "photo" => $url);
    $parameters["method"] = "sendPhoto";    
} elseif($text === "/killz") {
    $parameters = array('chat_id' => $chatId, "voice" => $url);
    $parameters["method"] = "sendVoice";    
} else {
    $parameters = array('chat_id' => $chatId, "text" => $response);
    $parameters["method"] = "sendMessage";
}

echo json_encode($parameters);