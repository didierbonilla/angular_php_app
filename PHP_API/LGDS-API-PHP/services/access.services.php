<?php

class AccessServices{

    private conection $conection;
    private userRepository $userRepository;
    private helpers $_helpers;

    function __construct(){
        $conection = new conection();

        if ($conection->success) {
            $this->conection = new conection();
            $this->userRepository = new userRepository($this->conection->mysqli);
            $this->_helpers = new helpers();
        }
        else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500,"Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }


    //--------------------------------------------------------- USERS BLOCK ----------------------------------------------------------
    function list_user($rol_id) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $userList = $this->userRepository->list();

        if(!empty($rol_id)){
            $userList = $this->_helpers->filterArray($userList, function (user $value) use ($rol_id) {
                if ($value->rol_id == $rol_id) return true; 
                return false;
            });
        }

        $servicesResult->Ok($userList);
        return $servicesResult;
    }

    function find_user($id,$dni) : HTTP_Response{

        $user = array();
        if(!empty($id))
            $user = $this->userRepository->find($id);
        else if(!empty($dni))
            $user = $this->userRepository->find($dni,"usua_dni");

        $servicesResult = new HTTP_Response();
        $servicesResult->Ok($user);
        return $servicesResult;
    }

    function create_user(user $user) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->find_user( $id=null, $dni=$user->usua_dni )->data;
        if( count($exist) > 0 ){
            $servicesResult->Error(500,"Ya existe un usuario con el dni especificado"); 
        }
        else{
            $response = $this->userRepository->create($user);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }
                   

        return $servicesResult;
    }

    function update_user($id,user $user) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $response = $this->userRepository->update($id,$user);
        if($response["udp_code"] > 0){
            $servicesResult->Error(500,"Error en peticion a base de datos - mysql code: ".$response["udp_code"]);
        } else{
            $servicesResult->Ok($response);
        }

        return $servicesResult;
    }

    function update_password_user($id, user $user) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $response = $this->userRepository->update_password($id,$user);
        if($response["udp_code"] > 0){
            $servicesResult->Error(500,"Error en peticion a base de datos - mysql code: ".$response["udp_code"]);
        } else{
            $servicesResult->Ok($response);
        }

        return $servicesResult;
    }

    function setState_user($id, $state = 0) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $response = $this->userRepository->setState($id,$state);
        if($response["udp_code"] > 0){
            $servicesResult->Error(500,"Error en peticion a base de datos - mysql code: ".$response["udp_code"]);
        } else{
            $servicesResult->Ok($response);
        }    

        return $servicesResult;
    }

}