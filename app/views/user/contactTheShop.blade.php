@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="panel panel-info no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Contatta lo Shop
      </div>
      <div class="panel-body">
        <h6>
          Tramite questo form potrai contattare il negoziante.<br />
          Scrivi il tuo messaggio nel campo sottostante e il sistema
          lo invierà al proprietario che ti risponderà non appena possibile!
        </h6>
        {{ Form::open(array('action' => 'MailController@mailToShop', 'class' => 'form-horizontal')) }}
          <div class="form-group">
            <div class="col-md-12">
              {{ Form::textarea('message', '', array('class' => 'form-control')) }}
            </div>
          </div>
          <div class="form-group">
            {{ Form::submit('Invia mail', array('class' => 'btn btn-primary button-margin no-radius')) }}
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@include('../layouts/js-include')

@stop
<!--TOMU APPROVED! -->