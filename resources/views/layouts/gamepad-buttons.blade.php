<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
</head>

<body>
    {{ $slot }}
    @livewireScripts
    <script>
        options = {
            a() {
                $('#button').val('a');
            },
            b() {
                $('#button').val('b');
            },
            x() {
                $('#button').val('x');
            },
            y() {
                $('#button').val('y');
            },
            rb() {
                $('#button').val('rb');
            },
            lb() {
                $('#button').val('lb');
            },
            t() {
                $('#button').val('t');
            }
        };
    </script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
