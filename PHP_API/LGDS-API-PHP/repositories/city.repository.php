<?php

class cityRepository
{
    private mysqli $conection;

    function __construct(mysqli $mysqli)
    {
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = 
            "SELECT muni.*, depa.depa_descripcion FROM tblmunicipios as muni
             JOIN tbldepartamentos as depa ON depa.depa_id = muni.depa_id";

        if($stmt = $this->conection->query($query)){

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $city = new city($item);
                    array_push($data, $city);
                }
            }
        }
        return $data;
    }

    function find($value, $column="muni_id"){

        $cities = $this->list();
        $cities_filter = array();
        foreach ($cities as $city) {
            if($city->$column == $value)
                $cities_filter[] = $city;
        }

        return $cities_filter;
    }

    function create(city $city) : array{

        /* json model
        {
            "muni_descripcion":""
            "depa_id":0
        }
        */
        $response = array();
        $query = "INSERT INTO `tblmunicipios`(`muni_descripcion`, `depa_id`) VALUES (?,?);";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("ss", $city->muni_descripcion, $city->depa_id);
            $stmt->execute();
            $response["udp_inserted_id"] = mysqli_insert_id($this->conection);;
            $response["udp_code"] = 0;
            $response["udp_message"] = "Municipio creado con exito";
        } 
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;

    }

    function update($id, city $city) : array{

        /* json model
        {
            "muni_descripcion":""
            "depa_id":0
        }
        */
        $response = array();
        $query = "UPDATE `tblmunicipios` SET `muni_descripcion`=?,`depa_id`=? WHERE `muni_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("sss", $city->muni_descripcion, $city->depa_id, $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Municipio actualizado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }

    function delete($id) : array{

        $response = array();
        $query = "DELETE FROM `tblmunicipios` WHERE `muni_id`=?";

        if($stmt = $this->conection->prepare($query)){
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $response["udp_code"] = 0;
            $response["udp_message"] = "Municipio eliminado con exito";
        }
        else {
            $response["udp_code"] = $stmt->errno;
            $response["udp_message"] = $stmt->error;
        }

        return $response;
    }
}