<?php

define('BOT_TOKEN', '598000419:AAH7f58MfMbqZN3a7lu5DpZCVi8v10Rfnp4'); //ferex_test
//define('BOT_TOKEN', '594696565:AAGJ8_I_LxUI2lS5iViYppfJToGWXXENjt8'); //ferick
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");

  echo json_encode($parameters);
  return true;
}

function processMessage($message) {
  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];
    apiRequestWebhook("sendMessage", array('chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => 'Cool'));

  }
}


define('WEBHOOK_URL', 'https://www.ferex.xyz/bot_test2.php');

// if (php_sapi_name() == 'cli') {
//   // if run from console, set or delete webhook
//   apiRequest('setWebhook', array('url' => isset($argv[1]) && $argv[1] == 'delete' ? '' : WEBHOOK_URL));
//   exit;
// }


$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
  // receive wrong update, must not happen
  exit;
}

if (isset($update["message"])) {
  processMessage($update["message"]);
}
