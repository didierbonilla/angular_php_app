<?php

class state{
    public int $depa_id;
    public ?string $depa_descripcion;

    function __construct($state){
        $this->depa_id = !isset($state["depa_id"]) ? 0 : $state["depa_id"];
        $this->depa_descripcion = !isset($state["depa_descripcion"]) ? null : $state["depa_descripcion"];
    }
}