@section('content')
  @if(count($errors)>0)
    <h3>Whoops! C'è stato un errore!!! <br/>
      Se il problema persiste, contattare un amministratore!</h3>
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-info no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Contatta lo Shop
        </div>
        <div class="panel-body">
          <h6>
            Tramite questo form potrai contattare il negoziante.<br/>
            Scrivi il tuo messaggio nel campo sottostante e il sistema
            lo invierà al proprietario che ti risponderà non appena possibile!
          </h6>
          {{ Form::open(array('action' => 'MailController@mailToShop', 'id' => 'mail-contact', 'class' => 'form-horizontal')) }}
          <div class="form-group has-feedback">
            <div class="col-md-12">
              {{ Form::textarea('message', $errors->first('message') ? $errors->first('message') : '' , array('id' => 'message','class' => 'form-control')) }}
              <div></div>
            </div>
          </div>
          <div class="form-group">
            {{ Form::submit('Invia mail', array('class' => 'btn btn-primary button-margin no-radius')) }}
          </div>
          {{ Form::close() }}
          <div class="cAlert" id="alert-1">
            <div class="alert alert-success success no-radius"></div>
            <div class="alert alert-danger error no-radius"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('../layouts/js-include')
  <script>
    $(document).ready(function () {
      $('#mail-contact').on('submit', function () {
        $('#alert-1').hide();
        $('#alert-1').find('.success').hide();
        $('#alert-1').find('.error').hide();
        $('#alert-1').find('.success').html("");
        $('#alert-1').find('.error').html("");

        //value
        var message = $('#mail-contact').find('#message').val();

        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!
        //message
        var result = checkInputValue(message, "message", 2000, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#mail-contact').find('#message').closest('.form-group').removeClass('has-success');
          $('#mail-contact').find('#message').closest('.form-group').addClass('has-error');
          $('#mail-contact').find('#message ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "m",
            elementName: "messaggio",
            maxLength: 2000,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#mail-contact').find('#message').closest('.form-group').removeClass('has-error');
          $('#mail-contact').find('#message').closest('.form-group').addClass('has-success');
          $('#mail-contact').find('#message ~ div').html(success_icon);
        }
        if (submit) {
          //chiamata ajax
        }
        return submit;
      });
    });
  </script>
  @stop
          <!--TOMU APPROVED! -->