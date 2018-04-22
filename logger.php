<?php

$content = '[';

for($i = 0; $i < 10; $i++){
  $content .= '\''. substr(md5(rand()), 0, 7) . '\',' . PHP_EOL;
}

$content .= ']';

$filename = dirname( __FILE__ ) . '/big_array.php';


if(!is_dir(dirname($filename))) mkdir(dirname($filename).'/', 0744, TRUE);

file_put_contents($filename, $content,FILE_APPEND);
