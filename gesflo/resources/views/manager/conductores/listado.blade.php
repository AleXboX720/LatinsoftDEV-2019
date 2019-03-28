<div class="panel">    
    <div class="panel-heading bg-blue">
        <h1 class="panel-title">Listado de Conductores</h1>
    </div>
    
    <div style="height:450px;overflow-y:scroll;"><!--ACTIVAMOS EL SCROLL EN DIV CONTENEDOR DE LA TABLA-->
        <table class="table table-responsive table-striped table-condensed table-hover table-bordered">
            <thead>
                <tr class="info">
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Opcion</th>
                    <th class="text-center">Nombres</th>
                    <th class="text-center">Apellidos</th>
                    <th class="text-center">Domicilio</th>
                    <th class="text-center">Telefono</th>
                    <th class="text-center">Movil</th>
                    <th class="text-center">E-Mail</th>
                </tr>
            </thead>
            <tbody id="tablaListadoPersonas">
               
            </tbody>
        </table>
        
        {!! Form::open(['route' => ['conductores.destroy', ':IDDE_OBJET'], 'method' => 'DELETE', 'id' => 'frmEliminar']) !!}
        {!! Form::close() !!}
    </div>
</div>