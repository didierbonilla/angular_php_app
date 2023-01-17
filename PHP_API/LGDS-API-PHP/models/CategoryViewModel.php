<?php

class category{
    
    public int $cate_id;
    public ?string $cate_descripcion;
    public int $usua_id;

    function __construct($state){
        $this->cate_id = !isset($state["cate_id"]) ? 0 : $state["cate_id"];
        $this->cate_descripcion = !isset($state["cate_descripcion"]) ? null : $state["cate_descripcion"];
        $this->usua_id = !isset($state["usua_id"]) ? 0 : $state["usua_id"];
    }
}
