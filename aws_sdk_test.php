<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

//Create a S3Client
$s3 = new S3Client([
    'region' => 'eu-west-3',
    'version' => 'latest',
    'credentials' => [
        'key'    => 'AKIAI3DSZ2ZLFW72RYFA',
        'secret' => 'xBBv0eohiI1DqLOEBHVpnNjEa2n/4ex/aLyphvkN',
    ]
]);

$bucket = 'tg-bots';

// Use the high-level iterators (returns ALL of your objects).
try {
    $objects = $s3->getPaginator('ListObjects', [
        'Bucket' => $bucket,
        'Prefix' => 'gifferex/'
    ]);

    echo "Keys retrieved!" . PHP_EOL;
    foreach ($objects as $object) {
      //echo '<pre>' . print_r($object, 1) . '</pre>';
      foreach($object['Contents'] as $content){
        echo $content['Key'] . PHP_EOL;
        //echo '<pre>' . print_r($content, 1) . '</pre>';
        echo '<pre>' . print_r($s3 -> getObjectUrl($bucket, $content['Key']), 1) . '</pre>';
      }
    }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

?>
