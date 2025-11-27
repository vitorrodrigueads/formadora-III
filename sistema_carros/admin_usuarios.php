<?php
include 'auth_admin.php';

$clientes = $conn->query("SELECT * FROM usuarios WHERE tipo='cliente'");
?>
<h2>Clientes Cadastrados</h2>
<table border="1" cellpadding="5">
<tr>
<th>ID</th><th>Nome</th><th>Email</th></tr>
<?php foreach($clientes as $c): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= $c['nome'] ?></td>
<td><?= $c['email'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<a href="painel_admin.php">Voltar</a>
