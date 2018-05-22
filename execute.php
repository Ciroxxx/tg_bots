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


require_once 'log_debug.php';
require_once 'functions.php';


log_debug($update, 'logging $update');
log_debug($_GET, '$_GET');

if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){

      $BOT_NAME = $_GET["bot_name"];
      $TOKEN = $bots[$BOT_NAME]["token"];

      if($_GET["do"] && array_key_exists($_GET["do"], $bots[$BOT_NAME]["commands"])){//se è un'azione autonoma del bot
        $COMMAND = $_GET["do"];

        log_debug($COMMAND, 'logging command');

    		if($COMMAND){
    			$chat_id = $_GET["chat_id"];

          if($chat_id){

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

		    $command = new Command($BOT_NAME, $chat_id, $text, true, $message);

		    if($command){
			      $response = $command -> response;
		    }

		    log_debug($command, 'command');
        header("Content-Type: application/json");

        echo json_encode($response);

    }

} else {
  exit('no bot_name set');
}
