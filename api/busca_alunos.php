<?php
require '../conn.php';

$nome = $_GET['nome'] ?? '';
$stmt = $conn->prepare("SELECT id, nome, sala FROM alunos WHERE nome LIKE ?");
$busca = "%$nome%";
$stmt->bind_param("s", $busca);
$stmt->execute();
$result = $stmt->get_result();

$alunos = [];
while ($row = $result->fetch_assoc()) {
    $alunos[] = $row;
}
echo json_encode($alunos);
