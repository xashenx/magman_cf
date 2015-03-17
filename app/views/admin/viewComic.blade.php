@section('content')
  @if(count($errors)>0)
    <div class="alert alert-danger error no-radius">
      <h3>Whhops: E' avvenuto un errore!!<br/>
        Se il problema persiste contattare un amministratore</h3>
    </div>
  @endif
  @if($comic->active)
    {{--*/ $color_header = 'default' /*--}}
  @else
    {{--*/ $color_header = 'danger' /*--}}
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-{{ $color_header }} no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Gestione Fumetto
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle little-icon little-icon-padding no-radius" aria-expanded="false"><span class="caret"></span></button>
            <ul class="dropdown-menu no-radius">
              @if($comic->active)
                <li><a href="#"             @if($path == '../')
                    onclick="showConfirmModal({{$comic->id}},0,0)"
                    @else
                    onclick="showConfirmModal({{$comic->id}},{{$comic->series->id}},0)"
                    @endif
                    >
                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                  Disattiva Fumetto</a></li>
              @else
                <li><a href="#"
                  @if($path == '../')
                    onclick="showConfirmModal({{$comic->id}},0,1)"
                  @else
                    onclick="showConfirmModal({{$comic->id}},{{$comic->series->id}},1)"
                  @endif
                  >
                  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                  Riattiva Fumetto</a></li>
              @endif
            </ul>
          </div>
        </div>
        <div class="panel-body">
          <ul class="nav nav-tabs margin-bottom">
            <li class="active">
              <a href="#details" data-toggle="tab">
                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                <span class="titoli-tab">Dettagli</span>
              </a>
            </li>
            @if($comic->series->active == 1)
              @if(count($ordered)>0)
                <li class="">
                  <a href="#ordered" data-toggle="tab">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    <span class="titoli-tab">Prenotazioni</span>
                  </a>
                </li>
              @endif
              <li class="">
                <a href="#edit" data-toggle="tab">
                  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                  <span class="titoli-tab">Modifica</span>
                </a>
              </li>
            @endif
          </ul>

          <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
              <div class="row">
                <strong class="col-md-1 margin-bottom">Serie</strong>

                <div class="col-md-11 margin-bottom">
                  {{$comic->series->name}}
                </div>
              </div>

              <div class="row">
                <strong class="col-md-1 margin-bottom">Versione</strong>

                <div class="col-md-11 margin-bottom">
                  {{$comic->series->version}}
                </div>
              </div>

              <div class="row">
                <strong class="col-md-1 margin-bottom">Autore</strong>

                <div class="col-md-11 margin-bottom">
                  {{$comic->series->author}}
                </div>
              </div>

              <div class="row">
                <strong class="col-md-1 margin-bottom">Numero</strong>

                <div class="col-md-11 margin-bottom">
                  {{$comic->number}}
                </div>
              </div>

              <div class="row">
                <strong class="col-md-1 margin-bottom">Nome</strong>

                <div class="col-md-11 margin-bottom">
                  {{$comic->name}}
                </div>
              </div>
              @if($inv_state == 1)
                <div class="row">
                  <strong class="col-md-1 margin-bottom">Disponibilità</strong>

                  <div class="col-md-11 margin-bottom">
                    {{$comic->available}}
                  </div>
                </div>
              @endif
              <div class="row">
                <strong class="col-md-1 margin-bottom">Prezzo</strong>

                <div class="col-md-11 margin-bottom">
                  {{number_format((float)$comic->price, 2, '.', '')}} €
                </div>
              </div>
              @if($comic->image)
                <div class="row">
                  <strong class="col-md-1 margin-bottom">Cover</strong>

                  <div class="col-md-11 margin-bottom">
                    <a href="{{$comic->image}}" target="_blank"><img src="{{$comic->image}}" alt=""
                                                                     class="cover"></a>
                  </div>
                </div>
              @endif

            </div>
            @if($comic->series->active == 1)
              @if(count($ordered)>0)
                <div class="tab-pane fade" id="ordered">
                  <div>
                    <div class="tab-content">
                      <div>
                        <table class="table table-striped table-bordered table-hover"
                               id="dataTables-example">
                          <thead>
                          <tr>
                            <th>Casellante</th>
                            <th>Prezzo</th>
                            <th>Data prenotazione</th>
                          </tr>
                          </thead>
                          <tbody>
                          @foreach ($ordered as $order)
                            <tr class="odd gradeX">
                              <td>
                                <a href="{{ $path }}boxes/{{ $order->box->id }}">{{ $order->box->name }} {{ $order->box->surname }}</a>
                              </td>
                              <td>{{number_format((float)$order->price, 2, '.', '')}} €</td>
                              <td>{{ date('d/m/Y',strtotime($order->created_at)) }}</td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              <div class="tab-pane fade" id="edit">
                <div>
                  {{ Form::model($comic, array('action' => 'ComicsController@update', 'id' => 'edit-comic', 'class' => 'form-horizontal')) }}
                  <div class="form-group has-feedback">
                    {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                    <div class="col-md-10">
                      {{ Form::text('name', $comic->name, array('class' => 'form-control', 'placeholder' => 'Nome del fumetto *')) }}
                      <div></div>
                    </div>
                    {{ Form::hidden('id') }}
                    {{ Form::hidden('series_id') }}
                    @if($path == "../")
                      {{ Form::hidden('return','comics') }}
                    @elseif($path == "../../")
                      {{ Form::hidden('return','series') }}
                    @endif
                  </div>
                  <div class="form-group has-feedback">
                    {{ Form::label('number', 'Numero', array('class' => 'col-md-2 label-padding')) }}
                    <div class="col-md-10">
                      {{ Form::text('number', $comic->number, array('class' => 'form-control', 'placeholder' => 'Numero del fumetto')) }}
                      <div></div>
                    </div>
                  </div>
                  @if($inv_state == 1)
                    <div class="form-group has-feedback">
                      {{ Form::label('available', 'Disponibilità', array('class' => 'col-md-2 label-padding')) }}
                      <div class="col-md-10">
                        {{ Form::text('available', $comic->available, array('class' => 'form-control', 'placeholder' => 'Disponibilità del fumetto')) }}
                        <div></div>
                      </div>
                    </div>
                  @endif
                  <div class="form-group has-feedback">
                    {{ Form::label('image', 'Link Immagine', array('class' => 'col-md-2 label-padding')) }}
                    <div class="col-md-10">
                      {{ Form::text('image', $comic->image, array('class' => 'form-control', 'placeholder' => 'Link all\'immagine *')) }}
                      <div></div>
                    </div>
                  </div>
                  <div class="form-group">
                    {{ Form::label('price', 'Prezzo', array('class' => 'col-md-2 label-padding')) }}
                    <div class="col-md-10">
                      <div class="input-group">
                        <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                        {{ Form::text('price', $comic->price, array('class' => 'form-control', 'placeholder' => 'Prezzo del fumetto')) }}
                        <div></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
                  </div>
                  {{ Form::close() }}
                  <div class="cAlert" id="alert-1">
                    <div class="alert alert-success success no-radius"></div>
                    <div class="alert alert-info necessary no-radius">
                      I campi con
                      <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                      sono opzionali.
                    </div>
                    <div class="alert alert-danger error no-radius"></div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
          <h3 class="modal-title">Conferma azione</h3>
        </div>
        <div class="modal-body">
          <p id="confirmPageName" class="text-danger"></p>
        </div>
        <div class="modal-footer">
          {{ Form::open(array('name' => 'confirmForm')) }}
          {{ Form::hidden('id') }}
          {{ Form::hidden('return') }}
          {{ Form::button('Annulla', array(
          'data-dismiss' => 'modal',
          'class' => 'btn btn-danger btn-sm')) }}
          {{ Form::submit('Confermo', array('class' => 'btn btn-danger btn-sm',)) }}
          {{ Form::close() }}
        </div>
      </div>
      {{-- /.modal-content --}}
    </div>
    {{-- /.modal-dialog --}}
  </div>
  {{-- /.modal --}}
  @include('../layouts/js-include')
  <script>
    function showConfirmModal(object_id, series, mode) {
      if (series != 0)
        document.confirmForm.return.value = "series/" + series + "/" + object_id;
      else
        document.confirmForm.return.value = "comics/" + object_id;
      if (mode == 0) {
        // delete comic
        if (series != 0)
          document.confirmForm.action = '../../deleteComic';
        else
          document.confirmForm.action = '../deleteComic';
        document.confirmForm.id.value = object_id;
        $('#confirmPageName').text('Sei sicuro di volere disattivare questo fumetto?');
      } else if (mode == 1) {
        // restore comic
        if (series != 0)
          document.confirmForm.action = '../../restoreComic';
        else
          document.confirmForm.action = '../restoreComic';
        document.confirmForm.id.value = object_id;
        $('#confirmPageName').text('Sei sicuro di volere attivare nuovamente questo fumetto?');
      }
      $('#modal-confirm').modal({
        show: true
      });
    }
  </script>
  <script>
    $(document).ready(function () {

        $('#edit-comic').on('submit', function () {
            $('#alert-1').hide();
            $('#alert-1').find('.success').hide();
            $('#alert-1').find('.error').hide();
            $('#alert-1').find('.necessary').hide();
            $('#alert-1').find('.success').html("");
            $('#alert-1').find('.error').html("");

            //value
            var name = $('#edit-comic').find('#name').val();
            var number = $('#edit-comic').find('#number').val();
            var image = $('#edit-comic').find('#image').val();
            var price = $('#edit-comic').find('#price').val();

            var error_icon ='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
            var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
            var error_icon_select ='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
            var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

            var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
            //submit = true
            var submit = true;
            //start the check!
            //name
            if (name.length != 0){
              var result = checkInputValue(name, "message", 128, -1);
              if (result['status'] == 'ko') {
                $('#alert-1').show();
                $('#alert-1').find('.error').show();
                $('#edit-comic').find('#name').closest('.form-group').removeClass('has-success');
                $('#edit-comic').find('#name').closest('.form-group').removeClass('not-necessary');
                $('#edit-comic').find('#name').closest('.form-group').addClass('has-error');
                $('#edit-comic').find('#name ~ div').html(error_icon);

                var obj = {
                  result: result,
                  htmlElement: $('#alert-1').find('.error'),
                  sex: "m",
                  elementName: "nome",
                  maxLength: 128,
                  minLength: -1
                };
                showErrorMsg(obj);
                submit = false;
              } else {
                $('#edit-comic').find('#name').closest('.form-group').removeClass('not-necessary');
                $('#edit-comic').find('#name').closest('.form-group').removeClass('has-error');
                $('#edit-comic').find('#name').closest('.form-group').addClass('has-success');
                $('#edit-comic').find('#name ~ div').html(success_icon);
              }
            } else {
              $('#alert-1').find('.necessary').show();
              $('#edit-comic').find('#name').closest('.form-group').removeClass('has-error');
              $('#edit-comic').find('#name').closest('.form-group').addClass('not-necessary');
              $('#edit-comic').find('#name ~ div').html(notnecessary_icon);
            }

            //number
            var result = checkInputValue(number, "integer", 11, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#edit-comic').find('#number').closest('.form-group').removeClass('has-success');
              $('#edit-comic').find('#number').closest('.form-group').addClass('has-error');
              $('#edit-comic').find('#number ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "numero",
                maxLength: 11,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#edit-comic').find('#number').closest('.form-group').removeClass('has-error');
              $('#edit-comic').find('#number').closest('.form-group').addClass('has-success');
              $('#edit-comic').find('#number ~ div').html(success_icon);
            }

            //image
            if (image.length != 0){
              var result = checkInputValue(image, "url", 128, -1);
              if (result['status'] == 'ko') {
                $('#alert-1').show();
                $('#alert-1').find('.error').show();
                $('#edit-comic').find('#image').closest('.form-group').removeClass('not-necessary');
                $('#edit-comic').find('#image').closest('.form-group').removeClass('has-success');
                $('#edit-comic').find('#image').closest('.form-group').addClass('has-error');
                $('#edit-comic').find('#image ~ div').html(error_icon);

                var obj = {
                  result: result,
                  htmlElement: $('#alert-1').find('.error'),
                  sex: "m",
                  elementName: "link all'immagine",
                  maxLength: 128,
                  minLength: -1
                };
                showErrorMsg(obj);
                submit = false;
              } else {
                $('#edit-comic').find('#image').closest('.form-group').removeClass('not-necessary');
                $('#edit-comic').find('#image').closest('.form-group').removeClass('has-error');
                $('#edit-comic').find('#image').closest('.form-group').addClass('has-success');
                $('#edit-comic').find('#image ~ div').html(success_icon);
              }
            } else {
              $('#alert-1').find('.necessary').show();
              $('#edit-comic').find('#image').closest('.form-group').removeClass('has-error');
              $('#edit-comic').find('#image').closest('.form-group').addClass('not-necessary');
              $('#edit-comic').find('#image ~ div').html(notnecessary_icon);
            }

            //price
            var result = checkInputValue(price, "number", 128, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#edit-comic').find('#price').closest('.form-group').removeClass('has-success');
              $('#edit-comic').find('#price').closest('.form-group').addClass('has-error');
              $('#edit-comic').find('#price ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "prezzo",
                maxLength: 128,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#edit-comic').find('#price').closest('.form-group').removeClass('has-error');
              $('#edit-comic').find('#price').closest('.form-group').addClass('has-success');
              $('#edit-comic').find('#price ~ div').html(success_icon);
            }
            if (submit){
              //chiamata ajax
            }
            return submit;
        });

    });
  </script>
@stop