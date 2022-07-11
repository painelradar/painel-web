@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 border rounded p-3"
            style="background-color: white !important; margin-top:7vh;.">
            <form action="{{ route('panel.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Agência</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="cooperative" class="form-label">Cooperativa</label>
                    <input type="text" class="form-control" id="cooperative" name="cooperative"
                        value="{{ old('cooperative') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="pa" class="form-label">PA</label>
                    <input type="text" class="form-control" id="pa" name="pa"
                        value="{{ old('pa') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Filas</label>
                    <div class="form-check">
                        @foreach ($queues as $queue)
                        <div class="col-6 @error('queues_array') is-invalid @enderror">
                            <input class="form-check-input" type="checkbox" value="{{ $queue->id }}"
                                id="{{ $queue->name }}" name="queues_array[]" @if(is_array(old('queues_array')) &&
                                in_array($queue->id, old('queues_array'))) checked @endif>
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
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        value="{{ old('password') }}" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label"> Confirmar Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="mb-3">
                    <label for="remember">Lembrar-me</label>
                    <input type="checkbox" name="remember" id="remember" value="1" checked>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #003641 !important; ">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop
