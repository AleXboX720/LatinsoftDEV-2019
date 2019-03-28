@extends('admin.layout')

@section('title', $data['title'])

@section('content')
    <div class="row">
    	<div class="col-md-12">
    		@include('recaudaciones.panelPrincipal')
		</div>
    </div>	
@endsection

@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>
	<script src="{{{ asset('js/recaudaciones/modRecaudaciones.js') }}}"></script>
	<script src="{{{ asset('js/recaudaciones/dataMultas.js') }}}"></script>
	<script src="{{{ asset('js/recaudaciones/dataCuotas.js') }}}"></script>
	<script src="{{{ asset('js/recaudaciones/dataRecaudaciones.js') }}}"></script>
	
	
	<script src="{{{ asset('js/charts/highcharts.js') }}}"></script>
	<script src="{{{ asset('js/charts/highcharts-3d.js') }}}"></script>
	<script src="{{{ asset('js/charts/confiGraficos.js') }}}"></script>
@endsection