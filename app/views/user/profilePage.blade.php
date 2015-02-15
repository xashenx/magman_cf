@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="panel panel-info no-radius">
      <div class="panel-heading">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profilo Utente
      </div>
      <div class="panel-body">
        {{ Form::model($user, array('action' => 'UsersController@changePassword', 'id' => 'new-password', 'class' => 'form-horizontal')) }}
        <div class="form-group has-feedback">
          {{ Form::label('old_pass', 'Password attuale', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('old_pass', array('class' => 'form-control')) }}
            <div></div>
          </div>
          {{ Form::hidden('id') }}
        </div>
        <div class="form-group has-feedback">
          {{ Form::label('pass', 'Nuova Password', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('pass', array('class' => 'form-control')) }}
            <div></div>
          </div>
        </div>
        <div class="form-group has-feedback">
          {{ Form::label('pass_confirmation', 'Conferma Password', array('class' => 'col-md-2 label-padding')) }}
          <div class="col-md-10">
            {{ Form::password('pass_confirmation', array('class' => 'form-control')) }}
            <div></div>
          </div>
        </div>
        <div class="form-group">
          {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
        </div>
        {{ Form::close() }}
        <div class="cAlert" id="alert-1">
          <div class="alert alert-success success no-radius"></div>
          <div class="alert alert-danger error no-radius"></div>
        </div>
        @if($errors->first('old_pass') != null || $errors->first('pass') != null)
        <div id="alert-2">
          <div class="alert alert-danger no-radius">
            @if($errors->first('old_pass') != null)
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> {{{$errors->first('old_pass') }}}<br/>
            @endif
            @if($errors->first('pass') != null)
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong>{{{ $errors->first('pass') }}}<br/>
            @endif
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('../layouts/js-include')

<script>
  $(document).ready(function () {
    $('#new-password').on('submit', function () {
      $('#alert-1').hide();
      $('#alert-2').hide();
      $('#alert-1').find('.success').hide();
      $('#alert-1').find('.error').hide();
      $('#alert-1').find('.success').html("");
      $('#alert-1').find('.error').html("");

      //value
      var old_pass = $('#new-password').find('#old_pass').val();
      var pass = $('#new-password').find('#pass').val();
      var pass_confirmation = $('#new-password').find('#pass_confirmation').val();
      var error_icon ='<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>'
      var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>'
      //submit = true
      var submit = true;
      //start the check!

      //OLD_PASS
      var result = checkInputValue(old_pass, "pwd", 30, 6);
      if (result['status'] == 'ko') {
        $('#alert-1').show();
        $('#alert-1').find('.error').show();
        $('#new-password').find('#old_pass').closest('.form-group').removeClass('has-success');
        $('#new-password').find('#old_pass').closest('.form-group').addClass('has-error');
        $('#new-password').find('#old_pass ~ div').html(error_icon);

        var obj = {
          result: result,
          htmlElement: $('#alert-1').find('.error'),
          sex: "f",
          elementName: "password attuale",
          maxLength: 30,
          minLength: 6
        };
        showErrorMsg(obj);
        submit = false;
      } else {
        $('#new-password').find('#old_pass').closest('.form-group').removeClass('has-error');
        $('#new-password').find('#old_pass').closest('.form-group').addClass('has-success');
        $('#new-password').find('#old_pass ~ div').html(success_icon);
      }

      //PASSWORD
      var result = checkInputValue(pass, "pwd", 30, 6);
      if (result['status'] == 'ko') {
        $('#alert-1').show();
        $('#alert-1').find('.error').show();
        $('#new-password').find('#pass').closest('.form-group').removeClass('has-success');
        $('#new-password').find('#pass').closest('.form-group').addClass('has-error');
        $('#new-password').find('#pass ~ div').html(error_icon);

        var obj = {
          result: result,
          htmlElement: $('#alert-1').find('.error'),
          sex: "f",
          elementName: "password",
          maxLength: 30,
          minLength: 6
        };
        showErrorMsg(obj);
        submit = false;
      } else {
        $('#new-password').find('#pass').closest('.form-group').removeClass('has-error');
        $('#new-password').find('#pass').closest('.form-group').addClass('has-success');
        $('#new-password').find('#pass ~ div').html(success_icon);
      }

      //PASSWORD CONFIRMATION
      if (pass == pass_confirmation){
        var result = checkInputValue(pass_confirmation, "pwd", 30, 6);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-password').find('#pass_confirmation').closest('.form-group').removeClass('has-success');
          $('#new-password').find('#pass_confirmation').closest('.form-group').addClass('has-error');
          $('#new-password').find('#pass_confirmation ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "f",
            elementName: "conferma della password",
            maxLength: 30,
            minLength: 6
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-password').find('#pass_confirmation').closest('.form-group').removeClass('has-error');
          $('#new-password').find('#pass_confirmation').closest('.form-group').addClass('has-success');
          $('#new-password').find('#pass_confirmation ~ div').html(success_icon);
        }
      } else {
        $('#alert-1').show();
        $('#alert-1').find('.error').show();
        $('#new-password').find('#pass_confirmation').closest('.form-group').removeClass('has-success');
        $('#new-password').find('#pass_confirmation').closest('.form-group').addClass('has-error');
        $('#new-password').find('#pass_confirmation ~ div').html(error_icon);
        $('#alert-1').find('.error').append('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> <strong>Attenzione!</strong> La password di conferma inserita è differente dalla password.<br/>');
        submit = false;
      }

      if (submit){
        //chiamata ajax
      }
      return submit;
    })
  });
</script>
@stop
