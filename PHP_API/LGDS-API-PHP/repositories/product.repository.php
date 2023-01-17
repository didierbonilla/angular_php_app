<?php

class productRepository
{
    private mysqli $conection;

    function __construct(mysqli $mysqli)
    {
        $this->conection = $mysqli;
    }

    function list($usua_id){
    
        $data = array();
        $query = 
            "SELECT prod.*, cate.cate_descripcion FROM `tblproductos` as prod
             JOIN tblcategorias as cate ON prod.cate_id = cate.cate_id";
        if(!empty($usua_id)){
            $query .= " WHERE prod.usua_id = ?";
        }

        if($stmt = $this->conection->prepare($query)){
            if(!empty($usua_id)){
                $stmt->bind_param("s",$usua_id);
            }
            $stmt->execute();
            $stmt = $stmt->get_result();

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $product = new product($item);
                    array_push($data, $product);
                }
            }
        }
        return $data;
    }

    function find($value, $usua_id, string $column="prod_id"){

        $products = $this->list($usua_id);
        $products_filter = array();
        foreach ($products as $product) {
            if($product->$column == $value)
                $products_filter[] = $product;
        }

        return $products_filter;
    }

    function create(product $product) : array{

        /* json model
        {
            "prod_nombre": "",
            "prod_precioCompra": 0,
            "prod_precioVenta": 0,
            "usua_id": 0,
            "cate_id": 0
        }
        */
        $response = array();
        $query = 
            "INSERT INTO `tblproductos`
                (`prod_nombre`, `prod_precioCompra`, `prod_precioVenta`,`usua_id`, `cate_id`) 
                VALUES (?,?,?,?,?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("sddii", 
                $product->prod_nombre, $product->prod_precioCompra, $product->prod_precioVenta,
                $product->usua_id, $product->cate_id
            );
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Producto creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, product $product) : array{

        /* json model
        {
            "prod_nombre": "",
            "prod_precioCompra": 0,
            "prod_precioVenta": 0,
            "prod_usuarioModifica":"",
            "usua_id": 0,
            "cate_id": 0
        }
        */
        $response = array();
        $query = 
            "UPDATE `tblproductos` 
             SET 
                `prod_nombre`=?,
                `prod_precioCompra`=?,
                `prod_precioVenta`=?,
                `cate_id`=?,
                `prod_usuarioModifica`=?,
                `prod_fechaModifica`= CURRENT_TIMESTAMP
             WHERE `prod_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("sddiiii", 
                $product->prod_nombre, $product->prod_precioCompra, $product->prod_precioVenta,
                $product->cate_id, $product->prod_usuarioModifica, $id, $product->usua_id
            );
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Producto actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function setStock(product $product, float $cantidad, bool $add) : array{

        /* json model
        {
            "cantidad": 0,
            "prod_id": "",
            "usua_id": 0
        }
        */

        $response = array();
        $query = "UPDATE `tblproductos` as prod SET prod.`prod_stock`= (prod.prod_stock + ?)  WHERE prod.`prod_id`=? AND prod.`usua_id`=?";
        if($add == false){
            $query = "UPDATE `tblproductos` as prod SET prod.`prod_stock`= (prod.prod_stock - ?)  WHERE prod.`prod_id`=? AND prod.`usua_id`=?";
        }

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("dii", $cantidad, $product->prod_id, $product->usua_id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Stock de producto actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function setState($id, $usua_id, $state) : array{

        $response = array();
        $query = "UPDATE `tblproductos` SET `prod_estado`= ?  WHERE `prod_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("iii", $state, $id, $usua_id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Estado de producto actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete(int $id, int $usua_id) : array{

        $response = array();
        $query = "DELETE FROM `tblproductos` WHERE `prod_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $id, $usua_id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Producto eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }
}