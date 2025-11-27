<?php

// Recebe mensagens de feedback do cadastro.php
$feedback = '';
if (isset($_GET['cadastro'])) {
  if ($_GET['cadastro'] == 'true') {
    $feedback = "<p class='text-success text-center'>Cadastro realizado com sucesso! Faça login para começar.</p>";
  } else {
    $feedback = "<p class='text-danger text-center'>Erro ao realizar o cadastro!</p>";
  }
}

// Processamento do Login
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  require('conexao.php');
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  try {
    // 1. Busca o usuário pelo email
    $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Verifica se encontrou e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
      session_start();
      $_SESSION['acesso'] = true;
      $_SESSION['usuario_id'] = $usuario['id']; 
      $_SESSION['nome'] = $usuario['nome'];

      // Redirecionar para a tela principal
      header('location: principal.php');
      exit();
    } else {
      $feedback = "<p class='text-danger text-center'>Credenciais inválidas! Email ou senha incorretos.</p>";
    }
  } catch (\Exception $e) {
    $feedback = "<p class='text-danger text-center'>Erro ao processar login: " . $e->getMessage() . "</p>";
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root {
      --cor-primaria: #001F3F;
      --cor-destaque: #007bff;
      --cor-fundo: #F8F9FA;
      --cor-texto: #333;
    }

    body {
      background-color: #F8F9FA;
      color: var;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      max-width: 400px;
      padding: 30px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: var;
      border-color: var;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }

    a {
      color: var;
      text-decoration: none;
      font-weight: 500;
    }

    a:hover {
      color: #003366;
      text-decoration: underline;
    }

    .logo-placeholder {
      height: 60px;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--cor-primaria);
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="logo-placeholder">
      <img src="logo.jpg" alt="logo" style="max-width:70%; height: auto;">
    </div>

    <h2 class="mb-4 text-center">Acesso ao Sistema</h2>

    <?= $feedback ?>

    <form action="index.php" method="POST">
      <div class="mb-3">
        <label for="emailLogin" class="form-label">Email</label>
        <input type="email" class="form-control" id="emailLogin" name="email" placeholder="seu.email@exemplo.com" required />
      </div>
      <div class="mb-3">
        <label for="senhaLogin" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senhaLogin" name="senha" placeholder="Sua senha" required />
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-success">Entrar</button>
      </div>
    </form>
    <p class="mt-4 text-center">
      Não tem uma conta?
      <a href="cadastro.php">Cadastre-se aqui</a>
    </p>
  </div>
</body>

</html>