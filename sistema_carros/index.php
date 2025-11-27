<?php
include 'config.php';

// PEGAR TODOS OS CARROS
$carros = $conn->query("SELECT * FROM carros");

// ARRAYS PARA GRÁFICO
$marcas = [];

foreach ($carros as $c) {
    $marcas[$c["marca"]] = ($marcas[$c["marca"]] ?? 0) + $c["estoque"];
}

// RESETAR RESULT (pq foreach consome)
$carros = $conn->query("SELECT * FROM carros");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Loja de Carros</title>

<link rel="stylesheet" href="assets/style.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- jsPDF + AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f5f7;
    margin: 0;
}
header {
    background: #1f2937;
    color: white;
    padding: 20px;
    text-align: center;
}
header a {
    color: white;
    margin-left: 20px;
    text-decoration: none;
    font-weight: bold;
}
.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}
.carro-card {
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
}
.carro-card h3 {
    margin: 0;
}
.btn {
    display:inline-block;
    background:#2563eb;
    padding:8px 12px;
    color:white;
    text-decoration:none;
    border-radius:5px;
    margin-top:10px;
}
.btn:hover {
    background:#1e40af;
}
.pdf-btn {
    background:#7e22ce;
}
</style>
</head>
<body>

<header>
    <h1>🚗 Loja de Carros</h1>

    <?php if(!isset($_SESSION["id"])): ?>
        <a href="login.php">Login</a>
        <a href="register.php">Criar conta</a>
    <?php else: ?>
        <span>Bem-vindo, <?= $_SESSION["nome"] ?>!</span>
        <a href="logout.php">Sair</a>

        <?php if($_SESSION["tipo"] == "admin"): ?>
            <a href="painel_admin.php">Painel Admin</a>
        <?php endif; ?>
    <?php endif; ?>
</header>

<div class="container">

    <h2>Carros Disponíveis</h2>
    <a href="#" class="btn pdf-btn" onclick="gerarPDF()">📄 Gerar Relatório em PDF</a>

    <br><br>

    <?php foreach($carros as $c): ?>
<div class="carro-card">

    <img src="<?= $c['foto'] ?>" alt="<?= $c['modelo'] ?>" style="width:25%; aspect-ratio:16/9; object-fit:cover; border-radius:5px; margin-bottom:10px;">



    <h3><?= $c["marca"] . " " . $c["modelo"] ?> (<?= $c["ano"] ?>)</h3>
    <p><b>Cor:</b> <?= $c["cor"] ?></p>
    <p><b>Preço:</b> R$ <?= number_format($c["preco"], 2, ",", ".") ?></p>
    <p><b>Estoque:</b> <?= $c["estoque"] ?></p>

    <a href="carro.php?id=<?= $c["id"] ?>" class="btn">Ver detalhes</a>

</div>
<?php endforeach; ?>

    <hr><br>

    <h2>📊 Gráfico – Estoque por Marca</h2>
    <canvas id="grafico" width="400" height="200"></canvas>
</div>

<script>
let marcas = <?= json_encode(array_keys($marcas)) ?>;
let valores = <?= json_encode(array_values($marcas)) ?>;

// ----- GRAFICO -----
const ctx = document.getElementById("grafico");
const chart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: marcas,
        datasets: [{
            label: "Quantidade em estoque",
            data: valores,
            backgroundColor: "blue"
        }]
    }
});

// ----- PDF -----
function gerarPDF(){
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Relatório de Carros em Estoque", 10, 10);

    // TABELA
    doc.autoTable({
        startY: 20,
        head: [["Modelo", "Marca", "Ano", "Cor", "Preço", "Estoque"]],
        body: <?= json_encode(
            array_map(function($c){
                return [
                    $c["modelo"],
                    $c["marca"],
                    $c["ano"],
                    $c["cor"],
                    "R$ " . number_format($c["preco"], 2, ",", "."),
                    $c["estoque"]
                ];
            }, $conn->query("SELECT * FROM carros")->fetch_all(MYSQLI_ASSOC))
        ) ?>
    });

    // GRAFICO NO PDF
    let imgData = chart.toBase64Image();
    doc.addImage(imgData, "PNG", 10, doc.lastAutoTable.finalY + 10, 180, 90);

    doc.save("relatorio_carros.pdf");
}
</script>

</body>
</html>
