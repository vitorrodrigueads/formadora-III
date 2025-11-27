<?php
include 'auth_admin.php';

$carros = $conn->query("SELECT * FROM carros");
?>
<h2>Todos os Carros</h2>
<a href="admin_carros_add.php">➕ Adicionar Carro</a>
<table border="1" cellpadding="5">
<tr>
<th>ID</th><th>Modelo</th><th>Marca</th><th>Ações</th>
</tr>
<?php foreach($carros as $c): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['modelo'] ?></td>
<td><?= $c['marca'] ?></td>
<td>
<a href="admin_carros_edit.php?id=<?= $c['id'] ?>">Editar</a> |
<a href="admin_carros_delete.php?id=<?= $c['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
</td>
</tr>
<?php endforeach; ?>
</table>
<a href="painel_admin.php">Voltar</a>
