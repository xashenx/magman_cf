@section('content')
  <div class="row">
    @if(Auth::user()->notes)
    <div class="col-md-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          Messaggi dal negoziante
        </div>
          <div class="panel-body">
            {{ nl2br(Auth::user()->notes) }}
          </div>
      </div>
    </div>
    @endif
    @if(count($news)!=null && (count($comics)>0 || date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now'))))
      {{--*/ $col = 6 /*--}}
    @else
      {{--*/ $col = 12 /*--}}
    @endif
    @if(count($comics)>0 || date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
      <div class="col-md-{{$col}}">
        <div class="panel panel-default no-radius">
          <div class="panel-heading no-radius">
            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Casella
            <strong>
              @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
                <br/>
                - <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Rinnovo
                Tessera: {{ $renewal_price }} € <span class="glyphicon glyphicon-warning-sign"
                                                      aria-hidden="true"></span>
                <br/>
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
              <div class="row">
                <div class="col-xs-12">
                  <div class="legend-green col-xs-2"></div>
                  Disponibilità garantita -
                  <small><i>uscita da meno di un mese</i></small>
                </div>
                <div class="col-xs-12">
                  <div class="legend-yellow col-xs-2"></div>
                  Disponibilità non garantita -
                  <small><i>uscita da più di un mese</i></small>
                </div>
              </div>
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
                    @if ($comic->comic->arrived_at > date('Y-m-d',strtotime('-1 month')))
                      {{--*/ $tr = 'success'; $skip = 0 /*--}}
                    @else
                      @if ($comic->comic->state == 2)
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
                                                                                  height="42" width="42"></a>
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
            </div>
          @endif
        </div>
      </div>
    @endif
    @if(count($news)!=0)
      <div class="col-md-{{$col}}">
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
                <th>Cover</th>
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
                  <td>
                    @if($new->image)
                      <a href="{{$new->image}}" target="_blank"><img src="{{$new->image}}" alt="" height="42" width="42"
                                ></a>
                    @endif
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
      $('#dataTables-comics').dataTable({
        "language": {
          "url": "{{ URL::asset('assets/js/dataTables/comic.lang') }}"
        }
      });
      $('#dataTables-news').dataTable({
        "language": {
          "url": "{{ URL::asset('assets/js/dataTables/comic.lang') }}"
        }
      });
    });
  </script>

  @stop
          <!--TOMU APPROVED! -->