@extends('template/master')
@section('titulo', $title)

@section('contenido')
	<div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
            	{{ $title }}
            	<a href="{{ route('administracion') }}" class="btn btn-warning pull-right">
	        		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Volver
	        	</a>
            </h3>
        </div>
    </div>

    <div class="alert" id="alert"></div>
    
	<div class="row">
		<div class="col-md-12">
			@include('usuarios.listado')
		</div>
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/jquery.js') }}}"></script>
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/eliminar.js') }}}"></script>
@section('contenido')