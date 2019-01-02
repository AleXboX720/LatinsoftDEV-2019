@extends('admin.layout')

@section('content')
    <div class="alert" id="alert"></div>
    
	<div class="row">
		<div class="col-md-12">
			@include('manager.conductores.listado')
		</div>
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/eliminar.js') }}}"></script>
		
	<script src="{{{ asset('js/conductores/modConductores.js') }}}"></script>
@endsection