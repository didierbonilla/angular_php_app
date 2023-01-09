<?php

//namespace helpers\HTTP_Response;
class HTTP_Response {

    public int $Code = 200;
    public string $Message;
    public bool $Success;
    public $data;

    function Ok($data, string $Message = "Operacion completada con exito"){
        $this->Code = 200;
        $this->Message = $Message;
        $this->Success = true;
        $this->data = $data;

        header('Content-Type: application/json charset=utf-8 HTTP/1.1 200 OK');
        //return $this;
    }

    function Error(int $Code = 500, $Message = "Error al realizar la operacion"){
        $this->Code = $Code;
        $this->Message = $Message;
        $this->Success = false;
        $this->data = null;

        header('Content-Type: application/json HTTP/1.1 200 OK');
        //return $this;
    }

    function NotFound(int $Code = 404, $Message = "La direccion requerida no existe - 404 not found"){
        $this->Code = $Code;
        $this->Message = $Message;
        $this->Success = false;
        $this->data = null;

        header('Content-Type: application/json HTTP/1.1 404 OK');
        //return $this;
    }
}