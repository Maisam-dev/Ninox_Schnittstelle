<?php
require_once 'classes/http_request2/vendor/autoload.php';
require_once 'classes/downloadC.php';
use API\downloadC;
if (array_key_exists('tab',$_GET) and array_key_exists('record',$_GET) and array_key_exists('name',$_GET)){

    $downObj = new \API\downloadC();
    $downObj->downloadFoto($_GET['record'],$_GET['name'],$_GET['tab']);


}