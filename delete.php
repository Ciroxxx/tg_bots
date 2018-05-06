<?php

require_once("required_common/bots.php");

if(isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)){
    
    $BOT_NAME = $_GET["bot_name"];
    $TOKEN = $bots[$BOT_NAME]["token"];

    // NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
    $API_URL = 'https://api.telegram.org/bot' . $TOKEN .'/';
    $method = 'setWebhook';
    
    $url = $API_URL . $method;
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($handle, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($handle);
    print_r($result);
    echo "<br>";
    print_r($TOKEN);
    echo "<br>";
} else {
    exit;
}