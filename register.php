<?php

require_once("required_common/bots.php");
require_once 'functions.php';


if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){

    $BOT_NAME = $_GET["bot_name"];
    $TOKEN = $bots[$BOT_NAME]["token"];
    // PARAMETRI DA MODIFICARE
    //$WEBHOOK_URL = 'https://' . $BOT_NAME . '-killer-bot.herokuapp.com/execute.php';
    //$WEBHOOK_URL = 'https://miner-killer-bot.herokuapp.com/execute.php?bot_name=' . $BOT_NAME;

    $WEBHOOK_URL = 'https://' . $_SERVER['HTTP_HOST'] . '/execute.php?bot_name=' . $BOT_NAME;

    // NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
    $API_URL = 'https://api.telegram.org/bot' . $TOKEN .'/';
    $method = 'setWebhook';
    $parameters = array('url' => $WEBHOOK_URL);
    $url = $API_URL . $method. '?' . http_build_query($parameters);
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    $result = exec_curl_request($handle);
    print_r($result);

} else {
    exit;
}
