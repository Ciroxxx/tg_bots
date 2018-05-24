<?php
function log_debug ($variable,$info, $mode = 'a'){
	$strng = PHP_EOL.'********** '.date('d-m h:i:s').' **********'.PHP_EOL.$info.PHP_EOL.print_r($variable, true);
	//$log_file = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'utilities'.DIRECTORY_SEPARATOR.'log_debug'.DIRECTORY_SEPARATOR.'log_debug.txt';
	$log_file = __DIR__.'/log_debug.txt'; //__DIR__ is a contant containing path to the current file while . gives path to the executing file
	//$log_file = dirname(__FILE__).DIRECTORY_SEPARATOR.'log_debug.txt';

	$fh = fopen($log_file, 'a') or die("can't open file");

	fwrite($fh,$strng);

	fclose($fh);
}
