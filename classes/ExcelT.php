<?php


namespace Trait_Excel {

    require_once 'spreadsheet/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    trait ExcelT
    {

        private $file = null;
        private $spreadsheet = null;
        public $lastColumn = null;
        public $countRows = null;
        private $spreadsheetForm = null;

        //Style//
        public $F_bold = false;
        public $F_italic = false;
        public $F_underline = 'none';
        public $F_size = 11;
        public $F_name = 'Calibri';
        public $F_color = 'FF000000';

        public $Alignment_horizontal = 'left';

        public $FillType = 'solid';
        public $BackColor = 'FFFFFFFF';

        public $Border = 'none';    //  'allBorders';    https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/
        public $Border_Style = 'thin';
        public $Border_Color = 'FF000000';

        public $FormatCode = '#,##0.00';

        private $style = array(); //  Arrray for Style


        public function __construct($file)
        {

            if (file_exists($file)) {
                $this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
                $this->lastColumn = $this->spreadsheet->getActiveSheet()->getHighestColumn();
                $this->countRows = $this->spreadsheet->getActiveSheet()->getHighestRow();
            } else {
                $this->spreadsheetForm = new Spreadsheet();
                $this->EXL_updateStyle();
            }

            $this->file = $file;

        }

        /**
         *
         */

        private function EXL_updateStyle()
        {

            /* $this->F_bold=['font'=>['bold'=>true] ];
             $this->F_italic=['font'=>['italic'=>true] ];
             $this->F_underline=['font'=>['underline'=>true] ];
             $this->F_size=['font'=>['size'=>$this->Size] ];
             $this->F_name=['font'=>['name'=>$this->Name_font] ];

             $this->Alignment_R = [ 'alignment' => [
                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                 ]
             ];
             $this->Alignment_L = [ 'alignment' => [
                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                 ]
             ];
             $this->Alignment_C= [ 'alignment' => [
                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                 ]
             ];

             $this->BackColor = ['fill' => [  'endColor' => ['argb' => $this->Color]]];

             $this->F_Color = ['startColor' => ['argb' =>  $this->Color]]; ///chick

         // border
           $this->styleBorder =  [
                 'borders' => [
                     $this->styleBorder_Border => [
                         'borderStyle' =>  $this->styleBorder_Style,
                         'color' => ['argb' =>  $this->styleBorder_Color],
                     ],
                 ],
           ];

     // number

         $this->styleNumberOrDate =  [
             'numberFormat' => [
                 'formatCode' => $this->styleNumberOrDate_FormatCode
             ]
         ];

     */


            $this->style = [
                'font' => [
                    'bold' => $this->F_bold,
                    'italic' => $this->F_italic,
                    'underline' => $this->F_underline,
                    'size' => $this->F_size,
                    'name' => $this->F_name,
                    'color' => [
                        'argb' => $this->F_color
                    ]
                ],

                'alignment' => [
                    'horizontal' => $this->Alignment_horizontal
                ],

                'fill' => [
                    'type' => $this->FillType,
                    // 'endColor' => ['argb' => $this->BackColor],
                    'color' => [
                        'argb' => $this->BackColor
                    ]
                ],

                'borders' => [
                    $this->Border => [
                        'style' => $this->Border_Style,  // or 'borderStyle' =>
                        'color' => [
                            'argb' => $this->Border_Color
                        ],
                    ],
                ],
                'numberFormat' => [
                    'formatCode' => $this->FormatCode
                ]

            ];

        }// getstyle()

        /**
         * @param null $range @$range zb A1:E30
         * @param null $file
         * @return array
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
         */
        protected function EXL_getTable_($file = null, $range = null)
        {
            $spreadsheet = null;
            if (!empty($file)) {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

            } else if  (!empty ($this->spreadsheet)) {

                $spreadsheet = $this->spreadsheet;
            }
            else {
                die ('File not Existiert');
            }
            // check File ob es Existiert
            if (!empty($range)) {
                return $spreadsheet->getActiveSheet()->rangeToArray($range);
            } else {
                return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            }
        }

        /**
         * @param $Cell
         * @param $value
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_updateCellValue_($Cell, $value)
        {
            $this->spreadsheet->getActiveSheet()->setCellValue($Cell, $value);

        }

        /**
         * @param $writType
         * @param null $newname
         * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
         */
        protected function EXL_update_($writType, $newname = null)
        {
            $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->spreadsheet, $writType);
            if (empty($newname)) {
                $objWriter->save($this->file);

            } else
                $objWriter->save($newname);
        }

        /**
         * @param $DataArray
         * @return bool
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
         */

        protected function EXL_create_xlsx_($DataArray)
        {
            $ret = false;
            if (empty($this->spreadsheetForm))
            {
                die ('filename  '.$this->file.' is exists' );
            }
            $spreadsheet = $this->spreadsheetForm;

            $rowNum = 1;
            foreach ($DataArray as $row) {
                $columnNum = 0;
                foreach ($row as $value) {
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValueByColumnAndRow($columnNum, $rowNum, $value);
                    $columnNum++;
                }//foreach Row
                $rowNum++;
            }//foreach Column

            $writer = new Xlsx($spreadsheet);
            $writer->save($this->file);
            $ret = true;
            return $ret;
        }


        ///////////////////* Form *//////////////////////////////////////////////////////////////////

        /**
         * @param $Cell
         * @param $val
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */

        protected function EXL_setFormValByCell_($Cell, $val)
        {

            $this->spreadsheetForm->setActiveSheetIndex(0)
                ->setCellValue($Cell, $val);

        }

        /**
         * @param $Col
         * @param $row
         * @param $val
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_setFormValByColAndRow_($Col, $row, $val)
        {

            $this->spreadsheetForm->setActiveSheetIndex(0)
                ->setCellValueByColumnAndRow($Col, $row, $val);

        }

        /**
         * @param $cellOrRange
         * @param null $arrStyle
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_applyStyleForm_($cellOrRange, $arrStyle = null)
        {
            if (empty($arrStyle)) {
                $this->EXL_updateStyle();
                $arrStyle = $this->style;
            }

            $this->spreadsheetForm->getActiveSheet()->getStyle($cellOrRange)->applyFromArray($arrStyle);

        }

        /**
         *
         */
         protected function EXL_setDefaultStyle_(){
             $this->F_bold = false;
             $this->F_italic = false;
             $this->F_underline = 'none';
             $this->F_size = 11;
             $this->F_name = 'Calibri';
             $this->F_color = 'FF000000';

             $this->Alignment_horizontal = 'left';

             $this->FillType = 'solid';
             $this->BackColor = 'FFFFFFFF';

             $this->Border = 'none';    //  'allBorders';    https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/
             $this->Border_Style = 'thin';
             $this->Border_Color = 'FF000000';

             $this->FormatCode = '#,##0.00';

         }

        /**
         * @param null $SHEETVIEW
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
         protected function EXL_setPageViewForm_ ($SHEETVIEW = null ){

             if ( empty ($SHEETVIEW)  ){

                 $SHEETVIEW = 'pageLayout';

             }
             $this->spreadsheetForm->getActiveSheet()->getSheetView()->setView($SHEETVIEW);
         }

        /**
         * @param $cellOrRange
         * @return \PhpOffice\PhpSpreadsheet\Style as Array
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_ExportStyleForm_($cellOrRange = null)
        {

            return $this->spreadsheetForm->getActiveSheet()->getStyle($cellOrRange);

        }

        /**
         * @param $Column
         * @param $width
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */

        protected function EXL_setWidth_($Column, $width)
        {

            $this->spreadsheetForm->getActiveSheet()->getColumnDimensionByColumn($Column)->setWidth($width);
        }

        /**
         * @param $Title
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_setSheetTitle_($Title)
        {

            $this->spreadsheetForm->getActiveSheet()->setTitle($Title);
        }

        /**
         * @param $col1 int
         * @param $row1 int
         * @param $col2 int
         * @param $row2 int
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         */
        protected function EXL_mergeCellS_($col1, $row1, $col2, $row2)
        {

            $this->spreadsheetForm->getActiveSheet()->mergeCellsByColumnAndRow($col1, $row1, $col2, $row2);
        }

        /**
         * @return bool
         * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
         */
        protected function EXL_saveXLSX_Form_()
        {

            $writer = new Xlsx($this->spreadsheetForm);

            $writer->save($this->file);

            if (file_exists($this->file))
                return true;
            else
                return false;

        }

        /**
         * @throws \PhpOffice\PhpSpreadsheet\Exception
         * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
         */
        protected function EXL_savePDF_Form_(){

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($this->spreadsheetForm);
            //$writer->setPreCalculateFormulas(false); // Default Value is True
            $writer->save($this->file);

            if (file_exists($this->file))
                return true;
            else
                return false;

        }
    }// Trait

}//namespace