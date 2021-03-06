@section('content')
  @if(count($errors)>0)
    <h3>Whoops! C'è stato un errore!!! <br/>
      Se il problema persiste, contattare un amministratore!</h3>
  @endif
  @if(count($series)>0)
    {{--*/ $col = 6 /*--}}
  @else
    {{--*/ $col = 12 /*--}}
  @endif
  @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
    {{--*/ $color_header = 'warning' /*--}}
  @else
    {{--*/ $color_header = 'default' /*--}}
  @endif
  <div class="row">
    <div class="col-md-{{$col}}">
      <div class="panel panel-{{ $color_header }} no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Casella
          <strong>
            @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
              <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Rinnovo
              Tessera: {{ $renewal_price }} €
            @endif
            @if($user->show_price && $dueG+$dueNG > 0 )

              <div>
                - Saldo disponibili:
                @if($dueG > 0)
                  <div>
                    <label title="guaranteed"
                           class="label label-success no-radius medium-icon little-icon-padding">
                      Garantiti: {{ $dueG }} €
                    </label>
                  </div>
                @endif
                @if($dueNG > 0)
                  <div>
                    <label title="not_guaranteed"
                           class="label label-warning no-radius medium-icon little-icon-padding">
                      Non garantiti: {{ $dueNG }} €
                    </label>
                  </div>
                @endif
                @if($dueG > 0 && $dueNG > 0)
                  <div>
                    <u>Totale</u>: {{ $dueG+$dueNG }} €
                  </div>
                @endif
              </div>
            @endif
          </strong>
        </div>
        @if(count($comics)>0)
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="dataTables-comics">
              <thead>
              <tr>
                <th>Fumetto</th>
                <th>Cover</th>
                @if($user->show_price)
                  <th>Prezzo</th>
                @endif
              </tr>
              </thead>
              <tbody>
              @foreach ($comics as $comic)
                @if ($inv_state == 1)
                  @if ($comic->comic->available > 1)
                    {{--*/ $tr = 'success'; $skip = 0 /*--}}
                  @else
                    {{--*/ $tr = 'odd gradeX'; $skip = 0 /*--}}
                  @endif
                @else
                  @if (($comic->comic->arrived_at > date('Y-m-d',strtotime('-1 month')) && !$comic->old_comic) || $comic->old_arrived_at > date('Y-m-d',strtotime('-1 month')))
                    {{--*/ $tr = 'success'; $skip = 0 /*--}}
                  @else
                    @if (($comic->comic->state == 2 && !$comic->old_comic) || $comic->old_arrived_at != NULL)
                      {{--*/ $tr = 'warning'; $skip = 0 /*--}}
                    @else
                      {{--*/ $tr = 'odd gradeX'; $skip = 1 /*--}}
                    @endif
                  @endif
                @endif
                @if(!$skip)
                  <tr class="{{{ $tr }}}">
                    <td>
                      {{ $comic->comic->series->name}}
                      {{{ ($comic->comic->series->version != null) ? ' - '.$comic->comic->series->version : '' }}}
                      <strong>
                        # {{ $comic->comic->number }}
                      </strong>
                    </td>
                    <td>
                      @if($comic->comic->image)
                        <a href="{{$comic->comic->image}}" target="_blank"><img src="{{$comic->comic->image}}" alt=""
                                                                                class="cover"></a>
                      @endif
                    </td>
                    @if($user->show_price)
                      <td>
                        {{ round($comic->price,2) }} €
                      </td>
                    @endif
                    @endif
                  </tr>
                  @endforeach
              </tbody>
            </table>
            <div class="row">
              <div class="col-xs-12">
                <div class="legend-green col-xs-2"></div>
                Disponibilità garantita - <small><i>uscita da meno di un mese</i></small>
              </div>
              <div class="col-xs-12">
                <div class="legend-yellow col-xs-2"></div>
                Disponibilità non garantita - <small><i>uscita da più di un mese</i></small>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
    @if(count($series)>0)
      <div class="col-md-6">
        <div class="panel panel-default no-radius">
          <div class="panel-heading no-radius">
            <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Serie Seguite
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="dataTables-series">
              <thead>
              <tr>
                <th>Editore</th>
                <th>Nome</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($series as $serie)
                @if ($serie->series->concluded == 1)
                  {{--*/ $tr = 'success' /*--}}
                @else
                  {{--*/ $tr = 'odd GradeX' /*--}}
                @endif
                <tr class="{{$tr}}">
                  <td>{{$serie->series->publisher->name}}</td>
                  <td>{{ $serie->series->name}}
                    {{{ ($serie->series->version != null) ? ' - '.$serie->series->version : '' }}}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
            <div class="row">
              <div class="col-xs-12">
                <div class="legend-green col-xs-2"></div>
                Serie conclusa
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  @include('../layouts/js-include')

  <script>
    $(document).ready(function () {
      $('#dataTables-comics').dataTable({
      "language": {
        "url": "{{ URL::asset('assets/js/dataTables/comic.lang') }}"
      }
    } );
      $('#dataTables-series').dataTable({
      "language": {
        "url": "{{ URL::asset('assets/js/dataTables/series.lang') }}"
      }
    } );
    });
  </script>

  @stop
          <!--TOMU APPROVED! -->