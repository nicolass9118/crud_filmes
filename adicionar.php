<?php
require 'db.php';

$id = $_GET['id'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $diretor = $_POST['diretor'];
    $data_lancamento = $_POST['data_lancamento'];
    $sinopse = $_POST['sinopse'];
    $imagem_capa = $_POST['imagem_capa'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE filmes SET titulo = ?, genero = ?, diretor = ?, data_lancamento = ?, sinopse = ?, imagem_capa = ? WHERE id = ?");
        $stmt->execute([$titulo, $genero, $diretor, $data_lancamento, $sinopse, $imagem_capa, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO filmes (titulo, genero, diretor, data_lancamento, sinopse, imagem_capa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $genero, $diretor, $data_lancamento, $sinopse, $imagem_capa]);
    }

    header('Location: index.php');
    exit;
}

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM filmes WHERE id = ?");
    $stmt->execute([$id]);
    $filme = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $filme = null;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id ? 'Editar Filme' : 'Adicionar Filme' ?></title>
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
    <h1><?= $id ? 'Editar Filme' : 'Adicionar Filme' ?></h1>
    <form method="post">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $filme['titulo'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <input type="text" class="form-control" id="genero" name="genero" value="<?= $filme['genero'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="diretor" class="form-label">Diretor</label>
            <input type="text" class="form-control" id="diretor" name="diretor" value="<?= $filme['diretor'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="data_lancamento" class="form-label">Data de Lançamento</label>
            <input type="date" class="form-control" id="data_lancamento" name="data_lancamento" value="<?= $filme['data_lancamento'] ?? '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="sinopse" class="form-label">Sinopse</label>
            <textarea class="form-control" id="sinopse" name="sinopse" rows="4" required><?= $filme['sinopse'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label for="imagem_capa" class="form-label">Imagem de Capa (URL)</label>
            <input type="text" class="form-control" id="imagem_capa" name="imagem_capa" value="<?= $filme['imagem_capa'] ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
