<?php

//namespace helpers\HTTP_Response;
class HTTP_Response {

    public int $Code = 200;
    public string $Message;
    public bool $Success;
    public $data;

    function Ok($data, string $Message = "Operacion completada con exito"){
        $this->Code = 200;
        $this->Message = utf8_decode($Message);
        $this->Success = true;
        $this->data = $data;

        //return $this;
    }

    function Error(int $Code = 500, $Message = "Error al realizar la operacion", $data = null){
        $this->Code = $Code;
        $this->Message = utf8_decode($Message);
        $this->Success = false;
        $this->data = $data;

        //return $this;
    }

    function NotFound(int $Code = 404, $Message = "La direccion requerida no existe - 404 not found"){
        $this->Code = $Code;
        $this->Message = utf8_decode($Message);
        $this->Success = false;
        $this->data = null;

        //return $this;
    }
}