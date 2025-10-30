function mostrarNotificacao(texto, tipo = 'ok') {
    const notificacao = document.getElementById('notificacao');
    const mensagem = document.getElementById('mensagemNotificacao');

    mensagem.innerText = texto;
    notificacao.className = `notificacao show ${tipo}`;

    setTimeout(() => {
        notificacao.className = 'notificacao';
    }, 3000);
}


document.addEventListener('DOMContentLoaded', () => {
    const alunoInput = document.getElementById('buscaAluno');
    const alunoId = document.getElementById('aluno_id');
    const resultadoAluno = document.getElementById('resultadoAluno');

    const livroInput = document.getElementById('buscaLivro');
    const livroId = document.getElementById('livro_id');
    const resultadoLivro = document.getElementById('resultadoLivro');

    alunoInput.addEventListener('input', () => {
        const busca = alunoInput.value;
        if (busca.length < 2) return resultadoAluno.innerHTML = '';

        fetch('src/api/busca_alunos.php?nome=' + encodeURIComponent(busca))
            .then(res => res.json())
            .then(data => {
                resultadoAluno.innerHTML = '';
                data.forEach(aluno => {
                    const div = document.createElement('div');
                    div.textContent = `${aluno.nome} (${aluno.sala})`;
                    div.addEventListener('click', () => {
                        alunoInput.value = aluno.nome;
                        alunoId.value = aluno.id;
                        resultadoAluno.innerHTML = '';
                    });
                    resultadoAluno.appendChild(div);
                });
            });
    });

    livroInput.addEventListener('input', () => {
        const busca = livroInput.value;
        if (busca.length < 2) return resultadoLivro.innerHTML = '';

        fetch('src/api/busca_livros.php?titulo=' + encodeURIComponent(busca))
            .then(res => res.json())
            .then(data => {
                resultadoLivro.innerHTML = '';
                data.forEach(livro => {
                    const div = document.createElement('div');
                    div.textContent = `${livro.titulo} (${livro.quantidade} disponíveis)`;
                    div.addEventListener('click', () => {
                        livroInput.value = livro.titulo;
                        livroId.value = livro.id;
                        resultadoLivro.innerHTML = '';
                    });
                    resultadoLivro.appendChild(div);
                });
            });
    });

    document.getElementById('emprestimoForm').addEventListener('submit', e => {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const alunoId = document.getElementById('aluno_id');
        const livroId = document.getElementById('livro_id');

        if (!alunoId.value || !livroId.value) {
            mostrarNotificacao('Selecione um aluno e um livro.', 'erro');
            return;
        }

        fetch('src/api/cadastro_emprestimo.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    mostrarNotificacao('Empréstimo registrado com sucesso!', 'ok');
                    form.reset();
                    alunoId.value = '';
                    livroId.value = '';

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    
                } else {
                    mostrarNotificacao('Erro: ' + response.message, 'erro');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarNotificacao('Erro de comunicação com o servidor.', 'erro');
            });
    });
});
