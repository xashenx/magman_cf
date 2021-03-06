@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5>Visualizza/Modifica Serie</h5>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#details" data-toggle="tab">Dettagli</a>
                        </li>
                        <li class="">
                            <a href="#numbers" data-toggle="tab">Numeri</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <!-- <h4>Details Tab</h4> -->
                            <p>
                                Nome: {{$series->name}}
                                <br/>
                                Versione: {{$series->version}}
                                <br/>
                                Autore: {{$series->author}}
                                <br/>
                                Numeri usciti: {{$series->listComics->max('number')}}
                                <br/>
                                @if($series->conclusa)
                                    Stato: Conclusa
                                    <br/>
                                @endif
                            </p>
                        </div>
                        <div class="tab-pane fade" id="numbers">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive table-bordered">
                                        <table class="table table-striped table-bordered table-hover"
                                               id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>Numero</th>
                                                <th>Nome</th>
                                                <th>Prezzo</th>
                                                <th>Disponibilità</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($comics as $comic)
                                                <tr class="odd gradeX">
                                                    <td>{{$comic->number}}</td>
                                                    <td>{{$comic->name}}</td>
                                                    <td>{{round($comic->price,2)}}</td>
                                                    <td>{{$comic->available}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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