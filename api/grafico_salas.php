<?php
include_once '../conn.php';

$sql = "SELECT sala, COUNT(*) as total FROM emprestimos
        JOIN alunos ON emprestimos.aluno_id = alunos.id
        GROUP BY sala";

$result = $conn->query($sql);
$data = [];
$data[] = ['Sala', 'Total de Empréstimos'];

while ($row = $result->fetch_assoc()) {
    $data[] = [$row['sala'], (int)$row['total']];
}

header('Content-Type: application/json');
echo json_encode($data);
