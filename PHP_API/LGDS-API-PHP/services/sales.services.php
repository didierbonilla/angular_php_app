<?php

class SaleServices
{
    private conection $conection;
    private helpers $_helpers;
    private clientRepository $clientRepository;
    private categoryRepository $categoryRepository;
    private productRepository $productRepository;

    function __construct()
    {
        $conection = new conection();

        if ($conection->success) {
            $this->conection = new conection();
            $this->_helpers = new helpers();
            $this->clientRepository = new clientRepository($this->conection->mysqli);
            $this->categoryRepository = new categoryRepository($this->conection->mysqli);
            $this->productRepository = new productRepository($this->conection->mysqli);
        } else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500, "Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }

    /* #region CLIENT BLOCK */
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
    /* #endregion */
    
    /* #region CATEGORY BLOCK */

    function list_category($user_id) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $categoriesList = $this->categoryRepository->list($user_id);

        $servicesResult->Ok($categoriesList);
        return $servicesResult;
    }

    function find_category($category_id, $category_name, $user_id) : HTTP_Response{
        $servicesResult = new HTTP_Response();
        $categoriesList = array();

        if(!empty($category_id)){
            $categoriesList = $this->categoryRepository->find($category_id, $user_id);
        }
        else if(!empty($category_name)){
            $categoriesList = $this->categoryRepository->find($category_name, $user_id, "cate_descripcion");
        }

        $servicesResult->Ok($categoriesList);
        return $servicesResult;
    }

    function create_category(category $category) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        //filterArray
        $exist = $this->categoryRepository->find($category->cate_descripcion, $category->usua_id, "cate_descripcion");

        if(count($exist) > 0){
            $servicesResult->Error(500,"Ya existe una categoria con este nombre en la lista");
        }
        else{

            $response = $this->categoryRepository->create($category);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }  

        return $servicesResult;
    }

    function update_category(int $id, category $category) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->categoryRepository->find($id, $category->usua_id);

        if(count($exist) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response = $this->categoryRepository->update($id, $category);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function delete_category(int $id, int $usua_id) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->categoryRepository->find($id, $usua_id);
        if(count($exist) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response = $this->categoryRepository->delete($id, $usua_id);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    /* #endregion */

    /* #region PRODUCT BLOCK */

    function list_product($user_id, $category_id) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $productList = $this->productRepository->list($user_id);

        if(!empty($category_id)){
            $productList = $this->productRepository->find($category_id, $user_id,"cate_id");
        }

        $servicesResult->Ok($productList);
        return $servicesResult;
    }

    function find_product($product_id, $product_name, $user_id) : HTTP_Response{
        $servicesResult = new HTTP_Response();
        $productList = array();

        if(!empty($product_id)){
            $productList = $this->productRepository->find($product_id, $user_id);
        }
        else if(!empty($product_name)){
            $productList = $this->productRepository->find($product_name, $user_id, "prod_descripcion");
        }

        $servicesResult->Ok($productList);
        return $servicesResult;
    }

    function create_product(product $product) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        //filterArray
        $exist_product = array_values(array_filter($this->productRepository->list($product->usua_id), function (product $item) use ($product) {
            return $item->prod_nombre == $product->prod_nombre && $item->cate_id == $product->cate_id;
        }));
        $exist_category = $this->categoryRepository->find($product->cate_id, $product->usua_id);

        if(count($exist_category) == 0){
            $servicesResult->Error(500,"La categoria especificada no existe en la lista");
        }
        else if(count($exist_product) > 0){
            $servicesResult->Error(500,"Ya existe un producto con el nombre y categoria especificada en la lista");
        }
        else{

            $response = $this->productRepository->create($product);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }  

        return $servicesResult;
    }

    function update_product(int $id, product $product) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist_product = $this->productRepository->find($id, $product->usua_id);
        $exist_category = $this->categoryRepository->find($product->cate_id, $product->usua_id);

        if(count($exist_category) == 0){
            $servicesResult->Error(500,"La categoria especificada no existe en la lista");
        }
        if(count($exist_product) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response = $this->productRepository->update($id, $product);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function setStock_product(product $product,int $unit, bool $add) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->productRepository->find($product->prod_id, $product->usua_id);
        if(count($exist) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response =  $this->productRepository->setStock($product, $unit, $add);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function setState_product(int $id, int $usua_id, int $state) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->productRepository->find($id, $usua_id);
        if(count($exist) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response = $this->productRepository->setState($id, $usua_id,$state);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    function delete_product(int $id, int $usua_id) : HTTP_Response{
        $servicesResult = new HTTP_Response();

        $exist = $this->productRepository->find($id, $usua_id);
        if(count($exist) == 0){
            $servicesResult->Error(500,"El registro requerido no existe");
        }
        else{
            $response = $this->productRepository->delete($id, $usua_id);
            if($response["udp_code"] > 0){
                $servicesResult->Error(500,"Error en peticion a base de datos - mysql error code: " . $response["udp_code"]);
            } else{
                $servicesResult->Ok($response);
            }
        }         

        return $servicesResult;
    }

    /* #endregion */
}