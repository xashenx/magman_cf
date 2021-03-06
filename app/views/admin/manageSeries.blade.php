@section('content')
  @if(count($errors)>0)
    <div class="alert alert-danger error no-radius">
      <h3>Whhops: E' avvenuto un errore!!<br/>
        Se il problema persiste contattare un amministratore</h3>
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Gestione Serie
        </div>
        <div class="panel-body">
          <ul class="nav nav-tabs margin-bottom">
            <li class="active">
              <a href="#series" data-toggle="tab">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                <span class="titoli-tab">Serie</span>
              </a>
            </li>
            <li class="">
              <a href="#new" data-toggle="tab">
                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                <span class="titoli-tab">Nuova Serie</span>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active in" id="series">
              <div>
                <div>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="legend-green col-xs-2"></div>
                      Serie conclusa
                    </div>
                    <div class="col-xs-12">
                      <div class="legend-red col-xs-2"></div>
                      Serie disabilitata
                    </div>
                  </div>
                  <table class="table table-striped table-bordered table-hover"
                         id="dataTables-series">
                    <thead>
                    <tr>
                      <th>Nome</th>
                      <th>Editore</th>
                      {{--<th>Versione</th>--}}
                      {{--<th>Autore</th>--}}
                      <th>Numeri Usciti</th>
                      <th>Azioni veloci</th>
                      <th># Casellanti</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($series as $serie)
                      @if ($serie->active == 0)
                        <tr class="danger">
                          @elseif ($serie->concluded == 1)
                        <tr class="success">
                      @else
                        <tr class="odd gradeX">
                          @endif
                          @if($serie->version != null)
                            <td><a href="series/{{$serie->id}}">{{$serie->name}} - {{$serie->version}}</a></td>
                          @else
                            <td><a href="series/{{$serie->id}}">{{$serie->name}}</a></td>
                          @endif
                          <td>{{$serie->publisher->name}}</td>
                          {{--<td>{{$serie->version}}</td>--}}
                          {{--<td>{{$serie->author}}</td>--}}
                          <td>{{$serie->listActive->max('number') != null ? $serie->listActive->max('number') : 0}}</td>
                          <td>
                            @if($serie->active == 1)
                              <button type="button" title="Disabilita"
                                      onclick="showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},0)"
                                      class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-remove"
                                                                      aria-hidden="true"></span>
                              </button>
                            @else
                              <button type="button" title="Abilita"
                                      onclick="showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},1)"
                                      class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-ok "
                                                                      aria-hidden="true"></span>
                              </button>
                              <button type="button" title="Abilita con Fumetti"
                                      onclick="showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},2)"
                                      class="btn btn-warning btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-book"
                                                                      aria-hidden="true"></span>
                              </button>
                            @endif
                              <button type="button" title="Cancella"
                                      onclick="showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},3)"
                                      class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-trash"
                                                                      aria-hidden="true"></span>
                              </button>
                            {{--<div class="btn-group">--}}
                            {{--<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">--}}
                            {{--Azioni <span class="caret"></span>--}}
                            {{--</button>--}}
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li>--}}
                            {{--@if($serie->active)--}}
                            {{--<a href="#" onclick = "showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},0)">Disabilita</a>--}}
                            {{--@else--}}
                            {{--<a href="#" onclick = "showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},1)">Abilita</a>--}}
                            {{--<a href="#" onclick = "showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},2)">Abilita+fumetti</a>--}}
                            {{--@endif--}}
                            {{--</li>--}}
                            {{--<!-- <li>--}}
                            {{--<a href="newComic/{{$serie->id}}">Nuovo fumetto</a>--}}
                            {{--</li> -->--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                          </td>
                          <td>{{count($serie->inBoxes)}}</td>
                          @endforeach
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="new">
              <div>
                {{ Form::open(array('action' => 'SeriesController@create', 'id' => 'new-series', 'class' => 'form-horizontal')) }}
                <div class="form-group has-feedback">
                  {{ Form::label('name', 'Nome', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('name', "", array('class' => 'form-control', 'placeholder' => 'Nome della serie')) }}
                    <div></div>
                  </div>
                  {{ Form::hidden('id')}}
                </div>
                <div class="form-group has-feedback">
                  {{ Form::label('version','Versione', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('version', "", array('class' => 'form-control', 'placeholder' => 'Versione della serie *')) }}
                    <div></div>
                  </div>
                </div>
                <div class="form-group has-feedback">
                  {{ Form::label('author', 'Autore', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('author', "", array('class' => 'form-control', 'placeholder' => 'Autore della serie')) }}
                    <div></div>
                  </div>
                </div>
                <div class="form-group has-feedback">
                  {{ Form::label('publisher', 'Editore', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('publisher', "", array('class' => 'form-control', 'placeholder' => 'Editore della serie')) }}
                    <div></div>
                  </div>
                </div>
                {{--<div class="form-group">--}}
                {{--{{ Form::label('type_id', 'Tipo', array('class' => 'col-md-1 label-padding')) }}--}}
                {{--<div class="col-md-11">--}}
                {{--{{ Form::text('type_id', "", array('class' => 'form-control')) }}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                {{--{{ Form::label('subtype_id', 'Sotto Tipo', array('class' => 'col-md-1 label-padding')) }}--}}
                {{--<div class="col-md-11">--}}
                {{--{{ Form::text('subtype_id', "", array('class' => 'form-control')) }}--}}
                {{--</div>--}}
                {{--</div>--}}
                <div>
                  {{ Form::submit('Aggiungi', array('class' => 'btn btn-primary no-radius')) }}
                </div>
                {{ Form::close() }}
                <div class="cAlert" id="alert-1">
                  <div class="alert alert-success success no-radius"></div>
                  <div class="alert alert-info no-radius">
                    I campi con
                    <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                    sono opzionali.
                  </div>
                  <div class="alert alert-danger error no-radius"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('../layouts/confirmation-box')
  @include('../layouts/js-include')
  <script>
    function showConfirmModal(name, version, serie_id, mode) {
      document.confirmForm.id.value = serie_id;
      document.confirmForm.return.value = 'series';
      if (mode == 0) {
        document.confirmForm.action = 'deleteSeries';
        $('#confirmPageName').text('Sei sicuro di voler disabilitare la serie ' + "'" + name + " - " + version + "'?");
      } else if (mode == 1) {
        document.confirmForm.action = 'restoreSeries';
        $('#confirmPageName').text('Sei sicuro di voler abilitare la serie ' + "'" + name + " - " + version + "'?");
      } else if (mode == 2){
        document.confirmForm.action = 'restoreSeries';
        document.confirmForm.comics.value = '1';
        $('#confirmPageName').text('Sei sicuro di voler abilitare la serie ' + "'" + name + " - " + version + "' e i relativi fumetti?");
      } else if (mode == 3){
        document.confirmForm.action = 'delete2Series';
        $('#confirmPageName').text('Sei sicuro di voler cancellare la serie ' + "'" + name + " - " + version + "' e i relativi fumetti?");
      }
      $('#modal-confirm').modal({
        show: true
      });
    }
  </script>
  <script>
    $(document).ready(function () {
      $('#dataTables-series').dataTable({
        "language": {
          "url": "{{ URL::asset('assets/js/dataTables/series.lang') }}"
        }
      });
      $('#new-series').on('submit', function () {
        $('#alert-1').hide();
        $('#alert-1').find('.success').hide();
        $('#alert-1').find('.error').hide();
        $('#alert-1').find('.success').html("");
        $('#alert-1').find('.error').html("");

        //value
        var name = $('#new-series').find('#name').val();
        var version = $('#new-series').find('#version').val();
        var author = $('#new-series').find('#author').val();
        var publisher = $('#new-series').find('#publisher').val();

        var error_icon = '<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>'
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>'
        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>'
        //submit = true
        var submit = true;
        //start the check!
        //NAME
        var result = checkInputValue(name, "message", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-series').find('#name').closest('.form-group').removeClass('has-success');
          $('#new-series').find('#name').closest('.form-group').addClass('has-error');
          $('#new-series').find('#name ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "m",
            elementName: "nome",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-series').find('#name').closest('.form-group').removeClass('has-error');
          $('#new-series').find('#name').closest('.form-group').addClass('has-success');
          $('#new-series').find('#name ~ div').html(success_icon);
        }

        //VERSION
        var result = checkInputValue(version, "message", 128, -1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-series').find('#version').closest('.form-group').removeClass('not-necessary');
          $('#new-series').find('#version').closest('.form-group').addClass('has-error');
          $('#new-series').find('#version ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "f",
            elementName: "versione",
            maxLength: 128,
            minLength: -1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-series').find('#version').closest('.form-group').removeClass('has-error');
          $('#new-series').find('#version').closest('.form-group').addClass('not-necessary');
          $('#new-series').find('#version ~ div').html(notnecessary_icon);
        }

        //AUTHOR
        var result = checkInputValue(author, "message", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-series').find('#author').closest('.form-group').removeClass('has-success');
          $('#new-series').find('#author').closest('.form-group').addClass('has-error');
          $('#new-series').find('#author ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "am",
            elementName: "autore",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-series').find('#author').closest('.form-group').removeClass('has-error');
          $('#new-series').find('#author').closest('.form-group').addClass('has-success');
          $('#new-series').find('#author ~ div').html(success_icon);
        }

        //PUBLISHER
        var result = checkInputValue(publisher, "message", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-series').find('#publisher').closest('.form-group').removeClass('has-success');
          $('#new-series').find('#publisher').closest('.form-group').addClass('has-error');
          $('#new-series').find('#publisher ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "am",
            elementName: "editore",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-series').find('#publisher').closest('.form-group').removeClass('has-error');
          $('#new-series').find('#publisher').closest('.form-group').addClass('has-success');
          $('#new-series').find('#publisher ~ div').html(success_icon);
        }

        if (submit) {
          //chiamata ajax
        }
        return submit;
      });

    });
  </script>
  <!-- CUSTOM SCRIPTS -->
@stop