<?php
include 'auth_admin.php';

$vendas = $conn->query("
SELECT v.id, u.nome AS cliente, c.marca, c.modelo, v.quantidade, v.preco_unitario, v.total, v.data
FROM vendas v
JOIN usuarios u ON v.usuario_id = u.id
JOIN carros c ON v.carro_id = c.id
");
?>
<h2>Vendas Realizadas</h2>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Cliente</th><th>Carro</th><th>Qtd</th><th>Preço Unitário</th><th>Total</th><th>Data</th></tr>
<?php foreach($vendas as $v): ?>
<tr>
<td><?= $v['id'] ?></td>
<td><?= $v['cliente'] ?></td>
<td><?= $v['marca'].' '.$v['modelo'] ?></td>
<td><?= $v['quantidade'] ?></td>
<td>R$ <?= number_format($v['preco_unitario'],2,",",".") ?></td>
<td>R$ <?= number_format($v['total'],2,",",".") ?></td>
<td><?= $v['data'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<a href="painel_admin.php">Voltar</a>
