<?php

class authController{

    public array $public_access = array(
        "login", "logOut"
    );
    private AuthServices $_AuthServices;
    private HTTP_Response $_serviceResult;
    private helpers $_helpers;

    function __construct()
    {
        $this->_AuthServices = new AuthServices();
        $this->_serviceResult = new HTTP_Response();
        $this->_helpers = new helpers();
    }

    //[POST_REQUEST]
    function login(){

        $data = $this->_helpers->getBodyContent("POST");
        if($data == 1){
            $this->_serviceResult->Error(405, utf8_decode("metodo HTTP no permitido"));
            echo json_encode($this->_serviceResult);
        } else {
            $login_data = new user($data,true);
            $response = $this->_AuthServices->LogIn($login_data);
            echo json_encode($response);
        }
    }

    function logOut(){
        $this->_AuthServices->LogOut();
        $this->_serviceResult->Ok(null, "Sesion cerrada correctamente");
        echo json_encode($this->_serviceResult);
    }

    /*
    function getCookie()
    {
        setcookie("myCookie", "didier", time() + 10,"/");
        //echo var_dump($_COOKIE);
        echo "cookie guardada";
    }

    function extractCookie()
    {
        echo var_dump(
            isset($_COOKIE["myCookie"]) ? $_COOKIE["myCookie"] : "no existe la cookie"
        );
    }*/
}