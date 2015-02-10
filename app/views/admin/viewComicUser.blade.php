@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-danger no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Fumetto Ordinato
        </div>
        <div class="panel-body">
          <div class="row">
            <strong class="col-md-2 margin-bottom">Fumetto</strong>
            <div class="col-md-10 margin-bottom">
              {{$comic->comic->series->name}}
              {{{ ($comic->comic->series->version != null) ? ' - '.$comic->comic->series->version : '' }}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Numero</strong>
            <div class="col-md-10 margin-bottom">
              {{$comic->comic->number}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Casellante</strong>
            <div class="col-md-10 margin-bottom">
              {{$comic->box->name}} {{$comic->box->surname}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Ordinato il</strong>
            <div class="col-md-10 margin-bottom">
              {{date('d-m-Y',strtotime($comic->created_at))}}
            </div>
          </div>

          <hr>

          <div class="row" style="padding:15px">
            {{ Form::model($comic, array('action' => 'ComicUserController@update', 'class' => 'form-horizontal')) }}
            <div class="form-group">
              {{ Form::label('price', 'Prezzo', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::text('price', $comic->price, array('class' => 'form-control')) }}
              </div>
              {{ Form::hidden('cu_id',$comic->id) }}
              {{ Form::hidden('user_id',$comic->box->id) }}
            </div>
            <div class="form-group">
              {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
            </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('../layouts/js-include')
  @stop
          <!--TOMU APPROVED! -->