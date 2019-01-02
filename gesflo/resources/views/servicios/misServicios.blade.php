@if($listado != false)
	@foreach($listado as $obj)
	<tr class="success" data-codi_servi="{{ $obj->codi_servi }}">
		<td class="info text-center hidden-sm hidden-xs"><b>X</b></td>
		<td class="info text-center"><b>{{ $obj->nume_movil }}</b></td>
		<td class="info text-center"><b>{{ $obj->pate_movil }}</b></td>
		<td class="text-nowrap hidden-sm hidden-xs">{{ $obj->conductor }}</td>
		<td class="text-center"><b>{{ $obj->inic_servi }}</b></td>
		<td class="text-center hidden-sm hidden-xs">{{ $obj->term_servi }}</td>
		<td class="text-center">{{ $obj->porcentaje }}%</td>
		<td class="text-center">
			<a href="#" class="btn btn-xs btn-success"><i class="fa fa-money fa-fw"></i></a>
			<a href="#" class="btn btn-xs btn-primary"><i class="fa fa-file-text fa-fw"></i></a>
			<a href="#" class="btn btn-xs btn-info"><i class="fa fa-map fa-fw"></i></a>
			<a href="#" class="btn btn-xs btn-danger"><i class="fa fa-trash fa-fw"></i></a>
		</td>
	</tr>
	@endforeach
@endif