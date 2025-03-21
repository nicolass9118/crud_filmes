<?php
require 'db.php';

// Obtém o ID da avaliação
$id = $_GET['id'] ?? null;
$filme_id = $_GET['filme_id'] ?? null;

if (!$id || !$filme_id) {
    header("Location: filme.php?id=$filme_id");
    exit;
}

// Busca os dados da avaliação existente
$stmt = $pdo->prepare("SELECT * FROM avaliacoes WHERE id = ?");
$stmt->execute([$id]);
$avaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$avaliacao) {
    die("Avaliação não encontrada.");
}

// Atualiza a avaliação após o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $critica = $_POST['critica'];
    $nota = (int)$_POST['nota'];

    if ($critica && $nota >= 1 && $nota <= 5) {
        $stmt = $pdo->prepare("UPDATE avaliacoes SET critica = ?, nota = ? WHERE id = ?");
        $stmt->execute([$critica, $nota, $id]);
        header("Location: filme.php?id=$filme_id");
        exit;
    } else {
        $erro = "Por favor, insira uma crítica válida e uma nota entre 1 e 5.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Avaliação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1>Editar Avaliação</h1>
    <?php if ($erro): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label for="critica" class="form-label">Crítica</label>
            <textarea class="form-control" id="critica" name="critica" rows="3" required><?= htmlspecialchars($avaliacao['critica']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="nota" class="form-label">Nota</label>
            <select class="form-select" id="nota" name="nota" required>
                <option value="1" <?= $avaliacao['nota'] == 1 ? 'selected' : '' ?>>1 - Muito Ruim</option>
                <option value="2" <?= $avaliacao['nota'] == 2 ? 'selected' : '' ?>>2 - Ruim</option>
                <option value="3" <?= $avaliacao['nota'] == 3 ? 'selected' : '' ?>>3 - Médio</option>
                <option value="4" <?= $avaliacao['nota'] == 4 ? 'selected' : '' ?>>4 - Bom</option>
                <option value="5" <?= $avaliacao['nota'] == 5 ? 'selected' : '' ?>>5 - Excelente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="filme.php?id=<?= $filme_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
