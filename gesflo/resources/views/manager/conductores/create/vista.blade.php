@extends('admin.layout')

@section('title', $data['title'])

@section('content')
	<div class="alert" id="alert"></div>
	
	<div class="row">
		{!! Form::open(['route' => 'conductores.store', 'method' => 'POST', 'id' => 'frmAgregar']) !!}
			<div class="col-md-12">
				@include('manager.conductores.create.panelPrincipal')
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	
	<script src="{{{ asset('js/crear.js') }}}"></script>
@endsection