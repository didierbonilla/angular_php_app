<?php
    
header('Content-Type: application/json charset=utf-8 HTTP/1.1 200 OK');


class main{

    function getHelpers(){
        include_once("helpers/helpers.class.php");
        include_once("helpers/conection.class.php");
        include_once("helpers/HTTP_Response.class.php");
    }

    function getModels(){
        include_once("models/UserViewModel.php");
        include_once("models/StateViewModel.php");
        include_once("models/CityViewModel.php");
    }

    function getRepositories(){
        include_once("repositories/user.repository.php");
        include_once("repositories/state.repository.php");
        include_once("repositories/city.repository.php");
    }

    function getServices(){
        include_once("services/general.services.php");
        include_once("services/access.services.php");
    }
}

$_main = new main();
$_main->getHelpers();
$_main->getModels();
$_main->getRepositories();
$_main->getServices();

include_once("controllers/controller.class.php");
$_Controller = new Controller();
$_Controller->main();
