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
                                Dettagli
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                            </a>
                        </li>
                        @if(count($series->inBoxes)>0)
                            <li class="">
                                <a href="#boxes" data-toggle="tab">
                                    Casellanti
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                </a>
                            </li>
                        @endif
                        @if(count($series->listComics)>0)
                            <li class="">
                                <a href="#numbers" data-toggle="tab">
                                    Numeri
                                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                                </a>
                            </li>
                        @endif
                        <li class="">
                            <a href="#newnumber" data-toggle="tab">
                                Nuovo Numero
                                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#edit" data-toggle="tab">
                                Modifica
                                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
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
                                                                    <a href="{{$comic->image}}" target="_blank"><img src="{{$comic->image}}" alt="" height="42" width="42"></a>
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
                                <div class="form-group">
                                    {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('name', "", array('class' => 'form-control')) }}
                                    </div>
                                    {{ Form::hidden('series_id', $series->id, array('id' => 'comic_series_id'))}}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('number','Numero', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        @if($last_comic != null)
                                            {{ Form::text('number', $last_comic->number+1, array('id' => 'comic_number', 'class' => 'form-control')) }}
                                        @else
                                            {{ Form::text('number', '', array('id' => 'comic_number', 'class' => 'form-control')) }}
                                        @endif
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
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('image', 'Link Immagine', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('image', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                @if($inv_state == 1)
                                    <div class="form-group">
                                        {{ Form::label('available', 'Disponibilità', array('class' => 'col-md-2 label-padding')) }}
                                        <div class="col-md-10">
                                            {{ Form::text('available', '0', array('id' => 'comic_available', 'class' => 'form-control')) }}
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    {{ Form::submit('Inserisci', array('class' => 'btn btn-primary no-radius')) }}
                                </div>
                                {{ Form::close() }}
                                <div class="restyleAlert2" style="display:none">
                                    <div class="alert alert-success suc_not"></div>
                                    <div class="alert alert-error err_not"></div>
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
            $('#dataTables-boxes').dataTable();
            $('#dataTables-comics').dataTable();
            $('#comic').on('submit', function () {
                $('.restyleAlert2').hide();
                $('.err_not').hide();
                $('.suc_not').hide();
                $('.err_not').html("");
                $('.suc_not').html("");
                var number = $('#comic_number').val();
                var price = $('#comic_price').val();
                var available = $('#comic_available').val();
                var series_id = $('#comic_series_id').val();
                var submit = true;
                var result = checkInputValue(number, "number", 11, 1);
                if (result['status'] == 'ko') {
                    $('.restyleAlert2').show();
                    $('.err_not').show();
                    var obj = {
                        result: result,
                        htmlElement: $('.err_not'),
                        sex: "m",
                        elementName: "numero",
                        maxLength: 11,
                        minLength: 1
                    };
                    showErrorMsg(obj);
                    submit = false;
                }
                var result = checkInputValue(price, "price", 11, 1);
                if (result['status'] == 'ko') {
                    $('.restyleAlert2').show();
                    $('.err_not').show();
                    var obj = {
                        result: result,
                        htmlElement: $('.err_not'),
                        sex: "m",
                        elementName: "prezzo",
                        maxLength: 11,
                        minLength: 1
                    };
                    showErrorMsg(obj);
                    submit = false;
                }
                return submit;
            })
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
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
