<?php
include 'auth_admin.php';

if(!isset($_GET['id'])){
    die("Carro não especificado.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM carros WHERE id=$id";
$result = $conn->query($sql);
if($result->num_rows == 0) die("Carro não encontrado.");

$carro = $result->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = intval($_POST['ano']);
    $cor = $_POST['cor'];
    $preco = floatval(str_replace(',', '.', $_POST['preco']));
    $estoque = intval($_POST['estoque']);
    $descricao = $_POST['descricao'];

    $sql = "UPDATE carros SET modelo='$modelo', marca='$marca', ano=$ano, cor='$cor', preco=$preco, estoque=$estoque, descricao='$descricao' WHERE id=$id";
    if($conn->query($sql)){
        header("Location: painel_admin.php");
        exit;
    } else {
        echo "Erro ao atualizar carro: ".$conn->error;
    }
}
?>

<h2>Editar Carro</h2>
<form method="POST">
    Modelo: <input type="text" name="modelo" value="<?= $carro['modelo'] ?>" required><br>
    Marca: <input type="text" name="marca" value="<?= $carro['marca'] ?>" required><br>
    Ano: <input type="number" name="ano" value="<?= $carro['ano'] ?>" required><br>
    Cor: <input type="text" name="cor" value="<?= $carro['cor'] ?>" required><br>
    Preço: <input type="text" name="preco" value="<?= $carro['preco'] ?>" required><br>
    Estoque: <input type="number" name="estoque" value="<?= $carro['estoque'] ?>" required><br>
    Descrição:<br>
    <textarea name="descricao" rows="5" cols="40"><?= $carro['descricao'] ?></textarea><br>
    <button type="submit">Atualizar</button>
</form>
<a href="painel_admin.php">Voltar</a>
