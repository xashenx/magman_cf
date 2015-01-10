@section('content')
    {{ var_dump($errors) }}
    {{ sizeof($errors) }}
    @if(array_has($errors,'test'))
        chumbawamba
    @endif
    @foreach($errors as $message)
        asdasdasd
        {{ $message }}
    @endforeach
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>Profilo Utente</h5>
                </div>
                <div class="panel-body">
                    {{ Form::model($user, array('action' => 'UsersController@changePassword')) }}
                    <div>
                        {{ Form::label('old_pass', 'Password attuale') }}
                        {{ Form::password('old_pass') }}
                        {{ Form::hidden('id') }}
                    </div>
                    <div>
                        {{ Form::label('pass_confirmation', 'Conferma Password') }}
                        {{ Form::password('pass_confirmation') }}
                    </div>
                    <div>
                        {{ Form::label('pass', 'Nuova Password') }}
                        {{ Form::password('pass') }}
                    </div>
                    <div>
                        {{ Form::submit('Aggiorna') }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
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
        });
    </script>
    <!-- CUSTOM SCRIPTS -->
    <script src="../assets/js/custom.js"></script>
@stop
