<?php
class stateRepository{
    private mysqli $conection;

    function __construct(mysqli $mysqli){
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = "SELECT * FROM `tbldepartamentos`";

        if($stmt = $this->conection->query($query)){

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $state = new state($item);
                    array_push($data, $state);
                }
            }
        }
        return $data;
    }

    function find($value, $column="depa_id"){

        $states = $this->list();
        $states_filter = array();
        foreach ($states as $state) {
            if($state->$column == $value)
                $states_filter[] = $state;
        }

        return $states_filter;
    }

    function create(state $state) : array{

        /* json model
        {
            "depa_descripcion":""
        }
        */
        $response = array();
        $query = 
            "INSERT INTO `tbldepartamentos`(`depa_descripcion`) VALUES (?);";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s", $state->depa_descripcion);
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Departamento creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, state $state) : array{

        /* json model
        {
            "depa_descripcion":""
        }
        */

        $response = array();
        $query = "UPDATE `tbldepartamentos` SET `depa_descripcion`=? WHERE `depa_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $state->depa_descripcion, $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Departamento actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete($id) : array{

        $response = array();
        $query = "DELETE FROM `tbldepartamentos` WHERE `depa_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Departamento eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

}