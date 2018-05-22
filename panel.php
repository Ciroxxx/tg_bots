<?php


//$website="https://api.telegram.org/bot".$botToken;
//code for inline keyboard markup
//$keyboard = array('inline_keyboard' => array(array(array('text' => 'forward me to groups', 'callback_data' => 'someString'),array('text' => 'forward me to groups2', 'callback_data' => 'someStringgg'))));
//$encodedKeyboard = json_encode($keyboard);

//code for keyboard markup
//$encodedKeyboard = json_encode(array("keyboard" => array(array(":-)", ":-("), array(":-D",":-O")),"resize_keyboard" => true,"one_time_keyboard" => true));
//'reply_markup' => '{"remove_keyboard":true}'

// $params=[
//     'chat_id'=>$chat_id,
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

$chats = array("-247870527" => "Save the Ferick", "-308708713" => "Bot Exp", "92219874" => "FeRick");

require_once("required_common/bots.php");
//require_once("required_common/Command.php");


if((isset($_GET["bot_name"]) && array_key_exists($_GET["bot_name"], $bots)) && $_GET['truly_submit'] == 1){
	echo '<pre>' . "I'll submit it truly" . '</pre>';
	require_once 'execute.php';
} else {
	echo '<pre>' . "I won't submit it" . '</pre>';
}

echo '<pre>The GET ' . print_r($_GET, 1) . '</pre>';
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
          <form method="GET" action="">
            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Bot</label>
                <select name="bot_name" id="bot_selection">
                  <option value="0"></option>

<?php
                  foreach($bots as $key => $value){
					  if($_GET['bot_name'] === $key){
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
                <select name="do">
                  <option value="0"></option>
<?php
          foreach($bots[$_GET['bot_name']]['commands'] as $key => $value){
					  if($_GET['do'] === $key){
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
                <label>Textarea Label</label>
                <textarea name="text" placeholder="small-12.cell"><?php
                if(isset($_GET['text'])){
					echo trim($_GET['text']);
				} else {
					echo '';
				}
			  ?></textarea>
              </div>
            </div>

            <div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                <label>Gruppo</label>
                <select name="chat_id">
				  <option value="0"></option>
<?php
                  foreach($chats as $key => $value){
					  if($_GET['chat_id'] === $key){
						  echo '<option value="' . $key .'" selected>' . ucfirst($value) . '</option>';
					  } else {
						  echo '<option value="' . $key .'">' . ucfirst($value) . '</option>';
					  }
				  }
?>
                </select>
              </div>
            </div>

            <input id = "truly_submit" type="hidden" name="truly_submit" value="0">

			<div class="grid-x grid-padding-x">
              <div class="large-12 cell">
                 <button id="submit_button" type="button" class="button large expanded">Manda</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>

	<script>
		var bot_selector = document.getElementById('bot_selection');
		var form = document.getElementsByTagName('form');
		var submit_button = document.getElementById('submit_button');

		bot_selector.addEventListener('change', function(){document.getElementsByTagName('form')[0].submit();});
		submit_button.addEventListener('click', function(){
			document.getElementById('truly_submit').value = 1;

			form[0].submit();
		});

		//var myform = document.getElementsByTagName('form');

		// myform.onsubmit = function(){
		    // document.getElementById('truly_submit').value = 1;
		    // myform.submit();
	    // };
		function truly_submit(){
            document.getElementById('truly_submit').value = 1;
			return false;
		}
	</script>
  </body>
</html>
