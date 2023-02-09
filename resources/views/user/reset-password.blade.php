@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3 border rounded p-3"
            style="background-color: white !important; margin-top:7vh;.">
            <form action="{{ route('attendant.reset', $attendant->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ $attendant ? $attendant->email : old('email')}}" readonly>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"> Nova Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        value="{{ old('password') }}" name="password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <i class="fi-circle-cross"></i><strong> {{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label"> Confirmar Nova Senha</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #003641 !important; ">Atualizar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop