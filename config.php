<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "carros"; // 🧩 altere o nome do banco aqui

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
