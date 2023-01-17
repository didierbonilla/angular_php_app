<?php

class categoryRepository
{
    private mysqli $conection;

    function __construct(mysqli $mysqli)
    {
        $this->conection = $mysqli;
    }

    function list($usua_id){
    
        $data = array();
        $query = "SELECT * FROM `tblcategorias`";
        if (!empty($usua_id))
            $query .= " WHERE `usua_id` = ?";

        if($stmt = $this->conection->prepare($query)){
            if (!empty($usua_id)){
                $stmt->bind_param("s", $usua_id);
            }
            $stmt->execute();
            $stmt = $stmt->get_result();

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $category = new category($item);
                    array_push($data, $category);
                }
            }
        }
        return $data;
    }

    function find($value, $usua_id, $column="cate_id"){

        $categories = $this->list($usua_id);
        $categories_filter = array();
        foreach ($categories as $category) {
            if($category->$column == $value)
                $categories_filter[] = $category;
        }

        return $categories_filter;
    }

    function create(category $category) : array{

        /* json model
        {
            "cate_descripcion":""
            "usua_id":0
        }
        */
        $response = array();
        $query = "INSERT INTO `tblcategorias`(`cate_descripcion`, `usua_id`) VALUES (?,?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $category->cate_descripcion, $category->usua_id);
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);
            $response["udp_code"] = 0;
            $response["udp_message"] = "Categoria creada con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($cate_id,category $category) : array{

        /* json model
        {
            "cate_descripcion":""
            "usua_id":0
        }
        */
        $response = array();
        $query = "UPDATE `tblcategorias` SET `cate_descripcion`=? WHERE `cate_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("sss", $category->cate_descripcion, $cate_id, $category->usua_id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Categoria actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete($cate_id, $usua_id) : array{

        $response = array();
        $query = "DELETE FROM `tblcategorias` WHERE `cate_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $cate_id, $usua_id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Categoria eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }
}