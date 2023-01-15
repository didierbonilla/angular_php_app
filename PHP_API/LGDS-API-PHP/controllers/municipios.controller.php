<?php

class municipiosController
{
    public array $public_access = array();
    private GeneralServices $_GeneralServices;
    private HTTP_Response $_serviceResult;
    private helpers $_helpers;

    function __construct()
    {
        $this->_GeneralServices = new GeneralServices();
        $this->_serviceResult = new HTTP_Response();
        $this->_helpers = new helpers();
    }
 
    //[GET_REQUEST]
    public function listar()
    {
        $muni_id = isset($_GET["id"]) ? $_GET["id"] : null;
        $muni_descripcion = isset($_GET["nombre"]) ? $_GET["nombre"] : null;
        $depa_id = isset($_GET["id_departamento"]) ? $_GET["id_departamento"] : null;
        $listado = $this->_GeneralServices->list_city($muni_id,$muni_descripcion,$depa_id);

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
            $city = new city($data);
            $response = $this->_GeneralServices->create_city($city);
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
                $city = new city($data);
                $response = $this->_GeneralServices->update_city($id,$city);
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
                $response = $this->_GeneralServices->delete_city($id);
                echo json_encode($response);
            }
        }
    }

}

?>