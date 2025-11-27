<?php
include 'config.php';
if(!isset($_SESSION["id"]) || $_SESSION["tipo"] != "admin"){
    die("Acesso negado.");
}
?>
