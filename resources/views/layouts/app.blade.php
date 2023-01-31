<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel de Senhas</title>
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        body {
            background-image: url('/images/bg-sicoob.png');
            background-size: cover;
        }

        .row {
            margin-top: 2vh !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>

    @yield('content')

    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
