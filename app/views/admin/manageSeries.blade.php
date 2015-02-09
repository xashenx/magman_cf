@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
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
                                Serie
                                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#new" data-toggle="tab">
                                Nuova Serie
                                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="series">
                            <div>
                                <div>
                                    <table class="table table-striped table-bordered table-hover"
                                           id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>Editore</th>
                                            <th>Nome</th>
                                            <th>Serie</th>
                                            <th>Autore</th>
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
                                                    <td>{{$serie->publisher}}</td>
                                                    <td><a href="series/{{$serie->id}}">{{$serie->name}}</a></td>
                                                    <td>{{$serie->version}}</td>
                                                    <td>{{$serie->author}}</td>
                                                    <td>{{$serie->listActive->max('number')}}</td>
                                                    <td>
                                                        @if($serie->active)
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
                                                                <span class="glyphicon glyphicon-ok	"
                                                                      aria-hidden="true"></span>
                                                            </button>
                                                            <button type="button" title="Abilita con Fumetti"
                                                                    onclick="showConfirmModal('{{$serie->name}}','{{$serie->version}}',{{$serie->id}},2)"
                                                                    class="btn btn-warning btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-book"
                                                                      aria-hidden="true"></span>
                                                            </button>
                                                        @endif
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
                                {{ Form::open(array('action' => 'SeriesController@create', 'class' => 'form-horizontal')) }}
                                <div class="form-group">
                                    {{ Form::label('name', 'Nome', array('class' => 'col-md-1 label-padding')) }}
                                    <div class="col-md-11">
                                        {{ Form::text('name', "", array('class' => 'form-control')) }}
                                    </div>
                                    {{ Form::hidden('id')}}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('version','Versione', array('class' => 'col-md-1 label-padding')) }}
                                    <div class="col-md-11">
                                        {{ Form::text('version', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('author', 'Autore', array('class' => 'col-md-1 label-padding')) }}
                                    <div class="col-md-11">
                                        {{ Form::text('author', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('publisher', 'Editore', array('class' => 'col-md-1 label-padding')) }}
                                    <div class="col-md-11">
                                        {{ Form::text('publisher', "", array('class' => 'form-control')) }}
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
                                    {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Advanced Tables -->
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
                    {{ Form::hidden('return') }}
                    {{ Form::button('Annulla', array(
                    'data-dismiss' => 'modal',
                    'class' => 'btn btn-danger btn-sm')) }}
                    {{ Form::submit('Sì', array('class' => 'btn btn-danger btn-sm',)) }}
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
        function showConfirmModal(name, version, serie_id, mode) {
            document.confirmForm.id.value = serie_id;
            document.confirmForm.return.value = 'series';
            if (mode == 0) {
                document.confirmForm.action = 'deleteSeries';
                $('#confirmPageName').text('Sei sicuro di voler disabilitare la serie ' + "'" + name + " - " + version + "'?");
            } else if (mode == 1) {
                document.confirmForm.action = 'restoreSeries';
                $('#confirmPageName').text('Sei sicuro di voler abilitare la serie ' + "'" + name + " - " + version + "'?");
            } else {
                document.confirmForm.action = 'restoreSeries';
                document.confirmForm.comics.value = '1';
                $('#confirmPageName').text('Sei sicuro di voler abilitare la serie ' + "'" + name + " - " + version + "' e i relativi fumetti?");
            }
            $('#modal-confirm').modal({
                show: true
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
@stop