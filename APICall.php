<?php
require_once 'classes/http_request2/vendor/autoload.php';
require_once  'classes/ApiToDBC.php';
require_once  'classes/downloadC.php';
use API\ApiToDBC;
use API\downloadC;

/*

$url =
    'https://vog.ninoxdb.com/v1/teams/uaru198it6m6mqsx1/databases/xsrw389wnhdb/tables/M/records/417/files/Foto%202021-08-30%2010-55-15.jpg';//'https://media.geeksforgeeks.org/wp-content/uploads/gfg-40.png';

// Use basename() function to return the base name of file
$file_name = basename($url);

// Use file_get_contents() function to get the file
// from url and use file_put_contents() function to
// save the file by using base name


if (file_put_contents($file_name, file_get_contents($url)))
{
    echo "File downloaded successfully";
}
else
{
    echo "File downloading failed.";
}

*/



$obj = new ApiToDBC('phpappl','n4Ovxs&Mlhnl&Yms');

$obj->DBabgleich('VFBAKPFP','U');






    $data =$obj->getDataAsArray('https://vog.ninoxdb.com/share/34a08hveypverqj7i06m5rrghd7k2idt8u4f');
exit();
    foreach ($data as $row){

        if (array_key_exists('Foto1', $row)) {

            $arrayname = explode('/', $row['Foto1']);
            $download = new \API\downloadC();
            $download->downloadFoto($row['Id'],$arrayname[1],'M');
            $download= null;

        }
        if (array_key_exists('Foto2', $row)) {
            $arrayname = explode('/', $row['Foto2']);
            $download = new \API\downloadC();
            $download->downloadFoto($row['Id'],$arrayname[1],'M');
            $download= null;
        }
        if (array_key_exists('Foto3', $row)) {
            $arrayname = explode('/', $row['Foto3']);
            $download = new \API\downloadC();
            $download->downloadFoto($row['Id'],$arrayname[1],'M');
            $download= null;
        }
        if (array_key_exists('Foto4', $row)) {
            $arrayname = explode('/', $row['Foto4']);
            $download = new \API\downloadC();
            $download->downloadFoto($row['Id'],$arrayname[1],'M');
            $download= null;
        }

    }//foreach








$download = new \API\downloadC();
$download->downloadFoto('1224','Foto 2021-12-22 10-12-00.jpg','M');









//    $obj->updateBesuch('https://vog.ninoxdb.com/share/34a08hveypverqj7i06m5rrghd7k2idt8u4f');
//$obj->allFotos('','M');



//$obj->remove('1224','Foto 2021-12-22 10-12-00.jpg');


     // $obj->updateBAkpf('https://vog.ninoxdb.com/share/1pmwz2n89kj0i98tta12jmhlk3tqs3ztelyq');
       // ini_set("default_socket_timeout", 10000);
     // $obj->updateBlspos('https://vog.ninoxdb.com/share/7t6ryzx2xmwxqsa1tquzi55x12l2ncoq2nb2');
       echo "enddddddddddddddddddddddddddddddd";










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