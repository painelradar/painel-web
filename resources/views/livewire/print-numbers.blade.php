<div>
    <div class="queueButtons">
        <div class="row align-items-center" style="height: 75vh; margin-top:50px;">
            <div class="col-md-12">
                <h1 class="d-flex justify-content-center"
                    style="font-size: 4rem !important; color:white; -webkit-text-stroke: 1px black;">RETIRE SUA
                    SENHA</h1><br /><br />
            </div>
            @foreach ($queues as $queue)
            <div class="col-6">
                <div class="card border-0 align-items-center text-bg-light"
                    style="max-width: 1200x; --bs-bg-opacity: .0 !important;">
                    <div class="card-body">
                        <form wire:submit.prevent="render">
                            <button type="submit" id="{{ $queue->id }}" class="btn btn-light"
                                style="height:150px;width:500px; font-size: 2rem !important; font-weight: 700; color: #003641; border: 4px solid #003641;"
                                onclick="buttons[{{ $queue->id }}]()">{{
                                $queue->name
                                }}</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <br>
    <div class="print">
        <div class="row text-center">
            <div class="col-12">
                <img src="{{ url('images/logo.png') }}" alt="Logo Sicoob" style="max-height: 150px; max-width:200px;">
            </div>
            <hr>
            <div class="col-12">
                <h4 id="queue">-</h4>
            </div>
            <div class="col-12">
                <h1 id="number">-</h1>
            </div>
            <div class="col-6">
                <h4 id="date">-</h4>
            </div>
            <div class="col-6">
                <h4 id="time">-</h4>
            </div>
            <hr>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade align-items-center" id="showPrintLoading" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-12 d-flex justify-content-center">
                            <h1> IMPRIMINDO </h1>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        buttons = {
            @foreach ($queues as $queue)
                {{ $queue->id }}(){

                    $.get("{{ route('panel.print', $queue->id) }}", function(senha) {
                        printNumber('{{ $queue->name }}', senha);
                    });

                },
            @endforeach
        }
        function printNumber(queue, number){
            // Get the current date/time
            let date = new Date();

            // Store each part in a variable
            let day = date.getDate(); // 1-31
            let month = date.getMonth(); // 0-11 (zero=January)
            let year = date.getFullYear(); // 4 digits
            let hour = date.getHours(); // 0-23
            let minutes = date.getMinutes(); // 0-59
            let seconds = date.getSeconds(); // 0-59
            if(hour < 10){ hour='0' + hour; }
            // Format the date and time
            if(day < 10){ day='0' + day; } if(month < 10){ month='0' + (month+1); } if(minutes < 10){ minutes='0' + minutes; }
                if(seconds < 10){ seconds='0' + seconds; } let strDate=day + '/' + month + '/' + year; let strTime=hour + ':' +
                minutes + ':' + seconds;
            document.getElementById('queue').innerHTML = queue;
            document.getElementById('number').innerHTML = number;
            document.getElementById('date').innerHTML = strDate;
            document.getElementById('time').innerHTML = strTime;
            window.print();
            setTimeout(function() {
            $('#showPrintLoading').modal('show');
            }, 500);
            setTimeout(function() {
                        $('#showPrintLoading').modal('hide');
                    }, 3000);
        }

    </script>
</div>
