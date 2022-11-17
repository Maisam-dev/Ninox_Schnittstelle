<?php

namespace Trait_Access{

    use PDO;

    trait AccessT{


        private  $connection_Linke;

        /**
         * AccessT constructor.
         * @param $dbq
         */

        public function __construct($dbq){

        $this->connection_Linke = $this->ACS_createConnection($dbq);

        }

       /**
        * @param $dbq
        * @return PDO
        */
        private function  ACS_createConnection($dbq){

           $connectionString =
              'odbc:' .
              'Driver={Microsoft Access Driver (*.mdb, *.accdb)};' .
              'Dbq='. "$dbq". ";" .
              'Uid=Admin;';
           $db = new PDO($connectionString);

           return $db;
        }

        /**
         * @return PDO
         */
         protected function ACS_getConnection_(){

              return $this->connection_Linke;

         }

         /**
          * @param String $query
          * @return array
          */
          protected function ACS_query_ (String $query ){

              $rows =array();

              $this->connection_Linke->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              foreach ($this->connection_Linke->query($query) as $row) {

                  array_push($rows, $row);

              }

              return $rows;

          }

        /**
         * @param $DataArray
         * @param $Fields
         * @param $Table
         */
          protected function ACS_exec_from_Array_($DataArray,$Fields,$Table){
              $Values =null;

              foreach ($DataArray as $row){

                  $Values =null;

                  foreach ($row as $val){

                      $Values.=" '".$val."', ";
                  }

                  $Values = substr($Values,0,strlen($Values)-2);
                  $this->ACS_exec_('insert into '.$Table.' ('.$Fields.' ) values ( '." $Values".' )');

              }

          }


        //begin: Standard Functionen

        /**
         * @param String $query
         * @return mixed
         */
          protected function ACS_exec_ (String $query ){
            return   $this->connection_Linke->exec($query);
          }

        /**
         * @return mixed
         */
         protected function ACS_beginTransaction_(){
            return  $this->connection_Linke->beginTransaction();
         }

        /**
         * @return mixed
         */
          protected function ACS_commit_(){
             return  $this->connection_Linke->commit();
          }

        /**
         * @return mixed
         */
          protected function ACS_rollBack_(){
             return  $this->connection_Linke->rollBack();
          }

        /**
         * @return mixed
         */
          protected function ACS_errorCode_(){
             return  $this->connection_Linke->errorCode();
          }

        /**
         * @return mixed
         */
         protected function ACS_errorInfo_(){
            return  $this->connection_Linke->errorInfo();
         }

        /**
         * @param int $Attribute
         * @return mixed
         */
          protected function ACS_getAttribute_( int $Attribute){
              return  $this->connection_Linke->getAttribute($Attribute);
          }

        /**
         * @return mixed
         */
         protected function ACS_inTransaction_(){
            return  $this->connection_Linke->inTransaction();
         }

        /**
         * @param int $Attribute
         * @param $value
         * @return mixed
         */

         protected function ACS_setAttribute_( int $Attribute  , $value){
            return  $this->connection_Linke->sisetAttribute( $Attribute , $value);
         }

        /**
         * @param null $name
         * @return mixed
         */
          protected function ACS_lastInsertId_($name = null){
             return  $this->connection_Linke->lastInsertId($name);
          }
    //END: Standard Functionen

    }//trait

}//namespace