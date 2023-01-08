<?php

namespace models\user;

    class user{
        public int $idusuario;
        public string $usuario;
        public string $correoElect;
        public string $telefonoU;
        public string $nombreEmpresa;
        public string $ubicacion;
        public int $idperfil;
        public string $usuarioModifica;
        public string $fechaModifica;
        public string $password;
        public int $contadorRutas;
        public int $contadorClientes;

        function __construct($user){
            $this->idusuario = $user["idusuario"];
            $this->usuario = $user["usuario"];
            $this->correoElect = $user["correoElect"];
            $this->telefonoU = $user["telefonoU"];
            $this->nombreEmpresa = $user["nombreEmpresa"];
            $this->ubicacion = $user["ubicacion"];
            $this->idperfil = $user["idperfil"];
            $this->usuarioModifica = $user["usuarioModifica"];
            $this->fechaModifica = $user["fechaModifica"];
            $this->password = $user["contraseña"];
            $this->contadorRutas = $user["contadorRutas"];
            $this->contadorClientes = $user["contadorClientes"];
        }

    }
