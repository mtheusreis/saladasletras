<?php
require_once '../conn.php';

$nome = trim($_POST['aluno'] ?? '');
$serie = trim($_POST['serie'] ?? '');

if ($nome === '' || $serie === '') {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO alunos (nome, sala) VALUES (?, ?)");
$stmt->bind_param("ss", $nome, $serie);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao cadastrar aluno.']);
}

$stmt->close();
$conn->close();
