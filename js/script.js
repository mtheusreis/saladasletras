document.addEventListener("DOMContentLoaded", function () {
    const navButtons = document.querySelectorAll('.navBtns');
    const screens = document.querySelectorAll('.contentScreen');

    navButtons.forEach(button => {
        button.addEventListener('click', () => {
            const id = button.id;

            screens.forEach(screen => screen.style.display = 'none');

            navButtons.forEach(btn => btn.classList.remove('active'));

            button.classList.add('active');

            if (id === '1') {
                document.getElementById('emprestimosContainer').style.display = 'block';
                document.getElementById('title').innerHTML = `<ion-icon name="paper-plane"></ion-icon> Empréstimos`;
            } else if (id === '2') {
                document.getElementById('livrosContainer').style.display = 'block';
                document.getElementById('title').innerHTML = `<ion-icon name="library"></ion-icon> Livros`;
            } else if (id === '3') {
                document.getElementById('alunosContainer').style.display = 'block';
                document.getElementById('title').innerHTML = `<ion-icon name="school"></ion-icon> Alunos`;
            } else if (id === '4') {
                document.getElementById('atrasosContainer').style.display = 'block';
                document.getElementById('title').innerHTML = `<ion-icon name="alarm"></ion-icon> Atrasos`;
            } else if (id === '5') {
                document.getElementById('graficosContainer').style.display = 'block';
                document.getElementById('title').innerHTML = `<ion-icon name="stats-chart"></ion-icon> Gráficos`;
            }
        });
    });

    screens.forEach(screen => screen.style.display = 'none');
    document.getElementById('emprestimosContainer').style.display = 'block';
    document.getElementById('title').innerHTML = `<ion-icon name="paper-plane"></ion-icon> Empréstimos`;

});


function mostrarNotificacao(texto, tipo = 'ok') {
    const notificacao = document.getElementById('notificacao');
    const mensagem = document.getElementById('mensagemNotificacao');

    mensagem.innerText = texto;
    notificacao.className = `notificacao show ${tipo}`;

    setTimeout(() => {
        notificacao.className = 'notificacao';
    }, 3000);
}


document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btnDevolver')) {
        const btn = e.target;
        const id = btn.getAttribute('data-id');

        if (confirm('Confirmar devolução?')) {
            const formData = new FormData();
            formData.append('emprestimo_id', id);

            fetch('src/api/devolver.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const row = btn.closest('tr');
                        row.querySelector('td:nth-child(5)').innerText = 'Devolvido';
                        row.querySelector('td:nth-child(5)').className = 'status-ok';

                        const checkTd = document.createElement('td');
                        checkTd.className = 'checkIcon';
                        checkTd.innerHTML = "<ion-icon name='checkmark-circle'></ion-icon>";
                        btn.parentElement.replaceWith(checkTd);

                        mostrarNotificacao('Empréstimo marcado como devolvido.', 'ok');
                    } else {
                        mostrarNotificacao('Erro: ' + data.message, 'erro');
                    }
                })
                .catch(() => mostrarNotificacao('Erro de comunicação com o servidor.', 'erro'));
        }
    }
});

document.getElementById('filtroLivro').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const tabela = document.getElementById('tabelaEmprestimos');
    const linhas = tabela.tBodies[0].rows;

    for (let i = 0; i < linhas.length; i++) {
        const celulaLivro = linhas[i].cells[1].textContent.toLowerCase();
        if (celulaLivro.includes(filtro)) {
            linhas[i].style.display = '';
        } else {
            linhas[i].style.display = 'none';
        }
    }
});

google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    fetch('src/api/grafico_salas.php')
        .then(response => response.json())
        .then(data => {
            var dataTable = google.visualization.arrayToDataTable(data);

            var optionsColumn = {
                title: 'Empréstimos por Sala',
                hAxis: {
                    title: 'Sala',
                    textStyle: {
                        fontSize: 13
                    },
                    slantedText: true,
                    slantedTextAngle: 45
                },
                vAxis: { title: 'Total de Empréstimos', minValue: 0 },
                colors: ['rgb(255, 68, 68)'],
                width: 1100,
                height: 400,
                legend: {
                    position: 'right',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            var optionsPie = {
                title: 'Distribuição de Empréstimos por Sala',
                colors: [
                    '#FF4444', '#FF8800', '#FFBB33', '#99CC00', '#33B5E5',
                    '#AA66CC', '#0099CC', '#9933CC', '#669900', '#FF6F61',
                    '#6C5CE7', '#00B894', '#FD79A8', '#E17055', '#2ECC71',
                    '#F1C40F', '#1ABC9C', '#9B59B6', '#34495E', '#D35400',
                    '#C0392B', '#7F8C8D', '#16A085', '#2980B9', '#8E44AD'
                ],
                pieHole: 0,
                legend: { position: 'right' },
                width: 1100,
                height: 400,
            };

            var chartColumn = new google.visualization.ColumnChart(document.getElementById('graficoSalasColumn'));
            chartColumn.draw(dataTable, optionsColumn);

            var chartPie = new google.visualization.PieChart(document.getElementById('graficoSalasPie'));
            chartPie.draw(dataTable, optionsPie);
        })
        .catch(error => console.error('Erro ao carregar dados do gráfico:', error));
}

document.getElementById('atualizarSalas').addEventListener('click', () => {
    fetch('src/api/atualizar_salas.php')
        .then(res => res.json())
        .then(data => {
            mostrarNotificacao(data.mensagem, data.success ? 'ok' : 'erro');

            if (data.success && data.reload) {
                setTimeout(() => location.reload(), 1500);
            }
        })
        .catch(() => {
            mostrarNotificacao('❌ Erro ao tentar atualizar as salas.', 'erro');
        });
});