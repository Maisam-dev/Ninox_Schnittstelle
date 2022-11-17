<?php


namespace API;


use HTTP_Request2;
use HTTP_Request2_Exception;

class downloadC
{
    public function downloadFoto($recordId,$Filename,$tableId)
    {


        header("Content-Type:  image/jpeg");
        header("Content-Disposition: attachment; filename= $Filename");
        $request = new HTTP_Request2();
        $request->setUrl("https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/$tableId/records/$recordId/files/$Filename");
        $request->setMethod(HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
            'follow_redirects' => TRUE,
            'ssl_verify_peer' => false,
            'ssl_verify_host' => false
        ));
        $request->setHeader(array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer NWMzYThhNmEtMjhjYi01MDY3LWI0ZGYtOWYxOGE4ZWNlZjAy'

        ));
        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                echo $response->getBody()  ;
            }
            else {
                echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
                    $response->getReasonPhrase();
            }
        }
        catch(HTTP_Request2_Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }//instalFotos


    public function remove($recordId,$Filename){

        if (!file_exists("c:/ninox/fotos/$recordId")) {
            mkdir("c:/ninox/fotos/$recordId", 0777, true);

        }
        rename("C:\Users\maak\Downloads\\$Filename","c:/ninox/fotos/$recordId/$Filename");
        unlink("C:\Users\maak\Downloads\\$Filename");

    }




}