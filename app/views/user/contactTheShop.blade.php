@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h5>Contatta lo Shop</h5>
                </div>
                <div class="panel-body">
                    <h6>Tramite questo form potrai contattare il negoziante.<br />
                    Scrivi il tuo messaggio nel campo sottostante e il sistema lo invierà al proprietario che ti risponderà non appena possibile!</h6>
                    {{ Form::open(array('action' => 'MailController@mailToShop')) }}
                    <div>
                        {{ Form::textarea('message') }}
                    </div>
                    <div>
                        {{ Form::submit('Invia mail') }}
                    </div>
                    {{ Form::close() }}
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
@stop
