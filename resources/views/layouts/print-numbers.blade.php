<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <style>
        body {
            background-image: url('/images/bg-sicoob.png');
            background-size: cover;
        }

        .print h1 {
            font-weight: bold !important;
            font-weight: 200;
            color: black;
            font-size: 64px;
        }

        .print {
            font-weight: bold !important;
            font-weight: 200;
            color: black;
            display: none;
        }

        .print h4 {
            font-weight: bold !important;
            font-weight: 200;
            color: black;
            font-size: 18px;
            padding: 10px;
            display: inline-block;
        }

        @media print {
            .print {
                display: block;
            }

            .queueButtons {
                display: none;
            }
        }
    </style>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <div class="container">
        {{ $slot }}
    </div>


    @livewireScripts

    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>
