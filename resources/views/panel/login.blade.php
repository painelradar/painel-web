@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 border rounded p-3"
            style="background-color: white !important; margin-top:20vh !important;">
            <form action=" {{ route('user.auth') }}" method="POST">
                @csrf
                <div class="mb-3 text-center">
                    <img src="{{ url('images/logo-colorida.jpg') }}" width="50%" alt="Logo Sicoob">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label @error('name') is-invalid @enderror">Login</label>
                    <input type="text" class="form-control" id="name" name="name"
                        required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="remember">Lembrar-me</label>
                    <input type="checkbox" name="remember" id="remember" value="1">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #003641 !important; ">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
