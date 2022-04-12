<?php
$host = "localhost";
$name = "Webstack";
$user = "root";
$passwort = "T1m0w3b3r.--4dm1n";
try{
    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
} catch (PDOException $e){
    echo "SQL Error: ".$e->getMessage();
}
 ?>
