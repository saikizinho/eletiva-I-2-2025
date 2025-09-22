<?php
include("cabecalho.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contatos_mapa = [];
    $mensagens_erro = [];
    $nomes = $_POST['nome'];
    $telefones = $_POST['telefone'];

    for ($i = 0; $i < count($nomes); $i++) {
        $nome = $nomes[$i];
        $telefone = $telefones[$i];

        if (array_key_exists($nome, $contatos_mapa)) {
            $mensagens_erro[] = "Erro: O nome $nome já foi adicionado.";
            continue;
        }

        if (in_array($telefone, $contatos_mapa)) {
            $mensagens_erro[] = "Erro: O telefone $telefone já foi adicionado.";
            continue;
        }

        $contatos_mapa[$nome] = $telefone;
    }

    if (count($mensagens_erro) > 0) {
        foreach ($mensagens_erro as $msg) {
            echo "<p style='color:red;'>$msg</p>";
        }
    } else {
        ksort($contatos_mapa);
        echo "<h3>Lista de Contatos Ordenada por Nome:</h3>";
        echo "<ul>";
        foreach ($contatos_mapa as $nome => $telefone) {
            echo "<li>$nome: $telefone</li>";
        }
        echo "</ul>";
    }
}
?>

<form method="post">
    <h3>Adicionar 5 Contatos</h3>
    <?php for ($i = 1; $i <= 5; $i++): ?>
        <div class="mb-3">
            <label for="nome<?php echo $i; ?>" class="form-label">Nome do Contato <?php echo $i; ?>:</label>
            <input type="text" name="nome[]" id="nome<?php echo $i; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tel<?php echo $i; ?>" class="form-label">Telefone do Contato <?php echo $i; ?>:</label>
            <input type="text" name="telefone[]" id="tel<?php echo $i; ?>" class="form-control" required>
        </div>
        <hr>
    <?php endfor; ?>
    <button type="submit" class="btn btn-primary">Adicionar Contatos</button>
</form>

<?php
include("rodape.php");
?>