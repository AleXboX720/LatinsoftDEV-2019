@extends('admin.layout')

@section('title', $data['title'])

@section('content')
    <div class="alert" id="alert"></div>
    
	<div class="row">
		{!! Form::open(['route' => ['conductores.actualizar'], 'method' => 'POST', 'id' => 'frmEditar']) !!}
			<div class="col-md-12">
				@include('manager.conductores.edit.panelPrincipal')
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/editar.js') }}}"></script>
@endsection