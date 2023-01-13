<?php

class city{
    
    public int $muni_id;
    public ?string $muni_descripcion;
    public int $depa_id;
    public ?string $depa_descripcion;

    function __construct($state){
        $this->muni_id = !isset($state["muni_id"]) ? 0 : $state["muni_id"];
        $this->muni_descripcion = !isset($state["muni_descripcion"]) ? null : $state["muni_descripcion"];
        $this->depa_id = !isset($state["depa_id"]) ? 0 : $state["depa_id"];
        $this->depa_descripcion = !isset($state["depa_descripcion"]) ? null : $state["depa_descripcion"];
    }
}
