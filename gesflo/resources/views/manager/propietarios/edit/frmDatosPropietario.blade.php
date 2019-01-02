<div style="height:250px;overflow-y:scroll;"><!--ACTIVAMOS EL SCROLL EN DIV CONTENEDOR DE LA TABLA-->
	<table class="table table-responsive table-striped table-condensed table-hover table-bordered">
	    <thead>
	        <tr class="info">
	            <th class="text-center">Movil</th>
	            <th class="text-center">PPT</th>
	            <th class="text-center">Rev. Tecnica</th>
	            <th class="text-center">Año</th>
	        </tr>
	    </thead>
	    <tbody id="tablaListadoFlota">
			@foreach($data['objMoviles'] as $obj)
			<tr class="">
				<td class="text-center info">{{ $obj->nume_movil }}</td>
				<td class="text-center"><b>{{ $obj->pate_movil }}</b></td>
				<td class="text-center">{{ $obj->fech_revis }}</td>
				<td class="text-center">{{ $obj->anio_movil }}</td>
			<tr class="info">
			@endforeach
		</tbody>
	</tr>
	</table>
</div>