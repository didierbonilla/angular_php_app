<?php

class SaleServices
{
    private conection $conection;
    private clientRepository $clientRepository;
    private helpers $_helpers;

    function __construct()
    {
        $conection = new conection();

        if ($conection->success) {
            $this->conection = new conection();
            $this->clientRepository = new clientRepository($this->conection->mysqli);
            $this->_helpers = new helpers();
        } else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500, "Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }

    //--------------------------------------------------------- CLIENT BLOCK ----------------------------------------------------------

    function list_client($user_id, $client_state) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $clientsList = $this->clientRepository->list($user_id,$client_state);

        $servicesResult->Ok($clientsList);
        return $servicesResult;
    }

    function find_client($client_id, $client_dni, $usua_id, $client_state) : HTTP_Response{
        $servicesResult = new HTTP_Response();
        $clientsList = array();

        if(!empty($client_id)){
            $clientsList = $this->clientRepository->find($client_id, $usua_id, $client_state);
        }
        else if(!empty($client_dni)){
            $clientsList = $this->clientRepository->find($client_dni, $usua_id, $client_state, "clie_dni");
        }

        $servicesResult->Ok($clientsList);
        return $servicesResult;
    }

    function create_client(client $client) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        //filterArray
        $exist_active = $this->clientRepository->find($client->clie_dni, $client->usua_id, 1, "clie_dni");
        $exist_inactive = $this->clientRepository->find($client->clie_dni, $client->usua_id, 0, "clie_dni");

        if(count($exist_inactive) > 0){
            $servicesResult->Error(500,"El cliente con DNI: {$client->clie_dni} ya existe en la lista con un estado inactivo");
        }
        else if(count($exist_active) > 0){
            $servicesResult->Error(500,"El cliente con DNI: {$client->clie_dni} ya existe en la lista");
        }
        else{

            $response = $this->clientRepository->create($client);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }  

        return $servicesResult;
    }

    function update_client(int $id, client $client) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist_active = $this->clientRepository->find($id, $client->usua_id, 1);
        $exist_inactive = $this->clientRepository->find($id, $client->usua_id, 0);

        if( count($exist_active) == 0 && count($exist_inactive) == 0 ){
            $servicesResult->Error(500,"El cliente especificado no existe en la lista"); 
        }
        else{
            $response = $this->clientRepository->update($id,$client);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function setState_client(int $id, int $usua_id, $state) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist_active = $this->clientRepository->find($id, $usua_id, 1);
        $exist_inactive = $this->clientRepository->find($id, $usua_id, 0);

        if( count($exist_active) == 0 && count($exist_inactive) == 0 ){
            $servicesResult->Error(500,"El cliente especificado no existe en la lista"); 
        }
        else{
            $response = $this->clientRepository->setState($id, $usua_id, $state);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function delete_client(int $id, int $usua_id) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist_active = $this->clientRepository->find($id, $usua_id, 1);
        $exist_inactive = $this->clientRepository->find($id, $usua_id, 0);

        if( count($exist_active) == 0 && count($exist_inactive) == 0 ){
            $servicesResult->Error(500,"El cliente especificado no existe en la lista"); 
        }
        else{
            $response = $this->clientRepository->delete($id, $usua_id);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }
}