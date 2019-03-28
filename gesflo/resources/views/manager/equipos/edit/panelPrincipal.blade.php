<div class="panel panel-primary">    
    <div class="panel-heading">
        <h1 class="panel-title">Formulario de Registro</h1>
    </div>

    <div class="panel-body">
        <!--	LOS TABs 	-->
        <div>
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li role="presentation" class="active"><a href="#tabFrmPersona" aria-controls="tabFrmPersona" role="tab" data-toggle="tab">Datos Equipo</a></li>
                <li role="presentation"><a href="#tabFrmContacto" aria-controls="tabFrmContacto" role="tab" data-toggle="tab">Datos Empresa</a></li>
                <li role="presentation"><a href="#tabAyuda" aria-controls="tabAyuda" role="tab" data-toggle="tab">Ayuda</a></li>
            </ul>
        </div>

        <!--	CONTENIDO de los TABs	-->
        <div class="tab-content">
        	<!-- PANEL 001 -->
            <div role="tabpanel" class="tab-pane fade active in" id="tabFrmPersona">
                @include('administrador.equipos.edit.frmEquipo')
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