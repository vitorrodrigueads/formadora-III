<?php
include 'auth_admin.php'; // garante que só admins acessam

// Pegar carros
$carros = $conn->query("SELECT * FROM carros");
$carrosArray = [];
while($c = $carros->fetch_assoc()){
    $carrosArray[] = $c;
}

// Agrupar estoque por marca
$estoquePorMarca = [];
foreach($carrosArray as $c){
    if(isset($estoquePorMarca[$c['marca']])){
        $estoquePorMarca[$c['marca']] += $c['estoque'];
    } else {
        $estoquePorMarca[$c['marca']] = $c['estoque'];
    }
}

// Pegar clientes
$clientes = $conn->query("SELECT id, nome, email FROM usuarios WHERE tipo='cliente'");

// Pegar vendas
$vendas = $conn->query("
    SELECT v.id, u.nome AS cliente, c.marca, c.modelo, v.quantidade, v.preco_unitario, v.total, v.data
    FROM vendas v
    JOIN usuarios u ON v.usuario_id = u.id
    JOIN carros c ON v.carro_id = c.id
");

$vendasArray = [];
while($v = $vendas->fetch_assoc()){
    $vendasArray[] = $v;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel Admin</title>
<link rel="stylesheet" href="assets/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<style>
.container{width:90%; margin:auto; padding:20px;}
h2{margin-top:40px;}
table{width:100%; border-collapse: collapse; margin-top:10px;}
th,td{border:1px solid #ddd; padding:8px;}
th{background:#1f2937; color:white;}
a.btn{background:#2563eb; color:white; padding:5px 10px; border-radius:4px; text-decoration:none;}
a.btn:hover{background:#1e40af;}
</style>
</head>
<body>
<div class="container">
<h1>Painel Admin</h1>
<a href="index.php" class="btn">Voltar à loja</a>
<a href="logout.php" class="btn">Logout</a>

<!-- CARROS -->
<h2>Gerenciar Carros</h2>
<a href="admin_carros_add.php" class="btn">➕ Adicionar Carro</a>
<table>
<tr>
<th>ID</th><th>Modelo</th><th>Marca</th><th>Ano</th><th>Cor</th><th>Preço</th><th>Estoque</th><th>Ações</th>
</tr>
<?php foreach($carrosArray as $c): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['modelo'] ?></td>
<td><?= $c['marca'] ?></td>
<td><?= $c['ano'] ?></td>
<td><?= $c['cor'] ?></td>
<td>R$ <?= number_format($c['preco'],2,",",".") ?></td>
<td><?= $c['estoque'] ?></td>
<td>
<a href="admin_carros_edit.php?id=<?= $c['id'] ?>" class="btn">✏️ Editar</a>
<a href="admin_carros_delete.php?id=<?= $c['id'] ?>" class="btn" onclick="return confirm('Tem certeza?')">🗑️ Excluir</a>
</td>
</tr>
<?php endforeach; ?>
</table>

<!-- CLIENTES -->
<h2>Clientes Cadastrados</h2>
<table>
<tr><th>ID</th><th>Nome</th><th>Email</th></tr>
<?php foreach($clientes as $cl): ?>
<tr>
<td><?= $cl['id'] ?></td>
<td><?= $cl['nome'] ?></td>
<td><?= $cl['email'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- VENDAS -->
<h2>Vendas Realizadas</h2>
<table>
<tr><th>ID</th><th>Cliente</th><th>Carro</th><th>Quantidade</th><th>Preço Unitário</th><th>Total</th><th>Data</th></tr>
<?php foreach($vendasArray as $v): ?>
<tr>
<td><?= $v['id'] ?></td>
<td><?= $v['cliente'] ?></td>
<td><?= $v['marca'] . ' ' . $v['modelo'] ?></td>
<td><?= $v['quantidade'] ?></td>
<td>R$ <?= number_format($v['preco_unitario'],2,",",".") ?></td>
<td>R$ <?= number_format($v['total'],2,",",".") ?></td>
<td><?= $v['data'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<!-- GRAFICO ESTOQUE POR MARCA -->
<h2>Gráfico – Estoque por Marca</h2>
<canvas id="graficoEstoque" width="400" height="150"></canvas>

<!-- BOTÃO PDF -->
<br>
<a href="#" class="btn" onclick="gerarPDFAdmin()">📄 Gerar PDF Avançado</a>

</div>

<script>
// GRÁFICO ESTOQUE AGRUPADO POR MARCA
let marcas = <?= json_encode(array_keys($estoquePorMarca)) ?>;
let estoque = <?= json_encode(array_values($estoquePorMarca)) ?>;

const ctx = document.getElementById('graficoEstoque');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: marcas,
        datasets: [{
            label: 'Estoque por marca',
            data: estoque,
            backgroundColor:'blue'
        }]
    }
});

// GERAR PDF
function gerarPDFAdmin(){
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p','mm','a4');

    // Título
    doc.setFontSize(18);
    doc.setTextColor(30, 30, 30);
    doc.text("Relatorio Completo - Admin", 105, 15, null, null, "center");
    // Tabela carros
    const carrosData = <?= json_encode(array_map(function($c){
        return [
            $c["modelo"],
            $c["marca"],
            $c["ano"],
            $c["cor"],
            "R$ ".number_format($c["preco"],2,",","."), 
            $c["estoque"]
        ];
    }, $carrosArray)) ?>;

    doc.autoTable({
        startY: 25,
        head: [["Modelo","Marca","Ano","Cor","Preço","Estoque"]],
        body: carrosData,
        headStyles: {fillColor: [30, 144, 255], textColor: 255, fontStyle: 'bold'},
        bodyStyles: {fillColor: [245,245,245]},
        alternateRowStyles: {fillColor: [230,230,230]},
        margin: {left:10, right:10}
    });

    // Tabela vendas
    const vendasData = <?= json_encode(array_map(function($v){
        return [
            $v["cliente"],
            $v["marca"]." ".$v["modelo"],
            $v["quantidade"],
            "R$ ".number_format($v["preco_unitario"],2,",","."),
            "R$ ".number_format($v["total"],2,",","."),
            $v["data"]
        ];
    }, $vendasArray)) ?>;

    doc.autoTable({
        startY: doc.lastAutoTable.finalY + 10,
        head: [["Cliente","Carro","Qtd","Preço Unit.","Total","Data"]],
        body: vendasData,
        headStyles: {fillColor: [34, 139, 34], textColor: 255, fontStyle: 'bold'},
        bodyStyles: {fillColor: [245,245,245]},
        alternateRowStyles: {fillColor: [230,230,230]},
        margin: {left:10, right:10}
    });

    // Gráfico
    let chartCanvas = document.getElementById('graficoEstoque');
    let imgData = chartCanvas.toDataURL("image/png");
    let posY = doc.lastAutoTable.finalY + 10;
    doc.addImage(imgData, "PNG", 15, posY, 180, 100);

    // Rodapé
    doc.setFontSize(10);
    doc.setTextColor(100);
    doc.text("Gerado em: " + new Date().toLocaleString(), 105, 290, null, null, "center");

    // Salvar PDF
    doc.save("relatorio_admin_profissional.pdf");
}
</script>

</body>
</html>
