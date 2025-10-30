<?php
include_once '../conn.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Erro ao atualizar.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestimo_id'])) {
    $id = intval($_POST['emprestimo_id']);

    $sql = "UPDATE emprestimos 
            SET data_devolucao = CURDATE(), devolvido = 1 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Empréstimo marcado como devolvido.';
    } else {
        $response['message'] = 'Erro ao executar a query.';
    }
}

echo json_encode($response);
exit;
