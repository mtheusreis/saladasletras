<?php
require '../conn.php';

$titulo = $_GET['titulo'] ?? '';
$stmt = $conn->prepare("SELECT id, titulo, quantidade FROM livros WHERE titulo LIKE ?");
$busca = "%$titulo%";
$stmt->bind_param("s", $busca);
$stmt->execute();
$result = $stmt->get_result();

$livros = [];
while ($row = $result->fetch_assoc()) {
    $livros[] = $row;
}
echo json_encode($livros);
