<?php

require_once("required_common/bots.php");
require_once("required_common/Command.php");


require_once 'log_debug.php';
require_once 'functions.php';

if($_SERVER['REMOTE_ADDR'] === "127.0.0.1"){//se è in locale fornisco io dei valori dummy
    $content = '{"message" : {"message_id" : "666", "chat" : {"id" : "999"}, "date" : "1234654", "text" : "/gnocca"}}';
} else {
    $content = file_get_contents("php://input");
}


$update = json_decode($content, true);

log_debug($update, 'logging $update');


if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){

    $BOT_NAME = $_GET["bot_name"];
    $TOKEN = $bots[$BOT_NAME]["token"];

    if($_GET["do"] && in_array($_GET["do"], $bots[$BOT_NAME]["commands"])){//se è un'azione autonoma del bot
      $COMMAND = $_GET["do"];

      log_debug($COMMAND, 'logging command');

  		if($COMMAND){
  			$chatId = "";
  		} else {
  			log_debug($COMMAND, 'check_right_command = false');
  			exit;
  		}

    } else if($update['message']['entities'][0]['type'] === 'bot_command'){//se è un comando cioè se inizia con /
        if(!$update)
        {
          exit;
        }

		    $message = isset($update['message']) ? $update['message'] : "";
        $messageId = isset($message['message_id']) ? $message['message_id'] : "";
		    $chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
        $date = isset($message['date']) ? $message['date'] : "";
        $text = isset($message['text']) ? $message['text'] : "";
        $text = trim($text);
        $text = strtolower($text);

		    $command = new Command($BOT_NAME, $chatId, $text, true, $message);

		    if($command -> is_command){
			      $response = $command -> response;
		    } else {
			// implementare funzione per leggere da file le info sul messaggio precedente

			// è dialogo con bot se dal precedente messaggio sono passati meno di 30 secondi e se la persona che scrive il messaggio è la stessa del precedente

		    }
		    log_debug($command, 'command');

    } else {//prova a capire se è un argomento al comando

	  }


    header("Content-Type: application/json");

    echo json_encode($response);


} else {
  exit;
}
