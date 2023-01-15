<?php

class helpers
{
    private $vars;
 
    function __construct()
    {
        $this->vars = array();
    }
 
    //Con set vamos guardando nuestras variables.
    public function set($name, $value)
    {
        if(!isset($this->vars[$name]))
        {
            $this->vars[$name] = $value;
        }
    }
 
    //Con get('nombre_de_la_variable') recuperamos un valor.
    public function get($name)
    {
        if(isset($this->vars[$name]))
        {
            return $this->vars[$name];
        }
    }

    public function getBodyContent(string $method){

        if($_SERVER["REQUEST_METHOD"] == strtoupper($method)){
            $json = json_decode(file_get_contents('php://input',true));
            $array = json_decode(json_encode($json), true);
            return $array;
        }else{
            return 1;
        }
    }

    public function getCookie() : array | bool{
        $headers = getallheaders();
        $headers = str_replace(" ", "", $headers);

        if(isset($headers["Cookie"])){
            $headers = explode(";", $headers["Cookie"]);

            $array_headers = array();
            foreach ($headers as $header) {
                $item = explode("=", $header);
                $array_headers[$item[0]] = $item[1];
            }

            return $array_headers;
        }
        else return false;
        
    }

    public function getHeaderByName($name){
        $headers = getallheaders();
        if (isset($headers[$name])) {
            return $headers[$name];
        }else{
            return null;
        }
    }

    public function filterArray($array,$callback) : array{
        $array_filter = array();
        foreach ($array as $item) {
            $state = $callback($item);
            if($state == true) 
                $array_filter[] = $item;
        }

        return $array_filter;
    }
}


?>