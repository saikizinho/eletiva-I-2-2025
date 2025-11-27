<?php
session_start();

if (!isset($_SESSION['acesso']) || $_SESSION['acesso'] !== true) {
  header('location: index.php');
  exit(); 
}


$usuario_id = $_SESSION['usuario_id'];
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Orçamento Familiar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
    <div class="logo-placeholder">
      <img src="logo.jpg" alt="logo" style="max-width:120px; height: auto;">
    </div>
    <div class="container">
      <a class="navbar-brand" href="principal.php">Gestão Financeira Familiar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Alternar navegação">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="principal.php">Home</a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Cadastros
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdown2">
              <li><a class="dropdown-item" href="contas.php">Contas</a></li>
              <li><a class="dropdown-item" href="categorias_despesas.php">Categorias de Despesas</a></li>
              <li><a class="dropdown-item" href="fontes_renda.php">Fontes de Renda</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="movimentacoes.php">Movimentações</a></li>
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="logout.php">Sair</a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">