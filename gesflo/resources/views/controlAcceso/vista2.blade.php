@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div class="form-group">
                <input id="docu_perso" type="number" class="form-control{{ $errors->has('docu_perso') ? ' is-invalid' : '' }}" name="docu_perso" value="{{ old('docu_perso') }}" placeholder="Codigo" required autofocus>

                @if ($errors->has('docu_perso'))
                    <span class="badge badge-danger">{{ $errors->first('docu_perso') }}</span>
                @endif
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <hr>

            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-sign-in"></i> <span>{{ __('Ingresar') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
