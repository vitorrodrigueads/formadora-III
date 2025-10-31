<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Adicionar Carro</title>
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
        background-color: #27ae60;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }
    input[type="submit"]:hover {
        background-color: #219150;
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
    <h2>Adicionar Carro</h2>
    <form action="insert.php" method="POST">
        <label>Modelo:</label>
        <input type="text" name="modelo" required>

        <label>Marca:</label>
        <input type="text" name="marca" required>

        <label>Ano:</label>
        <input type="number" name="ano" required>

        <label>Cor:</label>
        <input type="text" name="cor">

        <label>Placa:</label>
        <input type="text" name="placa">

        <input type="submit" value="Cadastrar">
    </form>
    <a href="index.php" class="voltar">⬅️ Voltar à lista</a>
</div>
</body>
</html>
