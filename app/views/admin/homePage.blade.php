@section('content')
  <div class="row">
    @if(count($insolvents) > 0 || count($defaultings) > 0 || count($abb_carts) > 0)
      {{--*/ $col = 6 /*--}}
    @else
      {{--*/ $col = 12 /*--}}
    @endif
    <div class="col-md-{{ $col }} col-sm-{{ $col }}">
      <div class="panel panel-info no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Fumetti ordinati da clienti
        </div>
        <div class="panel-body">
          @if(count($to_order) > 0)
            <table class="table table-striped table-bordered table-hover" id="dataTables-comics">
              <thead>
              <tr>
                <th>Fumetto</th>
                <th>Editore</th>
                <th>Cover</th>
                <th>Richiesta</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($to_order as $order)
                @if($order->need > 0)
                  <tr class="odd gradeX">
                    <td>
                      <a href="series/{{$order->sid}}/{{$order->cid}}">
                        {{$order->name}}
                        {{{ ($order->version != null) ? ' - '.$order->version : ' ' }}}
                        #{{$order->number}}
                      </a>
                    </td>
                    <td>{{$order->publisher}}</td>
                    <td>
                      @if($order->image)
                        <a href="{{$order->image}}" target="_blank"><img src="{{$order->image}}" alt=""
                                                                         class="cover"></a>
                      @endif
                    </td>
                    <td>
                      {{$order->need}}
                    </td>
                  </tr>
                @endif
              @endforeach
              </tbody>
            </table>
          @else
            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
            Non ci sono fumetti da ordinare!
            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
          @endif
        </div>
      </div>
    </div>
    @if(count($insolvents) > 0 || count($defaultings) > 0 || count($abb_carts) > 0)
      <div class="col-md-6 col-sm-6">
        <div class="panel panel-warning no-radius">
          <div class="panel-heading no-radius">
            <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> Warning Caselle
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="dataTables-warning">
              <thead>
              <tr>
                <th>Casellante</th>
                <th>Motivo del warning</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($abb_carts as $key => $cart)
                <tr class="odd gradeX">
                  <td>
                    {{User::find($key)->name}} {{User::find($key)->surname}}
                  </td>
                  <td>
                    <a href="cart/{{$key}}">Carrello attivo! ({{Cart::instance($key)->count()}} fumetto)</a>
                  </td>
                </tr>
              @endforeach
              @foreach ($insolvents as $key => $insolvent)
                <tr class="odd gradeX">
                  <td>
                    <a href="boxes/{{array_get($insolventBoxes,$key)->id}}">
                      {{array_get($insolventBoxes,$key)->name}}
                      {{array_get($insolventBoxes,$key)->surname}}
                    </a>
                  </td>
                  <td>
                    {{$insolvent}}
                  </td>
                </tr>
              @endforeach
              @foreach ($defaultings as $key => $defaulting)
                <tr class="odd gradeX">
                  <td>
                    <a href="boxes/{{array_get($defaultingBoxes,$key)->id}}">
                      {{array_get($defaultingBoxes,$key)->name}}
                      {{array_get($defaultingBoxes,$key)->surname}}</a>
                  </td>
                  <td>
                    {{$defaulting}}
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
      $('#dataTables-warning').dataTable({
        "language": {
          "url": "{{ URL::asset('assets/js/dataTables/box.lang') }}"
        }
      });
    });
  </script>

  @stop
          <!--TOMU APPROVED! -->