<?php
include 'auth_admin.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = intval($_POST['ano']);
    $cor = $_POST['cor'];
    $preco = floatval(str_replace(',', '.', $_POST['preco']));
    $estoque = intval($_POST['estoque']);
    $descricao = $_POST['descricao'];

    $sql = "INSERT INTO carros (modelo, marca, ano, cor, preco, estoque, descricao) 
            VALUES ('$modelo','$marca',$ano,'$cor',$preco,$estoque,'$descricao')";

    if($conn->query($sql)){
        header("Location: painel_admin.php");
        exit;
    } else {
        echo "Erro ao adicionar carro: ".$conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Adicionar Carro - Admin</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f9fafb;
    margin: 0;
    padding: 0;
}

.container {
    width: 500px;
    max-width: 90%;
    margin: 40px auto;
    background: #fff;
    padding: 25px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

h2 {
    margin-bottom: 20px;
    color: #1f2937;
    text-align: center;
}

form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #374151;
}

form input[type="text"],
form input[type="number"],
form textarea {
    width: 100%;
    padding: 8px 10px;
    margin-bottom: 15px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

form textarea {
    resize: vertical;
}

button {
    background-color: #2563eb;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

button:hover {
    background-color: #1e40af;
}

a.back-link {
    display: inline-block;
    margin-top: 15px;
    color: #2563eb;
    text-decoration: none;
    font-size: 14px;
}

a.back-link:hover {
    text-decoration: underline;
}
</style>
</head>
<body>

<div class="container">
<h2>Adicionar Carro</h2>
<form method="POST">
    <label>Modelo:</label>
    <input type="text" name="modelo" required>

    <label>Marca:</label>
    <input type="text" name="marca" required>

    <label>Ano:</label>
    <input type="number" name="ano" required>

    <label>Cor:</label>
    <input type="text" name="cor" required>

    <label>Preço:</label>
    <input type="text" name="preco" required>

    <label>Estoque:</label>
    <input type="number" name="estoque" required>

    <label>Descrição:</label>
    <textarea name="descricao" rows="5"></textarea>

    <button type="submit">Adicionar</button>
</form>

<a href="painel_admin.php" class="back-link">← Voltar</a>
</div>

</body>
</html>
