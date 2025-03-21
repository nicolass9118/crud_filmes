<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$filme_id = $_GET['filme_id'] ?? null;

if (!$id || !$filme_id) {
    header("Location: filme.php?id=$filme_id");
    exit;
}

// Exclui a avaliação
$stmt = $pdo->prepare("DELETE FROM avaliacoes WHERE id = ?");
$stmt->execute([$id]);

header("Location: filme.php?id=$filme_id");
exit;
?>
