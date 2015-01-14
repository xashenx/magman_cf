@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Nuovi Arrivi
                </div>
                <div class="panel-body">
                    {{ Form::open(array('action' => 'ComicsController@loadShipment')) }}
                    <div>
                        {{ Form::label('comic_id', 'Fumetto') }}
                        <select name="series_id" id="series_id">
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
                        @foreach($errors->get('comic_id') as $message)
                            {{$message}}
                        @endforeach
                    </div>
                    <div>
                        {{ Form::label('number', 'Numero') }}
                        <select name="comic_id" id="comic_id" disabled>
                        </select>
                    </div>
                    <div>
                        {{ Form::label('amount', 'Quantità') }}
                        {{ Form::text('amount') }}
                        @foreach($errors->get('amount') as $message)
                            {{$message}}
                        @endforeach
                    </div>
                    <div>
                        {{ Form::submit('Carica',['id' => 'load_comic','disabled' => 'disabled']) }}
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
    <!-- CUSTOM SCRIPTS -->
    <script>
        $('select#series_id').on('change', function () {
            var selected_id = $('select#series_id').val();
            if (selected_id == -1) {
                $('select#comic_id').prop('disabled', 'disabled');
                $('select#comic_id').empty();
                $('#load_comic').prop('disabled', 'disabled');
            } else {
                $.ajax({
                    url: 'getNumberFromSeries',
                    type: 'POST',
                    data: {'series_id': selected_id},
                    success: function (data) {
                        $('select#comic_id').empty();
                        $('select#comic_id').prop('disabled', false);
                        $('select#comic_id').append('<option value="-1">-- Seleziona un numero --</option>');
                        $.each(data, function (index, value) {
                            $('select#comic_id').append('<option value="' + value.id + '">' + value.number + '</option>');
                        });
                    },
                    error: function () {
                        $('select#comic_id').prop('disabled', 'disabled');
                        $('#load_comic').prop('disabled', 'disabled');
                    }
                });
            }
        });

        $('select#comic_id').on('change', function () {
            var selected_id = $('select#comic_id').val();
            if (selected_id != -1) {
//                $('#load_comic').prop('disabled', false);
            }
        });

        $('#amount').on('change', function () {
            var first_selected_id = $('select#series_id').val();
            var second_selected_id = $('select#comic_id').val();
            if(first_selected_id != -1 && second_selected_id != -1)
                $('#load_comic').prop('disabled', false);
        });
    </script>
@stop