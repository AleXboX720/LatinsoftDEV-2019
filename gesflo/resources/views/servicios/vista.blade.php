@extends('admin.layout')

@section('content')
	@include('servicios.modalForm')
	@include('servicios.modalProcesar')

	@include('servicios.modalMulta')
	@include('servicios.modalInfor')
	@include('servicios.modalMapa')
	<div class="alert" id="alert"></div>
	
    <div class="row">
    	<div class="col-md-12">
    		@include('servicios.formulario')
    	</div>
    </div>
    
	<div class="row">
		<div class="col-md-12">
			@include('servicios.listado')
		</div>
		
	</div>
@endsection


@section('listadoJS')
	<script src="{{{ asset('js/general.js') }}}"></script>

	<script src="{{{ asset('js/servicios/modServicios.js') }}}"></script>
	
	<script src="{{{ asset('js/servicios/funMoviles.js') }}}"></script>
	<script src="{{{ asset('js/servicios/funConductores.js') }}}"></script>
	<script src="{{{ asset('js/servicios/funServicio.js') }}}"></script>

	<script src="{{{ asset('js/servicios/funMultas.js') }}}"></script>
	<script src="{{{ asset('js/servicios/funInformeServicio.js') }}}"></script>
	<script src="{{{ asset('js/servicios/funTrayectoServicio.js') }}}"></script>
	
	<script src="{{{ asset('js/servicios/funAgregar.js') }}}"></script>
	<script src="{{{ asset('js/servicios/funProcesar.js') }}}"></script>

	<script src="{{{ asset('js/servicios/lstServicios.js') }}}"></script>
	<script src="{{{ asset('js/servicios/lstPuntosControl.js') }}}"></script>





	<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCpcjpET_egxZ-KiFlQwio0x7HLFjcphgc"></script>
	
	<script src="{{{ asset('js/gmaps/funMapas.js') }}}"></script>
	<script src="{{{ asset('js/gmaps/funMarkers.js') }}}"></script>


	<script src="{{{ asset('js/gmaps/funModalMapa.js') }}}"></script>
	<script src="{{{ asset('js/gmaps/mapaLathinSoft.js') }}}"></script>
	<script src="{{{ asset('js/gmaps/funGeozonas.js') }}}"></script>
@endsection