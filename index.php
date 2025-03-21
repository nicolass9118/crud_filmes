<?php
require 'db.php';
$stmt = $pdo->query("SELECT * FROM filmes");
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmes</title>
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

</head>
<body>
<nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
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
    <h1 class="mb-4">Lista de Filmes</h1>
    <a href="adicionar.php" class="btn btn-primary mb-3">Adicionar Filme</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Capa</th>
            <th>Título</th>
            <th>Gênero</th>
            <th>Diretor</th>
            <th>Data de Lançamento</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($filmes as $filme): ?>
            <tr>
                <td><img src="<?= $filme['imagem_capa'] ?>" alt="Capa" width="50"></td>
                <td><?= $filme['titulo'] ?></td>
                <td><?= $filme['genero'] ?></td>
                <td><?= $filme['diretor'] ?></td>
                <td><?= $filme['data_lancamento'] ?></td>
                <td>
                    <a href="filme.php?id=<?= $filme['id'] ?>" class="btn btn-info btn-sm">Detalhes</a>
                    <a href="adicionar.php?id=<?= $filme['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="excluir.php?id=<?= $filme['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
