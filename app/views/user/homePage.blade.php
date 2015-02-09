@section('content')
  <div class="row">
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
              @endif
              @if($user->show_price && $due > 0 )
                <br/>
                - Saldo disponibili: {{ $due }} €
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
                          <a href="{{$comic->comic->image}}" target="_blank"><img src="{{$comic->comic->image}}" alt="" height="42" width="42"></a>
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
      $('#dataTables-comics').dataTable();
      $('#dataTables-news').dataTable();
    });
  </script>

  @stop
          <!--TOMU APPROVED! -->