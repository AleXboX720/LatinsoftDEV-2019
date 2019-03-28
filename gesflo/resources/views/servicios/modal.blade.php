<div class="modal fade modal-primary" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal_salidas">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header  modal-header-primary">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Datos del Servicio</h4>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
				    <div class="form-group">
				        <div class="hidden-sm hidden-xs col-md-3">
				            {{ Form::label('nume_movil', 'Movil', ['class' => 'hidden-sm hidden-xs control-label']) }}
				        </div>
				        <div class="col-md-9">
				            {{ Form::number('nume_movil', null, ['class' => 'form-control text-uppercase', 'id' => 'nume_movil', 'maxlength' => '3', 'required' => 'required', 'placeholder' => 'Numero']) }}
				            {{ Form::text('codi_movil', null, ['class' => 'form-control text-uppercase', 'id' => 'codi_movil', 'placeholder' => 'Codigo', 'readonly']) }}
				            {{ Form::text('pate_movil', null, ['class' => 'form-control text-uppercase', 'id' => 'pate_movil', 'placeholder' => 'Patente', 'readonly']) }}
				        </div>
				    </div>

				    <div class="form-group">
				        <div class="hidden-sm hidden-xs col-md-3">
				            {{ Form::label('docu_perso', 'Coductor', ['class' => 'hidden-sm hidden-xs control-label']) }}
				        </div>
				        <div class="col-md-9">
				            {{ Form::number('docu_perso', null, ['class' => 'form-control text-uppercase', 'id' => 'docu_perso', 'maxlength' => '8', 'required' => 'required', 'placeholder' => 'Codigo']) }}
				            {{ Form::text('nomb_condu', null, ['class' => 'form-control text-uppercase', 'id' => 'nomb_condu', 'placeholder' => 'Conductor', 'readonly']) }}
				        </div>
				    </div>


				    <div class="form-group">
				        <div class="hidden-sm hidden-xs col-md-3">
				            {{ Form::label('hora_servi', 'Inicio', ['class' => 'hidden-sm hidden-xs control-label']) }}
				        </div>
				        <div class="col-md-9">
				            {{ Form::time('hora_servi', '00:00', ['class' => 'form-control text-uppercase', 'id' => 'hora_servi']) }}
				        </div>
				    </div>
				</div>
			</div>
			<div class="modal-footer">		
				<button type="button" class="btn btn-lg btn-success btn-block" id="btnGuardar">
					<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"> Guardar</span>
				</button>
			</div>
		</div>
	</div>
</div>