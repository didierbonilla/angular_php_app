<?php
/*
namespace repositories\user;

use mysqli;
use models\user\user;
*/

//include_once("../models/UserViewModel.php");
class userRepository{
    private mysqli $conection;

    function __construct(mysqli $mysqli){
        $this->conection = $mysqli;
    }

    function list(){
    
        $data = array();
        $query = 
            "SELECT * FROM `usuarios` as usu
            JOIN perfiles as per ON per.idperfil = usu.idperfil";

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

    function create(user $user){

        $data = array();

        if(count($this->find($user->idusuario)) > 0)
            $data["response"]="!Ya existe un usuario con este ID!";
        else{

            $password = password_hash($user->password, PASSWORD_DEFAULT);
            
            $query="INSERT INTO `usuarios` (`idusuario`, `usuario`, `correoElect`, `telefonoU`, `idperfil`, `contraseña`) 
                    VALUES 
                        ('{$user->idusuario}', '{$user->idusuario}', '{$user->idusuario}', 
                         '{$user->idusuario}', '{$user->idusuario}', '$password')";

            if($this->conection->query($query)){
                $data["status"]=true;
            }
            else $data["response"]="!Error al crear usuario!";
        }

    }

    function find($id){

        $users = $this->list();
        $users_filter = array_filter($users, function($user) use ($id) {
            return $user->idusuario == $id;
        });

        return $users_filter;
    }
}
/*
$pdo = new PDO("mysql:dbname=la_garita_web;host=localhost", "root", "");
$query = 
    "SELECT * FROM `usuarios` as usu
    JOIN perfiles as per ON per.idperfil = usu.idperfil";
$stmt = $pdo->prepare($query);
$arrParams=array(2);
$stmt ->execute($arrParams);

$stmt->setFetchMode(PDO::FETCH_SERIALIZE, 'user');
$data = $stmt->fetch();
echo var_dump($data);*/
