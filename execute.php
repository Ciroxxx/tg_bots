<?php

/*
data needed to execute a command:
bot_name
token
chat_id
text
*/

require_once("required_common/bots.php");
require_once("required_common/Command.php");

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

//Create a S3Client
global $s3;

$s3 = new S3Client([
    'region' => 'eu-west-3',
    'version' => 'latest',
    'credentials' => false
]);

require_once 'log_debug.php';
require_once 'functions.php';


if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){

      $BOT_NAME = $_GET["bot_name"];
      $TOKEN = $bots[$BOT_NAME]["token"];

      if(isset($_GET["do"]) && array_key_exists($_GET["do"], $bots[$BOT_NAME]["commands"])){//se è un'azione autonoma del bot
        $do = '/' . $_GET["do"];

    		if($do){
    			$chat_id = $_GET["chat_id"];

          if($chat_id){
            $command = new Command($BOT_NAME, $chat_id, $do);

            if($command){
                $response = $command -> response;
            }


            $website="https://api.telegram.org/bot" . $TOKEN;

            $params = $response;

            unset($params["method"]);

            $ch = curl_init($website . '/' . $response["method"]);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
            curl_close($ch);
          } else {
            exit('chat_id not set');
          }

    		} else {
    			exit('no command set from panel');
    		}

    } else {

        if($_SERVER['REMOTE_ADDR'] === "127.0.0.1" && 0){//se è in locale fornisco io dei valori dummy
            $content = '{"message" : {"message_id" : "666", "chat" : {"id" : "999"}, "date" : "1234654", "text" : "/mine","entities" : [{"type" : "bot_command"}]}}';
        } else {
            $content = file_get_contents("php://input");
        }

        $update = json_decode($content, true);

        if(!$update)
        {
          exit('false update variable');
        }

		    $message = isset($update['message']) ? $update['message'] : "";
        $messageId = isset($message['message_id']) ? $message['message_id'] : "";
		    $chat_id = isset($message['chat']['id']) ? $message['chat']['id'] : "";
        $date = isset($message['date']) ? $message['date'] : "";
        $text = isset($message['text']) ? $message['text'] : "";
        $text = trim($text);
        $text = strtolower($text);

		    $command = new Command($BOT_NAME, $chat_id, $text, $message);

		    if($command){

			      $response = $command -> response;
		    }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

} else {
  exit('no bot_name set');
}
