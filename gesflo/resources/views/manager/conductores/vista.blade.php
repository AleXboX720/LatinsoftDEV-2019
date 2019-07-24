@extends('admin.layout')

@section('cabecera_adicional')    
    <div class=" pull-right">
		<button type="button" class="btn btn-block btn-success" id="btnAgregar"> 
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar
		</button>
	</div>
@endsection

@section('content')
	@include('manager.conductores.modal.agregar')
	@include('manager.conductores.modal.editar')
	<div class="row">
		<div class="col-md-12">
			@include('manager.conductores.listado')
		</div>
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/eliminar.js') }}}"></script>
		
	<script src="{{{ asset('js/mng/conductores/modConductores.js') }}}"></script>
	<script src="{{{ asset('js/mng/conductores/lstConductores.js') }}}"></script>
@endsection