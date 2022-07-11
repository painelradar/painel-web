<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Painel de Senhas</title>
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <style>
        body {
            background-image: url('/images/bg-sicoob.png');
            background-size: cover;
        }
    </style>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>

    {{ $slot }}

    @livewireScripts
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>

</html>
