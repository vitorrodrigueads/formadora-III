<?php
include 'config.php';
$id = $_GET['id'];

$sucesso = false;

if ($conn->query("DELETE FROM carros WHERE id=$id") === TRUE) {
    $sucesso = true;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Excluir Carro</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f7f8fc;
        margin: 0;
    }
    header {
        background-color: #2c3e50;
        color: white;
        padding: 20px;
        text-align: center;
    }
    .container {
        width: 400px;
        background: white;
        margin: 80px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        text-align: center;
    }
    .success {
        color: #27ae60;
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .error {
        color: #c0392b;
        font-size: 1.2em;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .btn {
        display: inline-block;
        background-color: #2980b9;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    .btn:hover {
        background-color: #1f6fa5;
    }
</style>
</head>
<body>
<header>
    <h1>🚗 Sistema de Cadastro de Carros</h1>
</header>

<div class="container">
    <?php if ($sucesso) { ?>
        <p class="success">✅ Carro excluído com sucesso!</p>
    <?php } else { ?>
        <p class="error">❌ Ocorreu um erro ao excluir o carro.</p>
    <?php } ?>
    <a href="index.php" class="btn">⬅️ Voltar à Lista</a>
</div>
</body>
</html>
