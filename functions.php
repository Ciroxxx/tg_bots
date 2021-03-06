<?php

function apiRequestWebhook($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  $parameters["method"] = $method;

  header("Content-Type: application/json");

  echo json_encode($parameters);
  return true;
}

function prepare_curl_request($curl_website, $query_vars){
  if(!$curl_website && $query_vars){
    trigger_error('mancano parametri in prepare_curl_request', E_USER_WARNING);
  } else {
    $ch = curl_init($curl_website . '/' . $query_vars['method']);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($query_vars));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = exec_curl_request($ch);
    return $response;
  }
}

function exec_curl_request($handle) {
  $response = curl_exec($handle);

  if ($response === false) {
    $errno = curl_errno($handle);
    $error = curl_error($handle);

    error_log("Curl returned error $errno: $error\n");
    curl_close($handle);
    return false;
  }

  $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
  log_debug($http_code, 'logging $http_code');
  curl_close($handle);

  if ($http_code >= 500) {
    // do not wat to DDOS server if something goes wrong
    sleep(10);
    return false;
  } else if ($http_code != 200) {
    $response = json_decode($response, true);
    error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
    if ($http_code == 401) {
      throw new Exception('Invalid access token provided');
    }
    return false;
  } else {
    $response = json_decode($response, true);
    if (isset($response['description'])) {
      error_log("Request was successful: {$response['description']}\n");
    }
    $response = $response['result'];
  }

  return $response;
}

function google_images_search($string, $lang = "lang_it"){//gets term to search, returns urls to images

    $start = rand(1,100);
    static $counter = 0;

    $query_url = "https://www.googleapis.com/customsearch/v1?";

    $google_search_params = array(
        "q" => urlencode($string),
        "num" => 10,
        "key" => "AIzaSyA4H9Je_epjF9G-s5ibU7d0-qO7T4i4ucU",
        "cx" => "007307369367147993290:mvp2ald3mrm",
        "search_type" => "image",
        "lr" => $lang,
        "start" => $start
    );

    foreach($google_search_params as $key => $val){
        $query_url .= "&" . $key . "=" . $val;
    }

    $ch = curl_init($query_url);
    //echo '<h3>' . $query_url . '</h3>';
    $curl_options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    );


    curl_setopt_array($ch, $curl_options);

    $results = curl_exec($ch);

    $results = json_decode($results);

    curl_close($ch);

    $images_url = array();

    foreach($results->items as $item){
      if($item->pagemap->cse_image[0]->src){
        $images_url[] = $item->pagemap->cse_image[0]->src;
      }
    }
    if(count($images_url) >= 1){
      log_debug($string, '$string from google_images_search');
      return $images_url;
    } else if($counter <= 3){
      $counter++;
      return google_images_search($string);
    } else {
      return false;
    }
}

function pick_random($arr){
    if(is_array($arr)){
        $index = rand(0, count($arr) -1);

        $counter = 0;
        foreach($arr as $item){//use loop through elements because array can be associative
            if($counter === $index){
                return $item;
            } else {
                $counter++;
            }
        }

    } else {
        return false;
    }
}

function check_right_command($COMMAND, $BOT_NAME){

	return $COMMAND ? $COMMAND : false;
}

function get_protocol(){
  return !empty($_SERVER['HTTPS']) ? 'https' : 'http';
}


function access_s3($folder = "gifferex"){
  global $s3;
  $bucket = 'tg-bots';

  // Use the high-level iterators (returns ALL of your objects).
  try {
      $objects = $s3->getPaginator('ListObjects', [
          'Bucket' => $bucket,
          'Prefix' => $folder . '/'
      ]);

      //echo "Keys retrieved!" . PHP_EOL;
      $retrieved_files = array();
      foreach ($objects as $object) {
        //echo '<pre>' . print_r($object, 1) . '</pre>';
        foreach($object['Contents'] as $content){
          //echo $content['Key'] . PHP_EOL;
          //echo '<pre>' . print_r($content, 1) . '</pre>';
          //echo '<pre>' . print_r($s3 -> getObjectUrl($bucket, $content['Key']), 1) . '</pre>';
          $retrieved_files[] = $s3 -> getObjectUrl($bucket, $content['Key']);
        }
      }
    return count($retrieved_files) ? $retrieved_files : 0;
  } catch (S3Exception $e) {
      //echo $e->getMessage() . PHP_EOL;
      trigger_error($e->getMessage(), E_USER_ERROR);
  }
}
