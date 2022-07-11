<div>
    <div class="row">
        <div class="col-12" style="margin-top: 30vh !important;">

            <h4 class="text-center h1">Ações para o atendimento</h4>
            <div id="alert">
                @if (session()->has('message'))
                <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <strong>Você já está atendendo uma senha!</strong> Você precisa concluir ou encaminhar a senha antes
                    de realizar outro atendimento.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
            <table class="table">

                <thead class="text-warning text-center">
                    <div class="text-center" style="font-size: 50px;">
                        {{ $number->stringNumber }}
                    </div>
                </thead>
                <tbody class="d-flex justify-content-around">
                    <tr>
                        <td class="align-middle" style="padding: 30px !important;"><button type="button"
                                class="btn btn-primary btn-lg" wire:click="absent({{ $number->id }})">Ausente</button>
                        </td>

                        <td class="align-middle" style="padding: 30px !important;"><button type="button"
                                class="btn btn-primary btn-lg" onclick="clickRepeat()"
                                wire:click="repeat({{ $number->id }})">Repetir</button>
                        </td>

                        <td class="align-middle" style="padding: 30px !important;"><button type="button"
                                class="btn btn-primary btn-lg" wire:click="conclude({{ $number->id }})">Concluir
                                atendimento</button></td>
                        <td class="align-middle" style="padding: 30px !important;">
                            <div class="dropdown">
                                <button class="btn btn-primary btn-lg dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    ENCAMINHAR
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    @foreach ($queues as $queue)
                                    <li><a class="dropdown-item"
                                            wire:click.prevent="route({{ $number->id }}, {{ $queue->id }})">{{
                                            $queue->name }}</a>
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
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
                            <h1> REPETINDO SENHA </h1>
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
</div>
