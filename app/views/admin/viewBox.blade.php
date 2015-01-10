@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Casella {{$user->number}}: {{$user -> name}} {{$user->surname}}</h1>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        @if($user->active)
                            @if(count($comics)>0)
                                <li class="active">
                                    <a href="#orderedComics" data-toggle="tab">In arrivo</a>
                                </li>
                                @if(count($series)>0)
                                    <li class="">
                                        <a href="#series" data-toggle="tab">Serie Seguite</a>
                                    </li>
                                @endif
                                <li class="">
                                    <a href="#newseries" data-toggle="tab">Nuova Serie</a>
                                </li>
                            @elseif(count($series)>0)
                                <li class="active">
                                    <a href="#series" data-toggle="tab">Serie Seguite</a>
                                </li>
                                <li class="">
                                    <a href="#newseries" data-toggle="tab">Nuova Serie</a>
                                </li>
                            @elseif(count($comics)==0 && count($series)==0)
                                <li class="active">
                                    <a href="#newseries" data-toggle="tab">Nuova Serie</a>
                                </li>
                            @endif
                            <li class="">
                                <a href="#newsinglecomic" data-toggle="tab">Nuovo Arretrato/Singolo</a>
                            </li>
                            <li class="">
                                <a href="#details" data-toggle="tab">Dettagli</a>
                            </li>
                        @else
                            <li class="active">
                                <a href="#details" data-toggle="tab">Dettagli</a>
                            </li>
                        @endif
                        @if(count($purchases)>0)
                            <li class="">
                                <a href="#purchases" data-toggle="tab">Storico Acquisti</a>
                            </li>
                        @endif
                        <li class="">
                            <a href="#edit" data-toggle="tab">Modifica</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @if($user->active)
                            @if(count($comics)>0)
                                <div class="tab-pane fade active in" id="orderedComics">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5>Fumetti in arrivo</h5> (Saldo disponibili: {{ $due }}€)
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive table-bordered">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="dataTables-example">
                                                    <thead>
                                                    <tr>
                                                        <th>Serie</th>
                                                        <th>Prezzo</th>
                                                        <th>Azioni Rapide</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($comics as $comic)
                                                        @if ($comic->comic->available > 1)
                                                            <tr class="success">
                                                        @else
                                                            <tr class="odd gradeX">
                                                                @endif
                                                                @if($comic->comic->series->version != null)
                                                                    <td>
                                                                        <a href="{{$user->id}}/comic/{{$comic->id}}">{{ $comic->comic->series->name}}
                                                                            - {{ $comic->comic->series->version}}
                                                                            nr. {{ $comic->comic->number}}</a></td>
                                                                @else
                                                                    <td>
                                                                        <a href="{{$user->id}}/comic/{{$comic->id}}">{{ $comic->comic->series->name}}
                                                                            nr. {{ $comic->comic->number}}</a></td>
                                                                @endif
                                                                <td>{{ round($comic->price,2) }}</td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button data-toggle="dropdown"
                                                                                class="btn btn-primary dropdown-toggle">
                                                                            Azioni <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                @if($comic->comic->available > 0)
                                                                                    <a href="#"
                                                                                       onclick="showConfirmModal({{$comic->id}},{{$user->id}},0)">Acquistato</a>
                                                                                @endif
                                                                                <a href="#"
                                                                                   onclick="showConfirmModal({{$comic->id}},{{$user->id}},1)">Rimuovi</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(count($series)>0)
                                    <div class="tab-pane fade" id="series">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h5>Serie Seguite dal casellante</h5>
                                            </div>
                                            <div class="table-responsive table-bordered">
                                                <table class="table table-striped table-bordered table-hover"
                                                       id="dataTables-example">
                                                    <thead>
                                                    <tr>
                                                        <th>Serie</th>
                                                        <th>Autore</th>
                                                        <th>Numeri Usciti</th>
                                                        <th>Azioni Rapide</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($series as $serie)
                                                        @if ($serie->series->concluded)
                                                            <tr class="success">
                                                                @elseif($serie->active)
                                                            <tr class="odd gradeX">
                                                        @else
                                                            <tr class="danger">
                                                                @endif
                                                                @if($serie->series->version == null)
                                                                    <td>{{$serie->series->name}}</td>
                                                                @else
                                                                    <td>{{$serie->series->name}}
                                                                        - {{$serie->series->version}}</td>
                                                                @endif
                                                                <td>{{$serie->series->author}}</td>
                                                                <td>{{count($serie->series->listComics)}}</td>
                                                                <td> @if(!$serie->series->concluded)
                                                                        <div class="btn-group">
                                                                            <button data-toggle="dropdown"
                                                                                    class="btn btn-primary dropdown-toggle">
                                                                                Azioni <span class="caret"></span>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                                <li>
                                                                                    @if($serie->active)
                                                                                        <a href="#"
                                                                                           onclick="showConfirmModal({{$serie->id}},{{$user->id}},2)">Abbandona</a>
                                                                                    @else
                                                                                        <a href="#"
                                                                                           onclick="showConfirmModal({{$serie->id}},{{$user->id}},3)">Segui</a>
                                                                                    @endif
                                                                                </li>
                                                                            </ul>
                                                                        </div> @endif </td>
                                                            </tr>
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @elseif(count($series)>0)
                                <div class="tab-pane fade active in" id="series">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5>Serie Seguite dal casellante</h5>
                                        </div>
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="dataTables-example">
                                                <thead>
                                                <tr>
                                                    <th>Serie</th>
                                                    <th>Autore</th>
                                                    <th>Numeri Usciti</th>
                                                    <th>Azioni Rapide</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($series as $serie)
                                                    @if ($serie->series->concluded)
                                                        <tr class="success">
                                                            @elseif($serie->active)
                                                        <tr class="odd gradeX">
                                                    @else
                                                        <tr class="danger">
                                                            @endif
                                                            @if($serie->series->version == null)
                                                                <td>{{$serie->series->name}}</td>
                                                            @else
                                                                <td>{{$serie->series->name}}
                                                                    - {{$serie->series->version}}</td>
                                                            @endif
                                                            <td>{{$serie->series->author}}</td>
                                                            <td>{{count($serie->series->listComics)}}</td>
                                                            <td> @if(!$serie->series->concluded)
                                                                    <div class="btn-group">
                                                                        <button data-toggle="dropdown"
                                                                                class="btn btn-primary dropdown-toggle">
                                                                            Azioni <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                @if($serie->active)
                                                                                    <a href="#"
                                                                                       onclick="showConfirmModal({{$serie->id}},{{$user->id}},2)">Abbandona</a>
                                                                                @else
                                                                                    <a href="#"
                                                                                       onclick="showConfirmModal({{$serie->id}},{{$user->id}},3)">Segui</a>
                                                                                @endif
                                                                            </li>
                                                                        </ul>
                                                                    </div> @endif </td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(count($series)>0 || count($comics)>0)
                                <div class="tab-pane fade" id="newseries">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5>Nuova Serie in casella</h5>
                                        </div>
                                        {{ Form::open(array('action' => 'SeriesUserController@create')) }}
                                        <div>
                                            <select name="series_id" id="series_id">
                                                @foreach($active_series as $serie)
                                                    @if($serie->version != null)
                                                        <option value="{{ $serie->id }}"
                                                                rel="{{ $serie->name }}">{{ $serie->name }}
                                                            - {{ $serie -> version }}</option>
                                                    @else
                                                        <option value="{{ $serie->id }}"
                                                                rel="{{ $serie->name }}">{{ $serie->name }}
                                                            - {{ $serie -> version }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            {{ Form::hidden('user_id', $user->id) }}
                                        </div>
                                        <div>
                                            {{ Form::submit('Aggiungi') }}
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            @else
                                <div class="tab-pane fade active in" id="newseries">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h5>Nuova Serie in casella</h5>
                                        </div>
                                        {{ Form::open(array('action' => 'SeriesUserController@create')) }}
                                        <div>
                                            <select name="series_id" id="series_id">
                                                @foreach($active_series as $serie)
                                                    @if($serie->version != null)
                                                        <option value="{{ $serie->id }}"
                                                                rel="{{ $serie->name }}">{{ $serie->name }}
                                                            - {{ $serie -> version }}</option>
                                                    @else
                                                        <option value="{{ $serie->id }}"
                                                                rel="{{ $serie->name }}">{{ $serie->name }}
                                                            - {{ $serie -> version }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            {{ Form::hidden('user_id', $user->id) }}
                                        </div>
                                        <div>
                                            {{ Form::submit('Aggiungi') }}
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            @endif
                            <div class="tab-pane fade" id="newsinglecomic">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Nuova Arretrato/Fumetto Singolo in casella</h5>
                                    </div>
                                    {{ Form::open(array('action' => 'ComicUserL2Controller@create')) }}
                                    <div>
                                        <select name="single_series_id" id="single_series_id">
                                            <option value="-1" selected>-- Seleziona una serie --</option>
                                            @foreach($active_series as $serie)
                                                @if($serie->version != null)
                                                    <option value="{{ $serie->id }}"
                                                            rel="{{ $serie->name }}">{{ $serie->name }}
                                                        - {{ $serie -> version }}</option>
                                                @else
                                                    <option value="{{ $serie->id }}"
                                                            rel="{{ $serie->name }}">{{ $serie->name }}
                                                        - {{ $serie -> version }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        {{ Form::label('number', 'Numero') }}
                                        <select name="single_number_id" id="single_number_id" disabled>
                                        </select>
                                        {{ Form::hidden('user_id', $user->id) }}
                                    </div>
                                    <div>
                                        {{ Form::submit('Aggiungi',['id' => 'add_single_number','disabled' => 'disabled']) }}
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        @endif
                        @if(!$user->active)
                            <div class="tab-pane fade active in" id="details">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Dettagli della casella</h5>
                                    </div>
                                    Nome: {{$user->name}}, Cognome: {{$user->surname}}
                                    <br/>
                                    Numero casella: {{$user->number}}
                                    <br/>
                                    Sconto: {{$user->discount}}
                                    <br/>
                                </div>
                            </div>
                        @else
                            <div class="tab-pane fade" id="details">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Dettagli della casella</h5>
                                    </div>
                                    Nome: {{$user->name}}, Cognome: {{$user->surname}}
                                    <br/>
                                    Numero casella: {{$user->number}}
                                    <br/>
                                    Sconto: {{$user->discount}}
                                    <br/>
                                </div>
                            </div>
                        @endif
                        @if(count($purchases)>0)
                            <div class="tab-pane fade" id="purchases">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5>Storico degli Acquisti</h5>
                                    </div>
                                    <div class="table-responsive table-bordered">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>Data Acquisto</th>
                                                <th>Fumetto</th>
                                                <th>Prezzo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($purchases as $purchase)
                                                <tr class="odd gradeX">
                                                    <td>{{date('d/m/Y',strtotime($purchase->buy_time))}}</td>
                                                    @if($purchase->series->version == null)
                                                        <td>{{$purchase->series->name}}
                                                            nr. {{$purchase->comic->number}}</td>
                                                    @else
                                                        <td>{{$purchase->series->name}} - {{$purchase->series->version}}
                                                            nr. {{$purchase->comic->number}}</td>
                                                    @endif
                                                    <td>{{$purchase->price}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane fade" id="edit">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Modifica della casella</h5>
                                </div>
                                {{ Form::model($user, array('action' => 'UsersController@update')) }}
                                <div>
                                    {{ Form::label('name', 'Nome') }}
                                    {{ Form::text('name') }}
                                </div>
                                <div>
                                    {{ Form::label('surname','Cognome') }}
                                    {{ Form::text('surname') }}
                                    {{ Form::hidden('id')}}
                                </div>
                                <div>
                                    {{ Form::label('number','Numero') }}
                                    {{ Form::text('number') }}
                                </div>
                                <div>
                                    {{ Form::label('pass', 'Password') }}
                                    {{ Form::password('pass') }}
                                </div>
                                <div>
                                    {{ Form::label('discount', 'Sconto') }}
                                    {{ Form::text('discount') }}
                                </div>
                                <div>
                                    {{ Form::label('active', 'Attivo') }}
                                    {{ Form::checkbox('active'); }}
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
                    {{ Form::hidden('user_id') }}
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
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script>
        function showConfirmModal(object_id, user_id, mode) {
            document.confirmForm.user_id.value = user_id;
            if (mode == 0) {
                // buying the comic
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../buyComic';
                $('#confirmPageName').text('Il fumetto è stato acquistato?');
            } else if (mode == 1) {
                // removing the comic from the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteComicUser';
                $('#confirmPageName').text('Sei sicuro di voler togliere il fumetto dalla casella?');
            } else if (mode == 2) {
                // removing the follow of the series from the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteSeriesUser';
                $('#confirmPageName').text('Sei sicuro di voler togliere la serie dalla casella?');
            } else if (mode == 3) {
                // restore the follow of the series in the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../restoreSeriesUser';
                $('#confirmPageName').text('Sei sicuro di voler ripristinare la seria nella casella?');
            }
            $('#modal-confirm').modal({
                show: true
            });
        }
    </script>
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
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
    <script>
            $('select#single_series_id').on('change', function () {
                var selected_id = $('select#single_series_id').val();
                if (selected_id == -1){
                    $('select#single_number_id').prop('disabled', 'disabled');
                    $('select#single_number_id').empty();
                    $('#add_single_number').prop('disabled', 'disabled');
                } else {
                    $.ajax({
                        url: '../getNumberFromSeries',
                        type: 'POST',
                        data: {'series_id': selected_id},
                        success: function (data) {
                            $('select#single_number_id').empty();
                            $('select#single_number_id').prop('disabled', false);
                            $('select#single_number_id').append('<option value="-1">-- Seleziona un numero --</option>');
                            $.each(data, function (index,value){
                                $('select#single_number_id').append('<option value="' + value.id + '">' + value.number + '</option>');
                            });
                        },
                        error: function () {
                            $('select#single_number_id').prop('disabled', 'disabled');
                            $('#add_single_number').prop('disabled', 'disabled');
                        }
                    });
                }
            });

            $('select#single_number_id').on('change', function () {
                var selected_id = $('select#single_number_id').val();
                if (selected_id != -1){
                    $('#add_single_number').prop('disabled', false);
                }
            });
    </script>
@stop
