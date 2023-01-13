<?php

class usuariosController
{
    private AccessServices $_AccessServices;
    private HTTP_Response $_serviceResult;
    private helpers $_helpers;

    function __construct()
    {
        $this->_AccessServices = new AccessServices();
        $this->_serviceResult = new HTTP_Response();
        $this->_helpers = new helpers();
    }
 
    //[GET_REQUEST]
    public function listar()
    {
        $rol_id = isset($_GET["rol_id"]) ? $_GET["rol_id"] : null;
        $listado = $this->_AccessServices->list_user($rol_id);

        echo json_encode($listado);
    }

    //[GET_REQUEST]
    public function buscar()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $dni = isset($_GET["dni"]) ? $_GET["dni"] : null;

        $listado = $this->_AccessServices->find_user($id,$dni);
        echo json_encode($listado);
    }

    //[POST_REQUEST]
    public function agregar()
    {
        $data = $this->_helpers->getBodyContent("POST");
        if($data == 1){
            $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
            echo json_encode($this->_serviceResult);
        } else {
            $user = new user($data);
            $user->usua_password = $data["usua_password"];
            $response = $this->_AccessServices->create_user($user);
            echo json_encode($response);
        }
    }

    //[PUT_REQUEST]
    public function editar()
    {

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        }
        else{

            $data = $this->_helpers->getBodyContent("PUT");
            if($data == 1){
                $this->_serviceResult->Error(405, utf8_decode("Metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $user = new user($data);
                $response = $this->_AccessServices->update_user($id, $user);
                echo json_encode($response);
            }
        }   
    }

    //[PUT_REQUEST]
    public function actualizar_password()
    {

        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        }
        else{

            $data = $this->_helpers->getBodyContent("PUT");
            if($data == 1){
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult); 
            } else {
                $user = new user($data);
                $response = $this->_AccessServices->update_password_user($id,$user);
                echo json_encode($response); 
            }
        }   
    }

    //[DELETE_REQUEST]
    public function actualizar_estado()
    {

        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $state = isset($_GET["estado"]) ? $_GET["estado"] : 0;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        }
        else{

            $data = $this->_helpers->getBodyContent("DELETE");
            if($data == 1){
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $response = $this->_AccessServices->setState_user($id, $state);
                echo json_encode($response);
            }

        }   
    }
}

?>