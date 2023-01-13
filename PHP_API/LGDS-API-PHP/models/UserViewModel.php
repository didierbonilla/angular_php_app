<?php

//namespace models\user;
    class user{ 
        public int $usua_id;
        public ?string $usua_dni;
        public ?string $usua_nombre;
        public ?string $usua_apellido;
        public ?string $usua_email;
        public ?string $usua_telefono;
        public int $muni_id;
        public ?string $muni_descripcion;
        public int $depa_id;
        public ?string $depa_descripcion;
        public int $rol_id;
        public ?string $rol_descripcion;
        public ?string $usua_direccion;
        public ?string $usua_password = null;
        public ?string $usua_fechaCreacion;
        public int $usua_modifica;
        public ?string $usua_fechaModifica;
        public int $usua_activo;

        function __construct($user){

            $this->usua_id = !isset($user["usua_id"]) ? 0 : $user["usua_id"];
            $this->usua_dni = !isset($user["usua_dni"]) ? null : $user["usua_dni"];
            $this->usua_nombre = !isset($user["usua_nombre"]) ? null : $user["usua_nombre"];
            $this->usua_apellido = !isset($user["usua_apellido"]) ? null : $user["usua_apellido"];
            $this->usua_email = !isset($user["usua_email"]) ? null : $user["usua_email"];
            $this->usua_telefono = !isset($user["usua_telefono"]) ? null : $user["usua_telefono"];
            $this->rol_id = !isset($user["rol_id"]) ? 0 : $user["rol_id"];
            $this->rol_descripcion = !isset($user["rol_descripcion"]) ? null : $user["rol_descripcion"];
            $this->muni_id = !isset($user["muni_id"]) ? 0 : $user["muni_id"];
            $this->muni_descripcion = !isset($user["muni_descripcion"]) ? null : $user["muni_descripcion"];
            $this->depa_id = !isset($user["depa_id"]) ? 0 : $user["depa_id"];
            $this->depa_descripcion = !isset($user["depa_descripcion"]) ? null : $user["depa_descripcion"];
            $this->usua_direccion = !isset($user["usua_direccion"]) ? null : $user["usua_direccion"];
            $this->usua_fechaCreacion = !isset($user["usua_fechaCreacion"]) ? null : $user["usua_fechaCreacion"];
            $this->usua_modifica = !isset($user["usua_modifica"]) ? 0 : $user["usua_modifica"];
            $this->usua_fechaModifica = !isset($user["usua_fechaModifica"]) ? 0 : $user["usua_fechaModifica"];
            $this->usua_activo = !isset($user["usua_activo"]) ? 0 : $user["usua_activo"];
        }

    }
