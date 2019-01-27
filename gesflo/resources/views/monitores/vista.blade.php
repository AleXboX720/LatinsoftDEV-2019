@extends('admin.app')

@section('content')
	<div class="row">
		
<div class="col-md-12">
		<div class="texto" id="texto" style="font-family=arial;color=#05c8bb !important;display:block;font-size:12em;text-align:center;font-weight:bold;">
		</div>
</div>	
        <div class="col-md-12">
	    	<h3 class="page-header">{{ $data['title'] }} <small>(Circuito : {{ $data['codi_circu']}})</small></h3>
		</div>

		<div class="col-md-12">
			@include('monitores.listado')
		</div>
		
		
	</div>
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>

	<script src="{{{ asset('js/monitores/funServicios.js') }}}"></script>
	<script src="{{{ asset('js/monitores/funReloj.js') }}}"></script>
@endsection