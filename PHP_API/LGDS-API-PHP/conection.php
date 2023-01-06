<?php 
    $servidor="localhost";
    $baseDatos="la_garita_web";
    $user="root";
    $password="";

    $mysqli=new mysqli($servidor, $user, $password, $baseDatos);
    mysqli_set_charset($mysqli, "utf8");
    date_default_timezone_set("America/Guatemala");

    if($mysqli->connect_error)
    {
        echo $mysqli->connect_error;
    }