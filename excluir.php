<?php
require 'db.php';

// Obtém o ID do filme a partir da URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

try {
    
    $stmt = $pdo->prepare("DELETE FROM filmes WHERE id = ?");
    $stmt->execute([$id]);

    // Redireciona para a página inicial
    header('Location: index.php');
    exit;

} catch (Exception $e) {
    die("Erro ao excluir o filme: " . $e->getMessage());
}
