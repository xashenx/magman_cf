@section('content')
    <div class="row">
        <div class="col-md-6">
            <!--    Bordered Table  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Fumetti in arrivo</h5> <strong>(Saldo disponibili: {{ $due }}€)</strong>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Numero</th>
                                <th>Prezzo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($comics as $comic)
                                @if ($comic->comic->available > 1)
                                    <tr class="success">
                                @else
                                    <tr class="odd gradeX">
                                        @endif
                                        <td>{{ $comic->comic->series->name}} - {{ $comic->comic->series->version}}</td>
                                        <td>{{ $comic->comic->number}}</td>
                                        <td>{{ round($comic->price,2) }}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--  End  Bordered Table  -->
        </div>


        <div class="col-md-6">
            <!--    Bordered Table  -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Novità del {{$last}}</h5>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Fumetto</th>
                                <th>Autore</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($news as $new)
                                <tr class="odd gradeX">
                                    @if($new->series->version != null)
                                        <td>{{$new->series->name}} - {{$new->series->version}} nr. {{$new->number}}</td>
                                    @else
                                        <td>{{$new->series->name}} nr. {{$new->number}}</td>
                                    @endif
                                    <td>{{$new->series->author}}</td>
                                </tr>
                                @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--  End  Bordered Table  -->
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
