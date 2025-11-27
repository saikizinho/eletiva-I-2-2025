<?php
// Processamento do Cadastro
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  require("conexao.php");
  $nome = $_POST['nome'];
  $email = $_POST['email'];
  // Garante que a senha está sendo hasheada antes de salvar, o que é CORRETO
  $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

  try {
    // Insere o novo usuário no banco de dados
    $stmt = $pdo->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");

    if ($stmt->execute([$nome, $email, $senha])) {
      // Redireciona para o login com mensagem de sucesso
      header("location: index.php?cadastro=true");
      exit();
    } else {
      header("location: index.php?cadastro=false");
      exit();
    }
  } catch (Exception $e) {
    // Exibe erro (ex: email duplicado)
    $erro_sql = "Erro ao executar o comando SQL: O email pode já estar cadastrado. Tente outro. (Detalhe: " . $e->getMessage() . ")";
  }
}

// Inicializa a variável de erro
$erro_sql = $erro_sql ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root {
      --cor-primaria: #001F3F;

      --cor-destaque: #4CAF50;

      --cor-fundo: #F8F9FA;

      --cor-texto: #333;
    }

    body {
      background-color: var;
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

    .btn-success {
      background-color: var;
      border-color: var;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .btn-success:hover {
      background-color: #388E3C;
      border-color: #388E3C;
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

    <h2 class="mb-4 text-center">Cadastro de Usuário</h2>

    <?php if ($erro_sql): ?>
      <p class='text-danger text-center'><?= $erro_sql ?></p>
    <?php endif; ?>

    <form action="cadastro.php" method="POST">
      <div class="mb-3">
        <label for="nomeCadastro" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nomeCadastro" name="nome" placeholder="Digite seu nome completo" required />
      </div>
      <div class="mb-3">
        <label for="emailCadastro" class="form-label">Email</label>
        <input type="email" class="form-control" id="emailCadastro" name="email" placeholder="seu.email@exemplo.com" required />
      </div>
      <div class="mb-3">
        <label for="senhaCadastro" class="form-label">Senha</label>
        <input type="password" class="form-control" id="senhaCadastro" name="senha" placeholder="Crie uma senha forte" required />
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-success">Cadastrar</button>
      </div>
    </form>
    <p class="mt-4 text-center">
      Já tem uma conta?
      <a href="index.php">Faça login aqui</a>
    </p>
  </div>
</body>

</html>