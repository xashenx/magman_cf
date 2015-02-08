@section('content')
<div class="row">
  @if(count($news)!=null)
    {{--*/ $col = 6 /*--}}
  @else
    {{--*/ $col = 12 /*--}}
  @endif
  <div class="col-md-{{$col}}">
    <div class="panel panel-default no-radius">
      <div class="panel-heading no-radius">
        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Fumetti in arrivo
        <strong>
          @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
            - Rinnovo Tessera; {{ $renewal_price }}€
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
  @if(count($news)!=0)
    <div class="col-md-6">
      <div class="panel panel-info no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> Novità della Settimana
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-hover" id="dataTables-news">
            <thead>
              <tr>
                <th>Fumetto</th>
                <th>Autore</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($news as $new)
                <tr class="odd gradeX">
                  <td>
                    {{$new->series->name}}
                    {{{ ($new->series->version != null) ? ' - '.$new->series->version : ' ' }}}
                    <strong>
                      # {{$new->number}}
                    </strong>
                  </td>
                  <td>
                    {{$new->series->author}}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endif
</div>

@include('../layouts/js-include')

<script>
  $(document).ready(function () {
    $('#dataTables-comics').dataTable();
    $('#dataTables-news').dataTable();
  });
</script>

@stop
<!--TOMU APPROVED! -->