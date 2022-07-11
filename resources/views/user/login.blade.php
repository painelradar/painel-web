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
                    <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                        required autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="password" name="password">
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
