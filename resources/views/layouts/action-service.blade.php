<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <style>
        #alert {
            transition: opacity 1s;
        }
    </style>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>
    <nav class="navbar fixed-top bg-light rounded-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ url('images/logo-colorida.png') }}" style="max-height: 40px;" alt="Logo Radar">
            </a>
            <div class="dropdown d-fex justify-content-end" style="right: 6vh;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="{{ route('user.edit', Auth::id()) }}">Editar Informações</a></li>
                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">Sair</a></li>
                </ul>
            </div>
        </div>

    </nav>
    <div class="container">
        {{ $slot }}
    </div>

    @livewireScripts
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

    <script>
        function clickRepeat(){
            $('#showPrintLoading').modal('show');
            setTimeout(function() {
            $('#showPrintLoading').modal('hide');
            }, 3000);
        }
    </script>

</body>

</html>
