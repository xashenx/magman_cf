@section('content')
@if(count($errors)>0)
  <h3>Whoops! C'è stato un errore!!! <br/>
    Se il problema persiste, contattare un amministratore!</h3>
@endif
<div class="row">
  <div class="col-md-6">
    <div class="panel panel-default no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Fumetti in arrivo
        <strong>
          @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
          - Rinnovo Tessera; {{ $renewal_price }}€<br/>
          @endif
          - Saldo disponibili: {{ $due }}€
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-hover" id="dataTables-comics">
          <thead>
            <tr>
              <th>Serie</th>
              <th>Numero</th>
              <th>Prezzo</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($comics as $comic)
              @if ($inv_state == 1)
                @if ($comic->comic->available > 1)
                  {{--*/ $tr = 'success' /*--}}
                @else
                  {{--*/ $tr = 'odd gradeX' /*--}}
                @endif
              @else
                @if ($comic->comic->arrived_at > date('Y-m-d',strtotime('-1 month')))
                  {{--*/ $tr = 'success' /*--}}
                @else
                  @if ($comic->comic->state == 2)
                    {{--*/ $tr = 'warning' /*--}}
                  @else
                    {{--*/ $tr = 'odd gradeX' /*--}}
                  @endif
                @endif
              @endif
              <tr class="{{{ $tr }}}">
                <td>
                  {{ $comic->comic->series->name}}
                  {{{ ($comic->comic->series->version != null) ? ' - '.$comic->comic->series->version : '' }}}
                </td>
                <td>
                  {{ $comic->comic->number}}
                </td>
                <td>
                  {{ round($comic->price,2) }} €
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <div class="col-md-6">
    <div class="panel panel-default no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Serie Seguite
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered table-hover" id="dataTables-series">
          <thead>
            <tr>
              <th>Serie</th>
              <th>Versione</th>
              <th>Autore</th>
              <th>Numeri Usciti</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($series as $serie)
              @if ($serie->series->concluded == 1)
                {{--*/ $tr = 'success' /*--}}
              @else
                {{--*/ $tr = 'odd gradeX' /*--}}
              @endif
              <tr class="{{$tr}}">
                <td>{{$serie->series->name}}</td>
                <td>{{$serie->series->version}}</td>
                <td>{{$serie->series->author}}</td>
                <td>
                  {{($serie->series->listActive->max('number') != null) ? $serie->series->listActive->max('number') : '0'}}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@include('../layouts/js-include')

<script>
  $(document).ready(function() {
    $('#dataTables-comics').dataTable();
    $('#dataTables-series').dataTable();
  });
</script>

@stop
<!--TOMU APPROVED! -->