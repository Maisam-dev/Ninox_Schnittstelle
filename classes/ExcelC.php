<?php


namespace Class_Excel;
require_once 'ExcelT.php';
require_once 'Definition.php';
use Trait_Excel\ExcelT;



class ExcelC implements \Definition
{


   use ExcelT{

       __construct as __constructT;
       EXL_getTable_ as public getTable;
       EXL_updateCellValue_  as public setInCellValue;
       EXL_create_xlsx_ as public create_xlsx;
       EXL_update_ as public update;
       EXL_applyStyleForm_ as public applyStyleForm;
       EXL_setDefaultStyle_ as public setDefaultStyle;
       EXL_ExportStyleForm_ as public ExportStyleForm;
       EXL_saveXLSX_Form_ as public saveXLSX_Form;
       EXL_setFormValByCell_ as public setFormValByCell;
       EXL_setFormValByColAndRow_  as public setFormValByColAndRow;
       EXL_mergeCellS_ as public mergeCells;
       EXL_setSheetTitle_ as public setSheetTitle;
       EXL_setWidth_ as public setWidth;
       EXL_setPageViewForm_ as public  setPageViewForm;
       EXL_savePDF_Form_ as public savePDF_Form;
   }


}