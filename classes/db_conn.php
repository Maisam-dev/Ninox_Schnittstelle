<?php

require_once 'IbmT.php';
require_once 'AccessT.php';
require_once 'ExcelT.php';
use Trait_Excel\ExcelT;
use Trait_Access\AccessT;
use Trait_Ibm\IbmT;


class db_conn{

    use IbmT,AccessT,ExcelT{

        IbmT::__construct as protected IBM__construct;

        IBM_GetConnection_ as public IBM_getConnection;
        IBM_Query_ as public IBM_query;


        AccessT::__construct as protected ACS__construct;

        ACS_rollBack_ as public ACS_rollBack;
        ACS_query_ as  public ACS_query;
        ACS_beginTransaction_ as public ACS_beginTransaction;
        ACS_commit_ as public ACS_commit;
        ACS_errorCode_ as public ACS_errorCode;
        ACS_errorInfo_ as public ACS_errorInfo;
        ACS_exec_ as public ACS_exec;
        ACS_exec_from_Array_ as public ACS_exec_from_Array;
        ACS_getAttribute_ as public ACS_getAttribute;
        ACS_getConnection_ as public ACS_getConnection;
        ACS_inTransaction_ as public ACS_inTransaction;
        ACS_lastInsertId_ as public ACS_lastInsertId;
        ACS_setAttribute_ as public ACS_setAttribute;



        ExcelT::__construct as protected EXL__construct;

        EXL_getTable_ as public EXL_getTable;
        EXL_updateCellValue_  as public EXL_setInCellValue;
        EXL_create_xlsx_ as public EXL_create_xlsx;
        EXL_update_ as public EXL_update;
        EXL_applyStyleForm_ as public EXL_applyStyleForm;
        EXL_setDefaultStyle_ as public EXL_setDefaultStyle;
        EXL_ExportStyleForm_ as public EXL_ExportStyleForm;
        EXL_saveXLSX_Form_ as public EXL_saveXLSX_Form;
        EXL_setFormValByCell_ as public EXL_setFormValByCell;
        EXL_setFormValByColAndRow_  as public EXL_setFormValByColAndRow;
        EXL_mergeCellS_ as public EXL_mergeCells;
        EXL_setSheetTitle_ as public EXL_setSheetTitle;
        EXL_setWidth_ as public EXL_setWidth;
        EXL_setPageViewForm_ as public  setPageViewForm;
        EXL_savePDF_Form_ as public EXL_savePDF_Form;


    }

    private $type;

    /**
     * db_conn constructor.
     */
    public function __construct(){

        $numberOfArguments = func_num_args();
        $arguments = func_get_args();

        if (method_exists($this,$function ="__construct".$numberOfArguments)){

             call_user_func_array(array($this,$function),$arguments);
        }
    }

    /**
     * @param $type
     * @param $dbq Pfad von Excel oder Access Datei
     */

     private function __construct2($type,$dbq){

        if (strcasecmp($type,'ACS')==0){

            $this->type=$type;
            $this->ACS__construct($dbq);

        }else if (strcasecmp($type,'EXL')==0){

           $this->type=$type;
           $this->EXL__construct($dbq);
        }

     }

    /**
     * @param $type
     * @param $user
     * @param $pwd
     */
    private function __construct3($type,$user,$pwd){

        if (strcasecmp($type,'IBM')==0){

            $this->type=$type;
            $this->IBM__construct($user,$pwd);

        }

    }

    /**
     * @param string $dbq
     * @return db_conn
     */
    public static function createACS_Object(string $dbq){

        return new self('ACS',$dbq);

}

    /**
     * @param $user
     * @param $pwd
     * @return db_conn
     */
    public static function createIBM_Object($user,$pwd){

        return new self('IBM',$user,$pwd);

    }

    /**
     * @param string $dbq
     * @return db_conn
     */
    public static function createEXL_Object(string $dbq){

        return new self('EXL',$dbq);

    }

}//class