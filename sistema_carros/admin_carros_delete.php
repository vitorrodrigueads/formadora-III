<?php
include 'auth_admin.php';

if(!isset($_GET['id'])){
    die("Carro não especificado.");
}

$id = intval($_GET['id']);

$sql = "DELETE FROM carros WHERE id=$id";
if($conn->query($sql)){
    header("Location: painel_admin.php");
    exit;
} else {
    echo "Erro ao excluir carro: ".$conn->error;
}
