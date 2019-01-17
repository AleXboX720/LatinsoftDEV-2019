@extends('template/slave')
@section('titulo', 'Mi Informe Online')

@section('contenido')
<style>
	#divGMap{height:500px;}
</style>
<div class="row">
	<div class="panel panel-green">    
		<div class="panel-heading">
			<h1 class="panel-title">Informe de Servicio</h1>
		</div>

		<div class="panel-body">
			<!--	LOS TABs 	-->
			<div>
				<ul class="nav nav-pills nav-justified" role="tablist">
					<li role="presentation" class="active"><a href="#tabMiServicio" aria-controls="tabMiServicio" role="tab" data-toggle="tab">Mi Servicio</a></li>
					<li role="presentation"><a href="#tabTuServicio" aria-controls="tabTuServicio" role="tab" data-toggle="tab">Tu Servicio</a></li>
				
					<li role="presentation"><a href="#tabTrayecto" aria-controls="tabTrayecto" role="tab" data-toggle="tab">El Trayecto</a></li>
				</ul>
			</div>

			<!--	CONTENIDO de los TABs	-->
			<div class="tab-content">
				<!-- PANEL 001 -->
				<div role="tabpanel" class="tab-pane fade active in" id="tabMiServicio">
				@if(isset($misProgramadas))
				   @include('informes.miServicio.tablaMiServicio')
				@endif
				</div>

				<!-- PANEL 002 -->
				<div role="tabpanel" class="tab-pane fade" id="tabTuServicio">
				@if(isset($tusProgramadas))
				   @include('informes.miServicio.tablaTuServicio')
				@endif
				</div>
				
				
				<!-- PANEL 002 -->
				<div role="tabpanel" class="tab-pane fade" id="tabTrayecto">
					<div id="divGMap"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('listadoJS')
	<!--<script src="{{{ asset('js/jquery.js') }}}"></script>-->
	<script src="{{{ asset('js/miInforme/modInforme.js') }}}"></script>
	
	
	<script src="{{{ asset('js/gmaps/funMapas.js') }}}"></script>
	
	<!-- GMap -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?"></script>
    
@section('contenido')