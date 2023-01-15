<?php

class rolesController
{
    public array $public_access = array();
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
        $rol_id = isset($_GET["id"]) ? $_GET["id"] : null;
        $rol_descripcion = isset($_GET["nombre"]) ? $_GET["nombre"] : null;
        $listado = $this->_AccessServices->list_role($rol_id,$rol_descripcion);

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
            $role = new role($data);
            $response = $this->_AccessServices->create_role($role);
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
        else {
            
            $data = $this->_helpers->getBodyContent("PUT");
            if ($data == 1) {
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $role = new role($data);
                $response = $this->_AccessServices->update_role($id,$role);
                echo json_encode($response);
            }
        }
    }

    //[DELETE_REQUEST]
    public function eliminar()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        } 
        else {
            
            $data = $this->_helpers->getBodyContent("DELETE");
            if ($data == 1) {
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $response = $this->_AccessServices->delete_role($id);
                echo json_encode($response);
            }
        }
    }

}

?>