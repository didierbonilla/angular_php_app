<?php
/*
namespace helpers\conection;
use mysqli;
*/
class conection
{
    private string $servidor = "localhost";
    private string $baseDatos = "la_garita_db";
    private string $user = "root";
    private string $password = "";
    public bool $success;
    public mysqli $mysqli;

    function __construct()
    {

        $mysqli = new mysqli($this->servidor, $this->user, $this->password, $this->baseDatos);
        mysqli_set_charset($mysqli, "utf8");
        date_default_timezone_set("America/Guatemala");

        $this->success = true;
        $this->mysqli = $mysqli;

        if ($mysqli->connect_error)
            $this->success = false;
    }

    public function getLastInsert(string $table,string $id_column){

        $sql_query = "SELECT ? as last_id FROM ? ORDER BY ? DESC LIMIT 1";
        
    }
}