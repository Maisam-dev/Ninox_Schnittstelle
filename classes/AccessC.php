<?php

namespace Class_Access {

    require_once 'AccessT.php';
    use Trait_Access\AccessT;

    class AccessC
    {

        use AccessT {

            __construct as protected __construct_T;
            ACS_rollBack_ as public rollBack;
            ACS_query_ as  public query;
            ACS_beginTransaction_ as public beginTransaction;
            ACS_commit_ as public commit;
            ACS_errorCode_ as public errorCode;
            ACS_errorInfo_ as public errorInfo;
            ACS_exec_ as public exec;
            ACS_exec_from_Array_ as public exec_from_Array;
            ACS_getAttribute_ as public getAttribute;
            ACS_getConnection_ as public getConnection;
            ACS_inTransaction_ as public inTransaction;
            ACS_lastInsertId_ as public lastInsertId;
            ACS_setAttribute_ as public setAttribute;

        }

        public function __construct($dbq)
        {
            $this->__construct_T($dbq);
        }

        public Static function createObject($dbq)
        {
            return new self($dbq);
        }


    }//class
}//namespace