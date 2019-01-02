@extends('admin.layout')

@section('content')
    <div class="alert" id="alert"></div>

	<div class="row">
		{!! Form::open(['route' => ['moviles.update', $data['movil']->nume_movil], 'method' => 'PUT', 'id' => 'frmEditar']) !!}
			<div class="col-md-12">
				@include('manager.moviles.edit.panelPrincipal')
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/jquery.min.js') }}}"></script>
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/editar.js') }}}"></script>
@endsection