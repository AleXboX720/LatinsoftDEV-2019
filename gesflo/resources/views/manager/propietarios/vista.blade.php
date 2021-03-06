@extends('admin.layout')

@section('content')
	<div class="alert" id="alert"></div>

	<div class="row">
		<div class="col-md-12">
			@include('manager.propietarios.listado')
		</div>
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/eliminar.js') }}}"></script>
		
	<script src="{{{ asset('js/propietarios/modPropietarios.js') }}}"></script>
@endsection