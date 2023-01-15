<?php

class role{
    
    public int $rol_id;
    public ?string $rol_descripcion;

    function __construct($role){
        $this->rol_id = !isset($role["rol_id"]) ? 0 : $role["rol_id"];
        $this->rol_descripcion = !isset($role["rol_descripcion"]) ? null : $role["rol_descripcion"];
    }
}