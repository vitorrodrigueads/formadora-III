<?php
include 'config.php';

// PEGAR ID DO CARRO
if(!isset($_GET['id'])){
    die("Carro não especificado.");
}

$id = intval($_GET['id']);

// BUSCAR CARRO NO BANCO
$sql = "SELECT * FROM carros WHERE id = $id";
$result = $conn->query($sql);

if($result->num_rows == 0){
    die("Carro não encontrado.");
}

$carro = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title><?= $carro['marca'] . " " . $carro['modelo'] ?></title>
<link rel="stylesheet" href="assets/style.css">
<style>
/* Fundo da página */
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

/* Container principal */
.container {
    width: 90%;
    max-width: 900px;
    padding: 30px;
}

/* Card do carro */
.carro-detalhes {
    display: flex;
    gap: 30px;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    flex-wrap: wrap;
}

/* Imagem do carro */
.carro-detalhes img {
    width: 100%;
    max-width: 400px;
    border-radius: 10px;
    object-fit: cover;
}

/* Informações do carro */
.carro-info {
    flex: 1;
    min-width: 250px;
}

.carro-info h2 {
    margin-top: 0;
    color: #1f2937;
    font-size: 26px;
}

.carro-info p {
    margin: 8px 0;
    font-size: 16px;
}

.carro-info .preco {
    font-weight: bold;
    font-size: 22px;
    color: #2563eb;
}

input[type=number]{
    width: 60px;
    padding:5px;
    margin-right:10px;
}

/* Botão comprar */
.btn {
    display:inline-block;
    background:#10b981;
    padding:10px 16px;
    color:white;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    margin-top:15px;
    transition: 0.3s;
    border: none;
    cursor: pointer;
}
.btn:hover { background:#059669; }

/* Responsivo */
@media(max-width:768px){
    .carro-detalhes {
        flex-direction: column;
        align-items: center;
    }
    .carro-info {
        text-align: center;
    }
}
</style>
</head>
<body>

<div class="container">
    <div class="carro-detalhes">

        <!-- FOTO DO CARRO -->
        <img src="<?= $carro['foto'] ?>" alt="<?= $carro['modelo'] ?>">

        <!-- INFORMAÇÕES -->
        <div class="carro-info">
            <h2><?= $carro['marca'] . " " . $carro['modelo'] ?> (<?= $carro['ano'] ?>)</h2>
            <p><b>Cor:</b> <?= $carro['cor'] ?></p>
            <p class="preco">R$ <?= number_format($carro['preco'], 2, ",", ".") ?></p>
            <p><b>Em estoque:</b> <?= $carro['estoque'] ?></p>
            <p><b>Descrição:</b><br><?= nl2br($carro['descricao']) ?></p>

            <?php if(!isset($_SESSION['id'])): ?>
                <p>Faça login para comprar este carro.</p>
                <a href="login.php" class="btn">Login</a>
            <?php else: ?>
                <form action="comprar.php" method="POST">
                    <input type="hidden" name="carro_id" value="<?= $carro['id'] ?>">
                    Quantidade:
                    <input type="number" name="quantidade" min="1" max="<?= $carro['estoque'] ?>" value="1" required>
                    <button class="btn" type="submit">Comprar</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
