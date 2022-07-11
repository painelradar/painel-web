<div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 border rounded p-3"
                style="background-color: white !important; margin-top:7vh;.">
                <form wire:submit.prevent="createButton()">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="button" id="button" wire:model="button" required>
                    </div>
                    <div class="mb-3">
                        @if (session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                        @endif
                        <select class="form-select" wire:model="queue" required>
                            <option selected value="">Selecione a fila para esse botão</option>
                            @foreach ($queues as $queue)
                                <option value="{{ $queue->id }}">{{ $queue->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Criar</button>
                </form>
            </div>
            @if ($gamepads->count() > 0)
                <div class="col-12">
                    <div class="card shadow" style="margin-top: 3vh !important">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title text-center">Botões cadastrados</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover datatable">
                                <thead class="text-warning text-center">
                                    <th>Botão</th>
                                    <th>Fila</th>
                                    <th>Ação</th>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($gamepads as $key => $gamepad)
                                        @if ($key % 2 > 0)
                                            <tr style="background-color: rgb(216, 216, 216);">
                                                <td>{{ $gamepad->button }}</td>
                                                <td>{{ $gamepad->queue->name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        wire:click="delete({{ $gamepad->id }})">Excluir
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{ $gamepad->button }}</td>
                                                <td>{{ $gamepad->queue->name }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        wire:click="delete({{ $gamepad->id }})">Excluir
                                                    </button>
                                                </td>


                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
