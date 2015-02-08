@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default no-radius">
                <div class="panel-heading no-radius">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Gestione Fumetto
                    @if($comic->active)
                            <button type="button" title="Disattiva fumetto"
                                    @if($path == '../')
                                    onclick="showConfirmModal({{$comic->id}},0,0)"
                                    @else
                                    onclick="showConfirmModal({{$comic->id}},{{$comic->series->id}},0)"
                                    @endif
                                    class="btn btn-danger btn-xs no-radius"><i
                                        class="fa fa-remove"></i>
                            </button>
                    @else
                        <button type="button" title="Riattiva fumetto"
                                @if($path == '../')
                                onclick="showConfirmModal({{$comic->id}},0,1)"
                                @else
                                onclick="showConfirmModal({{$comic->id}},{{$comic->series->id}},1)"
                                @endif
                                class="btn btn-success btn-sm"><i
                                    class="fa fa-thumbs-o-up"></i>
                        </button>
                    @endif
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs margin-bottom">
                        <li class="active">
                            <a href="#details" data-toggle="tab">Dettagli</a>
                        </li>
                        @if($comic->series->active == 1)
                            @if(count($ordered)>0)
                            <li class="">
                                <a href="#ordered" data-toggle="tab">Prenotazioni</a>
                            </li>
                            @endif
                            <li class="">
                                <a href="#edit" data-toggle="tab">Modifica</a>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div>
                                Nome: {{$comic->series->name}}
                                <br/>
                                Versione: {{$comic->series->version}}
                                <br/>
                                Autore: {{$comic->series->author}}
                                <br/>
                                Numero: {{$comic->number}}
                                <br/>
                                Nome del numero: {{$comic->name}}
                                <br/>
                                @if($inv_state == 1)
                                    Disponibilità: {{$comic->available}}
                                    <br/>
                                @endif
                                Prezzo: {{ $comic->price }} €
                                <br/>
                            </div>
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
                                                        <td>{{ round($order->price,2) }} €</td>
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
                                    {{ Form::model($comic, array('action' => 'ComicsController@update', 'class' => 'form-horizontal')) }}
                                    <div class="form-group">
                                        {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                                        <div class="col-md-10">
                                            {{ Form::text('name', $comic->name, array('class' => 'form-control')) }}
                                        </div>
                                        {{ Form::hidden('id') }}
                                        {{ Form::hidden('series_id') }}
                                        @if($path == "../")
                                            {{ Form::hidden('return','comics') }}
                                        @elseif($path == "../../")
                                            {{ Form::hidden('return','series') }}
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('number', 'Numero', array('class' => 'col-md-2 label-padding')) }}
                                        <div class="col-md-10">
                                            {{ Form::text('number', $comic->number, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    @if($inv_state == 1)
                                        <div class="form-group">
                                            {{ Form::label('available', 'Disponibilità', array('class' => 'col-md-2 label-padding')) }}
                                            <div class="col-md-10">
                                                {{ Form::text('available', $comic->available, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        {{ Form::label('image', 'Link Immagine', array('class' => 'col-md-2 label-padding')) }}
                                        <div class="col-md-10">
                                            {{ Form::text('image', $comic->image, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('price', 'Prezzo', array('class' => 'col-md-2 label-padding')) }}
                                        <div class="col-md-10">
                                            {{ Form::text('price', $comic->price, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div>
                                        {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
                                    </div>
                                    {{ Form::close() }}
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
            if(series != 0)
                document.confirmForm.return.value = "series/" + series + "/" + object_id;
            else
                document.confirmForm.return.value = "comics/" + object_id;
            if (mode == 0) {
                // delete comic
                if(series != 0)
                    document.confirmForm.action = '../../deleteComic';
                else
                    document.confirmForm.action = '../deleteComic';
                document.confirmForm.id.value = object_id;
                $('#confirmPageName').text('Sei sicuro di volere disattivare questo fumetto?');
            } else if (mode == 1) {
                // restore comic
                if(series != 0)
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

@stop