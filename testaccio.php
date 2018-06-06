<?php

require_once 'log_debug.php';
require_once 'functions.php';

$results = google_images_search('captain picard engage', 'lang_en');

foreach($results as $result){
  echo '<h3><img src="' . $result . '"></h3>';
}
