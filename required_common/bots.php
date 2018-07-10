<?php

//commands
// mine - genera una bitmoneta usando un algoritmo obsoleto cui ha ridato nuova luce
// gnocca - foto di pelo di alta qualità
// gif - invia una feRick gif

$bots = array(
    "ferick" =>
        array(
            "token" => "594696565:AAGJ8_I_LxUI2lS5iViYppfJToGWXXENjt8",
            "commands" => array(
				        //"start" => array(),
                //"mine" => array("panel"),
                "gnocca" => array("panel"),
                "gif" => array("panel"),
                "think" => array()
            ),
            "panel" => true
        ),
    "brent" =>
        array(
            "token" => "435363970:AAE96UAhhQCcpa3B6bnj36WGnBh63i2z0cM",
            "commands" => array(
			          "start" => array(),
                "appuntamento" => array("panel"),
                "brentize" => array()
            ),
            "panel" => true
        ),
    "captain" =>
        array(
            "token" => "559592888:AAEuEsT85IhpM0TTDHgD_Jvyy1aF1M8Eobg",
            "commands" => array(
                "start" => array(),
                "think" => array(),
                "engage" => array(),
                "smartwork" => array()
            ),
            "panel" => true
        ),
    "viking" =>
        array(
            "token" => "567065671:AAFc7q4ADo7E3Pj00RfG6oMlahXjVrmZMlE",
            "commands" => array(
                "start" => array(),
                "araldica" => array(),
                "cangurizza" => array(),
                "vkthinks" => array(),
                "sdegno" => array()
            ),
            "panel" => true
        ),
      "ferex_test" =>
          array(
              "token" => "598000419:AAH7f58MfMbqZN3a7lu5DpZCVi8v10Rfnp4",
              "commands" => array(
                  "start" => array(),
                  "send_gif_as_doc" => array(),
                  "send_video_as_video" => array()
              ),
              "panel" => false
          )
);

//to delete a webhook https://api.telegram.org/bot572812206:AAERyKASDR4TIqwJiPnt17bNSE0kCwkazB8/setwebhook LINK:https://stackoverflow.com/questions/32537081/how-to-use-getupdates-after-setwebhook-in-telegram-bot-api
//https://api.telegram.org/bot594696565:AAGJ8_I_LxUI2lS5iViYppfJToGWXXENjt8/sendMessage?chat_id=92219874&text=Hello%20World
