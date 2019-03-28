<div class="panel panel-primary">    
    <div class="panel-heading">
        <h1 class="panel-title">Listado de GeoZonas</h1>
    </div>
    
    <div style="height:450px;overflow-y:scroll;"><!--ACTIVAMOS EL SCROLL EN DIV CONTENEDOR DE LA TABLA-->
        <table class="table table-responsive table-striped table-condensed table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Opcion</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Abreviacion</th>
                </tr>
            </thead>
            <tbody id="tablaListadoGeozonas">
            
            </tbody>
        </table>

        {!! Form::open(['route' => ['geozonas.show', ':CODI_GEOZO'], 'method' => 'GET', 'id' => 'frmVer']) !!}
        {!! Form::close() !!}
    </div>
</div>