<?php
class clientRepository{
    private mysqli $conection;

    function __construct(mysqli $mysqli){
        $this->conection = $mysqli;
    }

    function list($usua_id, $clie_estado){
    
        $data = array();
        $query = 
            "SELECT clie.*, muni.muni_descripcion, depa.depa_id, depa.depa_descripcion 
             FROM `tblclientes` as clie
             JOIN tblmunicipios as muni ON muni.muni_id = clie.muni_id
             JOIN tbldepartamentos as depa ON depa.depa_id = muni.depa_id
             WHERE clie.clie_estado = ?";
        if(!empty($usua_id)){
            $query .= " AND clie.usua_id = ?";
        }

        if($stmt = $this->conection->prepare($query)){
            if(!empty($usua_id)){
                $stmt->bind_param("ss",$clie_estado,$usua_id);
            }else{
                $stmt->bind_param("s", $clie_estado);
            }
            $stmt->execute();

            $result = $stmt->get_result();
            while ($item = $result->fetch_assoc()) {
                $client = new client($item);
                array_push($data, $client);
            }
        }
        return $data;
    }

    function find($value, $usua_id, $clie_estado, $column="clie_id"){

        $clients = $this->list($usua_id, $clie_estado);
        $clients_filter = array();
        foreach ($clients as $client) {
            if($client->$column == $value)
                $clients_filter[] = $client;
        }

        return $clients_filter;
    }

    function create(client $client) : array{

        /* json model
        {
            "clie_id":0,
            "clie_dni":"",
            "clie_nombre":"",
            "clie_apellido":"",
            "clie_email":"",
            "clie_telefono":"",
            "clie_direccion":"",
            "clie_fechaCreacion":"",
            "clie_fechaModifica":"",
            "clie_usuarioModifica":0,
            "clie_estado":0,
            "muni_id":0,
            "usua_id":0,
        }
        */
        $response = array();
        $query = 
            "INSERT INTO `tblclientes`
            (`clie_dni`, `clie_nombre`, `clie_apellido`, `clie_telefono`, `clie_email`, `clie_direccion`, `muni_id`, `usua_id`) 
            VALUES (?,?,?,?,?,?,?,?)";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ssssssii", 
                $client->clie_dni, $client->clie_nombre, $client->clie_apellido, $client->clie_telefono,
                $client->clie_email, $client->clie_direccion, $client->muni_id, $client->usua_id,
            );
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Cliente creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, client $client) : array{

        /* json model
        {
            "clie_id":0,
            "clie_dni":"",
            "clie_nombre":"",
            "clie_apellido":"",
            "clie_email":"",
            "clie_telefono":"",
            "clie_direccion":"",
            "clie_fechaCreacion":"",
            "clie_fechaModifica":"",
            "clie_usuarioModifica":0,
            "clie_estado":0,
            "muni_id":0,
            "usua_id":0
        }
        */

        $response = array();
        $query = 
        "UPDATE `tblclientes` 
         SET 
            `clie_dni` = ?,
            `clie_nombre` = ?,
            `clie_apellido` = ?,
            `clie_telefono` = ?,
            `clie_email` = ?,
            `clie_direccion` = ?,
            `muni_id` = ?,
            `clie_fechaModifica` = CURRENT_TIMESTAMP,
            `clie_usuarioModifica` = ?
         WHERE `clie_id` = ? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ssssssiiii", 
                $client->clie_dni, $client->clie_nombre, $client->clie_apellido, $client->clie_telefono,
                $client->clie_email, $client->clie_direccion, $client->muni_id, $client->clie_usuarioModifica,
                $id, $client->usua_id
            );
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Cliente actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete($id_cliente, $id_usuario) : array{

        $response = array();
        $query = "DELETE FROM `tblclientes` WHERE `clie_id`=? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ii", $id_cliente, $id_usuario);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Cliente eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function setState($id_cliente, $id_usuario, $estado){

        $response = array();
        $query = "UPDATE `tblclientes` SET `clie_estado` = ? WHERE `clie_id` = ? AND `usua_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("iii", $estado, $id_cliente, $id_usuario);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Estado de cliente actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

}