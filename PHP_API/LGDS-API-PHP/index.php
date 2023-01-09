<?php

class main{

    function getHelpers(){
        include_once("helpers/conection.class.php");
        include_once("helpers/HTTP_Response.class.php");
    }

    function getModels(){
        include_once("models/UserViewModel.php");
    }

    function getRepositories(){
        include_once("repositories/user.repository.php");
    }

    function getServices(){
        include_once("services/general.services.php");
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
