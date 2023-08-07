<?php
/*
namespace services\GeneralServices;

use helpers\conection\conection;
use helpers\HTTP_Response\HTTP_Response;
use repositories\user\userRepository;
use mysqli;
*/
/*
require_once("../helpers/conection.class.php");
require_once("../helpers/HTTP_Response.class.php");
require_once("../repositories/user.respository.php");
*/
class GeneralServices{

    private conection $conection;
    private stateRepository $stateRepository;
    private cityRepository $cityRepository;
    private helpers $_helpers;

    function __construct(){
        $conection = new conection();

        if ($conection->success) {
            $this->conection = new conection();
            $this->stateRepository = new stateRepository($this->conection->mysqli);
            $this->cityRepository = new cityRepository($this->conection->mysqli);
            $this->_helpers = new helpers();
        }
        else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500,"Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }

//--------------------------------------------------------- STATES BLOCK ----------------------------------------------------------

    function list_state($state_id,$state) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $stateList = $this->stateRepository->list();

        if(!empty($state_id)){
            $stateList = $this->stateRepository->find($state_id);
        }
        else if(!empty($state)){
            $stateList = $this->stateRepository->find($state,"depa_descripcion");
        }

        $servicesResult->Ok($stateList);
        return $servicesResult;
    }

    function create_state(state $state) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->stateRepository->find($state->depa_descripcion,"depa_descripcion");
        if( count($exist) > 0 ){
            $servicesResult->Error(500,"Ya existe un departamento con este nombre"); 
        }
        else{
            $response = $this->stateRepository->create($state);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }
                   

        return $servicesResult;
    }
    
    function update_state(int $id, state $state) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->stateRepository->find($id);
        if( count($exist) == 0 ){
            $servicesResult->Error(500,"El registro requerido no existe"); 
        }
        else{
            $response = $this->stateRepository->update($id,$state);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function delete_state(int $id) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->stateRepository->find($id);
        if( count($exist) == 0 ){
            $servicesResult->Error(500,"El registro requerido no existe"); 
        }
        else{
            $response = $this->stateRepository->delete($id);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

//--------------------------------------------------------- CITIES BLOCK ----------------------------------------------------------

    function list_city($city_id, $city, $state_id, $group) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $citiesList = $this->cityRepository->list();

        if($group == true){
            $statesList = $this->stateRepository->list();
            foreach ( $statesList as $state) {
                $state_cities = $this->cityRepository->find($state->depa_id,"depa_id");
                $state->municipios = $state_cities;
            }

            $citiesList = $statesList;
        }
        else if(!empty($city_id)){
            $citiesList = $this->cityRepository->find($city_id);
        }
        else if(!empty($city)){
            $citiesList = $this->cityRepository->find($city,"muni_descripcion");
        }
        else if(!empty($state_id)){
            $citiesList = $this->cityRepository->find($state_id,"depa_id");
        }

        $servicesResult->Ok($citiesList);
        return $servicesResult;
    }

    function create_city(city $city) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        //filterArray
        $exist = $this->_helpers->filterArray($this->cityRepository->list(), function (city $value) use ($city) {
            if ($value->muni_descripcion == $city->muni_descripcion && $value->depa_id == $city->depa_id) return true; 
            return false;
        });

        if( count($exist) > 0 ){
            $servicesResult->Error(500,"Ya existe este municipio"); 
        }
        else{
            $response = $this->cityRepository->create($city);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }
                

        return $servicesResult;
    }

    function update_city(int $id, city $city) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->cityRepository->find($id);
        if( count($exist) == 0 ){
            $servicesResult->Error(500,"El registro requerido no existe"); 
        }
        else{
            $response = $this->cityRepository->update($id,$city);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function delete_city(int $id) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->cityRepository->find($id);
        if( count($exist) == 0 ){
            $servicesResult->Error(500,"El registro requerido no existe"); 
        }
        else{
            $response = $this->cityRepository->delete($id);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }
}