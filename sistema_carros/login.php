<?php
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensagem = '';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $r = $conn->query($sql);

    if($r->num_rows > 0){
        $u = $r->fetch_assoc();

        // comparar senha usando MD5 (igual ao banco)
        if(md5($senha) === $u["senha"]){
            
            $_SESSION["id"] = $u["id"];
            $_SESSION["tipo"] = $u["tipo"];
            $_SESSION["nome"] = $u["nome"];

            if($u["tipo"] == "admin"){
                header("Location: painel_admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $mensagem = "❌ Login inválido!";
        }
    } else {
        $mensagem = "❌ Login inválido!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>
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

input[type=email], input[type=password] {
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
    color:red;
    margin-bottom: 15px;
}
</style>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <?php if($mensagem != ''): ?>
        <div class="mensagem"><?= $mensagem ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="senha" placeholder="Senha" required><br>
        <button type="submit">Entrar</button>
    </form>
    <p style="margin-top:15px;">Não tem conta? <a href="register.php">Registrar-se</a></p>
</div>

</body>
</html>
