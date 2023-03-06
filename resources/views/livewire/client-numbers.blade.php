<div>
    <div wire:poll wire:init="verifyService" class="row g-5" style="margin-top: 50px !important;">
        <div class="col-8">
            <div class="card shadow">
                <div class="card-header card-header-warning">
                    <h4 class="card-title text-center">Senhas em espera</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover datatable">
                        <thead class="text-warning text-center">
                            <th>Senha</th>
                            <th>Fila</th>
                            <th>Tempo de Espera</th>
                            <th>Ações</th>

                        </thead>
                        <tbody class="text-center">

                            @foreach ($numbers as $key => $number)
                            @if ($key % 2 > 0)
                            <tr style="background-color: rgb(216, 216, 216);">
                                <td>{{ $number->stringNumber }}</td>
                                <td>{{ $number->queue->name }}</td>
                                <td>{{ $number->minutesWaiting() }} minutos </td>
                                <td><button type="button" class="btn btn-outline-success"
                                        wire:click="call({{ $number->id }})">Chamar</button>
                                </td>

                            </tr>
                            @else
                            <tr>
                                <td>{{ $number->stringNumber }}</td>
                                <td>{{ $number->queue->name }}</td>
                                <td>{{ $number->minutesWaiting() }} minutos </td>
                                <td><button type="button" class="btn btn-outline-success"
                                        wire:click="call({{ $number->id }})">Chamar</button>
                                </td>

                            </tr>
                            @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow">
                <div class="card-header card-header-warning">
                    <h4 class="card-title text-center">Filas</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table datatable">
                        <tbody class="text-center">
                            @foreach ($queues as $queue)
                            <tr>
                                <td><button class="btn btn-secondary" wire:click="callNext({{ $queue->id }})">
                                        {{ $queue->name }}
                                        ({{ $numbers->where('queue_id', $queue->id)->count()
                                        }}
                                        senhas)
                                    </button></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header card-header-warning">
                    <h4 class="card-title text-center">Senhas ausentes</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table datatable">
                        <tbody class="text-center">
                            @foreach ($absents as $absent)
                            <tr>
                                <td>{{ $absent->stringNumber }}</td>
                                <td><button type="button" class="btn btn-outline-success"
                                        wire:click="call({{ $absent->id }})">Chamar</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>