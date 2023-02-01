<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ url('images/logo-icon.png') }}">
    <title>Painel de Senhas</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <style>
        body {
            background-image: url('/images/bg-sicoob.png');
            background-size: cover;
        }
    </style>
</head>

<body>
    @yield('content')
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
            }
            rt() {
                $('#button').val('rt');
            },
            lt() {
                $('#button').val('lt');
            },
            rs() {
                $('#button').val('rs');
            },
            ls() {
                $('#button').val('ls');
            },
            start() {
                $('#button').val('start');
            },
            select() {
                $('#button').val('select');
            },
            dup() {
                $('#button').val('dup');
            },
            ddown() {
                $('#button').val('ddown');
            },
            dleft() {
                $('#button').val('dleft');
            },
            dright() {
                $('#button').val('dright');
            }

        };
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
                            setTimeout(scanKeys, 3000);
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
    </script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>