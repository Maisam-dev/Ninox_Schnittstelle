<?php

include 'db_conn.php';

//$Obj = new db_conn('IBM','testphp','Test123$');
$Ibm_Obj = db_conn::createIBM_Object('testphp','Test123$');
$fields = array(
     'ARTIKEL',
     'ARNAM',
     'BETRIEB',
     'NAME');
$data = $Ibm_Obj->IBM_query($fields,'VBNETFIL.VFARTIKEL_JOINV');

/*Daten schreiben */

$ACS_Obj = db_conn::createACS_Object('c:\test\Access_test.accdb');
$ACS_Obj->ACS_exec_from_Array($data,'ARTIKEL,
                                             ARNAM,
                                             BETRIEB,
                                               NAME','Artikel' );


echo 'End';


