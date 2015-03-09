@section('content')
    @if(count($errors)>0)
      <div class="alert alert-danger error no-radius">
        <h3>Whhops: E' avvenuto un errore!!<br/>
            Se il problema persiste contattare un amministratore</h3>
      </div>
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
                                  <div class="row" >

                                      <div class="col-xs-12">
                                        <div class="legend-red col-xs-2"></div>
                                        Casella non attiva
                                      </div>
                                      <div class="col-xs-12">
                                        <div class="legend-yellow col-xs-2"></div>
                                        Casella da rinnovare
                                      </div>

                                  </div>
                                    <table class="table table-striped table-bordered table-hover"
                                           id="dataTables-boxes">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Casellante</th>
                                            <th>Fumetti</th>
                                            {{--<th>Sconto</th>--}}
                                            <th>Dovuto</th>
                                            {{--<th>Ultimo Acquisto</th>--}}
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
{{--                                                        <td>{{$box->discount}} %</td>--}}
                                                        <td>{{array_get($due,$box->id) != 0 ? number_format((float)array_get($due,$box->id), 2, '.', '') : 0}} €</td>
                                                    @else
                                                        <td>0</td>
{{--                                                        <td>{{$box->discount}} %</td>--}}
                                                        <td>0 €</td>
                                                    @endif
                                                    {{--@if($box->lastBuy->max('buy_time') != null)--}}
                                                        {{--<td>{{date('d/m/Y',strtotime($box->lastBuy->max('buy_time')))}}</td>--}}
                                                    {{--@else--}}
                                                        {{--<td>/</td>--}}
                                                    {{--@endif--}}
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="new">
                            <div>
                                {{ Form::open(array('action' => 'UsersController@create', 'id' => 'new-box', 'class' => 'form-horizontal')) }}
                                <div class="form-group has-feedback">
                                    {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('name', "", array('class' => 'form-control', 'placeholder' => 'Nome del cliente')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    {{ Form::label('surname', 'Cognome', array('class' => 'col-md-2 label-padding', 'aria-describedby' => 'inputSuccess2Status')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('surname', "", array('class' => 'form-control', 'placeholder' => 'Cognome del cliente')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    {{ Form::label('number', 'Numero Casella', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('number', $next_box_id, array('class' => 'form-control', 'placeholder' => 'Numero della casella')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    {{ Form::label('username','Username', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::text('username', "", array('class' => 'form-control', 'placeholder' => 'Email del cliente')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    {{ Form::label('password','Password', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    {{ Form::label('password_confirmation','Conferma Password', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Conferma la password')) }}
                                        <div></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('discount', 'Sconto', array('class' => 'col-md-2 label-padding')) }}
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-addon no-radius" id="basic-addon1">%</span>
                                            {{ Form::text('discount', '10', array('class' => 'form-control', 'placeholder' => 'Percentuale di sconto')) }}
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    {{ Form::submit('Aggiungi', array('class' => 'btn btn-primary no-radius')) }}
                                </div>
                                {{ Form::close() }}
                                <div class="cAlert" id="alert-1">
                                    <div class="alert alert-success success no-radius"></div>
                                    <div class="alert alert-danger error no-radius"></div>
                                </div>
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
          $('#dataTables-boxes').dataTable({
            "language": {
              "url": "{{ URL::asset('assets/js/dataTables/box.lang') }}"
            }
          } );

          $('#new-box').on('submit', function () {
            $('#alert-1').hide();
            $('#alert-1').find('.success').hide();
            $('#alert-1').find('.error').hide();
            $('#alert-1').find('.success').html("");
            $('#alert-1').find('.error').html("");

            //value
            var name = $('#new-box').find('#name').val();
            var surname = $('#new-box').find('#surname').val();
            var number = $('#new-box').find('#number').val();
            var username = $('#new-box').find('#username').val();
            var password = $('#new-box').find('#password').val();
            var password_confirmation = $('#new-box').find('#password_confirmation').val();
            var discount = $('#new-box').find('#discount').val()
            var error_icon ='<span class=\"glyphicon glyphicon-remove form-control-feedback\" aria-hidden=\"true\"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>'
            var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>'
            //submit = true
            var submit = true;
            //start the check!
            //NAME
            var result = checkInputValue(name, "text", 30, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#name').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#name').closest('.form-group').addClass('has-error');
              $('#new-box').find('#name ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "nome",
                maxLength: 30,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#name').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#name').closest('.form-group').addClass('has-success');
              $('#new-box').find('#name ~ div').html(success_icon);
            }

            //SURNAME
            var result = checkInputValue(surname, "text", 30, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#surname').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#surname').closest('.form-group').addClass('has-error');
              $('#new-box').find('#surname ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "cognome",
                maxLength: 30,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#surname').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#surname').closest('.form-group').addClass('has-success');
              $('#new-box').find('#surname ~ div').html(success_icon);
            }

            //NUMBER
            var result = checkInputValue(number, "integer", 11, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#number').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#number').closest('.form-group').addClass('has-error');
              $('#new-box').find('#number ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "numero casella",
                maxLength: 11,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#number').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#number').closest('.form-group').addClass('has-success');
              $('#new-box').find('#number ~ div').html(success_icon);
            }

            //USERNAME
            var result = checkInputValue(username, "email", 128, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#username').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#username').closest('.form-group').addClass('has-error');
              $('#new-box').find('#username ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "am",
                elementName: "username",
                maxLength: 128,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#username').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#username').closest('.form-group').addClass('has-success');
              $('#new-box').find('#username ~ div').html(success_icon);
            }

            //PASSWORD
            var result = checkInputValue(password, "pwd", 30, 8);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#password').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#password').closest('.form-group').addClass('has-error');
              $('#new-box').find('#password ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "f",
                elementName: "password",
                maxLength: 30,
                minLength: 8
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#password').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#password').closest('.form-group').addClass('has-success');
              $('#new-box').find('#password ~ div').html(success_icon);
            }

            //PASSWORD CONFIRMATION
            if (password == password_confirmation){
              var result = checkInputValue(password_confirmation, "pwd", 30, 8);
              if (result['status'] == 'ko') {
                $('#alert-1').show();
                $('#alert-1').find('.error').show();
                $('#new-box').find('#password_confirmation').closest('.form-group').removeClass('has-success');
                $('#new-box').find('#password_confirmation').closest('.form-group').addClass('has-error');
                $('#new-box').find('#password_confirmation ~ div').html(error_icon);

                var obj = {
                  result: result,
                  htmlElement: $('#alert-1').find('.error'),
                  sex: "f",
                  elementName: "conferma della password",
                  maxLength: 30,
                  minLength: 8
                };
                showErrorMsg(obj);
                submit = false;
              } else {
                $('#new-box').find('#password_confirmation').closest('.form-group').removeClass('has-error');
                $('#new-box').find('#password_confirmation').closest('.form-group').addClass('has-success');
                $('#new-box').find('#password_confirmation ~ div').html(success_icon);
              }
            } else {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#password_confirmation').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#password_confirmation').closest('.form-group').addClass('has-error');
              $('#new-box').find('#password_confirmation ~ div').html(error_icon);
              $('#alert-1').find('.error').append('<strong>Attenzione!</strong> La password di conferma inserita è differente dalla password.<br/>');
              submit = false;
            }

            //DISCOUNT
            var result = checkInputValue(discount, "number", 2, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#new-box').find('#discount').closest('.form-group').removeClass('has-success');
              $('#new-box').find('#discount').closest('.form-group').addClass('has-error');
              $('#new-box').find('#discount ~ div').html(error_icon);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "f",
                elementName: "percentuale di sconto",
                maxLength: 2,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#new-box').find('#discount').closest('.form-group').removeClass('has-error');
              $('#new-box').find('#discount').closest('.form-group').addClass('has-success');
              $('#new-box').find('#discount ~ div').html(success_icon);
            }

            if (submit){
              //chiamata ajax
            }
            return submit;
          })
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
@stop