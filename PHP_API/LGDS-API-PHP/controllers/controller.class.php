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
                              if (is_callable(array($controller, $actionName)) == false){
                                    $serverResult->Error(500, "Ah ocurrido un error al realizar - el controlador o acceso no es correcto");
                                    echo json_encode($serverResult);
                              }
                              else{
                                    call_user_func(array($controller, $actionName));
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