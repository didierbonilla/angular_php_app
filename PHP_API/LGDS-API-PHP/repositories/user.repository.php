<?php
/*
namespace repositories\user;

use mysqli;
use models\user\user;
*/

//include_once("../models/UserViewModel.php");
class userRepository{
    private mysqli $conection;

    function __construct(mysqli $mysqli){
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = 
            "SELECT
                usua.*, muni.muni_descripcion, depa.depa_id, depa.depa_descripcion, rol.rol_descripcion
            FROM `tblusuarios` as usua
            JOIN tblroles as rol ON rol.rol_id = usua.rol_id
            JOIN tblmunicipios as muni ON muni.muni_id = usua.muni_id
            JOIN tbldepartamentos as depa ON depa.depa_id = muni.depa_id";

        if($stmt = $this->conection->query($query)){

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $user = new user($item);
                    array_push($data, $user);
                }
            }
        }

        return $data;
    }

    function find($value, $column="usua_id"){

        $users = $this->list();
        $users_filter = array();
        foreach ($users as $user) {
            if($user->$column == $value)
                $users_filter[] = $user;
        }

        return $users_filter;
    }

    function create(user $user) : array{

        /* json model
        {
            usua_dni:"",
            usua_nombre:"",
            usua_apellido:"",
            usua_email:"",
            usua_telefono:"",
            muni_id:"",
            rol_id:"",
            usua_direccion:"",
            usua_password:"",
        }
        */
        $response = array();

        $password = password_hash($user->usua_password, PASSWORD_DEFAULT);
        $query = "CALL UDP_usuarios_INSERT(?,?,?,?,?,?,?,?,?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param(
                "sssssiiss",
                $user->usua_dni, $user->usua_nombre, $user->usua_apellido, $user->usua_email, $user->usua_telefono,
                $user->muni_id, $user->rol_id, $user->usua_direccion, $password
            );
            $stmt->execute();
            $stmt->bind_result($last_id);
            $stmt->fetch();
            $response["udp_inserted_id"] = $last_id;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Usuario creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, user $user) : array{

        /* json model
        {
            usua_nombre:"",
            usua_apellido:"",
            usua_email:"",
            usua_telefono:"",
            muni_id:"",
            rol_id:"",
            usua_direccion:"",
            usua_modifica:"",
        }
        */
        $response = array();
        $query = "CALL UDP_usuarios_UPDATE(?,?,?,?,?,?,?,?,?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param(
                "issssiisi",
                $id, $user->usua_nombre, $user->usua_apellido, $user->usua_email, $user->usua_telefono,
                $user->muni_id, $user->rol_id, $user->usua_direccion, $user->usua_modifica
            );
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Usuario actualizado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function update_password($id, user $user){
        $response = array();

        $password = password_hash($user->usua_password, PASSWORD_DEFAULT);
        $query = "UPDATE `tblusuarios` as usua SET usua.usua_password= ? WHERE usua.usua_id=?;";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss",$password,$id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Password actualizada con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function setState($id, $state){
        $response = array();

        $query = "UPDATE `tblusuarios` as usua SET usua.`usua_activo`= ? WHERE usua.usua_id=?;";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("is",$state,$id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Estado de usuario actualizado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }
    
    function getPassword(string $column, string $value){

        $password = null;
        $query = "SELECT usua.usua_password FROM `tblusuarios` as usua WHERE usua.usua_dni = ?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s",$value);
            $stmt->execute();

            $stmt->bind_result($password);
            $stmt->fetch();
        }

        return $password;
    }

}
