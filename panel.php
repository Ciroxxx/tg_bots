<?php
$botToken = "572812206:AAERyKASDR4TIqwJiPnt17bNSE0kCwkazB8";

$website="https://api.telegram.org/bot".$botToken;
$chatId = "92219874";  //Receiver Chat Id


require_once("required_common/bots.php");
require_once("required_common/Command.php");

$chatId = "-308708713";

//code for inline keyboard markup
$keyboard = array('inline_keyboard' => array(array(array('text' => 'forward me to groups', 'callback_data' => 'someString'),array('text' => 'forward me to groups2', 'callback_data' => 'someStringgg'))));
$encodedKeyboard = json_encode($keyboard);

//code for keyboard markup
$encodedKeyboard = json_encode(array("keyboard" => array(array(":-)", ":-("), array(":-D",":-O")),"resize_keyboard" => true,"one_time_keyboard" => true));
//'reply_markup' => '{"remove_keyboard":true}'

// $params=[
//     'chat_id'=>$chatId,
//     'text'=>'rimuovi',
//
//     'reply_markup' => '{"remove_keyboard":true}'
//     //'reply_markup' => $encodedKeyboard
// ];
// $ch = curl_init($website . '/sendMessage');
// curl_setopt($ch, CURLOPT_HEADER, false);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// $result = curl_exec($ch);
// curl_close($ch);

if($_GET['true_submit'] === 1){
	echo '<pre>' . "I'll submit it truly" . '</pre>';
} else {
	echo '<pre>' . "I won't submit it" . '</pre>';
}

echo '<pre>' . print_r($_GET, 1) . '</pre>';

echo '<pre>' . print_r("reload", 1) . '</pre>';

?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitBot Control Panel</title>
    <link rel="stylesheet" href="foundation/css/foundation.css">
    <link rel="stylesheet" href="foundation/css/app.css">
  </head>
  <body>
    <div class="grid-container">
      <div class="grid-x grid-padding-x">
        <div class="large-12 cell">
          <h1>BitBot Control Panel</h1>
          <form method="get" action="">
            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Bot</label>
                <select name="bot">
                  <option value="0"></option>
				  
<?php
                  foreach($bots as $key => $value){
					  if($_GET['bot'] === $key){
						  echo '<option value="' . $key .'" selected>' . ucfirst($key) . '</option>';
					  } else {
						  echo '<option value="' . $key .'">' . ucfirst($key) . '</option>';
					  }
				  }
?>				  
                </select>
              </div>
            </div>
            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Command</label>
                <select name="command">
                  <option value="0"></option>
<?php
                  foreach($bots[$_GET['bot']]['commands'] as $value){
					  if($_GET['command'] === $value){
						  echo '<option value="' . $value .'" selected>' . ucfirst($value) . '</option>';
					  } else {
						  echo '<option value="' . $value .'">' . ucfirst($value) . '</option>';
					  }
				  }
?>	
                </select>
              </div>
            </div>

            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Textarea Label</label>
                <textarea name="text" placeholder="small-12.cell">
<?php
                if($_GET['text']) echo $_GET['text'];
?>								
				</textarea>
              </div>
            </div>

            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Gruppo</label>
                <select name="chat_id">
                  <option value="-308708713">Bot Exp</option>
                </select>
              </div>
            </div>

            <input type="hidden" name="true_submit" value="0">			
			
			<div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                 <button type="submit" class="button expanded" onclick="submit_truly()">Manda</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
	
	<script>
		var selectElements = document.getElementsByTagName('select');
		console.log(selectElements);
		var count = selectElements.length;
		
		for(i = 0; i < count; i++){
		    selectElements[i].addEventListener('change',function(){ document.getElementsByTagName('form')[0].submit();});
		}
		
		function submit_truly(){
			
		}
	</script>
  </body>
</html>
