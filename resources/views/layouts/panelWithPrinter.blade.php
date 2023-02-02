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

<body>
    @yield('content')
    <script src="{{ asset('js/jquery.js') }}"></script>

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
        class Gamepad {
            constructor() {
                this.buttons = {};

                this.buttons['a'] = 0;
                this.buttons['b'] = 0;
                this.buttons['x'] = 0;
                this.buttons['y'] = 0;
                this.buttons['rb'] = 0;
                this.buttons['lb'] = 0;
                this.buttons['rt'] = 0;
                this.buttons['lt'] = 0;
                this.buttons['rs'] = 0;
                this.buttons['ls'] = 0;
                this.buttons['start'] = 0;
                this.buttons['select'] = 0;
                this.buttons['dup'] = 0;
                this.buttons['ddown'] = 0;
                this.buttons['dleft'] = 0;
                this.buttons['dright'] = 0;
                this.connected = false;

                window.addEventListener("gamepadconnected", this.connect.bind(this));
                window.addEventListener("gamepaddisconnected", this.disconnect.bind(this));
            }

            connect() {
                this.connected = true;
            }

            disconnect() {
                this.connected = false;
            }

            update() {
                let gamepad = navigator.getGamepads()[0];
                if (gamepad) {
                    this.buttons['a'] = gamepad.buttons[0].value;
                    this.buttons['b'] = gamepad.buttons[1].value;
                    this.buttons['x'] = gamepad.buttons[2].value;
                    this.buttons['y'] = gamepad.buttons[3].value;
                    this.buttons['lb'] = gamepad.buttons[4].value;
                    this.buttons['rb'] = gamepad.buttons[5].value;
                    this.buttons['lt'] = gamepad.buttons[6].value;
                    this.buttons['rt'] = gamepad.buttons[7].value;
                    this.buttons['select'] = gamepad.buttons[8].value;
                    this.buttons['start'] = gamepad.buttons[9].value;
                    this.buttons['ls'] = gamepad.buttons[10].value;
                    this.buttons['rs'] = gamepad.buttons[11].value;
                    this.buttons['dup'] = gamepad.buttons[12].value;
                    this.buttons['ddown'] = gamepad.buttons[13].value;
                    this.buttons['dleft'] = gamepad.buttons[14].value;
                    this.buttons['dright'] = gamepad.buttons[15].value;
                }
            }

        }
        let gamepad = new Gamepad();
        function scanKeys(){
            gamepad.update();
            if(gamepad.connected){
                let botoes = Object.values(gamepad.buttons);
                if(botoes.indexOf(1) > - 1){

                    let index = botoes.indexOf(1);
                    let key = Object.keys(gamepad.buttons)[index];
                    if(options[key]){
                        options[key]();
                        setTimeout(function(){
                            scanKeys();
                        }, 3000);
                        return;
                    }
                }else{
                    setTimeout(scanKeys, 100);
                }
            }else{
                setTimeout(scanKeys, 100);
            }

        }
        scanKeys();
        setInterval(atualizarHora, 1000);

        function atualizarHora(){
            let date = new Date();

            // Store each part in a variable
            let day = date.getDate(); // 1-31
            let month = date.getMonth(); // 0-11 (zero=January)
            let year = date.getFullYear(); // 4 digits
            let hour = date.getHours(); // 0-23
            let minutes = date.getMinutes(); // 0-59
            let seconds = date.getSeconds(); // 0-59

            // Format the date and time
            if(hour < 10){ hour='0' + hour; } // 0-9 becomes 00-09
            if(day < 10){ day='0' + day; } if(month < 10){ month='0' + (month+1); } if(minutes < 10){ minutes='0' + minutes; }
                if(seconds < 10){ seconds='0' + seconds; } let strDate=day + '/' + month + '/' + year; let strTime=hour + ':' +
                minutes + ':' + seconds;
            document.getElementById('stringTime').innerHTML = strTime;
            document.getElementById('stringDate').innerHTML = strDate;
        }

        function printNumber(queue, number){
            let date = new Date();

            // Store each part in a variable
            let day = date.getDate(); // 1-31
            let month = date.getMonth(); // 0-11 (zero=January)
            let year = date.getFullYear(); // 4 digits
            let hour = date.getHours(); // 0-23
            let minutes = date.getMinutes(); // 0-59
            let seconds = date.getSeconds(); // 0-59

            // Format the date and time
            if(day < 10){ day='0' + day; } if(month < 10){ month='0' + (month+1); } if(minutes < 10){ minutes='0' + minutes; }
                if(seconds < 10){ seconds='0' + seconds; } let strDate=day + '/' + month + '/' + year; let strTime=hour + ':' +
                minutes + ':' + seconds;
            document.getElementById('queue').innerHTML = queue;
            document.getElementById('number').innerHTML = number;
            document.getElementById('date').innerHTML = strDate + ' - ' + strTime;
            window.print();
        }

        let voices = speechSynthesis.getVoices();
        var voice = voices[0];
        const speak = async text => {
            const message = new SpeechSynthesisUtterance(text)
            message.voice = voice;
            message.rate = 1.15;
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
