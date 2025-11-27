<?php
include 'config.php';

// Verificar se usuário está logado
if(!isset($_SESSION['id'])){
    die("<p>Você precisa estar logado para comprar. <a href='login.php'>Login</a></p>");
}

// Verificar dados do POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario_id = $_SESSION['id'];
    $carro_id = intval($_POST['carro_id']);
    $quantidade = intval($_POST['quantidade']);

    // Buscar carro no banco
    $sql = "SELECT * FROM carros WHERE id = $carro_id";
    $result = $conn->query($sql);

    if($result->num_rows == 0){
        die("<p>Carro não encontrado.</p>");
    }

    $carro = $result->fetch_assoc();

    // Validar estoque
    if($quantidade < 1){
        die("<p>Quantidade inválida.</p>");
    }
    if($quantidade > $carro['estoque']){
        die("<p>Não há estoque suficiente. Estoque disponível: " . $carro['estoque'] . "</p>");
    }

    // Calcular total
    $preco_unitario = $carro['preco'];
    $total = $preco_unitario * $quantidade;

    // Inserir na tabela vendas
    $sql = "INSERT INTO vendas (usuario_id, carro_id, quantidade, preco_unitario, total)
            VALUES ($usuario_id, $carro_id, $quantidade, $preco_unitario, $total)";
    if($conn->query($sql)){
        // Diminuir estoque
        $novo_estoque = $carro['estoque'] - $quantidade;
        $conn->query("UPDATE carros SET estoque = $novo_estoque WHERE id = $carro_id");

        $mensagem = "<p>✅ Compra realizada com sucesso! Você comprou $quantidade x {$carro['marca']} {$carro['modelo']}.</p>
                     <a href='index.php' class='btn'>Voltar para loja</a>";
    } else {
        $mensagem = "<p>❌ Erro ao registrar a compra.</p>";
    }
} else {
    $mensagem = "<p>⚠️ Acesso inválido.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Compra de Carro</title>
<link rel="stylesheet" href="assets/style.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f5f7;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    width: 90%;
    max-width: 600px;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
}

p {
    font-size: 18px;
    color: #1f2937;
}

.btn {
    display:inline-block;
    background:#2563eb;
    padding:10px 16px;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    margin-top:15px;
    transition: 0.3s;
}
.btn:hover { background:#1e40af; }
</style>
</head>
<body>

<div class="container">
    <?= $mensagem ?>
</div>

</body>
</html>
