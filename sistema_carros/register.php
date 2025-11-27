<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $senha = md5($_POST['senha']); // transforma a senha em hash MD5
    $tipo = 'cliente'; // todo novo cadastro é cliente

    // Verifica se já existe um usuário com esse email
    $verifica = $conn->query("SELECT * FROM usuarios WHERE email='$email'");
    if ($verifica->num_rows > 0) {
        $mensagem = "❌ Já existe um usuário com esse email!";
    } else {
        // Insere no banco
        $sql = "INSERT INTO usuarios (nome,email,senha,tipo) VALUES ('$nome','$email','$senha','$tipo')";
        if ($conn->query($sql)) {
            $mensagem = "✅ Cadastro realizado com sucesso! <a href='login.php'>Faça login</a>";
        } else {
            $mensagem = "❌ Erro ao cadastrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro de Usuário</title>
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
    max-width: 400px;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    text-align: center;
}

h2 {
    margin-top: 0;
    color: #1f2937;
    margin-bottom: 20px;
}

input[type=text], input[type=email], input[type=password] {
    width: 90%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
}

button {
    width: 95%;
    background:#2563eb;
    color:white;
    padding:10px;
    border:none;
    border-radius:6px;
    font-size:16px;
    margin-top:15px;
    cursor:pointer;
    transition: 0.3s;
}

button:hover {
    background:#1e40af;
}

.mensagem {
    margin-bottom: 15px;
    font-size: 16px;
    color: red;
}
.mensagem a {
    color:#2563eb;
    text-decoration:none;
    font-weight:bold;
}
.mensagem a:hover {
    text-decoration:underline;
}
</style>
</head>
<body>

<div class="container">
    <h2>Cadastro de Usuário</h2>
    <?php if($mensagem != ''): ?>
        <div class="mensagem"><?= $mensagem ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p style="margin-top:15px;">Já tem conta? <a href="login.php">Login</a></p>
</div>

</body>
</html>
