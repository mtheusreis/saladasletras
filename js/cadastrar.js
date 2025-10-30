function mostrarNotificacao(mensagem, tipo) {
    const notificacao = document.createElement('div');
    notificacao.className = `notificacao ${tipo}`;
    notificacao.innerText = mensagem;
    document.body.appendChild(notificacao);

    setTimeout(() => {
        notificacao.remove();
    }, 3000);
}


const alunosForm = document.getElementById('alunosForm');

if (alunosForm) {
    alunosForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(alunosForm);

        fetch('src/api/cadastrar_aluno.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    mostrarNotificacao('Aluno cadastrado com sucesso!', 'ok');
                    alunosForm.reset();

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    mostrarNotificacao('Erro: ' + response.message, 'erro');
                }
            })
            .catch(() => {
                mostrarNotificacao('Erro ao conectar com o servidor.', 'erro');
            });
    });
}

const formLivro = document.getElementById('livroForm');

formLivro.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(formLivro);

    fetch('src/api/cadastrar_livro.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                mostrarNotificacao('Livro cadastrado com sucesso!', 'ok');
                formLivro.reset();

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                mostrarNotificacao('Erro: ' + response.message, 'erro');
            }
        })
        .catch(() => {
            mostrarNotificacao('Erro de comunicação com o servidor.', 'erro');
        });
});

