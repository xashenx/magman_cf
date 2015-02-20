@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="panel panel-default no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuovi Arrivi
      </div>
      <div class="panel-body">
        {{ Form::open(array('action' => 'ComicsController@loadShipment', 'class' => 'form-horizontal')) }}
          <div class="form-group">
            {{ Form::label('series_id', 'Fumetto', array('class' => 'col-md-2 label-padding')) }}
            <div class="col-md-10">
              <select name="series_id" id="series_id" class="form-control">
                <option value="-1" selected>-- Seleziona una serie --</option>
                @foreach($active_series as $serie)
                  <option value="{{ $serie->id }}" rel="{{ $serie->name }}">
                    {{ $serie->name }}
                    {{{ ($serie->version != null) ?  ' - '.$serie -> version : ''}}}
                  </option>
                @endforeach
              </select>
            </div>
            @foreach($errors->get('comic_id') as $message)
              {{$message}}
            @endforeach
          </div>
          <div class="form-group">
            {{ Form::label('comic_id', 'Numero', array('class' => 'col-md-2 label-padding')) }}
            <div class="col-md-10">
              <select name="comic_id" id="comic_id" class="form-control" disabled>
              </select>
            </div>
          </div>
          @if($inv_state == 1)
            <div class="form-group">
              {{ Form::label('amount', 'Quantità', array('class' => 'col-md-1 label-padding')) }}
              <div class="col-md-11">
                {{ Form::text('amount', '', array('class' => 'form-control')) }}
              </div>
              @foreach($errors->get('amount') as $message)
                {{$message}}
              @endforeach
            </div>
          @endif
          <div class="form-group">
            {{ Form::submit('Carica',['id' => 'load_comic','disabled' => 'disabled', 'class' => 'btn btn-primary button-margin no-radius']) }}
          </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@include('../layouts/js-include')

<script>
  $('select#series_id').on('change', function () {
    var selected_id = $('select#series_id').val();
    if (selected_id == -1) {
      $('select#comic_id').prop('disabled', 'disabled');
      $('select#comic_id').empty();
      $('#load_comic').prop('disabled', 'disabled');
    } else {
      $.ajax({
        url: 'getNewNumbersFromSeries',
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

@if($inv_state == 0)
  $('select#comic_id').on('change', function () {
    var selected_id = $('select#comic_id').val();
    if (selected_id != -1) {
      $('#load_comic').prop('disabled', false);
    }
  });
@endif

@if($inv_state == 1)
  $('#amount').on('change', function () {
    var first_selected_id = $('select#series_id').val();
    var second_selected_id = $('select#comic_id').val();
    if(first_selected_id != -1 && second_selected_id != -1)
      $('#load_comic').prop('disabled', false);
  });
@endif

</script>

@stop
<!--TOMU APPROVED! -->