<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12" style="margin-top: 30vh !important;">

                <h4 class="text-center h1">Selecione as datas inicial e final para gerar o relatório</h4>
                <table class="table">

                    <tbody class="mx-auto">
                        <tr>
                            <td>
                                <form action="{{ route('reports.generate') }}" method="GET" target="_blank">
                                    <div class="input-group date">

                                    </div>
                                    <div class="col-12 d-flex justify-content-center p-3">
                                        <label for=" datepicker1" class="px-2"> <strong>Data inicial</strong></label>
                                        <input id="datepicker1" type="date" name="date_start" required />

                                    </div>
                                    <div class="col-12 d-flex justify-content-center p-3 ">
                                        <label for="datepicker2" class="px-2"> <strong>Data final</strong></label>
                                        <input id="datepicker2" type="date" name="date_end" required />
                                    </div>
                                    <div class="col-12 d-flex justify-content-center p-3">
                                        <button type="submit" class="btn btn-primary">Gerar relatório</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
