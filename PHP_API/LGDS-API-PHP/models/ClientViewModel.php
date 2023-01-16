<?php

class client{
    
    public int $clie_id;
    public ?string $clie_dni;
    public ?string $clie_nombre;
    public ?string $clie_apellido;
    public ?string $clie_email;
    public ?string $clie_telefono;
    public ?string $clie_direccion;
    public ?string $clie_fechaCreacion;
    public ?string $clie_fechaModifica;
    public int $clie_usuarioModifica;
    public int $clie_estado;
    public int $muni_id;
    public ?string $muni_descripcion;
    public int $depa_id;
    public ?string $depa_descripcion;
    public int $usua_id;

    function __construct($client){
        $this->clie_id = !isset($client["clie_id"]) ? 0 : $client["clie_id"];
        $this->clie_dni = !isset($client["clie_dni"]) ? null : $client["clie_dni"];
        $this->clie_nombre = !isset($client["clie_nombre"]) ? null : $client["clie_nombre"];
        $this->clie_apellido = !isset($client["clie_apellido"]) ? null : $client["clie_apellido"];
        $this->clie_email = !isset($client["clie_email"]) ? null : $client["clie_email"];
        $this->clie_telefono = !isset($client["clie_telefono"]) ? null : $client["clie_telefono"];
        $this->clie_direccion = !isset($client["clie_direccion"]) ? null : $client["clie_direccion"];
        $this->clie_fechaCreacion = !isset($client["clie_fechaCreacion"]) ? null : $client["clie_fechaCreacion"];
        $this->clie_fechaModifica = !isset($client["clie_fechaModifica"]) ? null : $client["clie_fechaModifica"];
        $this->clie_usuarioModifica = !isset($client["clie_usuarioModifica"]) ? 0 : $client["clie_usuarioModifica"];
        $this->clie_estado = !isset($client["clie_estado"]) ? 0 : $client["clie_estado"];
        $this->muni_id = !isset($client["muni_id"]) ? 0 : $client["muni_id"];
        $this->muni_descripcion = !isset($client["muni_descripcion"]) ? null : $client["muni_descripcion"];
        $this->depa_id = !isset($client["depa_id"]) ? 0 : $client["depa_id"];
        $this->depa_descripcion = !isset($client["depa_descripcion"]) ? null : $client["depa_descripcion"];
        $this->usua_id = !isset($client["usua_id"]) ? 0 : $client["usua_id"];
    }
}
