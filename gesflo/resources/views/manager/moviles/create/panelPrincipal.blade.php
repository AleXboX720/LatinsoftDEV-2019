<div class="panel">    
    <div class="panel-heading bg-green">
        <h1 class="panel-title">Formulario de Registro</h1>
    </div>

    <div class="panel-body">
        <!--	LOS TABs 	-->
        <div>
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#tabFrmPersona" aria-controls="tabFrmPersona" role="tab" data-toggle="tab">Datos Movil</a></li>
                <!--<li role="presentation" class=""><a href="#tabFrmUsuario" aria-controls="tabFrmUsuario" role="tab" data-toggle="tab">Datos del Equipo</a></li>-->
                <li role="presentation" class=""><a href="#tabAyuda" aria-controls="tabAyuda" role="tab" data-toggle="tab">Ayuda</a></li>
            </ul>
        </div>

        <!--	CONTENIDO de los TABs	-->
        <div class="tab-content">
        	<!-- PANEL 001 -->
            <div role="tabpanel" class="tab-pane fade active in" id="tabFrmPersona">
                @include('manager.moviles.create.frmDatosMovil')
            </div>
            <!-- PANEL 004 -->
            <div role="tabpanel" class="tab-pane fade" id="tabAyuda">
                @include('formularios.frmAyuda')
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <a href="#!" class="btn btn-block btn-success" id="btnAgregar">
            <span class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></span> Agregar
        </a>
    </div>
</div>