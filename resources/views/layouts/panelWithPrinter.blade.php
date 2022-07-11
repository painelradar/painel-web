<!DOCTYPE html>
<html lang="pt-BR" 0>

<head>
    <meta charset="utf-8" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body onload="startSetInterval()">
    @yield('content')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        options = {
            @foreach ($gamepads as $gamepad)
                {{ $gamepad->button }}() {
                        $.get("{{ route('panel.print', $gamepad->queue->id) }}", function(senha) {
                            printNumber('{{ $gamepad->queue->name }}', senha);
                        });
                    },
            @endforeach
        }

        function startSetInterval() {
            setInterval(function() {
                atualizaHora();
            }, 1000);
        }
        let voices = speechSynthesis.getVoices();
        var voice = voices[0];
        const speak = async text => {
            const message = new SpeechSynthesisUtterance(text)
            message.voice = voice;
            message.rate = 1.25;
            speechSynthesis.speak(message);
            document.getElementById("stringNumber").className = "stringNumber";
            document.getElementById("table-number").className = "stringTable";
        }
        const audio = new Audio('{{ url('/audios/ding.wav') }}');

        function chamaInterVal(interval) {
            intervalo = setInterval(() => {
                $.get("{{ route('panel.numberToCall', Request::segment(3)) }}", function(senha) {
                    senha = JSON.parse(senha);
                    if (senha != null) {
                        document.getElementById("stringNumber").innerHTML = senha.stringNumber;
                        document.getElementById("nameQueue").innerHTML = senha.queue;
                        document.getElementById("table-number").innerHTML = senha.table_number;
                        originalString = senha.stringNumber;
                        newString = originalString.replace(senha.stringNumber[0], '');
                        newString = newString.replace(senha.stringNumber[1], '');
                        falarMensagem = "SENHA" + "..." +
                            senha.stringNumber[0] + ' ' + senha.stringNumber[1] + " " + newString + ", " +
                            " GUICHÊ " + senha.table_number + "..." +
                            senha.queue;

                        document.getElementById("stringNumber").className = "piscando";
                        document.getElementById("table-number").className = "piscando";
                        audio.volume = 0.4;
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
