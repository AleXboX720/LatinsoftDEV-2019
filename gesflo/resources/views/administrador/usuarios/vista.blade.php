@extends('admin.layout')


@section('content')
    <!--
    	<div class="alert" id="alert"></div>
	-->
	<div class="row">
		<div class="col-md-12">
			@include('administrador.usuarios.listado')
		</div>
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/jquery.js') }}}"></script>
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/eliminar.js') }}}"></script>
@section('contenido')