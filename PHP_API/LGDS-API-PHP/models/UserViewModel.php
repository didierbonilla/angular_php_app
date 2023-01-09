<?php

//namespace models\user;

    class user{
        public int $idusuario;
        public string $usuario;
        public string $correoElect;
        public string $telefonoU;
        public string $password;
        public string $nombreEmpresa;
        public string $ubicacion;
        public int $idperfil;
        public string $perfil;
        public string $usuarioModifica;
        public string $fechaModifica;
        public int $contadorRutas;
        public int $contadorClientes;

        function __construct($user){
            $this->idusuario = !isset($user["idusuario"]) ? null : $user["idusuario"];
            $this->usuario = !isset($user["usuario"]) ? null : $user["usuario"];
            $this->correoElect = !isset($user["correoElect"]) ? null : $user["correoElect"];
            $this->telefonoU = !isset($user["telefonoU"]) ? null : $user["telefonoU"];
            $this->nombreEmpresa = !isset($user["nombreEmpresa"]) ? null : $user["nombreEmpresa"];
            $this->ubicacion = !isset($user["ubicacion"]) ? null : $user["ubicacion"];
            $this->idperfil = !isset($user["idperfil"]) ? null : $user["idperfil"];
            $this->perfil = !isset($user["perfil"]) ? null : $user["perfil"];
            $this->usuarioModifica = !isset($user["usuarioModifica"]) ? null : $user["usuarioModifica"];
            $this->fechaModifica = !isset($user["fechaModifica"]) ? null : $user["fechaModifica"];
            $this->contadorRutas = !isset($user["contadorRutas"]) ? null : $user["contadorRutas"];
            $this->contadorClientes = !isset($user["contadorClientes"]) ? null : $user["contadorClientes"];
        }

    }
