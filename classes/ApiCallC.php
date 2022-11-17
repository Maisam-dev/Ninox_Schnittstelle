<?php
namespace API;
require_once 'classes/http_request2/vendor/autoload.php';
use HTTP_Request2;
use HTTP_Request2_Exception;

class ApiCallC
{

    protected $Url = null;


    public function __construct($Url){
        $this->Url= $Url;

    }

    public function getDataAsArray($url = null){
       ini_set("default_socket_timeout", 10000); // php.ini  requst time

       $url_ =null;

       if ($url){
            $url_=    $url;
        }else {
            $url_=  $this->Url;
        }

        $request = new HTTP_Request2();
        $request->setUrl($url_);
        $request->setConfig(array(
            'follow_redirects' => TRUE,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));

        $request->setHeader(array(
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer NWMzYThhNmEtMjhjYi01MDY3LWI0ZGYtOWYxOGE4ZWNlZjAy'
        ));
        $request->setMethod(HTTP_Request2::METHOD_GET);

        try {

            $response = $request->send();
            if ($response->getStatus() == 200) {

                return json_decode($response->getBody(), true);// from json to hasch Table

            }
            else {
               return 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        }
        catch(HTTP_Request2_Exception $e) {
           return 'Error: ' . $e->getMessage();
        }//catch

    }// getDAtaAsArray



    public function setDaten ($Database,$tab, $bodyJson){
        $request = new HTTP_Request2();
        $request->setUrl("https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/$Database/tables/$tab/records");
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));
        $request->setHeader(array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer NWMzYThhNmEtMjhjYi01MDY3LWI0ZGYtOWYxOGE4ZWNlZjAy'
        ));
        $request->setBody($bodyJson);
        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                return json_decode($response->getBody(), true);// from json to hasch Table

            }
            else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
                return false;
            }
        }
        catch(HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

}//class



/*
 *
https://vog.ninoxdb.com/v1/teams  --- lise Teams

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases   --- liste Databese

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables -- liste Tabls

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records --- list records  von table besuch unter id "M"

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records/417 -- record id "417"

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records/417/files  ---  liste mit allen Dateien  in Tabelle M record 417

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records/417/files/Foto 2021-08-30 10-55-15.jpg -- foto  Foto 2021-08-30 10-55-15.jpg

https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records/417/files/Foto 2021-08-30 10-55-15.jpg/thumb.jpg --- foto  aber kleiner

*/