<?php

namespace controllers\user;

use services\GeneralServices\GeneralServices;

class usersController
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