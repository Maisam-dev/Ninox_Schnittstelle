<?php

include 'ExcelC.php';
include 'IbmC.php';
include 'AccessC.php';
include 'db_conn.php';
include '../xmlreader/xmlfu.php';

// lessen Excel Datei \\
/*
$excel = new \Class_Excel\ExcelC('test\test2.xlsx');
$tab = $excel->getTable(null,'A4:E30');  //  von 'test\test2.xlsx
$tab = $excel->getTable(); // ganze Table

$tab = $excel->getTable('c:\test.xlsx','A4:E30'); // von Andereer File
echo 'END';*/


//update Excel Datei */
/*
$excel = new \Class_Excel\ExcelC('test\test_2.xlsx');
$excel->setInCellValue('B103','VOG_TEST');
$excel->setInCellValue('B104','VOG_TEST');
$excel->setInCellValue('B105','VOG_TEST');
$excel->update('xlsx','test\test\test3.xlsx');
echo 'END';
*/

/// Create von ARRAY*/
///
/*
$con_arr = getCon_Link('testphp','Test123$') ;
$DataArr =   getXmlSpalteTab($con_arr['ConnectionId'],$con_arr['Type']) ;
$excel = new \Class_Excel\ExcelC('test\test_Create30.xlsx');
if ( $excel->create_xlsx($DataArr)) echo 'erfolgreich';
*/


//create Form */

$obj = new \Class_Excel\ExcelC('test\test_CreateFormmaak11.xlsx');
$obj->setSheetTitle('test');
$obj->setWidth(0,30);
$obj->setWidth(1,40);
$obj->setWidth(2,40);
$obj->setWidth(3,40);



$obj->setFormValByCell('A1','TEST Formular');
$obj->setFormValByCell('A2','FIRMA:');
$obj->setFormValByCell('B2','VOG');
$obj->setFormValByCell('A3','Adresse:');
$obj->setFormValByCell('b3','Bäckermühlweg44');
$obj->setFormValByCell('A4','tel:');
$obj->setFormValByCell('b4','06XXXXXX');
$obj->setFormValByCell('A6','BETRIEB');
$obj->setFormValByCell('B6','ARTIKEL_GRUPPE');
$obj->setFormValByCell('c6','ARTIKEL_BEZEICHNUNG');
$obj->setFormValByCell('d6','ARTIKEL_HAUPTGRUPPE');

$IBMObj = new Class_Ibm\IbmC('testphp','Test123$');
$filds = array ('BETRIEB','ARTIKEL_GRUPPE','ARTIKEL_BEZEICHNUNG','ARTIKEL_HAUPTGRUPPE');
 $data = $IBMObj->query($filds ,'VBNETFIL.VFARGRPP');


 // Daten Schreiben  mit foreach

$Rownum =7;
foreach ($data as $row ){
    $colnum =0;
    foreach ( $row as $val) {
        $obj->setFormValByColAndRow($colnum,$Rownum,$val);
        $colnum++;
    }
    $Rownum ++;
}// foreach

$obj->setFormValByColAndRow(0,$Rownum,'ENDE');

$obj->mergeCellS(0,1,3,1);

//style:all Form//
$obj->Border = \Class_Excel\ExcelC::BORDER_OUTLINE;
$obj->Border_Style = \Class_Excel\ExcelC::BORDER_STYLE_THICK;
$obj->Border_Color =  \Class_Excel\ExcelC::COLOR_BLUE;
$obj->applyStyleForm('A1:D22');


//style title//
$obj->setDefaultStyle();
$obj->F_size=30;
$obj->F_bold = true ;
$obj->F_italic = true ;
$obj->F_underline =  \Class_Excel\ExcelC::UNDERLINE_DOUBLEACCOUNTING;
$obj->F_name ='Algerian';
$obj->F_color = \Class_Excel\ExcelC::COLOR_GREEN;
$obj->Alignment_horizontal = \Class_Excel\ExcelC:: HORIZONTAL_CENTER;

$obj->applyStyleForm('A1');

//style line//
$obj->setDefaultStyle();
$obj->BackColor = \Class_Excel\ExcelC::COLOR_GREEN;
$obj->mergeCellS(0,5,3,5);
$obj->applyStyleForm('A5');

//style Header//
$obj->setDefaultStyle();
$obj->F_size=12;
$obj->F_bold = true ;
$obj->F_name ='Algerian';
$obj->F_color = \Class_Excel\ExcelC::COLOR_BLACK;
$obj->Alignment_horizontal = \Class_Excel\ExcelC::HORIZONTAL_CENTER;
$obj->BackColor =\Class_Excel\ExcelC::COLOR_DARKGREEN;
$obj->applyStyleForm('A6:d6');

//style cell data//
/*
$obj->setDefaultStyle();
$obj->Border = \Class_Excel\ExcelC::BORDER_INSIDE;
$obj->Border_Style = \Class_Excel\ExcelC::BORDER_STYLE_THIN;
$obj->Border_Color =  \Class_Excel\ExcelC::COLOR_BLACK;
$obj->applyStyleForm('A7:D'.$Rownum ); */

//style Footer//
$obj->setDefaultStyle();
$obj->F_size=30;
$obj->F_bold = true ;
$obj->F_italic = true ;
$obj->BackColor =\Class_Excel\ExcelC::COLOR_DARKGREEN;
$obj->Alignment_horizontal = \Class_Excel\ExcelC::HORIZONTAL_CENTER;
$obj->mergeCellS(0,$Rownum,3,$Rownum);
$obj->applyStyleForm('A'.$Rownum);


//$obj->FormatCode = \Class_Excel\ExcelC::FORMAT_DATE_DDMMYYYY; //todo

//$obj->savePDF_Form();

//$obj->setPageViewForm();   //Layout

if ($obj->saveXLSX_Form()) echo 'Formular  ist erstellt';