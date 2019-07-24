@extends('layouts.app')

@section('content')
<style type="text/css">
body {
  background: #999;
  padding: 100px;
}

#bg {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background:url(img/portada.jpg) no-repeat center center fixed;
  /*background: url(http://lorempixel.com/800/500/nature) no-repeat center center fixed;*/
  background-size: cover;
  -webkit-filter: blur(2px);    
}

form {
  position: relative;
  margin: 0 auto;
  background: rgba(180,180,180,.4);
  padding: 20px 30px;
}

form input, form button {
  letter-spacing: .08em;
  color: #fff;
}
form button:hover {
  font-weight: bold;
  background-color: #22C725 !important;
}

::-webkit-input-placeholder { color: #ccc; text-transform: uppercase; }
::-moz-placeholder { color: #ccc; text-transform: uppercase; }
:-ms-input-placeholder { color: #ccc; text-transform: uppercase; }
</style>

<div id="bg"></div>

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
            @csrf
            <div class="form-group">
                <input id="docu_perso" type="number" class="form-control input-lg {{ $errors->has('docu_perso') ? ' is-invalid' : '' }}" name="docu_perso" value="{{ old('docu_perso') }}" placeholder="Codigo" required autofocus>

                @if ($errors->has('docu_perso'))
                    <span class="badge badge-danger">{{ $errors->first('docu_perso') }}</span>
                @endif
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control input-lg {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-sign-in"></i> <span>{{ __('INGRESAR') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
