<?php
include 'config.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM carros WHERE id=$id");
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Carro</title>
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
        margin: 50px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        color: #2c3e50;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        font-weight: bold;
        margin-top: 10px;
    }
    input[type="text"], input[type="number"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 5px;
    }
    input[type="submit"] {
        margin-top: 20px;
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }
    input[type="submit"]:hover {
        background-color: #1f6fa5;
    }
    .voltar {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #2980b9;
        text-decoration: none;
    }
    .voltar:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>
<header>
    <h1>🚗 Sistema de Cadastro de Carros</h1>
</header>

<div class="container">
    <h2>Editar Carro</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">

        <label>Modelo:</label>
        <input type="text" name="modelo" value="<?= $row['modelo'] ?>" required>

        <label>Marca:</label>
        <input type="text" name="marca" value="<?= $row['marca'] ?>" required>

        <label>Ano:</label>
        <input type="number" name="ano" value="<?= $row['ano'] ?>" required>

        <label>Cor:</label>
        <input type="text" name="cor" value="<?= $row['cor'] ?>">

        <label>Placa:</label>
        <input type="text" name="placa" value="<?= $row['placa'] ?>">

        <input type="submit" value="Salvar Alterações">
    </form>
    <a href="index.php" class="voltar">⬅️ Voltar à lista</a>
</div>
</body>
</html>
