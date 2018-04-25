<?php

require_once 'log_debug.php';

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

if($message['entities'][0]['type'] === 'bot_command') $text = substr($text, 0, strpos($text, '@'));

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
    $url = "http://static2.oggi.it/wp-content/uploads/sites/6/2015/03/INTIMISSIMI518.jpg?v=1425547126";
}
else
{
	$response = "Comando non valido!";
}

log_debug($text, 'logging $text');

if($text === "/gnocca"){
    $parameters = array('chat_id' => $chatId, "photo" => $url);
    $parameters["method"] = "sendPhoto";    
} else {
    $parameters = array('chat_id' => $chatId, "text" => $response);
    $parameters["method"] = "sendMessage";
}

echo json_encode($parameters);