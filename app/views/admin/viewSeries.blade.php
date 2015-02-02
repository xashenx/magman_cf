@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Visualizza/Modifica Serie
                        @if($series->active)
                            <button type="button" title="Disattiva serie"
                                    onclick="showConfirmModal({{$series->id}},0,0)"
                                    class="btn btn-danger btn-sm">
                                <i class="fa fa-remove"></i>
                            </button>
                        @else
                            <button type="button" title="Riattiva serie"
                                    onclick="showConfirmModal({{$series->id}},0,1)"
                                    class="btn btn-success btn-sm">
                                <i class="fa fa-smile-o"></i>
                            </button>
                            <button type="button" title="Riattiva serie con fumetti"
                                    onclick="showConfirmModal({{$series->id}},1,1)"
                                    class="btn btn-warning btn-sm">
                                <i class="fa fa-book"></i>
                            </button>
                        @endif
                    </h1>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#details" data-toggle="tab">Dettagli</a>
                        </li>
                        <li class="">
                            <a href="#numbers" data-toggle="tab">Numeri</a>
                        </li>
                        <li class="">
                            <a href="#newnumber" data-toggle="tab">Nuovo Numero</a>
                        </li>
                        <li class="">
                            <a href="#edit" data-toggle="tab">Modifica</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Visualizza Dettagli della Serie</h5>
                                </div>
                                Nome: {{$series->name}}
                                <br/>
                                Versione: {{$series->version}}
                                <br/>
                                Autore: {{$series->author}}
                                <br/>
                                @if($series->listComics->max('number') != null)
                                    Numeri usciti: {{$series->listActive->max('number')}}
                                @else
                                    Numeri usciti: 0
                                @endif
                                <br/>
                                @if($series->conclusa)
                                    Stato: Conclusa
                                    <br/>
                                @else
                                    Stato: Attiva
                                    <br/>
                                @endif
                                Casellanti della serie: {{count($series->inBoxes)}}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="numbers">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Numeri della Serie</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>Numero</th>
                                                <th>Nome</th>
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
                                                        <td>{{round($comic->price,2)}}</td>
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
                        <div class="tab-pane fade" id="newnumber">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Inserimento Nuovo Numero</h5>
                                </div>
                                {{ Form::open(array('action' => 'ComicsController@create','id' => 'comic')) }}
                                <div>
                                    {{ Form::label('name', 'Nome') }}
                                    {{ Form::text('name') }}
                                    {{ Form::hidden('series_id', $series->id, array('id' => 'comic_series_id'))}}
                                </div>
                                <div>
                                    {{ Form::label('number','Numero') }}
                                    @if($last_comic != null)
                                        {{ Form::text('number', $last_comic->number+1, array('id' => 'comic_number')) }}
                                    @else
                                        {{ Form::text('number', '', array('id' => 'comic_number')) }}
                                    @endif
                                </div>
                                <div>
                                    {{ Form::label('price', 'Prezzo') }}
                                    @if($last_comic != null)
                                        {{ Form::text('price', $last_comic->price, array('id' => 'comic_price')) }}
                                    @else
                                        {{ Form::text('price', '', array('id' => 'comic_price')) }}
                                    @endif
                                </div>
                                <div>
                                    {{ Form::label('image', 'Link Immagine') }}
                                    {{ Form::text('image') }}
                                </div>
                                @if($inv_state == 1)
                                    <div>
                                        {{ Form::label('available', 'Disponibilità') }}
                                        {{ Form::text('available', '0', array('id' => 'comic_available')) }}
                                    </div>
                                @endif
                                <div>
                                    {{ Form::submit('Inserisci') }}
                                </div>
                                {{ Form::close() }}
                                <div class="restyleAlert2" style="display:none">
                                    <div class="alert alert-success suc_not"></div>
                                    <div class="alert alert-error err_not"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edit">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Modifica della Serie</h5>
                                </div>
                                {{ Form::model($series, array('action' => 'SeriesController@update')) }}
                                <div>
                                    {{ Form::label('name', 'Nome') }}
                                    {{ Form::text('name') }}
                                    {{ Form::hidden('id')}}
                                </div>
                                <div>
                                    {{ Form::label('version','Versione') }}
                                    {{ Form::text('version') }}
                                </div>
                                <div>
                                    {{ Form::label('author', 'Autore') }}
                                    {{ Form::text('author') }}
                                </div>
                                <div>
                                    {{ Form::label('type_id', 'Tipo') }}
                                    {{ Form::text('type_id') }}
                                </div>
                                <div>
                                    {{ Form::label('subtype_id', 'Sotto Tipo') }}
                                    {{ Form::text('subtype_id') }}
                                </div>
                                <div>
                                    {{ Form::label('concluded', 'Conclusa') }}
                                    @if($series->concluded)
                                        {{ Form::checkbox('finished',1,$series->concluded); }}
                                    @else
                                        {{ Form::checkbox('finished',1,$series->concluded); }}
                                    @endif
                                </div>
                                <div>
                                    {{ Form::submit('Aggiorna') }}
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
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="../assets/js/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="../assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="../assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
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
