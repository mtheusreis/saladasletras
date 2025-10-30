<?php
    include_once 'src/conn.php';

    $sql = "SELECT id, nome, sala FROM alunos ORDER BY nome";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Sala das Letras</title>
</head>

<body>

    <div class="container">

        <div class="lateral">

            <div class="headerLateral">
                <h1 class="logo">Sala das <span class='letras'>Letras</span></h1>
            </div>
            <div class="middleLateral">
                <div class="navBtns active" id="1">
                    <ion-icon name="paper-plane"></ion-icon> Empréstimos
                </div>
                <div class="navBtns" id="2">
                    <ion-icon name="library"></ion-icon> Livros
                </div>
                <div class="navBtns" id="3">
                    <ion-icon name="school"></ion-icon> Alunos
                </div>
                <div class="navBtns" id="4">
                    <ion-icon name="alarm"></ion-icon> Atrasos
                </div>
                <div class="navBtns" id="5">
                    <ion-icon name="stats-chart"></ion-icon> Gráficos
                </div>
            </div>
            <div class="bottomLateral">
                <a href="src/logout.php"><ion-icon name="exit-outline"></ion-icon></a>
            </div>

        </div>
        
        <div id="notificacao" class="notificacao hidden">
            <span id="mensagemNotificacao"></span>
        </div>

        
        <div class="content">

            <header>
                <h1 class="title h1" id='title'>
                    Bem Vindo
                </h1>
                <h1 class="title h1">
                    Nome Sobrenome
                </h1>
            </header>

            <div class="containerContent">

                <div class='contentScreen' id="alunosContainer">

                    <div class="subtitle">
                        Cadastrar Aluno
                    </div>

                    <form id="alunosForm">
                        <input type="text" name="aluno" id="aluno" placeholder="Nome do Aluno" required>

                        <select name="serie" id="serieAluno" required>
                            <option value="6º A - EF">6º ANO A - EF</option>
                            <option value="6º B - EF">6º ANO B - EF</option>
                            <option value="7º A - EF">7º ANO A - EF</option>
                            <option value="8º A - EF">8º ANO A - EF</option>
                            <option value="8º B - EF">8º ANO B - EF</option>
                            <option value="9º A - EF">9º ANO A - EF</option>
                            <option value="9º B - EF">9º ANO B - EF</option>
                            <option value="1ª A - EM">1ª SÉRIE A - EM</option>
                            <option value="1ª B - EM">1ª SÉRIE B - EM</option>
                            <option value="2ª A - EM">2ª SÉRIE A - EM</option>
                            <option value="3ª A - EM">3ª SÉRIE A - EM</option>
                            <option value="2ª ADM - EM">2ª SÉRIE ADM - EM</option>
                            <option value="3ª B - NOTURNO - EM">3ª SÉRIE B - NOTURNO - EM</option>
                            <option value="1° TCA - EJA">1° TCA - EJA</option>
                            <option value="2° TCA - EJA">2° TCA - EJA</option>
                            <option value="3° TCA - EJA">3° TCA - EJA</option>
                            <option value="PROFESSOR PEI">PROFESSOR PEI</option>
                            <option value="COMUNIDADE">COMUNIDADE</option>
                            <option value="PROFESSOR NOTURNO">PROFESSOR NOTURNO</option>
                            <option value="SECRETARIA">SECRETARIA</option>
                            <option value="VICE-DIRETORA">VICE-DIRETORA</option>
                            <option value="DIRETORA">DIRETORA</option>
                        </select>


                        <button type="submit" class="button red">Cadastrar</button>
                    </form>


                    <div class="tableContainer" id="tabelaAlunos">
                        <div class="subtitle">Alunos Cadastrados</div>

                        <table class="emprestimosTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Série</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['nome']) ?></td>
                                        <td><?= htmlspecialchars($row['sala']) ?></td>
                                        <td class="status-ok">Ativo</td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="contentScreen" id="livrosContainer">
                    <div class="subtitle">
                        Cadastrar Livro
                    </div>
                    <form id="livroForm">
                        <input type="text" name="titulo" id="titulo" placeholder="Título do Livro" required>
                        <input type="text" name="autor" id="autor" placeholder="Autor" required>
                        <input type="text" name="editora" id="editora" placeholder="Editora" required>
                        <input type="text" name="categoria" id="categoria" placeholder="Categoria" required>
                        <input type="number" name="quantidade" id="quantidade" placeholder="Qtd." required min="1">

                        <button type="submit" class="button red">Cadastrar</button>
                    </form>
                </div>
                <div class="contentScreen" id="emprestimosContainer">

                    <div class="subtitle">Registrar Empréstimo</div>

                    <form id="emprestimoForm">
                        
                        <div class="autocomplete-wrapper">
                            <input type="text" id="buscaAluno" placeholder="Buscar aluno..." autocomplete="off" required>
                            <input type="hidden" name="aluno_id" id="aluno_id">
                            <div id="resultadoAluno" class="autocomplete-results"></div>
                        </div>

                        <div class="autocomplete-wrapper">
                            <input type="text" id="buscaLivro" placeholder="Buscar livro..." autocomplete="off" required>
                            <input type="hidden" name="livro_id" id="livro_id">
                            <div id="resultadoLivro" class="autocomplete-results"></div>
                        </div>                        

                        <label>Data do Empréstimo</label>
                        <input type="date" name="data_emprestimo" required>

                        <button type="submit" class="button red">Registrar Empréstimo</button>
                    </form>

                    <div class="subtitle">Empréstimos Registrados</div>

                    <input type="text" id="filtroLivro" placeholder="Buscar por título do livro..." style="margin-bottom: 15px; padding: 8px; width: 100%; max-width: 400px; font-size: 14px; border-radius: 6px; border: 1px solid #ccc;">

                    <table class="emprestimosTable" id="tabelaEmprestimos">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Livro</th>
                                <th>Data Empréstimo</th>
                                <th>Data Devolução</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once 'src/conn.php';

                            $sql = "
                                SELECT e.id, a.nome AS aluno, l.titulo AS livro, 
                                    e.data_emprestimo, e.data_devolucao, e.devolvido
                                FROM emprestimos e
                                JOIN alunos a ON e.aluno_id = a.id
                                JOIN livros l ON e.livro_id = l.id
                                WHERE NOT (
                                    e.devolvido = 0 
                                    AND e.data_emprestimo <= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
                                )
                                ORDER BY e.data_emprestimo DESC
                            ";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['aluno']}</td>";
                                echo "<td>{$row['livro']}</td>";
                                echo "<td>" . date('d/m/Y', strtotime($row['data_emprestimo'])) . "</td>";
                                echo "<td>" . ($row['data_devolucao'] ? date('d/m/Y', strtotime($row['data_devolucao'])) : '-') . "</td>";
                                echo "<td class='" . ($row['devolvido'] ? 'status-ok' : 'status-pendente') . "'>" 
                                        . ($row['devolvido'] ? 'Devolvido' : 'Pendente') . 
                                    "</td>";
                                
                                if (!$row['devolvido']) {
                                    echo "<td>
                                            <button class='btnDevolver' data-id='{$row['id']}'>Devolver</button>
                                        </td>";
                                } else {
                                    echo "<td class='checkIcon'><ion-icon name='checkmark-circle'></ion-icon></td>";
                                }
                                echo "</tr>";
                            }

                            ?>
                        </tbody>
                    </table>


                </div>

                <div class="contentScreen" id='atrasosContainer'>
                    
                <div class="subtitle">Empréstimos em Atraso (mais de 15 dias)</div>

                    <table class="emprestimosTable" id="tabelaAtrasos">
                        <thead>
                            <tr>
                                <th>Aluno</th>
                                <th>Livro</th>
                                <th>Data Empréstimo</th>
                                <th>Data Devolução</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once 'src/conn.php';

                            $sql = "
                                SELECT e.id, a.nome AS aluno, l.titulo AS livro, 
                                    e.data_emprestimo, e.data_devolucao, e.devolvido
                                FROM emprestimos e
                                JOIN alunos a ON e.aluno_id = a.id
                                JOIN livros l ON e.livro_id = l.id
                                WHERE e.devolvido = 0
                                AND e.data_emprestimo <= DATE_SUB(CURDATE(), INTERVAL 15 DAY)
                                ORDER BY e.data_emprestimo ASC
                            ";

                            $result = $conn->query($sql);

                            if ($result->num_rows === 0) {
                                echo "<tr><td colspan='6' style='text-align:center;'>Nenhum empréstimo em atraso.</td></tr>";
                            } else {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$row['aluno']}</td>";
                                    echo "<td>{$row['livro']}</td>";
                                    echo "<td>" . date('d/m/Y', strtotime($row['data_emprestimo'])) . "</td>";
                                    echo "<td>" . ($row['data_devolucao'] ? date('d/m/Y', strtotime($row['data_devolucao'])) : '-') . "</td>";
                                    echo "<td class='status-pendente'>Atrasado</td>";
                                    
                                    echo "<td>
                                            <button class='btnDevolver' data-id='{$row['id']}'>Devolver</button>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

                <div class="contentScreen" id='graficosContainer'>

                    <div id="graficoSalasColumn" style="width: 1000px; height: 400px; margin-bottom: 100px;"></div>
                    <div id="graficoSalasPie" style="width: 1000px; height: 400px; margin-top: 100px;"></div>

                    <button id="atualizarSalas" class='btnDevolver'>Atualizar Salas</button>

                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>            

                </div>

            </div>

        </div>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="assets/js/busca.js"></script>
    <script src="assets/js/cadastrar.js"></script>
</body>

</html>