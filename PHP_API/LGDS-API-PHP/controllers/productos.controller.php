<?php

class productosController
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
        $id_cateogria = isset($_GET["categoria"]) ? $_GET["categoria"] : 1;
        $id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;
        $estado = isset($_GET["estado"]) ? $_GET["estado"] : null;

        $listado = $this->_SaleServices->list_product($id_usuario,$id_cateogria,$estado);
        echo json_encode($listado);
    }

    public function buscar()
    {
        $id_producto = isset($_GET["id"]) ? $_GET["id"] : null;
        $producto = isset($_GET["nombre"]) ? $_GET["nombre"] : null;
        $id_usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : null;
        $estado = isset($_GET["estado"]) ? $_GET["estado"] : 1;

        $response = $this->_SaleServices->find_product($id_producto, $producto, $id_usuario,$estado);
        echo json_encode($response);
    }

    //[POST_REQUEST]
    public function agregar()
    {
        $data = $this->_helpers->getBodyContent("POST");
        if($data == 1){
            $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
            echo json_encode($this->_serviceResult);
        } else {
            $product = new product($data);
            $response = $this->_SaleServices->create_product($product);
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
                $product = new product($data);
                $response = $this->_SaleServices->update_product($id,$product);
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
                $response = $this->_SaleServices->setState_product($id,$id_usuario,$estado);
                echo json_encode($response);
            }
        }
    }

    //[PUT_REQUEST]
    public function actualizar_stock()
    {
        $accion_stock = isset($_GET["accion_stock"]) ? $_GET["accion_stock"] : null;
        $data = $this->_helpers->getBodyContent("PUT");

        if ($accion_stock == null) {
            $this->_serviceResult->Error(400, utf8_decode("parametro: accion esta vacio - posibles opciones: 1 (sumar), 0 (restar)"));
            echo json_encode($this->_serviceResult);
        } 
        else if($accion_stock != 1 && $accion_stock != 0){
            $this->_serviceResult->Error(400, utf8_decode("parametro: accion es invalido - posibles opciones: 1 (sumar), 0 (restar)"));
            echo json_encode($this->_serviceResult);
        }
        else {
            
            if ($data == 1) {
                $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
                echo json_encode($this->_serviceResult);
            } else {
                $product = new product($data);
                $response = $this->_SaleServices->setStock_product($product, floatval($data["cantidad"]), $accion_stock);
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
                $response = $this->_SaleServices->delete_product($id,$id_usuario);
                echo json_encode($response);
            }
        }
    }

}

?>