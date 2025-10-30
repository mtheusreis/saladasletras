<?php
require '../conn.php';

$titulo = $_POST['titulo'] ?? '';
$autor = $_POST['autor'] ?? '';
$editora = $_POST['editora'] ?? '';
$categoria = $_POST['categoria'] ?? '';
$quantidade = $_POST['quantidade'] ?? 0;

if (!$titulo || !$autor || !$editora || !$categoria || $quantidade < 1) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO livros (titulo, autor, editora, categoria, quantidade) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $titulo, $autor, $editora, $categoria, $quantidade);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar.']);
}
