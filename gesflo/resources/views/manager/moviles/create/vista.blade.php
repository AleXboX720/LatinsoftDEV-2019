@extends('admin.layout')

@section('content')
	<div class="row">
		{!! Form::open(['route' => 'moviles.store', 'method' => 'POST', 'id' => 'frmAgregar']) !!}
			<div class="col-md-12">
				@include('manager.moviles.create.panelPrincipal')
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/jquery.js') }}}"></script>
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/crear.js') }}}"></script>
@endsection