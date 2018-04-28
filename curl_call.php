<?php

$ch = curl_init($_SERVER['HTTP_HOST'] . '/echo_something.php');
$fp = fopen("echoed.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);