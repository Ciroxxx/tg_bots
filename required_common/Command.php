<?php

class Command{

	public $is_command = false;
	public $command;
	public $response = '';
	public $chat_id;
	public $bot_name;

	function __construct($bot_name = "miner", $chat_id = 113,$text = "/start", $check_is_command = false, $message){
		global $bots;

		if($check_is_command){//è un comando se inizia con /
			if(strpos($text, '/') === 0){// è un comando

				if($at_pos = strpos($text, '@')) $text = substr($text, 0, $at_pos);//se il comando contiene la @ elimina la @botname

				log_debug($text, '$text');

				$this -> command = strpos($text, ' ') ? substr($text, 1 , strpos($text, ' ')) : substr($text, 1);
				$this -> is_command = true;
				$this -> chat_id = $chat_id;

				log_debug($this->command, '$this->command');

				if(in_array($this -> command, $bots[$bot_name]["commands"])){
					$this -> bot_name = $bot_name;

					//costruisci qui i parametri
					if($this -> command === "start" ){
						$firstname = isset($message['from']['first_name']) ? $message['from']['first_name'] : "";
						$lastname = isset($message['from']['last_name']) ? $message['from']['last_name'] : "";
						$username = isset($message['from']['username']) ? $message['from']['username'] : "";

						$params = array($firstname);
					} else {
						$params = array();
					}

					$this -> response = call_user_func_array(array($this, $this -> command), $params); //call_user_func_array chiama dinamicamente un metodo (callback), interessante comportamento se si passa un array come primo argomento, il secondo argomento deve essere un array per sintassi

				} else {
					$this -> response = $this -> wrong_command();
				}
			} else {
				$this -> is_command = false;
			}
		}
	}

	function wrong_command(){
		return array("chat_id" => $this -> chat_id, "text" => "hai sbagliato bot :-(", "method" => "sendMessage");
	}

	function send_text($text, $reply_markup){
		$response = array("chat_id" => $this -> chat_id, "text" => $text, "method" => "sendMessage");
		if($reply_markup) $response["reply_markup"] = $reply_markup;
		return $response;
	}

	function send_photo($url, $reply_markup){
		return array("chat_id" => $this -> chat_id, "photo" => $url, "method" => "sendPhoto");
	}

	function send_voice($url, $reply_markup){
		return array("chat_id" => $this -> chat_id, "voice" => $url, "method" => "sendVoice");
	}

	function start($firstname = ''){
		return $this -> send_text("Ciao $firstname, ti stimo");
	}

	function kill(){
		//$buttons = array(array("adesso", "più tardi"), array("domani", "dopodomani"));
		// $reply_markup = json_encode(array("keyboard" => $buttons, "resize_keyboard" => true,"one_time_keyboard" => true));
		$buttons = array(array("text" => "testo1", "callback_data" => "dati callback"),array("text" => "testo2", "callback_data" => "dati callback2"));
		$reply_markup = json_encode(array("inline_keyboard" => $buttons));
		return $this -> send_text("bang! Sei morto stronzo/a", $reply_markup);
	}

	function mine(){
		return $this -> send_text("Grazie! Con le tue risorse ho creato una monetina!!!");
	}

	function gnocca(){
		$gnocca = google_images_search("sexy");
        log_debug($gnocca, 'logging gnocca');

        if($gnocca){
            $url = pick_random($gnocca);
        } else {
            $url = "https://miner-killer-bot.herokuapp.com/images/no_gnocca.jpg";
        }

		return $this -> send_photo($url);
	}

	function killz(){
		return $this -> send_voice("https://miner-killer-bot.herokuapp.com/audio/killz.mp3");
	}

	function command1(){

	}

	function appuntamento(){

	}

	function kangaroo(){

	}
}
