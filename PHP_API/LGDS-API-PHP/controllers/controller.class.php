<?php
/*
namespace controllers\controller;
use helpers\HTTP_Response\HTTP_Response;
*/
/*
include_once("helpers/config.class.php");
include_once("helpers/HTTP_Response.class.php");
*/

class Controller
{
      function main()
      {
            try {
            
                  $serverResult = new HTTP_Response();
                  
                  //Formamos el nombre del Controlador o en su defecto, tomamos que es el IndexController
                  if (!empty($_GET['controller']))
                        $controllerName = $_GET['controller'];
                  else
                        $controllerName = "index";

                  //Lo mismo sucede con las acciones, si no hay acción, tomamos index como acción
                  if(!empty($_GET['action']))
                        $actionName = $_GET['action'];
                  else
                        $actionName = "list";

                  $controllerPath = "controllers/$controllerName.controller.php";



                  //Incluimos el fichero que contiene nuestra clase controladora solicitada
                  if(file_exists($controllerPath)){

                        require_once $controllerPath;

                        try {
                              
                              $controllerName = $controllerName . "Controller";
                              $controller = new $controllerName();
                              $public_access = $controller->public_access;

                              // filtramos por el nombre de "action" si existe dentro de los public access de el controller
                              $filtered_access = array_values(array_filter($public_access, function($value) use ($actionName) {
                                    return $value == $actionName;
                              }));

                              // si no existe un metodo con este nombre retorna error
                              if (is_callable(array($controller, $actionName)) == false){
                                    $serverResult->Error(500, "Ah ocurrido un error al realizar la consulta - el controlador o acceso no es correcto");
                                    echo json_encode($serverResult);
                              }
                              // si existe dentro de public access retorna valor sin usar token
                              else if( count($filtered_access) > 0 ){
                                    call_user_func(array($controller, $actionName));
                              }
                              // si no existe valida token y da acceso a metodo
                              else if( count($filtered_access) == 0 ){

                                    $_helpers = new helpers();
                                    //$headers = $_helpers->getCookie();
                                    $token = $_helpers->getHeaderByName("bearer_token");

                                    // si no existe una sesion o token de acceso
                                    if( !isset($_SESSION["token"]) || $token == null ){
                                          $serverResult->Error(401, "Token de acceso invalido o expirado");
                                          echo json_encode($serverResult);
                                    }
                                    // si token de servidor y de peticion es correcto da acesso a datos
                                    else if ($token === $_SESSION["token"] ) {
                                          $_auth = new AuthServices();
                                          $_auth->refreshToken($token);
                                          call_user_func(array($controller, $actionName));
                                    }
                                    // si no retorna error
                                    else{
                                          $serverResult->Error(401, "Token de acceso invalido");
                                          echo json_encode($serverResult);
                                    }
                              }
                              // si no retorna error
                              else{
                                    $serverResult->Error(401, "Token de acceso invalido o inexistente");
                                    echo json_encode($serverResult);
                              }
                        } 
                        catch (\Throwable $th) {
                              $serverResult->Error(
                                    500,
                                    "Ah ocurrido un error al realizar la peticion al servidor",
                                    $th->getMessage()." - ".$th->getLine()." - ".$th->getFile()
                              );
                              echo json_encode($serverResult);
                        }

                  }
                  else{
                        $serverResult->NotFound(404,"el controlador requerido no existe - 404 not found");
                        echo json_encode($serverResult);
                  }
            } 
            catch (\Throwable $th) {
                  $serverResult = new HTTP_Response();
                  $serverResult->Error(
                        500, 
                        "Ah ocurrido un error inesperado",
                        $th->getMessage()." - ".$th->getLine()." - ".$th->getFile()
                  );
            }

      }
}

?>