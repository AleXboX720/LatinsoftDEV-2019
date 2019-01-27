<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Servicios Registrados</h3>
    </div>
    <div class="table-responsive" style="height:1200px;">
        <table class="table table-striped table-hover table-condensed" id="tblListadoServicios">
            <thead>
                <tr class="info">
                    <th class="text-center">Movil</th>
                    <th class="text-center">Patente</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Termino</th>
                    <th class="text-left">Conductor</th>
                    <th class="text-center hidden-sm hidden-xs">Opciones</th>
                </tr>
            </thead>
            <tbody id="listadoServicios">
                @foreach($data['listado'] as $obj)
                    @if( $obj->multado === 0)
                        <tr class="success" data-codi_servi="{{ $obj->codi_servi }}">
                    @else
                        <tr class="danger" data-codi_servi="'{{ $obj->codi_servi }}">
                    @endif
                            <td class="info text-center"><b style="font-size: 22px;">{{ $obj->nume_movil }}</b></td>
                            <td class="info text-center">{{ $obj->pate_movil }}</td>
                            <td class="text-center">
                                <b style="font-size: 22px;">{{ date('H:i', strtotime($obj->inic_servi)) }}</b>
                            </td>
                            <td class="info text-center">
                                {{ date('H:i', strtotime($obj->term_servi)) }}
                            </td>
                            <td class="info text-left">{{ $obj->conductor }}</td>
                            <td class="info text-center hidden-sm hidden-xs">
                                <a href="#" class="btn btn-xs btn-info btnDetalle" disabled data-toggle="modal" data-target="#modal_informe"><i class="fa fa-file-text fa-fw"></i></a>
                                <a href="#" class="btn btn-xs btn-warning" disabled><i class="fa fa-money fa-fw"></i></a>
                                <a href="#" class="btn btn-xs btn-danger" disabled><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                            </td>
                    <tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="panel-footer">
        
    </div>
</div>