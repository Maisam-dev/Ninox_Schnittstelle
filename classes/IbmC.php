<?php


namespace Class_Ibm {

    require_once 'IbmT.php';
    use Trait_Ibm\IbmT;

    class IbmC
    {

        use IbmT {
            IbmT::__construct as protected __construct_T;
            IbmT::IBM_GetConnection_ as public getConnection;
            IbmT::IBM_Query_ as public query;
        }

        /**
         * IbmC constructor.
         * @param $user
         * @param $pwd
         */
        public function __construct($user, $pwd)
        {
            $this->__construct_T($user, $pwd);
        }


    }//Class
}//namespace