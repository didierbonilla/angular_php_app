<?php
/*
namespace controllers\user;

use services\GeneralServices\GeneralServices;
*/
/*
require_once("../services/general.services.php");
*/
class userController
{
    private GeneralServices $_GeneralServices;
    function __construct()
    {
        $this->_GeneralServices = new GeneralServices();
    }
 
    public function list()
    {
        $listado = $this->_GeneralServices->list();
        echo json_encode($listado);
    }
 
    public function agregar()
    {
        echo 'Aquí incluiremos nuestro formulario para insertar items';
    }
}

?>