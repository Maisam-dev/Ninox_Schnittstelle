<?php

namespace API;

require_once 'classes/ApiCallC.php';
require_once 'classes/IbmC.php';
use Class_Ibm\IbmC;
use API\ApiCallC;
use Dompdf\Exception;
use HTTP_Request2;
use HTTP_Request2_Exception;

class ApiToDBC extends ApiCallC
{


    /**
     * @param $url
     */
    public function updateBesuch ($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','".
                    $row['BesuchID']."',".
                    "timestamp_iso('". str_replace ('T',' ',$row['von']) ."'),".
                    "timestamp_iso('";
                if (array_key_exists('Ende',$row)) { $values .=  str_replace ('T',' ',$row['Ende'])."'),'";}else {$values .="2022-01-01 11:59:59'),'";}
                if (array_key_exists('KUNDE_GRUPPE',$row)) { $values .= $row['KUNDE_GRUPPE']."','";}else {$values .="0','";}
                if (array_key_exists('Marktnr',$row)) { $values .= $row['Marktnr']."','";}else {$values .="0','";}
                if (array_key_exists('Marktname',$row)) { $values .= $row['Marktname']."','";}else {$values .="','";}
                if (array_key_exists('Ort',$row)) { $values .= $row['Ort']."','";}else {$values .="','";}
                if (array_key_exists('Strasse',$row)) { $values .= $row['Strasse']."','";}else {$values .="','";}
                if (array_key_exists('Kommentar',$row)) { $values .= str_replace ("'"," ",strip_tags ($row['Kommentar']))."','";}else {$values .="','";}
                if (array_key_exists('KW',$row)) { $values .= $row['KW']."','";}else {$values .="0','";}
                if (array_key_exists('jahr',$row)) { $values .= $row['jahr']."','";}else {$values .="0','";}
                if (array_key_exists('Foto1',$row)) { $values .= $row['Foto1']."','";}else {$values .="','";}
                if (array_key_exists('Foto2',$row)) { $values .= $row['Foto2']."','";}else {$values .="','";}
                if (array_key_exists('Foto3',$row)) { $values .= $row['Foto3']."','";}else {$values .="','";}
                if (array_key_exists('Foto4',$row)) { $values .= $row['Foto4']."','";}else {$values .="','";}
                if (array_key_exists('vertreternr',$row)) { $values .= $row['vertreternr']."','";}else {$values .="0','";}
                if (array_key_exists('Vertreter',$row)) { $values .= $row['Vertreter']."','";}else {$values .="','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo
            }//foreach
            $values =   substr($values,0,-1);


            $sql= "insert into vbnetfil.VFBESUCHP(
       NR,
       BESUCHID,
       VON,
       ENDE,
       KDGRPNR,
       MARKTNR,
       MARKTNAM,
       ORT,
       Strasse,
       BEMERKUNG,
       KW,
       JAHR,
       f1,
       f2,
       f3,
       f4,
       VERTRETERNR,
       VERTRETERNAM,
       ERSTELLT
       ) values ".  $values;

            //$sql = strip_tags($sql); //  Html Tags entferen
            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateBesuch

    private $Ibm_link= null;

    public function __construct($user,$pass){

      $this->Ibm_link= new IbmC($user,$pass);
   }



    /**
     * @param $url
     * @return bool|void
     */

    public function updateBAkpf($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('IDAktion',$row)) { $values .= $row['IDAktion']."','";}else {$values .="0','";}
                if (array_key_exists('BesuchID',$row)) {$values .= $row['BesuchID']."','";}else {$values .="0','";}
                if (array_key_exists('BesuchNr',$row)) {$values .= $row['BesuchNr']."','";}else {$values .="0','";}
                if (array_key_exists('Posnr',$row)) { $values .= $row['Posnr']."','";}else {$values .="0','";}
                //if (array_key_exists('Aktionstitel',$row)) { $values .= $row['Aktionstitel']."','";}else {$values .="','";}
                if (array_key_exists('Status',$row)) { $values .= $row['Status']."','";}else {$values .="','";}
                if (array_key_exists('AkStatus',$row)) { $values .= $row['AkStatus']."','";}else {$values .="','";}
                if (array_key_exists('im Markt vorhanden',$row)) { if ($row ['im Markt vorhanden']){$values .= $row['im Markt vorhanden']."','";}else {$values .="0','";} }else {$values .="0','";}
                if (array_key_exists('Ware Text',$row)) { $values .= $row['Ware Text']."','";}else {$values .="','";}
                if (array_key_exists('im Regal',$row)) { if ($row ['im Regal']){$values .= $row['im Regal']."','";}else {$values .="0','";} }else {$values .="0','";}
                if (array_key_exists('Sonderplatzierung',$row) ) { if ($row ['Sonderplatzierung']) {$values .= $row['Sonderplatzierung']."','";}else {$values .="0','";}}else {$values .="0','";}
                if (array_key_exists('Platz text',$row)) { $values .= $row['Platz text']."','";}else {$values .="','";}
                if (array_key_exists('Preisschild',$row)) { if ($row ['Preisschild']){$values .= $row['Preisschild']."','";}else {$values .="0','";}}else {$values .="0','";}
                if (array_key_exists('schild Text',$row)) { $values .= $row['schild Text']."','";}else {$values .="','";}
                if (array_key_exists('kontrolliert',$row)) { if ($row ['kontrolliert']){$values .= $row['kontrolliert']."','";}else {$values .="0','";}}else {$values .="0','";}
                if (array_key_exists('Kommentar',$row)) { $values .= $row['Kommentar']."','";}else {$values .="','";}
                if (array_key_exists('Preis vorschlagen',$row)) { $values .= str_replace('.',',',$row['Preis vorschlagen'])."','";}else {$values .="0','";}
                if (array_key_exists('letzter Vorschlag',$row)) { $values .=str_replace('.',',', $row['letzter Vorschlag'])."','";}else {$values .="0','";}
                if (array_key_exists('Artikel Gruppe',$row)) { $values .= $row['Artikel Gruppe']."','";}else {$values .="0','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo
            }//foreach
            $values =   substr($values,0,-1);


//      AKTIONSTITEL,
            $sql= "insert into vbnetfil.VFBAKPFP (NR,
                                                  AKTIONID,
                                                  BESUCHID,
                                                  BesuchNr,
                                                  POSNR, 
                                               
                                                  STATUS, 
                                                  Akstatus, 
                                                  IM_MARKT, 
                                                  WARETEXT, 
                                                  REGAL, 
                                                  SONDERPLATZIERUNG, 
                                                  PLATZTEXT, 
                                                  PREISSCHILD, 
                                                  SCHILDTEXT, 
                                                  KONTOLIERT, 
                                                  BEMERKUNG, 
                                                  PREISVORSCHLAG,
                                                  LETZTERVORSCHLAG, 
                                                  ARGRUP, 
                                                  ERSTELTVON ) values ". $values;


            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if

    }// updateBapf

    /**
     * @param $url
     */

    public function updateBlspos($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data) ){
            if (count($Data) ==0) {return true;}
            $values= null;
            $counter = 0;
            $rond = 0;
            foreach ($Data as $row){
                $tampe = count($Data);
                $rond ++;
            $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('BesuchID',$row)) {$values .= $row['BesuchID']."','";}else {$values .="0','";}
                if (array_key_exists('BesuchNr',$row)) {$values .= $row['BesuchNr']."','";}else {$values .="0','";}
                if (array_key_exists('Posnr',$row)) { $values .= $row['Posnr']."','";}else {$values .="0','";}
                if (array_key_exists('Status',$row)) { $values .= $row['Status']."','";}else {$values .="','";}
                if (array_key_exists('im Markt vorhanden',$row)) { if ($row ['im Markt vorhanden']){$values .= $row['im Markt vorhanden']."','";}else {$values .="0','";} }else {$values .="0','";}
                if (array_key_exists('Ware Text',$row)) { $values .= $row['Ware Text']."','";}else {$values .="','";}
                if (array_key_exists('Kommentar',$row)) { $values .= $row['Kommentar']."','";}else {$values .="','";}
                if (array_key_exists('kontrolliert',$row)) { if ($row ['kontrolliert']){$values .= $row['kontrolliert']."','";}else {$values .="0','";}}else {$values .="0','";}

                if (array_key_exists('Status',$row)  and $row['Status'] == 'zusätzlich') {
                    if (array_key_exists('ArtikelGrp',$row)) { $values .= $row['ArtikelGrp']."','";}else {$values .="0','";}
                    if (array_key_exists('ArName',$row)) { $values .= $row['ArName']."','";}else {$values .="','";}
                }else{
                    if (array_key_exists('ARTIKELGRUPPENNAME',$row)) { $values .= $row['ARTIKELGRUPPENNAME']."','";}else {$values .="','";}
                    if (array_key_exists('ARNAM',$row)) { $values .= $row['ARNAM']."','";}else {$values .="','";}
                }

                if (array_key_exists('ArtNr',$row)) { $values .= $row['ArtNr']."','";}else {$values .="','";}
                if (array_key_exists('Betrieb',$row)) { $values .= $row['Betrieb']."','";}else {$values .="','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";}

                // verteilen die grosse Daten mehr 2000 Datensatz
                $counter ++;
                if ($counter < 2000  ) {
                    if ( $rond < count($Data) ){
                        continue;
                    }
                }

                $values =   substr($values,0,-1);

               $sql= "insert into VBNETFIL.VFBLSTPOSP(
                    NR,
                    BESUCHID,
                    BesuchNr,
                    POSNR,
                    STATUS,
                    MARKT,
                    WARETXT,
                    BEMERKUNG,
                    KONTOLLIERT,
                    ARTGRP,
                    Arname,
                    ARNR,
                    BIB,
                    ERSTELLT
               ) values ". $values;

               $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
               $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);
                    $values= null;
                    $counter = 0;

                if ($ret){
                    continue;
                }else {
                    break;
                }
            }//foreach

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateBlspos

    /**
     * @param $url
     * @return bool
     */


    public function updateZeiterfassung($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data) ){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('ID',$row)) {$values .= $row['ID']."','";}else {$values .="0','";}
                if (array_key_exists('Datum',$row)) { $values .= $row['Datum']."','";}else {$values .="1995-01-01','";}
                if (array_key_exists('Anfang',$row)) { $values .= date ('H:i:s',strtotime($row['Anfang'])-3600) ."','";}else {$values .="00:00:00','";}
                if (array_key_exists('Ende',$row)) { if ($row ['Ende']){$values .= date ("H:i:s",strtotime($row['Ende']) - 3600) ."','";}else {$values .="00:00:00','";} }else {$values .="00:00:00','";}
                if (array_key_exists('zeit',$row)) { $values .= $row['zeit']."','";}else {$values .="0.0','";}
                if (array_key_exists('rundZeit',$row)) { $values .= $row['rundZeit']."','";}else {$values .="0','";}
                if (array_key_exists('Diäten',$row)) { $values .= $row['Diäten']."','";}else {$values .="0.0','";}
                if (array_key_exists('Art',$row)) { $values .= $row['Art']."','";}else {$values .="','";}
                if (array_key_exists('Bemerkung',$row)) { $values .= $row['Bemerkung']."','";}else {$values .="','";}
                if (array_key_exists('Ort',$row)) { $values .= $row['Ort']."','";}else {$values .="','";}
                if (array_key_exists('Kategorie',$row)) { $values .= $row['Kategorie']."','";}else {$values .="','";}
               // if (array_key_exists('PersonalNr',$row)) { $values .= $row['PersonalNr']."','";}else {$values .="0','";}
                if (array_key_exists('übernacht',$row)) { if ($row ['übernacht']){$values .= $row['übernacht']."','";}else {$values .="0','";} }else {$values .="0','";}
                if (array_key_exists('Erstellt',$row)) { $values .= $row['Erstellt']."'),";}else {$values .="'),";}
            }//foreach

            $values =   substr($values,0,-1);

            $sql= "insert into vbnetfil.vfzeitp(
        NR,
        ID,
        Datum,
        Anfang,
        Ende,
        Zeit,
        rundzeit,
        Diaeten,
        Art,
        Bemerkung,
        Ort,
        Kategorie,
        eubernacht,  
        erstellt
        ) values ". $values;

            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateZeiterfassung


    public function updateAufgabe($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data) ){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('ID',$row)) {$values .= $row['ID']."','";}else {$values .="0','";}
                if (array_key_exists('erfassungID',$row)) { $values .= $row['erfassungID']."','";}else {$values .="0','";}
                if (array_key_exists('Aufgabe',$row)) { $values .= $row['Aufgabe']."','";}else {$values .="','";}
                if (array_key_exists('Bemerkung',$row)) { $values .= $row['Bemerkung']."','";}else {$values .="','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";}
            }//foreach

            $values =   substr($values,0,-1);
//Diaeten
            $sql= "insert into vbnetfil.VFAUFGABEP(
              Nr,
              \"ID\",
              ZEITID,
              AUFGABE,
              BEMERKUNG,
              ERSTELLT
        ) values ". $values;

            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateZeiterfassung





    /**
     * @param $milliseconds
     * @param string $format
     * @return string|void
     */


public function toTime($milliseconds , $format = '%02d:%02d'){

        if ($milliseconds < 1){
            return;
        }
    $seconds = floor ($milliseconds/1000);
    $min = floor ($seconds/60);
    $hours = floor($min/60);

    $min = $min % 60 ;
    return sprintf($format,$hours,$min);

}



    /**
     * @param $tab
     * @param $tabNinoxId
     */
  public function DBabgleich($db,$tab,$tabNinoxId, $where=""){
try {
    $sql = "select nr from vbnetfil.$tab where abgleichen = 0 $where"; // todo
    $ret = odbc_exec($this->Ibm_link->getConnection(), $sql);
    while ($row = odbc_fetch_array($ret)) {
        $body = array('id' => $row['NR'], 'fields' => array('kopiert' => true));
        $Ninoxrow = $this->setDaten($db,$tabNinoxId, json_encode($body));
        if (isset($Ninoxrow['id'])) {
            odbc_exec($this->Ibm_link->getConnection(), "update vbnetfil.$tab set abgleichen = 1  WHERE NR = {$Ninoxrow['id']} $where"); //todo
        } else if (isset ($Ninoxrow['_err']) and 'Record not found' == $Ninoxrow['_err']) {
            odbc_exec($this->Ibm_link->getConnection(), "delete vbnetfil.$tab  WHERE NR = {$row['NR']} $where"); // todo
        }
    }
    return true;
} catch (Exception $e){
  echo  $e->getMessage();
    return false;
}

  }//DBabgleich


 public function setAktion (){
      try{
          $sql ="Select distinct  kpf.NINOXNR, kpf.idaktion, kde.idkunde, agr.Betrieb, kdgr.ninoxnr as kdnoxnr,  nox.ninoxnr,
agr.ARTIKEL_HAUPTGRUPPE,  ' ' as Status,
aktionstitel, KWvon, KWbis, Aktionsjahr, DatumVon, DatumBis, Aktionsart, lieferung, hinweis,  anlagedatum, anlageuser, kpf.timestamp_insert, kpf.update_time
    from VFAKTKOPF kpf
    inner join VFAKTKUNDE kde on kpf.IDAKTION = kde.IDAKTION
    left join VFAKTARTGR artgr on kpf.idaktion = artgr.idaktion
 inner join VFARGRPP agr on artgr.AG_ID = agr.artikel_gruppe
    left join VFKDGRPP kdgr on kdgr.kunde_gruppe = kde.idkunde   
    left join vfnoxakp nox on nox.Aktionid =  kpf.idaktion and nox.kundgrnr = kde.idkunde  and nox.GRZUOrd = agr.artikel_Hauptgruppe
where kpf.datumvon >= date('2022-09-01') and nox.ninoxnr is null";

          $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);
          if ($ret){
              while ($row = odbc_fetch_array($ret)){
                  $body = array('fields' => array('IDAktion'=>$row['IDAKTION'],
                      'Aktionstitel'=>  mb_convert_encoding(html_entity_decode($row['AKTIONSTITEL']),"ISO-8859-1"),
                      'KWvon'=>$row['KWVON'],
                      'KWbis'=>$row['KWBIS'],
                      'Aktionsjahr'=>$row['AKTIONSJAHR'],
                      'Status_'=>$row['STATUS'],
                      'DatumVon'=>$row['DATUMVON'],
                      'DatumBis'=>$row['DATUMBIS'],
                      'Hinweis'=>str_replace(   ';',',',$row['HINWEIS']),
                      'vfkdgrpp'=>$row['KDNOXNR'],
                      'Artikel_Hauptgruppe'=>mb_convert_encoding(html_entity_decode($row['ARTIKEL_HAUPTGRUPPE']),"ISO-8859-1"),
                      'Betrieb'=>$row['BETRIEB']
                  ));
                  $Ninoxrow = $this->setDaten('xsrw389wnhdb','K', json_encode($body));
                  if (isset($Ninoxrow['id'])) {
                      $sql="insert into vfnoxakp (Ninoxnr,Aktionid,kundgrnr,GRZUORD) values('{$Ninoxrow['id']}','{$Ninoxrow['fields']['IDAktion']}','{$row['IDKUNDE']}','{$row['ARTIKEL_HAUPTGRUPPE']}')";
                      $d=  odbc_exec($this->Ibm_link->getConnection(),$sql);
                  }
              }//while
              return true;
          }

      } catch (Exception $e){
         echo  $e->getMessage();
         return false;
      }
 } //setAktion

public function setAktionsArtikel (){
try{
    $sql = "Select ninoxnr, idaktion, art.bib, Artikel, Arnam, nox.primary_ID
 from vbnetfil.VfAKARTIK art 
 inner Join vogfil.ARSTAV1 ars on art.bib = ars.bib and art.artikel=ars.ar#
 inner join vbnetfil.VfnoxAKP nox on art.idaktion = nox.aktionid 
where nox.akartkopiert =0
 ";

    $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);
if ($ret){
    while ($row = odbc_fetch_array($ret)){
        $body = array('fields' => array(
            'Aktionenkopf'=>$row['NINOXNR'],
            'BIB'=>$row['BIB'],
            'ARTIKEL'=>$row['ARTIKEL'],
            'artbez'=>  mb_convert_encoding(html_entity_decode($row['ARNAM']),"ISO-8859-1")
        ));

        $Ninoxrow = $this->setDaten('xsrw389wnhdb','LB', json_encode($body));
        if (isset($Ninoxrow['id'])) {
            $sql="update vbnetfil.vfnoxakp set Akartkopiert = 1 where primary_ID ={$row['PRIMARY_ID']}";
            $d=  odbc_exec($this->Ibm_link->getConnection(),$sql);
        }
    }//while
    return true;
}

} catch (Exception $e){
echo  $e->getMessage();
return false;

}

} //setAktionsArtikel

//update Spessen
    /**
     * @param $url
     */
    public function updateSpesen ($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                  //  $row['BesuchID']."',".
                    //"timestamp_iso('". str_replace ('T',' ',$row['von']) ."'),".
                   // "timestamp_iso('";
                if (array_key_exists('Datum',$row)) { $values .=  str_replace ('T',' ',$row['Datum'])."','";}else {$values .="'2022-01-01','";}
                if (array_key_exists('Foto',$row)) { $values .= $row['Foto']."','";}else {$values .="','";}
                if (array_key_exists('RE.Betrag Brutto',$row)) { $values .= $row['RE.Betrag Brutto']."','";}else {$values .="0','";}
                if (array_key_exists('Kostenart',$row)) { $values .= $row['Kostenart']."','";}else {$values .="','";}
                if (array_key_exists('MWST 20%',$row)) { $values .= $row['MWST 20%']."','";}else {$values .="0','";}
                if (array_key_exists('MWST 10%',$row)) { $values .= $row['MWST 10%']."','";}else {$values .="0','";}
                if (array_key_exists('MWST DIV',$row)) { $values .= $row['MWST DIV']."','";}else {$values .="0','";}
                if (array_key_exists('Gesamt incl Trinkgeld',$row)) { $values .= $row['Gesamt incl Trinkgeld']."','";}else {$values .="0','";}
                if (array_key_exists('Teilnehmer',$row)) { $values .= $row['Teilnehmer']."','";}else {$values .="','";}
                if (array_key_exists('Grund',$row)) { $values .= $row['Grund']."','";}else {$values .="','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo

            }//foreach
            $values =   substr($values,0,-1);


            $sql= "insert into vbnetfil.GROSPESEN(
             NR,
             Datum,
             Foto,
             REBretto,
             Kostenart,
             MWST20,
             MWST10,
             MWSTDiv,
             Ge_incl_Trinkgeld,
             Teilnehmer,
             GRUND,
             ersteller      
       ) values ".  $values;

            //$sql = strip_tags($sql); //  Html Tags entferen
            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateSpessen


// todo Table Besuch, auftrag, auftragpos  weiter aufbauen....
    public function updateGastroBesuch ($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','".
                    $row['BesuchID']."',".
                    "timestamp_iso('". str_replace ('T',' ',$row['von']) ."'),".
                    "timestamp_iso('";
                if (array_key_exists('Ende',$row)) { $values .=  str_replace ('T',' ',$row['Ende'])."'),'";}else {$values .="2022-01-01 11:59:59'),'";}
                if (array_key_exists('Foto1',$row)) { $values .= $row['Foto1']."','";}else {$values .="','";}
                if (array_key_exists('Foto2',$row)) { $values .= $row['Foto2']."','";}else {$values .="','";}
                if (array_key_exists('Firmenname',$row)) { $values .= $row['Firmenname']."','";}else {$values .="','";}
                if (array_key_exists('Kommentar',$row)) { $values .= str_replace ("'"," ",strip_tags ($row['Kommentar']))."','";}else {$values .="','";}
                if (array_key_exists('KW',$row)) { $values .= $row['KW']."','";}else {$values .="0','";}
                if (array_key_exists('jahr',$row)) { $values .= $row['jahr']."','";}else {$values .="0','";}
                if (array_key_exists('ORT',$row)) { $values .= $row['ORT']."','";}else {$values .="','";}
                if (array_key_exists('Strasse',$row)) { $values .= $row['Strasse']."','";}else {$values .="','";}
                if (array_key_exists('telefonisch',$row)) { $values .= $row['telefonisch']."','";}else {$values .="0','";}
                if (array_key_exists('Count of AuftragNr',$row)) { $values .= $row['Count of AuftragNr']."','";}else {$values .="0','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo


            }//foreach
            $values =   substr($values,0,-1);


            $sql= "insert into vbnetfil.GroBesuch(
       NR,
       BESUCHID,
       VON,
       ENDE,
       FOTO1,
       FOTO2,
       FIRMENNAME,
       KOMMENTAR,
       KW,
       JAHR,
       ORT, 
       Strasse,                        
       TELEFONISCH,
       AUFTRAG_COUT,
       ERSTELLT
       ) values ".  $values;

            //$sql = strip_tags($sql); //  Html Tags entferen
            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateGastroBesuch


    public function updateAuftrag ($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('BesuchNr',$row)) { $values .= $row['BesuchNr']."','";}else {$values .="'0,'";}
                if (array_key_exists('Status',$row)) { $values .= $row['Status']."','";}else {$values .="','";}
                if (array_key_exists('info from Kundenstamm',$row)) { $values .= $row['info from Kundenstamm']."','";}else {$values .="','";}
                if (array_key_exists('Auftragsdatum',$row)) { $values .= $row['Auftragsdatum']."','";}else {$values .="2022-01-01','";}
                if (array_key_exists('Liefertermin',$row)) { $values .= $row['Liefertermin']."','";}else {$values .="2022-01-01','";}
                if (array_key_exists('Art des Auftrags',$row)) { $values .= $row['Art des Auftrags']."','";}else {$values .="','";}
                if (array_key_exists('Händler',$row)) { $values .= $row['Händler']."','";}else {$values .="','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo
            }//foreach
            $values =   substr($values,0,-1);


            $sql= "insert into vbnetfil.GroAuftrag(
       NR,
       BESUCHNR,
       STATUS,
       INFOKUNDE,
       AUFTRAGSDATUM,
       LIEFERTERMIN,
       AUFTRAGART,
       HAENLER,
       ERSTELLT
       ) values ".  $values;

            //$sql = strip_tags($sql); //  Html Tags entferen
            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateAuftrag


    public function updateAuftragPos ($url){

        $this->Url = $url;
        $Data = $this->getDataAsArray();

//schleife durch  $Data  dann sql Abfrage erstellen
        if (is_array($Data)){
            if (count($Data) ==0) {return true;}
            $values= null;
            foreach ($Data as $row){
                $values .=
                    "('".
                    $row['Id']."','";
                if (array_key_exists('AuftragNr',$row)) { $values .= $row['AuftragNr']."','";}else {$values .="0','";}
                if (array_key_exists('Karton',$row)) { $values .= $row['Karton']."','";}else {$values .="0','";}
                if (array_key_exists('Flaschen',$row)) { $values .= $row['Flaschen']."','";}else {$values .="0','";}
                if (array_key_exists('UVP',$row)) { $values .= $row['UVP']."','";}else {$values .="0','";}
                if (array_key_exists('ArtBez',$row)) { $values .= $row['ArtBez']."','";}else {$values .="','";}
                if (array_key_exists('Total Preis',$row)) { $values .= $row['Total Preis']."','";}else {$values .="0','";}
                if (array_key_exists('Created by',$row)) { $values .= $row['Created by']."'),";}else {$values .="'),";} //todo
            }//foreach
            $values =   substr($values,0,-1);


            $sql= "insert into vbnetfil.GroAuftgpo(
              NR,
              AuftragNr,                   
              KARTON,
              Flaschen,
              UVP,
              ARTBEZ,
              TOTAL_PREIS,
              ERSTELLT
       ) values ".  $values;

            //$sql = strip_tags($sql); //  Html Tags entferen
            $sql=  mb_convert_encoding(html_entity_decode($sql),"ISO-8859-1");
            $ret = odbc_exec($this->Ibm_link->getConnection(),$sql);

            if ($ret ){
                return true;
            }else{
                return false;
            }
        }else {
            echo $Data;
        }//if
    }//updateAuftragPos


}//class