<?php
require_once '../conn.php';
header('Content-Type: application/json');
date_default_timezone_set('America/Sao_Paulo');

$anoAtual = (int)date('Y');

$result = $conn->query("SELECT ano_atualizacao FROM controle_atualizacao WHERE id = 1");

if ($result && $row = $result->fetch_assoc()) {
    $ultimoAno = (int)$row['ano_atualizacao'];
} else {
    $conn->query("INSERT INTO controle_atualizacao (id, ano_atualizacao) VALUES (1, 0)");
    $ultimoAno = 0;
}

if ($anoAtual > $ultimoAno) {
    $mapaDePromocao = [
        '6º A - EF' => '7º A - EF',
        '6º B - EF' => '7º B - EF',
        '7º A - EF' => '8º A - EF',
        '8º A - EF' => '9º A - EF',
        '8º B - EF' => '9º B - EF',
        '9º A - EF' => '1ª A - EM',
        '9º B - EF' => '1ª B - EM',
        '1ª A - EM' => '2ª A - EM',
        '1ª B - EM' => '2ª B - EM',
        '2ª A - EM' => '3ª A - EM',
        '2ª ADM - EM' => '3ª ADM - EM',
        '3ª A - EM' => 'FORMADO',
        '3ª B - NOTURNO - EM' => 'FORMADO',
        '1° TCA - EJA' => '2° TCA - EJA',
        '2° TCA - EJA' => '3° TCA - EJA',
        '3° TCA - EJA' => 'FORMADO'
    ];

    $stmt = $conn->prepare("UPDATE alunos SET sala = ? WHERE sala = ?");
    foreach ($mapaDePromocao as $salaAtual => $novaSala) {
        $stmt->bind_param("ss", $novaSala, $salaAtual);
        $stmt->execute();
    }

    $conn->query("UPDATE controle_atualizacao SET ano_atualizacao = $anoAtual WHERE id = 1");

    echo json_encode([
        'success' => true,
        'mensagem' => "Salas atualizadas para o ano $anoAtual.",
        'reload' => true
    ]);
} else {
    echo json_encode([
        'success' => false,
        'mensagem' => "As salas já foram atualizadas para o ano $anoAtual.",
        'reload' => false
    ]);
}
