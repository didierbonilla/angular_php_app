<?php

class roleRepository
{
    private mysqli $conection;

    function __construct(mysqli $mysqli)
    {
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = "SELECT * FROM `tblroles`";

        if($stmt = $this->conection->query($query)){

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $role = new role($item);
                    array_push($data, $role);
                }
            }
        }
        return $data;
    }

    function find($value, $column="rol_id"){

        $roles = $this->list();
        $roles_filter = array();
        foreach ($roles as $role) {
            if($role->$column == $value)
                $roles_filter[] = $role;
        }

        return $roles_filter;
    }

    function create(role $role) : array{

        /* json model
        {
            "rol_descripcion":""
        }
        */
        $response = array();
        $query = "INSERT INTO `tblroles`(`rol_descripcion`) VALUES (?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s", $role->rol_descripcion);
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Rol creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, role $role) : array{

        /* json model
        {
            "rol_descripcion":""
        }
        */
        $response = array();
        $query = "UPDATE `tblroles` SET `rol_descripcion`=? WHERE `rol_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $role->rol_descripcion, $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Rol actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete($id) : array{

        $response = array();
        $query = "DELETE FROM `tblroles` WHERE `rol_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Rol eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }
}