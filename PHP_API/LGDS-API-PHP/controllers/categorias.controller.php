<?php

class categoriasController
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
        $usua_id = isset($_GET["usuario"]) ? $_GET["usuario"] : null;
        $listado = $this->_SaleServices->list_category($usua_id);

        echo json_encode($listado);
    }

    //[GET_REQUEST]
    public function buscar()
    {
        $categori_id = isset($_GET["id"]) ? $_GET["id"] : null;
        $categori_name = isset($_GET["nombre"]) ? $_GET["nombre"] : null;
        $user_id = isset($_GET["usuario"]) ? $_GET["usuario"] : null;

        $listado = $this->_SaleServices->find_category($categori_id, $categori_name, $user_id);

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
            $category = new category($data);
            $response = $this->_SaleServices->create_category($category);
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
                $category = new category($data);
                $response = $this->_SaleServices->update_category($id,$category);
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
                $response = $this->_SaleServices->delete_category($id,$id_usuario);
                echo json_encode($response);
            }
        }
    }

}

?>