<?php

require_once("required_common/bots.php");

if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){
    
    $BOT_NAME = $_GET["bot_name"];
    $TOKEN = $bots[$bot_name];
    // PARAMETRI DA MODIFICARE
    $WEBHOOK_URL = 'https://' . $BOT_NAME . '-killer-bot.herokuapp.com/execute.php';


    // NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
    $API_URL = 'https://api.telegram.org/bot' . $TOKEN .'/';
    $method = 'setWebhook';
    $parameters = array('url' => $WEBHOOK_URL);
    $url = $API_URL . $method. '?' . http_build_query($parameters);
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($handle);
    print_r($result);
    
        print_r($BOT_NAME);
            print_r($TOKEN);
                        print_r($WEBHOOK_URL);
        print_url($API_URL);
        print_url($url);
} else {
    exit;
}