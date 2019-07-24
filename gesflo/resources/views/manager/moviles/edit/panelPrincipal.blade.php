<div class="panel">
    <div class="panel-heading bg-green">
        <h1 class="panel-title">Formulario de Edicion</h1>
    </div>
    <div class="panel-body">
        <div>
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#tabDatosMovil" aria-controls="tabDatosMovil" role="tab" data-toggle="tab">Datos Moviles</a></li>
                <li role="presentation" class=""><a href="#tabDatosEquipo" aria-controls="tabDatosEquipo" role="tab" data-toggle="tab">Datos del Equipo</a></li>
                <li role="presentation"><a href="#tabAyuda" aria-controls="tabAyuda" role="tab" data-toggle="tab">Ayuda</a></li>
            </ul>
        </div>
        <!--    CONTENIDO de los TABs   -->
        <div class="tab-content">
            <!-- PANEL 001 -->
            <div role="tabpanel" class="tab-pane fade active in" id="tabDatosMovil">                
                @include('manager.moviles.edit.frmDatosMovil')
            </div>
            <!-- PANEL 002 -->
            <div role="tabpanel" class="tab-pane fade" id="tabAyuda">
                @include('formularios.frmAyuda') 
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <a href="#!" class="btn btn-success btn-block" id="btnEditar">
            <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Guardar
        </a>
    </div>
</div>