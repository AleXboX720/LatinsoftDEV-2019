@extends('admin.layout')

@section('title', $data['title'])

@section('content')
    <div class="alert" id="alert"></div>

	<div class="row">
		<div class="col-md-12">
			@include('manager.moviles.listado')
        </div>        
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	
	
	<script src="{{{ asset('js/mng/moviles/modMoviles.js') }}}"></script>
@endsection