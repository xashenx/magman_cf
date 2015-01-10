@section('content')
    <div class="row">
        <div>
            @if(count($insolvents) > 0 || count($defaultings) > 0)
                <div class="col-md-6 col-sm-6">
                    @else
                        <div class="col-md-8 col-sm-8">
                            @endif
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Fumetti mancanti
                                </div>
                                <div class="panel-body">
                                    @if(count($to_order) > 0)
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="dataTables-example">
                                                <thead>
                                                <tr>
                                                    <th>Fumetto</th>
                                                    <th>Richiesta</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($to_order as $order)
                                                    @if($order->need > 0)
                                                        <tr class="odd gradeX">
                                                            @if($order->version == null)
                                                                <td>
                                                                    <a href="series/{{$order->sid}}/{{$order->cid}}">{{$order->name}}
                                                                        nr. {{$order->number}}</a></td>
                                                            @else
                                                                <td>
                                                                    <a href="series/{{$order->sid}}/{{$order->cid}}">{{$order->name}}
                                                                        - {{$order->version}} nr. {{$order->number}}</a>
                                                                </td>
                                                            @endif
                                                            <td>{{$order->need}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <h4>Non ci sono fumetti da ordinare!</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(count($insolvents) > 0 || count($defaultings) > 0)
                            <div class="col-md-6 col-sm-6">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        Warning Caselle
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive table-bordered">
                                            <table class="table table-striped table-bordered table-hover"
                                                   id="dataTables-example">
                                                <thead>
                                                <tr>
                                                    <th>Casellante</th>
                                                    <th>Motivo del warning</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($insolvents as $key => $insolvent)
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <a href="boxes/{{array_get($insolventBoxes,$key)->id}}">{{array_get($insolventBoxes,$key)->name}} {{array_get($insolventBoxes,$key)->surname}}</a>
                                                        </td>
                                                        <td>{{$insolvent}}</td>
                                                    </tr>
                                                @endforeach
                                                @foreach ($defaultings as $key => $defaulting)
                                                    <tr class="odd gradeX">
                                                        <td>
                                                            <a href="boxes/{{array_get($defaultingBoxes,$key)->id}}">{{array_get($defaultingBoxes,$key)->name}} {{array_get($defaultingBoxes,$key)->surname}}</a>
                                                        </td>
                                                        <td>{{$defaulting}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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
        <script src="assets/js/custom.js"></script>
@stop
