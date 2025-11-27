<?php
require("cabecalho.php");
require('conexao.php');

$usuario_id = $_SESSION['usuario_id'];

try {

  //1. Gasto Total do Mês (Apenas tipo 'despesa')
  $gasto_total_mes = 0;
  $stmt_total = $pdo->prepare("
        SELECT SUM(valor) as total 
        FROM movimentacao 
        WHERE 
            usuario_id = ? 
            AND tipo = 'despesa' 
            AND MONTH(data_movimentacao) = MONTH(CURRENT_DATE()) 
            AND YEAR(data_movimentacao) = YEAR(CURRENT_DATE())
    ");
  $stmt_total->execute([$usuario_id]);
  $resultado_total = $stmt_total->fetch(PDO::FETCH_ASSOC);
  if ($resultado_total && $resultado_total['total'] !== null) {
    $gasto_total_mes = (float) $resultado_total['total'];
  }

  //2. Maior Despesa
  $maior_gasto = ['valor' => 0, 'nome' => 'Nenhum'];
  $stmt_maior = $pdo->prepare("
        SELECT 
            m.valor, 
            c.nome 
        FROM movimentacao m
        JOIN categoria_despesa c ON m.categoria_despesa_id = c.id
        WHERE 
            m.usuario_id = ? 
            AND m.tipo = 'despesa' 
        ORDER BY m.valor DESC LIMIT 1
    ");
  $stmt_maior->execute([$usuario_id]);
  $resultado_maior = $stmt_maior->fetch(PDO::FETCH_ASSOC);
  if ($resultado_maior) {
    $maior_gasto = $resultado_maior;
  }

  // 3. Dados para o Gráfico
  $dados_grafico = [];
  $stmt_grafico = $pdo->prepare("
        SELECT 
            c.nome as categoria, 
            SUM(m.valor) as total_categoria
        FROM movimentacao m
        JOIN categoria_despesa c ON m.categoria_despesa_id = c.id
        WHERE 
            m.usuario_id = ? 
            AND m.tipo = 'despesa' 
            AND MONTH(m.data_movimentacao) = MONTH(CURRENT_DATE()) 
            AND YEAR(m.data_movimentacao) = YEAR(CURRENT_DATE())
        GROUP BY c.nome
        ORDER BY total_categoria DESC
    ");
  $stmt_grafico->execute([$usuario_id]);
  $dados_grafico = $stmt_grafico->fetchAll(PDO::FETCH_ASSOC);

  // Formatar os dados js
  $labels = [];
  $valores = [];
  $soma_valores_grafico = 0;

  foreach ($dados_grafico as $item) {
    $labels[] = $item['categoria'];
    $valores[] = (float) $item['total_categoria'];
    $soma_valores_grafico += (float) $item['total_categoria'];
  }
  $labels_json = json_encode($labels);
  $valores_json = json_encode($valores);
} catch (\Exception $e) {
  $erro_db = "Erro ao buscar dados de gastos: " . $e->getMessage() . ". Verifique se a conexão e as tabelas estão corretas.";
  $gasto_total_mes = 0;
  $maior_gasto = ['valor' => 0, 'nome' => 'Erro'];
  $labels_json = '[]';
  $valores_json = '[]';
}

// Calcula Média Diária
$dias_no_mes_ate_hoje = date('d');
$media_diaria = $gasto_total_mes > 0 ? $gasto_total_mes / $dias_no_mes_ate_hoje : 0;
?>

<style>
  
  @media print {


    .no-print {
      display: none !important;
    }


    #graficoGastos {
      display: none !important;
    }

    #grafico-print-img {
      display: block !important;
      max-width: 90%;
      height: auto;
      margin: 20px auto;
    }

    body {
      background-color: #fff !important;
    }

    .container {
      width: 100% !important;
      max-width: none !important;
      padding: 0 15px !important;
    }
  }
</style>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Seja bem vinda(o), <?= $_SESSION['nome'] ?>!</h1>

    <button onclick="imprimirDashboard()" class="btn btn-secondary no-print">
      <i class="bi bi-printer"></i> Imprimir
    </button>
  </div>

  <h2 class="mb-5">Dashboard de Gastos 💰</h2>

  <?php if (isset($erro_db)): ?>
    <div class="alert alert-danger" role="alert">
      <?= $erro_db ?>
    </div>
  <?php endif; ?>

  <!-- 2. INDICADORES (Cards) -->
  <div class="row mb-5">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Gasto Total no Mês</h5>
          <p class="card-text fs-3">R$ <?= number_format($gasto_total_mes, 2, ',', '.') ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-danger mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Maior Despesa</h5>
          <p class="card-text fs-3">R$ <?= number_format($maior_gasto['valor'], 2, ',', '.') ?></p>
          <p class="card-text"><small>Categoria: <?= $maior_gasto['nome'] ?></small></p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-white bg-info mb-3 shadow">
        <div class="card-body">
          <h5 class="card-title">Média Diária de Gastos</h5>
          <p class="card-text fs-3">R$ <?= number_format($media_diaria, 2, ',', '.') ?></p>
          <p class="card-text"><small>Estimativa baseada em <?= $dias_no_mes_ate_hoje ?> dias</small></p>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. GRÁFICO (Chart.js) -->
  <div class="row mb-5">
    <div class="col-lg-8 offset-lg-2">
      <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
          <i class="bi bi-pie-chart-fill"></i> Distribuição de Gastos por Categoria (Mês Atual)
        </div>
        <div class="card-body">
          <?php if ($gasto_total_mes > 0): ?>
            <canvas id="graficoGastos" style="max-height: 400px;"></canvas>

            <img id="grafico-print-img" alt="Gráfico de Distribuição de Gastos para Impressão" style="display: none;">
          <?php else: ?>
            <p class="text-center text-muted">Ainda não há despesas registradas para o mês atual.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
  let meuGrafico = null;


  const whiteBackgroundPlugin = {
    id: 'whiteBackground',
    beforeDraw: (chart) => {
      const ctx = chart.ctx;
      ctx.save();
      ctx.fillStyle = 'white';
      ctx.fillRect(0, 0, chart.width, chart.height);
      ctx.restore();
    }
  };


  function renderizarGrafico() {
    if (<?= $gasto_total_mes ?> <= 0) {
      return;
    }

    const ctx = document.getElementById('graficoGastos');

    if (!ctx) {
      console.error("Elemento Canvas 'graficoGastos' não encontrado.");
      return;
    }

    if (meuGrafico) {
      meuGrafico.destroy();
    }

    const labels = <?= $labels_json ?>;
    const valores = <?= $valores_json ?>;

    meuGrafico = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          label: 'Valor Gasto (R$)',
          data: valores,
          backgroundColor: [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(201, 203, 207, 0.8)',
            'rgba(0, 0, 0, 0.8)'
          ],
          borderColor: '#ffffff',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: true,
            text: 'Distribuição Percentual das Despesas'
          }
        }
      },

      plugins: [whiteBackgroundPlugin]
    });
  }


  function imprimirDashboard() {
    if (meuGrafico) {


      const scale = 2;


      const imageData = meuGrafico.toBase64Image({

        width: 800 * scale,
        height: 450 * scale,
        backgroundColor: 'white'
      });


      const imgElement = document.getElementById('grafico-print-img');
      imgElement.src = imageData;


      setTimeout(function() {
        window.print();
      }, 500);

    } else {

      window.print();
    }
  }

  document.addEventListener('DOMContentLoaded', renderizarGrafico);
</script>

<?php
require("rodape.php");
?>