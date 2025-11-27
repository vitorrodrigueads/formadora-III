<?php
$conn = new mysqli("localhost", "root", "", "sistema_carros");

if($conn->connect_error){
    die("Erro ao conectar: " . $conn->connect_error);
}

session_start();
?>
