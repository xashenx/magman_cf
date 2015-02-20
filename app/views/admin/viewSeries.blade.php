@section('content')
  @if(count($errors)>0)
    <h3>Whhops: E' avvenuto un errore!!<br/>
      Se il problema persiste contattare un amministratore</h3>
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Serie: {{$series->name}}
          @if($series->active)
            <button type="button" title="Disattiva serie"
                    onclick="showConfirmModal({{$series->id}},0,0)"
                    class="btn btn-danger btn-xs no-radius little-icon">
              <i class="fa fa-remove"></i>
            </button>
          @else
            <button type="button" title="Riattiva serie"
                    onclick="showConfirmModal({{$series->id}},0,1)"
                    class="btn btn-success btn-xs no-radius little-icon">
              <i class="fa fa-smile-o"></i>
            </button>
            <button type="button" title="Riattiva serie con fumetti"
                    onclick="showConfirmModal({{$series->id}},1,1)"
                    class="btn btn-warning btn-xs little-icon">
              <i class="fa fa-book"></i>
            </button>
          @endif
        </div>
        <div class="panel-body">
          <ul class="nav nav-tabs margin-bottom">
            <li class="active">
              <a href="#details" data-toggle="tab">
                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                <span class="titoli-tab">Dettagli</span>
              </a>
            </li>
            @if(count($series->inBoxes)>0)
              <li class="">
                <a href="#boxes" data-toggle="tab">
                  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                  <span class="titoli-tab">Casellanti</span>
                </a>
              </li>
            @endif
            @if(count($series->listComics)>0)
              <li class="">
                <a href="#numbers" data-toggle="tab">
                  <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                  <span class="titoli-tab">Numeri</span>
                </a>
              </li>
            @endif
            <li class="">
              <a href="#newnumber" data-toggle="tab">
                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                <span class="titoli-tab">Nuovo Numero</span>
              </a>
            </li>
            <li class="">
              <a href="#edit" data-toggle="tab">
                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                <span class="titoli-tab">Modifica</span>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
              <div>
                <div class="row">
                  <strong class="col-md-1 margin-bottom">Nome</strong>

                  <div class="col-md-11 margin-bottom">
                    {{$series->name}}
                  </div>
                </div>

                <div class="row">
                  <strong class="col-md-1 margin-bottom">Versione</strong>

                  <div class="col-md-11 margin-bottom">
                    {{$series->version}}
                  </div>
                </div>

                <div class="row">
                  <strong class="col-md-1 margin-bottom">Autore</strong>

                  <div class="col-md-11 margin-bottom">
                    {{$series->author}}
                  </div>
                </div>

                <div class="row">
                  <strong class="col-md-1 margin-bottom">Editore</strong>

                  <div class="col-md-11 margin-bottom">
                    {{$series->publisher}}
                  </div>
                </div>
                @if($series->active)
                  @if($series->listComics->max('number') != null)
                    {{--*/ $fumetti = $series->listActive->max('number') /*--}}
                  @else
                    {{--*/ $fumetti = 0 /*--}}
                  @endif
                  <div class="row">
                    <strong class="col-md-1 margin-bottom">Fumetti</strong>

                    <div class="col-md-11 margin-bottom">
                      {{$fumetti}}
                    </div>
                  </div>

                  @if($series->conclusa)
                    {{--*/ $stato = 'Conclusa' /*--}}
                  @else
                    {{--*/ $stato = 'Attiva' /*--}}
                  @endif
                  <div class="row">
                    <strong class="col-md-1 margin-bottom">Stato</strong>

                    <div class="col-md-11 margin-bottom">
                      {{$stato}}
                    </div>
                  </div>

                  <div class="row">
                    <strong class="col-md-1 margin-bottom">Caselle</strong>

                    <div class="col-md-11 margin-bottom">
                      {{count($series->inBoxes)}}
                    </div>
                  </div>
                @endif
              </div>
            </div>
            @if(count($series->inBoxes)>0)
              <div class="tab-pane fade" id="boxes">
                <div>
                  <div class="panel-body">
                    <div>
                      <table class="table table-striped table-bordered table-hover"
                             id="dataTables-boxes">
                        <thead>
                        <tr>
                          <th>Casellante</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($series->inBoxes as $series_user)
                          <tr class="odd GradeX">
                            <td>{{$series_user->box->name}} {{$series_user->box->surname}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @if(count($series->listComics)>0)
              <div class="tab-pane fade" id="numbers">
                <div>
                  <div class="panel-body">
                    <div>
                      <table class="table table-striped table-bordered table-hover"
                             id="dataTables-comics">
                        <thead>
                        <tr>
                          <th>Numero</th>
                          <th>Nome</th>
                          <th>Cover</th>
                          <th>Prezzo</th>
                          @if($inv_state == 1)
                            <th>Disponibilità</th>
                          @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($series->listComics as $comic)
                          @if($comic->active)
                            <tr class="odd gradeX">
                          @else
                            <tr class="danger">
                              @endif
                              <td>{{$comic->number}}</td>
                              <td>
                                <a href="{{$series->id}}/{{$comic->id}}">{{$comic->name}}</a>
                              </td>
                              <td>
                                @if($comic->image)
                                  <a href="{{$comic->image}}" target="_blank"><img src="{{$comic->image}}" alt=""
                                                                                   height="42" width="42"></a>
                                @endif
                              </td>
                              <td>{{round($comic->price,2)}} €</td>
                              @if($inv_state == 1)
                                <td>{{$comic->available}}</td>
                              @endif
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            <div class="tab-pane fade" id="newnumber">
              <div>
                {{ Form::open(array('action' => 'ComicsController@create','id' => 'comic', 'class' => 'form-horizontal')) }}
                <div class="form-group has-feedback">
                  {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    {{ Form::text('name', "", array('class' => 'form-control')) }}
                    <div></div>
                  </div>
                  {{ Form::hidden('series_id', $series->id, array('id' => 'comic_series_id'))}}
                </div>
                <div class="form-group has-feedback">
                  {{ Form::label('number','Numero', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    @if($last_comic != null)
                      {{ Form::text('number', $last_comic->number+1, array('id' => 'comic_number', 'class' => 'form-control')) }}
                    @else
                      {{ Form::text('number', '', array('id' => 'comic_number', 'class' => 'form-control')) }}
                    @endif
                    <div></div>
                  </div>
                </div>
                <div class="form-group has-feedback">
                  {{ Form::label('image', 'Link Immagine', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    {{ Form::text('image', "", array('class' => 'form-control')) }}
                    <div></div>
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('price', 'Prezzo', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    <div class="input-group">
                      <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                      @if($last_comic != null)
                        {{ Form::text('price', $last_comic->price, array('id' => 'comic_price', 'class' => 'form-control')) }}
                      @else
                        {{ Form::text('price', '', array('id' => 'comic_price', 'class' => 'form-control')) }}
                      @endif
                      <div></div>
                    </div>
                  </div>
                </div>
                @if($inv_state == 1)
                  <div class="form-group has-feedback">
                    {{ Form::label('available', 'Disponibilità', array('class' => 'col-md-2 label-padding')) }}
                    <div class="col-md-10">
                      {{ Form::text('available', '0', array('id' => 'comic_available', 'class' => 'form-control')) }}
                      <div></div>
                    </div>
                  </div>
                @endif
                <div class="form-group has-feedback">
                  {{ Form::label('no_follow', 'Auto inserimento disabilitato', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    {{ Form::select('no_follow',array('1' => 'Sì','0' => 'No'),'1',array('class' => 'form-control')) }}
                    <div></div>
                  </div>
                </div>
                <div>
                  {{ Form::submit('Inserisci', array('class' => 'btn btn-primary no-radius')) }}
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
            <div class="tab-pane fade" id="edit">
              <div>
                {{ Form::model($series, array('action' => 'SeriesController@update', 'class' => 'form-horizontal')) }}
                <div class="form-group">
                  {{ Form::label('name', 'Nome', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('name', $series->name, array('class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('id')}}
                </div>
                <div class="form-group">
                  {{ Form::label('version','Versione', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('version', $series->version, array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('author', 'Autore', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('author', $series->author, array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('publisher', 'Editore', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('publisher', $series->subtype_id, array('class' => 'form-control')) }}
                  </div>
                </div>
                {{--<div class="form-group">--}}
                {{--{{ Form::label('type_id', 'Tipo', array('class' => 'col-md-1 label-padding')) }}--}}
                {{--<div class="col-md-11">--}}
                {{--{{ Form::text('type_id', $series->type_id, array('class' => 'form-control')) }}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                {{--{{ Form::label('subtype_id', 'Sotto Tipo', array('class' => 'col-md-1 label-padding')) }}--}}
                {{--<div class="col-md-11">--}}
                {{--{{ Form::text('subtype_id', $series->subtype_id, array('class' => 'form-control')) }}--}}
                {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                  {{ Form::label('concluded', 'Conclusa', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::select('concluded',array('1' => 'Sì','0' => 'No'),$series->concluded,array('class' => 'form-control')) }}
                  </div>
                </div>
                {{--<div class="form-group">--}}
                {{--{{ Form::label('finished', 'Conclusa', array('class' => 'col-md-1 label-padding')) }}--}}
                {{--<div class="col-md-11">--}}
                {{--@if($series->concluded)--}}
                {{--{{ Form::checkbox('finished',1,$series->concluded); }}--}}
                {{--@else--}}
                {{--{{ Form::checkbox('finished',1,$series->concluded); }}--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}
                <div>
                  {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
                </div>
                {{ Form::close() }}
              </div>
            </div>
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
          {{ Form::hidden('comics') }}
          {{ Form::hidden('return','series/' . $series->id) }}
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
  @include('../layouts/js-include')

  <script>
    $(document).ready(function () {

      $('#comic').on('submit', function () {
        $('#alert-1').hide();
        $('#alert-1').find('.success').hide();
        $('#alert-1').find('.error').hide();
        $('#alert-1').find('.necessary').hide();
        $('#alert-1').find('.success').html("");
        $('#alert-1').find('.error').html("");

        //value
        var name = $('#comic').find('#name').val();
        var comic_number = $('#comic').find('#comic_number').val();
        var image = $('#comic').find('#image').val();
        var comic_price = $('#comic').find('#comic_price').val();

        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var notnecessary_icon_select = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!
        //name
        if (name.length != 0) {
          var result = checkInputValue(name, "message", 128, -1);
          if (result['status'] == 'ko') {
            $('#alert-1').show();
            $('#alert-1').find('.error').show();
            $('#comic').find('#name').closest('.form-group').removeClass('has-success');
            $('#comic').find('#name').closest('.form-group').removeClass('not-necessary');
            $('#comic').find('#name').closest('.form-group').addClass('has-error');
            $('#comic').find('#name ~ div').html(error_icon_select);

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
            $('#comic').find('#name').closest('.form-group').removeClass('not-necessary');
            $('#comic').find('#name').closest('.form-group').removeClass('has-error');
            $('#comic').find('#name').closest('.form-group').addClass('has-success');
            $('#comic').find('#name ~ div').html(success_icon_select);
          }
        } else {
          $('#alert-1').find('.necessary').show();
          $('#comic').find('#name').closest('.form-group').removeClass('has-error');
          $('#comic').find('#name').closest('.form-group').addClass('not-necessary');
          $('#comic').find('#name ~ div').html(notnecessary_icon_select);
        }

        //comic_number
        var result = checkInputValue(comic_number, "integer", 11, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#comic').find('#comic_number').closest('.form-group').removeClass('has-success');
          $('#comic').find('#comic_number').closest('.form-group').addClass('has-error');
          $('#comic').find('#comic_number ~ div').html(error_icon_select);

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
          $('#comic').find('#comic_number').closest('.form-group').removeClass('has-error');
          $('#comic').find('#comic_number').closest('.form-group').addClass('has-success');
          $('#comic').find('#comic_number ~ div').html(success_icon_select);
        }

        //image
        if (image.length != 0) {
          var result = checkInputValue(image, "url", 128, -1);
          if (result['status'] == 'ko') {
            $('#alert-1').show();
            $('#alert-1').find('.error').show();
            $('#comic').find('#image').closest('.form-group').removeClass('not-necessary');
            $('#comic').find('#image').closest('.form-group').removeClass('has-success');
            $('#comic').find('#image').closest('.form-group').addClass('has-error');
            $('#comic').find('#image ~ div').html(error_icon_select);

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
            $('#comic').find('#image').closest('.form-group').removeClass('not-necessary');
            $('#comic').find('#image').closest('.form-group').removeClass('has-error');
            $('#comic').find('#image').closest('.form-group').addClass('has-success');
            $('#comic').find('#image ~ div').html(success_icon_select);
          }
        } else {
          $('#alert-1').find('.necessary').show();
          $('#comic').find('#image').closest('.form-group').removeClass('has-error');
          $('#comic').find('#image').closest('.form-group').addClass('not-necessary');
          $('#comic').find('#image ~ div').html(notnecessary_icon_select);
        }

        //comic_price
        var result = checkInputValue(comic_price, "number", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#comic').find('#comic_price').closest('.form-group').removeClass('has-success');
          $('#comic').find('#comic_price').closest('.form-group').addClass('has-error');
          $('#comic').find('#comic_price ~ div').html(error_icon_select);

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
          $('#comic').find('#comic_price').closest('.form-group').removeClass('has-error');
          $('#comic').find('#comic_price').closest('.form-group').addClass('has-success');
          $('#comic').find('#comic_price ~ div').html(success_icon_select);
        }

        //no_follow
        $('#comic').find('#no_follow').closest('.form-group').removeClass('has-error');
        $('#comic').find('#no_follow').closest('.form-group').addClass('has-success');
        $('#comic').find('#no_follow ~ div').html(success_icon_select);
        $('#comic').find('#no_follow').css('outline-color', '#3c763d');

        if (submit) {
          //chiamata ajax
        }
        return submit;
      });

    });
  </script>
  <script>
    function showConfirmModal(object_id, restore_comics, mode) {
      document.confirmForm.comics.value = restore_comics;
      if (mode == 0) {
        // delete series
        document.confirmForm.action = '../deleteSeries';
        document.confirmForm.id.value = object_id;
        $('#confirmPageName').text('Sei sicuro di volere disattivare questo fumetto');
      } else if (mode == 1) {
        // restore series
        document.confirmForm.action = '../restoreSeries';
        document.confirmForm.id.value = object_id;
        $('#confirmPageName').text('Sei sicuro di volere attivare nuovamente questo fumetto?' + mode);
      }
      $('#modal-confirm').modal({
        show: true
      });
    }
  </script>
@stop
