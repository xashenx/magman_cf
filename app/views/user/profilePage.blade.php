@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="panel panel-info no-radius">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profilo Utente
      </div>
      <div class="panel-body">
        {{ Form::model($user, array('action' => 'UsersController@changePassword', 'class' => 'form-horizontal')) }}
        <div class="form-group">
          {{ Form::label('old_pass', 'Password attuale', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('old_pass', array('class' => 'form-control')) }}
          </div>
          {{ Form::hidden('id') }}
        </div>
        <div class="form-group">
          {{ Form::label('pass', 'Nuova Password', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('pass', array('class' => 'form-control')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::label('pass_confirmation', 'Conferma Password', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('pass_confirmation', array('class' => 'form-control')) }}
          </div>
        </div>
        <div class="form-group">
          {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
        </div>
        {{ Form::close() }}
        <strong>{{ $errors->first('old_pass') }}</strong>
        <strong>{{ $errors->first('pass') }}</strong>
      </div>
    </div>
  </div>
</div>
@include('../layouts/js-include')
@stop
