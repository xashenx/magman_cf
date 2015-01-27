@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
        {{ $errors->first('name') }}
        {{ $errors->first('surname') }}
        {{ $errors->first('username') }}
        {{ $errors->first('password') }}
        {{ $errors->first('number') }}
        {{ $errors->first('discount') }}
    @endif
    {{ date('Y-m-d',strtotime('now')) }}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Gestione Caselle</h1>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#boxes" data-toggle="tab">Caselle</a>
                        </li>
                        <li class="">
                            <a href="#new" data-toggle="tab">Nuova Casella</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="boxes">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Caselle inserite nel sistema</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                           id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th># Casella</th>
                                            <th>Casellante</th>
                                            <th>Fumetti disponibili</th>
                                            <th>Scontistica</th>
                                            <th>Dovuto sul disponibile</th>
                                            <th>Ultimo Acquisto</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($boxes as $box)
                                            @if($box->active)
                                                @if(date('Y-m-d', strtotime($box->shop_card_validity)) < date('Y-m-d',strtotime('now')))
                                                    <tr class="odd warning">
                                                @else
                                                    <tr class="odd gradeX">
                                                @endif
                                            @else
                                                <tr class="danger">
                                                    @endif
                                                    <td>{{$box->number}}</td>
                                                    <td>
                                                        <a href="boxes/{{$box->id}}">{{$box->name}} {{$box->surname}}</a>
                                                    </td>
                                                    @if (count($box->availableComics) > 0)
                                                        <td>{{array_get($available,$box->id)}}</td>
                                                        <td>{{$box->discount}}</td>
                                                        <td>{{array_get($due,$box->id)}}</td>
                                                    @else
                                                        <td>0</td>
                                                        <td>{{$box->discount}}</td>
                                                        <td>0</td>
                                                    @endif
                                                    @if($box->lastBuy->max('buy_time') != null)
                                                        <td>{{date('d/m/Y',strtotime($box->lastBuy->max('buy_time')))}}</td>
                                                    @else
                                                        <td>/</td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="new">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Inserimento Nuova Casella</h5>
                                </div>
                                {{ Form::open(array('action' => 'UsersController@create')) }}
                                <div>
                                    {{ Form::label('name', 'Nome') }}
                                    {{ Form::text('name') }}
                                </div>
                                <div>
                                    {{ Form::label('surname', 'Cognome') }}
                                    {{ Form::text('surname') }}
                                </div>
                                <div>
                                    {{ Form::label('number', 'Numero Casella') }}
                                    {{ Form::text('number', $next_box_id) }}
                                </div>
                                <div>
                                    {{ Form::label('username','Username') }}
                                    {{ Form::text('username') }}
                                </div>
                                <div>
                                    {{ Form::label('password','Password') }}
                                    {{ Form::password('password') }}
                                </div>
                                <div>
                                    {{ Form::label('password_confirmation','Conferma Password') }}
                                    {{ Form::password('password_confirmation') }}
                                </div>
                                <div>
                                    {{ Form::label('discount', 'Sconto') }}
                                    {{ Form::text('discount', '10') }}
                                </div>
                                <div>
                                    {{ Form::submit('Aggiungi') }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery.js"></script>
    <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
@stop