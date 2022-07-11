@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 border rounded p-3"
            style="background-color: white !important; margin-top:23vh;.">
            <form action="{{ route('user.update', Auth::id()) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Filas</label>
                    <div class="form-check">
                        @foreach ($queues as $queue)
                        <div class="col-6 @error('queues_array') is-invalid @enderror">
                            <input class="form-check-input" type="checkbox" value="{{ $queue->id }}"
                                id="{{ $queue->name }}" name="queues_array[]" @if($user->queues->contains($queue->id))
                            checked
                            @endif>
                            <label class="form-check-label" for="{{ $queue->name }}">
                                {{ $queue->name }}
                            </label>
                        </div>
                        @endforeach
                        @error('queues_array')
                        <span class="invalid-feedback" role="alert">
                            <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>

                <div class="mb-3">
                    <label for="table_number" class="form-label">Guichê</label>
                    <input type="number" class="form-control @error('table_number') is-invalid @enderror"
                        id="table_number" value="{{ isset($user) ? $user->table_number : old('table_number') }}"
                        name="table_number" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" onclick="javascript:history.back()">Voltar</button>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #003641 !important; margin-left:10px;">Atualizar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop
