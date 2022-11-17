<?php
include_once 'classes/ExcelC.php';

function getGeoData($adresse){
    $geo = file_get_contents("https://www.google.at/maps/place/".rawurlencode($adresse));
    //.rawurlencode($address));
    if($geo && substr_count($geo, '"code": 200,') != -1){
        preg_match("#/@([0-9.]+),([0-9.]+)#", $geo, $match);
      if ($match){

          return array($match[1], $match[2]);
      }
    }
}

$exlObj = new \Class_Excel\ExcelC('Maerkte2.xlsx');
$Tab = $exlObj->getTable(null,'A94:i216');
$i=94;
foreach ($Tab as $row ) {

   if   ($ret =  getGeoData($row[8]."+".$row[5]."+".$row[6]) ){

       $exlObj->setInCellValue('p'.$i,$ret[0]);
       $exlObj->setInCellValue('q'.$i,$ret[1]);

   }else{
       $exlObj->setInCellValue('o'.$i,0);
   }
   $i++;
}//foreach

$exlObj->update('xlsx');
echo "erfolgreich";
//echo "end ". getGeoData("Rosentaler Straße 74+9220+Velden");
//"#[ ([0-9.]+), ([0-9.]+), 0 ]#"
//"#\",\[\[([0-9.]+),([0-9.]+),([0-9.]+)]#"
//"freistädter+Str.+33,+4040+Linz"
