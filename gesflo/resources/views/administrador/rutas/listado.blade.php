<div class="panel panel-primary">    
    <div class="panel-heading">
        <h1 class="panel-title">Listado de GeoZonas</h1>
    </div>
    
    <div style="height:450px;overflow-y:scroll;"><!--ACTIVAMOS EL SCROLL EN DIV CONTENEDOR DE LA TABLA-->
        <table class="table table-responsive table-striped table-condensed table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Sentido</th>
                    <th class="text-center">Circuito</th>
                    <th class="text-center">Abreviacion</th>
                    <th class="text-center">Opcion</th>
                </tr>
            </thead>
            <tbody id="tablaListadoRutas">
            
            </tbody>
        </table>

        {!! Form::open(['route' => ['rutas.show', ':CODI_RUTA'], 'method' => 'GET', 'id' => 'frmVer']) !!}
        {!! Form::close() !!}
    </div>
</div>