<?php

class clientesController
{
    public array $public_access = array();
    private SaleServices $_SaleServices;
    private HTTP_Response $_serviceResult;
    private helpers $_helpers;

    function __construct()
    {
        $this->_SaleServices = new SaleServices();
        $this->_serviceResult = new HTTP_Response();
        $this->_helpers = new helpers();
    }
 
    //[GET_REQUEST]
    public function listar()
    {
        $estado = isset($_GET["estado"]) ? $_GET["estado"] : 1;
        $id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;

        /*if (empty($id_usuario)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: usuario esta vacio"));
            echo json_encode($this->_serviceResult);
        }else{*/
            $listado = $this->_SaleServices->list_client($id_usuario,$estado);
            echo json_encode($listado);
        //}
    }

    //[POST_REQUEST]
    public function agregar()
    {
        $data = $this->_helpers->getBodyContent("POST");
        if($data == 1){
            $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
            echo json_encode($this->_serviceResult);
        } else {
            $client = new client($data);
            $response = $this->_SaleServices->create_client($client);
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
                $client = new client($data);
                $response = $this->_SaleServices->update_client($id,$client);
                echo json_encode($response);
            }
        }
    }

    //[PUT_REQUEST]
    public function actualizar_estado()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;
        $estado = isset($_GET["estado"]) ? $_GET["estado"] : 0;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        } 
        else if (empty($id_usuario)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: usuario esta vacio"));
            echo json_encode($this->_serviceResult);
        } 
        else {
            
            $data = $this->_helpers->getBodyContent("PUT");
            if ($data == 1) {
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $response = $this->_SaleServices->setState_client($id,$id_usuario,$estado);
                echo json_encode($response);
            }
        }
    }

    //[DELETE_REQUEST]
    public function eliminar()
    {
        $id = isset($_GET["id"]) ? $_GET["id"] : null;
        $id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;

        if (empty($id)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: id esta vacio"));
            echo json_encode($this->_serviceResult);
        } 
        else if (empty($id_usuario)) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: usuario esta vacio"));
            echo json_encode($this->_serviceResult);
        } 
        else {
            
            $data = $this->_helpers->getBodyContent("DELETE");
            if ($data == 1) {
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $response = $this->_SaleServices->delete_client($id,$id_usuario);
                echo json_encode($response);
            }
        }
    }

}

?>