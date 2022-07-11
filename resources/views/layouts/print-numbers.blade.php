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
    <script>
        function clickButton(fila, senha){
            printNumber(fila,senha);

            setTimeout(function() {
                $('#showPrintLoading').modal('hide');
            }, 3000);
        };
        // Get the current date/time
        let date = new Date();

        // Store each part in a variable
        let day = date.getDate(); // 1-31
        let month = date.getMonth(); // 0-11 (zero=January)
        let year = date.getFullYear(); // 4 digits
        let hour = date.getHours(); // 0-23
        let minutes = date.getMinutes(); // 0-59
        let seconds = date.getSeconds(); // 0-59

        // Format the date and time
        if(day < 10){ day='0' + day; }
        if(month < 10){ month='0' + (month+1); }
        if(minutes < 10){
            minutes = '0' + minutes;
        }
        if(seconds < 10){
            seconds = '0' + seconds;
        }
        let strDate = day + '/' + month + '/' + year;
        let strTime = hour + ':' + minutes + ':' + seconds;

        function printNumber(queue, number){
            document.getElementById('queue').innerHTML = queue;
            document.getElementById('number').innerHTML = number;
            document.getElementById('date').innerHTML = strDate;
            document.getElementById('time').innerHTML = strTime;
            window.print();
            setTimeout(function() {
                $('#showPrintLoading').modal('show');
            }, 500);
        }
    </script>

</body>

</html>
