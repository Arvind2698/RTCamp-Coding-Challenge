<?php

function createConnection(){

    $servername = "";
    $username = "";
    $password = "";
    $dbname= "";
    $port= 3306;

    $conn = mysqli_connect($servername, $username, $password,$dbname,$port);

// Check connection
    if (!$conn) {
        return null;
    }

    return $conn;
}
?>