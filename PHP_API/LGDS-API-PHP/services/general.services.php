<?php
/*
namespace services\GeneralServices;

use helpers\conection\conection;
use helpers\HTTP_Response\HTTP_Response;
use repositories\user\userRepository;
use mysqli;
*/
/*
require_once("../helpers/conection.class.php");
require_once("../helpers/HTTP_Response.class.php");
require_once("../repositories/user.respository.php");
*/
class GeneralServices{

    private mysqli $conection;
    private userRepository $userRepository;

    function __construct(){
        $conection = new conection();

        if ($conection->success) {
            $this->conection = $conection->mysqli;
            $this->userRepository = new userRepository($this->conection);
        }
        else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500,"Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }


    //--------------------------------------------------------- USERS BLOCK ----------------------------------------------------------
    function list() : HTTP_Response{

        $userList = $this->userRepository->list();

        $servicesResult = new HTTP_Response();
        $servicesResult->Ok($userList);
        return $servicesResult;
    }
}