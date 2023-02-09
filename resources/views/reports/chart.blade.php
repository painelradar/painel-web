<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Relatórios</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="chart-container" style="height:50vh; width:50vw">
                    <canvas id="myChart"></canvas>
                    <br>
                    <canvas id="myChart5"></canvas>
                    <br>
                    <canvas id="myChart2"></canvas>
                    <br>
                    <canvas id="myChart3"></canvas>
                    <br>
                    <canvas id="myChart4"></canvas>
                    <br>
                </div>
            </div>

        </div>

    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script>
        var operador=
        <?php echo json_encode($attendantCalls); ?>;
        var chaves = Object.keys(operador);
        const labelsChamada = chaves;
        const dataChamada = {
            labels: labelsChamada,
            datasets: [{
                label: 'Tempo médio',
                backgroundColor: 'rgb(0, 160, 145)',
                borderColor: 'rgb(0, 54, 65)',
                data: [{{ implode(',', $attendantCalls) }}],
            }]
        };
        const configChamada = {
            type: 'bar',
            data: dataChamada,
            options: {
            indexAxis: 'y',
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Tempo médio ocioso X Operador'
                }
            }
            },
        };
        var operador= <?php echo json_encode($attendantAverage); ?>;
        var chaves = Object.keys(operador);
        const labelsTimeAtend = chaves;
        const dataTimeAtend = {
            labels: labelsTimeAtend,
            datasets: [{
                label: 'Tempo médio',
                backgroundColor: 'rgb(0, 54, 65)',
                borderColor: 'rgb(0, 160, 145)',
                data: [{{ implode(',', $attendantAverage) }}],
            }]
        };
        const configTimeAtend = {
            type: 'bar',
            data: dataTimeAtend,
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Tempo médio de atendimento X Operador'
                    }
                }
            },
        };

        var filas =
        <?php echo json_encode($queueTimeCalls); ?>;
        var chaves = Object.keys(filas);
        const labelsFilas = chaves;

        const datasFilas = {
            labels: labelsFilas,
            datasets: [{
                label: 'Tempo médio',
                backgroundColor: 'rgb(0, 160, 145)',
                borderColor: 'rgb(rgb(0, 54, 65))',
                data: [{{ implode(',', $queueTimeCalls) }}],
            }]
        };

        const configFilas = {
            type: 'bar',
            data: datasFilas,
            options: {
                indexAxis: 'y',
                elements: {
                    bar: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Tempo médio em espera X Fila'
                    }
                }
            },
        };
        var filaNumero=
        <?php echo json_encode($queueCountCalls); ?>;
        var chaves = Object.keys(filaNumero);
        const labelsNumeroChamadas = chaves;

        const datasNumeroChamadas = {
            labels: labelsNumeroChamadas,
            datasets: [{
                label: 'Número de senhas',
                backgroundColor: 'rgb(0, 54, 65)',
                borderColor: 'rgb(0, 160, 145)',
                data: [{{ implode(',', $queueCountCalls) }}],
            }]
        };
        const configNumeroChamadas = {
            type: 'bar',
            data: datasNumeroChamadas,
            options: {
            indexAxis: 'y',
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Número de senhas chamadas por atendimento'
                }
            }
            },
        };
        var numeroSenhas=
        <?php echo json_encode($queueNumbersCount); ?>;
        var chaves = Object.keys(numeroSenhas);
        const labelsNumeroSenhas = chaves;

        const datasNumeroSenhas = {
            labels: labelsNumeroSenhas,
            datasets: [{
                label: 'Número de Senhas',
                backgroundColor: 'rgb(0, 160, 145)',
                borderColor: 'rgb(rgb(0, 54, 65))',
                data: [{{ implode(',', $queueNumbersCount) }}],
            }]
        };
        const configNumeroSenhas = {
            type: 'bar',
            data: datasNumeroSenhas,
            options: {
            indexAxis: 'y',
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Número de senhas impressas por fila'
                }
            }
            },
        };
        const myChart = new Chart(
            document.getElementById('myChart'),
            configChamada
        );
        const myChart2 = new Chart(
            document.getElementById('myChart2'),
            configFilas
        );
        const myChart3 = new Chart(
            document.getElementById('myChart3'),
            configNumeroChamadas
        );
        const myChart4 = new Chart(
            document.getElementById('myChart4'),
            configNumeroSenhas
        );
        const myChart5 = new Chart(
        document.getElementById('myChart5'),
        configTimeAtend
        );
    </script>
</body>

</html>