<?php

class Command{

	public $is_command = false;
	public $is_reply = false;
	public $command;
	public $response = '';
	public $chat_id;
	public $bot_name;

	function __construct($bot_name = "miner", $chat_id = 113,$text = "/start", $message = ""){
		global $bots;

		$this -> chat_id = $chat_id;


		if(strpos($text, '/') === 0){// è un comando

			if($at_pos = strpos($text, '@')) $text = substr($text, 0, $at_pos);//se il comando contiene la @ elimina la @botname

			log_debug($text, '$text');

			$this -> command = strpos($text, ' ') ? substr($text, 1 , strpos($text, ' ')) : substr($text, 1);
			$this -> is_command = true;

			log_debug($this->command, '$this->command');

			if(array_key_exists($this -> command, $bots[$bot_name]["commands"])){
				$this -> bot_name = $bot_name;

        //crea file con nome chat_id, inserisci dentro tempo e nome comando
				$fh = fopen("chats/" . $chat_id . '.txt', 'w') or die("can't open file");
				$file_content = time() . PHP_EOL . $this->command . PHP_EOL . $this -> bot_name;
				fwrite($fh,$file_content);
				fclose($fh);

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
			//*** controlla se esiste un file con il nome di chat_id, se all'interno il parametro tempo meno l'attuale è minore di 30 e che comando c'è scritto
			//cambia la proprietà is_reply in true e poi chiama la funzione del relativo comando
			if(is_file('chats/' . $chat_id . '.txt')){
				log_debug(1, 'sono nell if il file esiste');
				$file_content = file('chats/' . $chat_id . '.txt',FILE_IGNORE_NEW_LINES);

				if((time() - $file_content[0]) <= 40){//$file_content[0] è lo UNIX timestamp in cui è statp eseguito l'ultimo comando da $chat_id
					log_debug(1, 'sono nel controllo sul tempo');
					log_debug($file_content[1], 'comando contenuto nel file');
					log_debug($bots[$file_content[2]]["commands"], 'nell array bots');
					if(array_key_exists($file_content[1], $bots[$file_content[2]]["commands"])){
						log_debug(1, 'if in_array dà sì');
					} else {
						log_debug(1, 'if in_array dà no');
					}


					if(array_key_exists($file_content[1], $bots[$file_content[2]]["commands"])){//$file_content[1] è il comando precedente, //$file_content[2] è il nome del bot precedente
						log_debug(1, 'sono nel controllo sulla corrispondenza bot/nome comando');
            $this->is_reply = true;
						log_debug($this->is_reply, 'this is reply');
						$this -> response = call_user_func_array(array($this, $file_content[1]), array($text)); //call_user_func_array chiama dinamicamente un metodo (callback), interessante comportamento se si passa un array come primo argomento, il secondo argomento deve essere un array per sintassi
					}
				}
			} else {
				log_debug(1, 'is not a file');
			}
		}
	}

	function wrong_command(){
		return array("chat_id" => $this -> chat_id, "text" => "hai sbagliato bot :-(", "method" => "sendMessage");
	}

	function send_text($text, $reply_markup = ""){
		$response = array("chat_id" => $this -> chat_id, "text" => $text, "method" => "sendMessage");
		if($reply_markup) $response["reply_markup"] = $reply_markup;
		return $response;
	}

	function send_photo($url, $reply_markup = "", $caption = ""){
		$response = array("chat_id" => $this -> chat_id, "photo" => $url, "method" => "sendPhoto");
		if($reply_markup) $response["reply_markup"] = $reply_markup;
		if($caption) $response['caption'] = $caption;
		return $response;
	}

	function send_voice($url, $reply_markup = ""){
		return array("chat_id" => $this -> chat_id, "voice" => $url, "method" => "sendVoice");
	}

	function start($firstname = ''){
		if($this->is_reply === true) exit;
		return $this -> send_text("Ciao $firstname, ti stimo");
	}

	function kill(){//non usato
		//$buttons = array(array("adesso", "più tardi"), array("domani", "dopodomani"));
		// $reply_markup = json_encode(array("keyboard" => $buttons, "resize_keyboard" => true,"one_time_keyboard" => true));
		//$buttons = array(array("text" => "testo1", "callback_data" => "dati callback"));
		$inline_keyboard = array('inline_keyboard' => array(array('text' => 'Tasto1', 'callback_data' => 'pressed_btn1')));
		//$reply_markup = json_encode(array("inline_keyboard" => $buttons));
		$reply_markup = json_encode($inline_keyboard);

		if($this->is_reply === true) exit;

		return $this -> send_text("bang! Sei morto stronzo/a", $reply_markup);
	}

	function mine(){
		if($this->is_reply === true) exit;
		return $this -> send_text("Grazie! Con le tue risorse ho creato una monetina!!!");
	}

	function gnocca(){
		if($this->is_reply === true) exit;
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
		if($this->is_reply === true) exit;
		return $this -> send_voice("https://miner-killer-bot.herokuapp.com/audio/killz.mp3");
	}

	function command1($text =""){
		log_debug($this->is_reply, 'this is reply in command 1');

		if($this->is_reply === true){
			log_debug($text, 'TEXT in command1');
			switch($text){
				case ":-)":
				  $url = "https://miner-killer-bot.herokuapp.com/images/pickard_smile.jpg";
				  break;
				case ":-(":
					$url = "https://miner-killer-bot.herokuapp.com/images/pickard_sad1.jpg";
				  break;
				case ":-x":
				  $url = "https://miner-killer-bot.herokuapp.com/images/pickard_hide.jpg";
				  break;
				case ":-o":
				  $url = "https://miner-killer-bot.herokuapp.com/images/pickard_cmon.jpg";
				  break;
				case "fuck!":
				  $url = "https://miner-killer-bot.herokuapp.com/images/pickard_fuck.jpg";
				  break;
			}
			return $this -> send_photo($url,'{"remove_keyboard":true}');
			log_debug($text, 'text in command1');
		} else {
			$encodedKeyboard = json_encode(array("keyboard" => array(array(":-)", ":-("), array(":-X",":-O"), array("fuck!")),"resize_keyboard" => true,"one_time_keyboard" => true));
			return $this -> send_text('eh già', $encodedKeyboard);
		}
	}

	function appuntamento($text = ""){
		if($this->is_reply === true){
			if($text === "sì"){
				$url = "https://miner-killer-bot.herokuapp.com/images/brent_contaci1.jpg";
				$caption = '';
			} else if($text === "no"){
				$url = "https://miner-killer-bot.herokuapp.com/images/brent_smart_work.jpg";
				$caption = 'Allora ti aspetto domani in ufficio!';
			}
			return $this -> send_photo($url,'{"remove_keyboard":true}', $caption);
		} else {
			$appuntamento = array(
				"proposta" => array("ci incontriamo a mensa ", "ci vediamo a pranzo ", "perchè non facciamo un giro in moto ", "ci vogliamo vedere al cinema ", "facciamo due passi ", "potremmo fare a pranzo "),
				"tempo" => array("domani ", "nel pomeriggio ", "stasera ", "tra una settimana ", "l'anno prossimo ", "ieri "),
				"luogo" => array("a Triparni?", "ai Due Mari?", "al River Village?", "a Cosenza?", "a Lamezia?", "a Chicago?")
			);
			$proposta = "";

			foreach($appuntamento as $item){
				$proposta .= pick_random($item);
			}
			$encodedKeyboard = json_encode(array("keyboard" => array(array("sì", "no")),"resize_keyboard" => true,"one_time_keyboard" => true));
			return $this -> send_text($proposta, $encodedKeyboard);
		}
	}
}
