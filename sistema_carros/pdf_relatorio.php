<?php
include 'config.php';

// Buscar carros
$carros = $conn->query("SELECT * FROM carros");
$carrosArray = $carros->fetch_all(MYSQLI_ASSOC);

require_once('vendor/autoload.php'); // se usar composer para jsPDF-php ou libraria equivalente
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
<script>
const { jsPDF } = window.jspdf;
const doc = new jsPDF();
doc.text("Relatório de Carros", 10, 10);

doc.autoTable({
  startY: 20,
  head: [["Modelo","Marca","Ano","Cor","Preço","Estoque"]],
  body: <?= json_encode(array_map(function($c){ return [$c['modelo'],$c['marca'],$c['ano'],$c['cor'],"R$ ".number_format($c['preco'],2,",","."),$c['estoque']];}, $carrosArray)) ?>
});

doc.save("relatorio_carros.pdf");
</script>
