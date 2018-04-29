<?php

function google_images_search($string){//gets term to search, returns urls to images
    $query_url = "https://www.googleapis.com/customsearch/v1?";

    $google_search_params = array(
        "q" => urlencode($string),
        "num" => 10,
        "key" => "AIzaSyA4H9Je_epjF9G-s5ibU7d0-qO7T4i4ucU",
        "cx" => "007307369367147993290:mvp2ald3mrm",
        "search_type" => "image",
        "lr" => "lang_it"
    );

    foreach($google_search_params as $key => $val){
        $query_url .= "&" . $key . "=" . $val;
    }
    
    $ch = curl_init($query_url);

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
    log_debug($results, 'logging image search results');
    curl_close($ch);
    
    $images_url = array();
    
    foreach($results->items as $item){
        $images_url[] = $item->pagemap->cse_image[0]->src;
    }
    
    if($images_url){ return $images_url; } else { return false; }
}

function pick_random($arr){
    if(is_array($arr)){
        $index = rand(0, count($arr));
        
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