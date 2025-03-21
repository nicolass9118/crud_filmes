<?php
require 'db.php';

$id = $_GET['id'] ?? null;

// Verifica se o ID foi fornecido
if (!$id) {
    header('Location: index.php');
    exit;
}

// Busca os dados do filme
$stmt = $pdo->prepare("SELECT * FROM filmes WHERE id = ?");
$stmt->execute([$id]);
$filme = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$filme) {
    die("Filme não encontrado.");
}

// Adiciona nova crítica
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $critica = $_POST['critica'];
    $nota = (int)$_POST['nota'];

    if ($critica && $nota >= 1 && $nota <= 5) {
        $stmt = $pdo->prepare("INSERT INTO avaliacoes (filme_id, critica, nota) VALUES (?, ?, ?)");
        $stmt->execute([$id, $critica, $nota]);
        header("Location: filme.php?id=$id");
        exit;
    } else {
        $erro = "Por favor, insira uma crítica válida e uma nota entre 1 e 5.";
    }
}

// Busca as avaliações do filme
$stmt = $pdo->prepare("SELECT * FROM avaliacoes WHERE filme_id = ?");
$stmt->execute([$id]);
$avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($filme['titulo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Modificando a cor da navbar */
.navbar {
    background-color: #5E17EB; 
}

.navbar .nav-link {
    color: white !important; 
}

    </style>

<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">


</head>
<body>
<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
    <img src="logo.png" alt="Logo" width="110" height="110" style="margin-right: 10px;">
        </a>        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="adicionar.php">Adicionar Filme</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <a href="index.php" class="btn btn-primary mb-4 btn-voltar">Voltar à Lista</a>
    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= htmlspecialchars($filme['imagem_capa']) ?>" class="img-fluid rounded-start" alt="Capa do filme">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($filme['titulo']) ?></h5>
                    <p class="card-text"><strong>Gênero:</strong> <?= htmlspecialchars($filme['genero']) ?></p>
                    <p class="card-text"><strong>Diretor:</strong> <?= htmlspecialchars($filme['diretor']) ?></p>
                    <p class="card-text"><strong>Data de Lançamento:</strong> <?= htmlspecialchars($filme['data_lancamento']) ?></p>
                    <p class="card-text"><strong>Sinopse:</strong> <?= nl2br(htmlspecialchars($filme['sinopse'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <h2>Avaliações</h2>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label for="critica" class="form-label">Crítica</label>
            <textarea class="form-control" id="critica" name="critica" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="nota" class="form-label">Nota</label>
            <select class="form-select" id="nota" name="nota" required>
                <option value="">Escolha uma nota</option>
                <option value="1">1 - Muito Ruim</option>
                <option value="2">2 - Ruim</option>
                <option value="3">3 - Médio</option>
                <option value="4">4 - Bom</option>
                <option value="5">5 - Excelente</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Avaliação</button>
    </form>

    <?php if ($avaliacoes): ?>
    <div class="list-group">
        <?php foreach ($avaliacoes as $avaliacao): ?>
            <div class="list-group-item">
                <p class="mb-1"><strong>Nota:</strong> <?= htmlspecialchars($avaliacao['nota']) ?>/5</p>
                <p class="mb-1"><?= nl2br(htmlspecialchars($avaliacao['critica'])) ?></p>
                <small class="text-muted">Avaliação #<?= $avaliacao['id'] ?></small>
                <div class="mt-2">
                    <a href="editar_avaliacao.php?id=<?= $avaliacao['id'] ?>&filme_id=<?= $id ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="excluir_avaliacao.php?id=<?= $avaliacao['id'] ?>&filme_id=<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta avaliação?')">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted">Nenhuma avaliação ainda.</p>
<?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
