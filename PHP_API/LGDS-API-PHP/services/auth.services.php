<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthServices{

    private $expire_token_time;
    private $expire_token_key;
    private userRepository $userRepository;
    private conection $conection;
    private helpers $_helpers;

    function __construct(){
        $conection = new conection();

        if ($conection->success) {
            $this->expire_token_key = "LaGarita1977";
            $this->expire_token_time = time() + (60 * 60 * 2);
            $this->conection = new conection();
            $this->_helpers = new helpers();
            $this->userRepository = new userRepository($this->conection->mysqli);
        }
        else {
            $servicesResult = new HTTP_Response();
            $servicesResult->Error(500,"Error de conexion a base de datos");
            echo json_encode($servicesResult);
        }
    }

    private function getToken($token_data, $exp) : string{

        $token = array(
            "iat" => time(),
            "exp" => $exp,
            "data" => $token_data
        );

        $jwt = JWT::encode($token, $this->expire_token_key, "HS256");

        return $jwt;
    }

    public function refreshToken($jwt){
        $token_data = JWT::decode($jwt,new Key($this->expire_token_key, 'HS256'));

        $seconds_per_expire = time() - $token_data->iat;
        $seconds_to_expire = $token_data->exp - $seconds_per_expire;

        if($seconds_to_expire < (60 * 5)){
            $jwt = $this->getToken($token_data->data,$this->expire_token_time);
            setcookie("token", $jwt, $this->expire_token_time, "/");
            $_SESSION["token"] = $jwt;
            echo $jwt;
        }
    }

    public function LogIn(user $login_data) : HTTP_Response{

        $servicesResult = new HTTP_Response();
        $user = $this->userRepository->find($login_data->usua_dni,"usua_dni");

        if(count($user) > 0){

            $user = current($user);
            if($user->usua_activo == 1){

                $user->usua_password = $this->userRepository->getPassword("usua_dni", $login_data->usua_dni);

                if( password_verify($login_data->usua_password, $user->usua_password) ){

                    // generate token and authentication cookie
                    unset($user->usua_password);
                    $jwt = $this->getToken($user, $this->expire_token_time);
                    setcookie("token", $jwt, $this->expire_token_time, "/");
                    $_SESSION["token"] = $jwt;

                    $login_response = array(
                        "token"=>$_SESSION["token"],
                        "session_id"=>session_id()
                    );
                    // get and return response
                    $servicesResult->Ok($login_response, "Inicio de sesion completado exitosamente");

                }
                else{
                    $servicesResult->Error(500, "la clave ingresada es incorrecta");
                }

            }
            else{
                $servicesResult->Error(500, "el usuario requerido se encuentra en estado inactivo - consulte con su moderador");
            }

        }
        else{
            $servicesResult->Error(500, "el DNI '{$login_data->usua_dni}' es incorrecto o inexistente");
        }

        return $servicesResult;
    }

    public function LogOut(){
        setcookie("token", "", time() - 60, "/");
        unset($_SESSION["token"]);
        session_destroy();
    }
}