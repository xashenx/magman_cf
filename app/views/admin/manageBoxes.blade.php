@section('content')
    @if(count($errors)>0)
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default no-radius">
                <div class="panel-heading no-radius">
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Gestione Caselle
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs margin-bottom">
                        <li class="active">
                            <a href="#boxes" data-toggle="tab">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                <span class="titoli-tab">Caselle</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#new" data-toggle="tab">
                                <span class="glyphicon glyphicon-certificate" aria-hidden="true"></span>
                                <span class="titoli-tab">Nuova Casella</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="boxes">
                            <div>

                                <div>
                                    <table class="table table-striped table-bordered table-hover"
                                           id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Casellante</th>
                                            <th>Fumetti</th>
                                            <th>Sconto</th>
                                            <th>Dovuto</th>
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
                                                        <td>{{$box->discount}} %</td>
                                                        <td>{{array_get($due,$box->id)}} €</td>
                                                    @else
                                                        <td>0</td>
                                                        <td>{{$box->discount}} %</td>
                                                        <td>0 €</td>
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
                            <div>
                                {{ Form::open(array('action' => 'UsersController@create', 'class' => 'form-horizontal')) }}
                                <div class="form-group">
                                    {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('name', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('surname', 'Cognome', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('surname', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('number', 'Numero Casella', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('number', $next_box_id, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('username','Username', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('username', "", array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password','Password', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::password('password', array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('password_confirmation','Conferma Password', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('discount', 'Sconto', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-addon no-radius" id="basic-addon1">%</span>
                                            {{ Form::text('discount', '10', array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    {{ Form::submit('Aggiungi', array('class' => 'btn btn-primary no-radius')) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('../layouts/js-include')
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
@stop