@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
    @endif
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Visualizza/Modifica Fumetto</h1>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
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
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Dettagli del Fumetto</h5>
                                </div>
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
                                Prezzo: {{round($comic->price,2)}}
                                <br/>
                            </div>
                        </div>
                        @if($comic->series->active == 1)
                            @if(count($ordered)>0)
                            <div class="tab-pane fade" id="ordered">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Prenotazioni del Fumetto</h5>
                                    </div>
                                    <div class="tab-content">
                                        <div class="table-responsive">
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
                                                        <td>{{ round($order->price,2)}}€</td>
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
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Modifica del Fumetto</h5>
                                    </div>
                                    {{ Form::model($comic, array('action' => 'ComicsController@update')) }}
                                    <div>
                                        {{ Form::label('name', 'Nome') }}
                                        {{ Form::text('name') }}
                                        {{ Form::hidden('id') }}
                                        {{ Form::hidden('series_id') }}
                                        @if($path == "../")
                                            {{ Form::hidden('return','comics') }}
                                        @elseif($path == "../../")
                                            {{ Form::hidden('return','series') }}
                                        @endif
                                    </div>
                                    <div>
                                        {{ Form::label('number', 'Numero') }}
                                        {{ Form::text('number') }}
                                    </div>
                                    @if($inv_state == 1)
                                        <div>
                                            {{ Form::label('available', 'Disponibilità') }}
                                            {{ Form::text('available') }}
                                        </div>
                                    @endif
                                    <div>
                                        {{ Form::label('price', 'Prezzo') }}
                                        {{ Form::text('price') }}
                                    </div>
                                    <div>
                                        {{ Form::label('active', 'Attivo') }}
                                        {{ Form::checkbox('active', 'value'); }}
                                    </div>
                                    <div>
                                        {{ Form::submit('Aggiorna') }}
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
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="{{$path}}assets/js/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="{{$path}}assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="{{$path}}assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="{{$path}}assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="{{$path}}assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
@stop