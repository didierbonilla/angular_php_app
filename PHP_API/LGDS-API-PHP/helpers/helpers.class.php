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