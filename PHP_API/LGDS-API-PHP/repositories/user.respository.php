<?php

namespace repositories\user;

use mysqli;
use models\user\user;

class userRepository{
    private mysqli $conection;

    function __construct(mysqli $mysqli){
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = "SELECT * FROM usuarios";

        if($stmt = $this->conection->query($query)){

            if($stmt->num_rows > 0){
    
                while ($item = $stmt->fetch_assoc()) {
                    $user = new user($item);
                    array_push($data, $user);
                }
            }
        }

        return $data;
    }
}