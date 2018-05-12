<?php
$botToken = "572812206:AAERyKASDR4TIqwJiPnt17bNSE0kCwkazB8";

$website="https://api.telegram.org/bot".$botToken;
$chatId = "92219874";  //Receiver Chat Id

//$chatId = "-308708713";

// $keyboard = array(array("[Destaques]","[Campinas e RMC]","[esportes]"));
// $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
// $reply = json_encode($resp);

//code for inline keyboard markup
// $keyboard = array('inline_keyboard' => array(array(array('text' => 'forward me to groups', 'callback_data' => 'someString'),array('text' => 'forward me to groups2', 'callback_data' => 'someStringgg'))));
// $encodedKeyboard = json_encode($keyboard);

//code for keyboard markup
$encodedKeyboard = json_encode(array("keyboard" => array(array(":-)", ":-("), array(":-D",":-O")),"resize_keyboard" => true,"one_time_keyboard" => true));
//'reply_markup' => '{"remove_keyboard":true}'

$params=[
    'chat_id'=>$chatId,
    'text'=>'rimuovi',

    'reply_markup' => '{"remove_keyboard":true}'
    //'reply_markup' => $encodedKeyboard
];
$ch = curl_init($website . '/sendMessage');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

//echo json_encode(array("keyboard" => array(array("done", "done2")),"resize_keyboard" => true,"one_time_keyboard" => true));
