<?php

namespace Trait_Ibm {

    trait IbmT
    {

        function __construct($user, $pwd)
        {
            $this->get_host();
            $this->IBM_CreateConnection($user, $pwd);

        }

        function __destruct()
        {
            $this->IBM_CloseConnection();
        }

        private $connection_id = null;
        Private $HOST_NAME =  false;

        /**
         *
         * return false oder dev für svatlisweap01 oder prod für svatliweap02
         */
        public function get_host()
        {
            if  (!$this->IBM_IsDB2Connection()) {
                $this->HOST_NAME= getenv('host_name', true);
            }else{

                $this->HOST_NAME= false ;
            }
        }


        /**
         * @return mixed
         */
        protected function IBM_GetConnection_()
        {

            return $this->connection_id;
        }

        /**
         * @param $fields
         * @param $view
         * @param null $globals
         * @param null $order
         * @param null $limit
         * @param null $offset
         * @return array
         */
        protected function IBM_Query_($fields, $view, $globals = NULL, $order = NULL, $limit = NULL, $offset = NULL)
        {

            /* funktioniert auf DEV noch nicht
            if(!$this->CheckView($view)){
                return false;
            }
            */
            $result = array();

            $query = 'select ';

            foreach ($fields as $field ) { // $fields as $field=> $gridfield  // custom:MAAk
                $query .= 'cast( ' . $field . ' as varchar(128) ccsid 1208) as ' . $field . ', ';
            }
            // letzten Beistrich löschen
            $query = substr($query, 0, strlen($query) - 2);

            $query .= ' from ';
            $query .= $view;

            if ($globals != NULL) {

                foreach ($globals as $global => $value) {
                    if (!$this->IBM_SetGlobalSQLVariable($global, $value)) {
                        $fehler = true;
                    }
                }

            }

            if ($order != NULL) {
                $query .= ' order by ';

                foreach ($order as $orderField => $sortOrder) {
                    $query .= !empty($orderField) ? $orderField . ' ' : '';
                    $query .= !empty($sortOrder) ? $sortOrder . ' ' : '';
                    $query .= ', ';

                }
                // den letzten Beistrich entfernen
                $query = substr($query, 0, strlen($query) - 2);

            }

            if ($limit != NULL) {
                $query .= ' limit ' . $limit . ' ';

                if ($offset != NULL) {
                    $query .= ' offset ' . $offset . ' ';
                }
            }

            if ($this->connection_id) {

                $result_id = $this->IBM_ExecSQL($query);
                if ($result_id) {

                    if ($this->IBM_IsDB2Connection()) {

                        while ($row = db2_fetch_assoc($result_id)) {
                            $sf_prepare_field = array();
                            foreach ($fields as $tbl_field => $grid_field) {

                                if (!empty($grid_field)) {
                                    $sf_prepare_field[$grid_field] = $row[$tbl_field];
                                } else {
                                    $sf_prepare_field[$tbl_field] = $row[$tbl_field];
                                }

                            }
                            array_push($result, $sf_prepare_field);

                        }

                    } else {

                        $result_id = odbc_exec($this->connection_id, $query);
                        if ($result_id) {

                            while ($row = odbc_fetch_array($result_id)) {
                                $sf_prepare_field = array();
                                foreach ($fields as $tbl_field => $grid_field) {

                                    if (!empty($grid_field)) {
                                        $sf_prepare_field[$grid_field] = $row[$grid_field]; // $sf_prepare_field[$grid_field] = $row[$tbl_field] // custom:MAAk
                                    } else {
                                        $sf_prepare_field[$tbl_field] = $row[$tbl_field];
                                    }

                                }
                                array_push($result, $sf_prepare_field);
                            }

                        }

                    }
                }


            } else {
                // Log - no connection could be made

            }
            return $result;
        }

        /**
         * @param $varname
         * @param $value
         * @return false|resource
         */
        private function IBM_SetGlobalSQLVariable($varname, $value)
        {

            $query_string = 'set ' . $varname . ' = ';
            $query_string .= is_string($value) ? " '" . $value . "' " : $value;

            return $this->IBM_ExecSQL($query_string);

        }

        /**
         * @return bool
         */
        private function IBM_IsDB2Connection()
        {

            $servername = $_SERVER['SERVER_NAME'];

            if ($servername == 'atvogdev' || $servername == 'atvogl40') {
                return true;
            }

            return false;

        }

        /**
         * @param $object_name
         * @return bool
         */
        private function IBM_CheckView($object_name)
        {

            $object_type = $this->IBM_Get_DB_ObjectType($object_name);

            if ($object_type == 'V') {
                return true;
            }

            return false;

        }

        /**
         * @param $object_name
         * @return bool|mixed
         */
        private function IBM_Get_DB_ObjectType($object_name)
        {

            $query_string = 'select table_type '
                . 'from systables where table_name = '
                . " '"
                . $object_name
                . "' "
                . ' fetch first row only';

            //oder mit where exists abprüfen?

            $result_id = $this->IBM_ExecSQL($query_string);

            if ($result_id) {

                if ($this->IBM_IsDB2Connection()) {

                } else {
                    $result = array();
                    if (odbc_fetch_into($result_id, $result)) {
                        return $result[0];
                    } else {
                        return false;
                    }
                }
            } else {
                //return empty? oder false
                return false;
            }

        }

        /**
         * @param $query_string
         * @return false|resource
         */
        private function IBM_ExecSQL($query_string)
        {

            if ($this->IBM_IsDB2Connection()) {
                return db2_exec($this->connection_id, $query_string);
            } else {
                return odbc_exec($this->connection_id, $query_string);
            }

        }

        /**
         * @param $user
         * @param $pwd
         */
        private function IBM_CreateConnection($user, $pwd)
        {
            // DB2 :
            if ($this->IBM_IsDB2Connection()) {

                $conn_string = '*LOCAL';
                $options = array();
                $options['i5_libl'] = 'SYS';
                $options['i5_naming'] = DB2_I5_NAMING_ON;

                $this->connection_id = db2_connect($conn_string, $user, $pwd, $options);
            } // ODBC :
            else {
                  //custom maak
                if ($this->HOST_NAME){

                    if ($this->HOST_NAME==='prod'){
                        $conn_string = "DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogl40.vog.local;NAM=1;DFT=5;DEC=1;";
                    }else{
                        //return "DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogdev.vog.local;NAMING=0";
                        //  return "DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogdev.vog.local;PersistSecurityInfo=False;";
                        $conn_string ="DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogdev.vog.local;NAM=1;DFT=5;DEC=1;";//  "DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogdev.vog.local;NAM=1;DFT=5;DEC=1;";

                    }
                    $this->connection_id = odbc_connect($conn_string, $user, $pwd);
                }else
                    return false;

                }
             //   $conn_string = 'DRIVER={IBM i Access ODBC Driver};SYSTEM=atvogdev.vog.local;NAM=1;DFT=5;DEC=1;CCSID=1208;';

        }//function

        /**
         * Sub
         */
        private function IBM_CloseConnection()
        {
            if (! empty($this->connection_id)) {
                if (!$this->IBM_IsDB2Connection()) {
                    odbc_close(($this->connection_id));
                } else {
                    db2_close($this->connection_id);
                }
            }
        }

    }//Trait

}//namespace