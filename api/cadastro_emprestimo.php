<?php
require '../conn.php';

$aluno_id = $_POST['aluno_id'];
$livro_id = $_POST['livro_id'];
$data_emprestimo = $_POST['data_emprestimo'];

$stmt = $conn->prepare("INSERT INTO emprestimos (aluno_id, livro_id, data_emprestimo) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $aluno_id, $livro_id, $data_emprestimo);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}
