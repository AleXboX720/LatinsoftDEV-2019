@extends('admin.layout')

@section('content')
    <div class="alert" id="alert"></div>
    
	<div class="row">
		{!! Form::open(['route' => ['conductores.update', $data['equipo'][0]->imeiNumber], 'method' => 'PUT', 'id' => 'frmEditar']) !!}
			<div class="col-md-12">
				@include('administrador.equipos.edit.panelPrincipal')
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/jquery.min.js') }}}"></script>
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/editar.js') }}}"></script>
@endsection