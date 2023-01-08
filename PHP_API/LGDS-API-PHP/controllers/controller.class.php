<?php

namespace controllers\controller;
use helpers\HTTP_Response\HTTP_Response;

//require_once("../helpers/config.class.php");
class Controller
{
      function main()
      {
            $serverResult = new HTTP_Response();

            //Formamos el nombre del Controlador o en su defecto, tomamos que es el IndexController
            if (!empty($_GET['controller']))
                  $controllerName = $_GET['controller'];
            else
                  $controllerName = "index";

            //Lo mismo sucede con las acciones, si no hay acción, tomamos index como acción
            if(! empty($_GET['action']))
                  $actionName = $_GET['action'];
            else
                  $actionName = "list";

            $controllerPath = 'controllers/'. $controllerName . '.controller.php';

            //Incluimos el fichero que contiene nuestra clase controladora solicitada
            if(is_file($controllerPath)){

                  require_once $controllerPath;

                  //Si no existe la clase que buscamos y su acción, mostramos un error 404
                  if (is_callable(array(strtolower($controllerName)."Controller", $actionName)) == false){
                        $serverResult->NotFound();
                        echo json_encode($serverResult);
                  }
                  else{
                        $controller = new $controllerName();
                        $controller->$actionName();
                  }
            }
            else{
                  $serverResult->NotFound();
                  echo json_encode($serverResult);
            }

      }
}

?>