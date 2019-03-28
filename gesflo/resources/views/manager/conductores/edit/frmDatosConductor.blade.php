<div class="panel panel-default">
    <div class="panel-body form-panel">
    
        <div class="form-horizontal">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

                <div class="form-group">
                    {{ Form::label('codi_licen', 'Codigo', ['class' => 'col-md-2 col-lg-2 hidden-sm hidden-xs control-label']) }}
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        {{ Form::text('codi_licen', $obj->codi_licen, ['class' => 'form-control text-uppercase', 'id' => 'codi_licen', 'maxlength' => '8', 'placeholder' => 'COD LICENCIA']) }}
                        <em id="helpBlock" class="help-block hidden-sm hidden-xs"><small>(Este Codigo Corresponde al N° de Licencia)</small></em>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('lice_condu', 'T. Licencia', ['class' => 'col-md-2 col-lg-2 hidden-sm hidden-xs control-label']) }}
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="btn-group btn-group-justified btn-group-md" data-toggle="buttons">
                            <label class="btn btn-default @if($obj->A1){{ 'active' }} @endif">A1
                                {{ Form::checkbox('A1', 1, $obj->A1) }}                                
                            </label>
                            <label class="btn btn-default @if($obj->A2){{ 'active' }} @endif">
                                {{ Form::checkbox('A2', 1, $obj->A2) }}
                                A2
                            </label>
                            <label class="btn btn-default @if($obj->A3){{ 'active' }} @endif">
                            {{ Form::checkbox('A3', 1, $obj->A3) }}
                            A3
                            </label>
                            <label class="btn btn-default @if($obj->A4){{ 'active' }} @endif">
                                {{ Form::checkbox('A4', 1, $obj->A4) }}
                                A4
                            </label>
                            <label class="btn btn-default @if($obj->A5){{ 'active' }} @endif">
                                {{ Form::checkbox('A5', 1, $obj->A5) }}
                                A5
                            </label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-2 col-lg-offset-2">
                        <div class="btn-group btn-group-justified btn-group-md" data-toggle="buttons">
                            <label class="btn btn-default @if($obj->B){{ 'active' }} @endif">
                                {{ Form::checkbox('B', 1, $obj->B) }}
                                B
                            </label>
                            <label class="btn btn-default @if($obj->C){{ 'active' }} @endif">
                                {{ Form::checkbox('C', 1, $obj->C) }}
                                C              </label>
                            <label class="btn btn-default @if($obj->D){{ 'active' }} @endif">
                                {{ Form::checkbox('D', 1, $obj->D) }}
                                D
                            </label>
                            <label class="btn btn-default @if($obj->E){{ 'active' }} @endif">
                                {{ Form::checkbox('E', 1, $obj->E) }}
                                E
                            </label>
                            <label class="btn btn-default @if($obj->F){{ 'active' }} @endif">
                                {{ Form::checkbox('F', 1, $obj->F) }}
                                F
                            </label>
                        </div>
                        <em class="help-block hidden-sm hidden-xs" id="helpBlock"><small>(Seleccionar Todas las Clases Obtenidas)</small></em>
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('fech_venci', 'F. Venci', ['class' => 'col-md-2 col-lg-2 hidden-sm hidden-xs control-label']) }}
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        {{ Form::date('fech_venci', $obj->fech_venci, ['class' => 'form-control text-uppercase', 'id' => 'fech_venci']) }}
                        <em class="help-block hidden-sm hidden-xs" id="helpBlock"><small>(Fecha de Vencimiento)</small></em>
                    </div>
                </div>
                
                <div class="form-group">
                    {{ Form::label('habilitado', 'Estado', ['class' => 'col-md-2 col-lg-2 hidden-sm hidden-xs control-label']) }}
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div id="losEstados" class="btn-group btn-group-justified" data-toggle="buttons">
                            <label class="btn btn-default @if($data['objConductor'][0]->habilitado){{ 'active' }} @endif">
                                {{ Form::radio('habilitado', 1, $data['objConductor'][0]->habilitado, ['name' => 'habilitado', 'id' => 'esHabilitado']) }}
                                <b class="hidden-sm hidden-xs">Habilitado</b>
                                <b class="hidden-md hidden-lg">H</b>
                            </label>
                            <label class="btn btn-default @if(!$data['objConductor'][0]->habilitado){{ 'active' }} @endif">
                                {{ Form::radio('habilitado', 0, !$data['objConductor'][0]->habilitado, ['name' => 'habilitado', 'id' => 'esDeshabilitado']) }}
                                <b class="hidden-sm hidden-xs">Deshabilitado</b>
                                <b class="hidden-md hidden-lg">D</b>
                            </label>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
</div>