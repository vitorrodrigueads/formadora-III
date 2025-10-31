<?php
include 'config.php';
$result = $conn->query("SELECT * FROM carros");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>🚗 Cadastro de Carros</title>
<style>
    body {
        font-family: "Segoe UI", Arial, sans-serif;
        background: #f7f8fc;
        margin: 0;
        padding: 0;
    }
    header {
        background-color: #2c3e50;
        color: white;
        padding: 20px;
        text-align: center;
    }
    h2 {
        color: #2c3e50;
    }
    .container {
        width: 80%;
        margin: 40px auto;
        background: white;
        padding: 20px 40px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #2c3e50;
        color: white;
    }
    tr:hover {
        background-color: #f2f2f2;
    }
    a {
        text-decoration: none;
        color: #2980b9;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
    .add-btn {
        display: inline-block;
        background-color: #27ae60;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }
    .add-btn:hover {
        background-color: #219150;
    }
    .action-links a {
        color: #2980b9;
        margin: 0 5px;
    }
    .action-links a.delete {
        color: #c0392b;
    }
</style>
</head>
<body>
    <header>
        <h1>🚗 Sistema de Cadastro de Carros</h1>
    </header>

    <div class="container">
        <h2>Lista de Carros</h2>
        <a href="form_add.php" class="add-btn">➕ Adicionar Novo Carro</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Ano</th>
                <th>Cor</th>
                <th>Placa</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['modelo'] ?></td>
                <td><?= $row['marca'] ?></td>
                <td><?= $row['ano'] ?></td>
                <td><?= $row['cor'] ?></td>
                <td><?= $row['placa'] ?></td>
                <td class="action-links">
                    <a href="edit.php?id=<?= $row['id'] ?>">✏️ Editar</a> |
                    <a class="delete" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este carro?')">🗑️ Excluir</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
