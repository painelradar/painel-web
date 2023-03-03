<!DOCTYPE html>
<html lang="pt-BR" 0>

<head>
    <meta charset="utf-8" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <style>
        body {
            background-image: url('/images/layout.jpg');
            background-color: rgb(0, 88, 101);
            background-repeat: no-repeat;
            background-size: cover;
        }

        .video {
            vertical-align: middle;
            text-align: center;
            padding-bottom: 15vh;
        }

        .nameNumber {
            border: none;
            color: rgb(200, 211, 0);
            text-align: center;
            text-decoration: none;
            font-family: Arial;
            font-size: 5vh;
            letter-spacing: 20px;
        }

        .stringNumber,
        .stringTable {
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            font-family: Arial;
            font-size: 15vh;
            font-weight: bold;
        }

        .backgroundGreen {
            background-color: rgb(200, 211, 0);
        }

        .nameQueue {
            border: none;
            color: rgb(0, 88, 101);
            text-align: center;
            min-height: 9vh;
            text-decoration: none;
            font-family: Arial;
            font-size: 5vh;
            font-weight: bold;
        }

        .stringDate {
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            font-family: Arial;
            font-size: 5vh;
            font-weight: bold;
        }

        .colunaDados {
            vertical-align: top;
            text-align: center;
            width: 32%;
        }

        .stringTime {
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            font-family: Arial;
            font-size: 10vh;
            font-weight: bold;
        }

        .piscando {
            animation: piscando 1.4s linear infinite;
            border: none;
            color: red;
            text-align: center;
            text-decoration: none;
            font-family: Arial;
            font-size: 15vh;
            font-weight: bold;
        }

        @keyframes piscando {
            100% {
                opacity: 0;
            }
        }
    </style>

</head>

<body onload="startSetInterval()">
    @yield('content')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script>
        function startSetInterval() {
        setInterval(function(){atualizaHora();}, 1000);
        }
        var atualizaHora = function() {
            var data = new Date();
            var hora = data.getHours();
            var minuto = data.getMinutes();
            var segundo = data.getSeconds();
            var dia = data.getDate();
            var mes = data.getMonth() + 1;
            var ano = data.getFullYear();
            if(dia<10) {
                dia = '0'+dia;
            }
            if(mes<10) {
                mes = '0'+mes;
            }
            if(segundo <10){
                segundo = "0" + segundo;
            }
            if(minuto <10){
                minuto = "0" + minuto;
            }
            if(hora < 10){ hora='0' + hora; } //
            var horaImprimivel = hora + ":" + minuto + ":" + segundo;
            var dataImprimivel = dia + "/" + mes + "/" + ano;
            $('#stringTime').html(horaImprimivel);
            $('#stringDate').html(dataImprimivel);
        };

        const voices = speechSynthesis.getVoices();
        const voice = voices[0];

        const speak = async text => {
            const message = new SpeechSynthesisUtterance(text)
            console.log(voices);
            message.voice = voice;
            message.rate = 1.10;
            speechSynthesis.speak(message);
            document.getElementById("stringNumber").className = "stringNumber";
            document.getElementById("table-number").className = "stringTable";
        }

        const audio = new Audio('{{ url("/audios/ding.wav") }}');
        function chamaInterVal(interval) {

            intervalo = setInterval(() => {
                $.get("{{ route('panel.numberToCall', Request::segment(2)) }}", function(senha) {
                    senha = JSON.parse(senha);
                    if (senha != null) {
                        document.getElementById("stringNumber").innerHTML = senha.stringNumber;
                        document.getElementById("nameQueue").innerHTML = senha.queue;
                        document.getElementById("table-number").innerHTML = senha.table_number;
                        originalString = senha.stringNumber;
                        newString = originalString.replace(senha.stringNumber[0], '');
                        newString = newString.replace(senha.stringNumber[1], '');
                        falarMensagem = "SENHA" + "..." +
                            senha.stringNumber[0] +' ' + senha.stringNumber[1] +" "+  newString +", " + " GUICHÊ "+ senha.table_number + "..." +
                            senha.queue;

                        document.getElementById("stringNumber").className = "piscando";
                        document.getElementById("table-number").className = "piscando";
                        audio.play();
                        setTimeout('speak(falarMensagem)', 3000);
                        clearInterval(intervalo);
                        chamaInterVal(9000);
                    } else {
                        clearInterval(intervalo);
                        chamaInterVal(1000);
                    }

                })
            }, interval);
        }
        chamaInterVal(1000);
    </script>
</body>

</html>
