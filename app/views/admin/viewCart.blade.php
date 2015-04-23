@section('content')
  @if(count($errors)>0)
    <div class="alert alert-danger error no-radius">
      <h3>Whhops: E' avvenuto un errore!!<br/>
        Se il problema persiste contattare un amministratore</h3>
    </div>
  @endif
  <div class="row">
    <div class="col-md-12">
      <!-- Advanced Tables -->
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Carrello
          di {{$user->name}} {{$user->surname}}
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-hover"
                 id="dataTables-series">
            <thead>
            <tr>
              <th>Fumetto</th>
              <th>Prezzo</th>
              <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            @foreach(Cart::instance($user->id)->content() as $row)
              <tr>
                <td>{{$row->name}}</td>
                <td>{{$row->price}}</td>
                <td>
                  <button type="button" title="Rimuovi dal carrello"
                          onclick="quickActionWithoutConfirm({{$row->id}},{{$user->id}},0)"
                          class="btn btn-danger btn-sm no-radius medium-icon">
                                                            <span class="glyphicon glyphicon-shopping-cart"
                                                                  aria-hidden="true"></span>
                  </button>
                </td>
              </tr>
            @endforeach
            <tr align="center">
              <td colspan="3">
                    <strong>TOTALE: {{Cart::instance($user->id)->total()}}€</strong>
              </td>
            </tr>
            </tbody>
          </table>
          <div class="row">
            <div class="col-sm-12 text-center">
              <button type="button" title="Rimuovi dal carrello"
                      onclick="quickActionWithoutConfirm({{$user->id}},{{$user->id}},1)"
                      class="btn btn-success btn-sm no-radius">Conferma Acquisto</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('../layouts/js-include')
  <!--TOMU APPROVED! -->
  <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
          </button>
          <h3 class="modal-title">Conferma azione</h3>
        </div>
        <div class="modal-body">
          <p id="confirmPageName" class="text-danger"></p>
        </div>
        <div class="modal-footer">
          {{ Form::open(array('name' => 'confirmForm')) }}
          {{ Form::hidden('id') }}
          {{ Form::hidden('user_id') }}
          {{ Form::hidden('path') }}
          {{ Form::button('Annulla', array(
          'data-dismiss' => 'modal',
          'class' => 'btn btn-danger btn-sm')) }}
          {{ Form::submit('Confermo', array('class' => 'btn btn-danger btn-sm',)) }}
          {{ Form::close() }}
        </div>
      </div>
      {{-- /.modal-content --}}
    </div>
    {{-- /.modal-dialog --}}
  </div>
  {{-- /.modal --}}
  <!-- CUSTOM SCRIPTS -->
  <script>
    function quickActionWithoutConfirm(object_id, user_id, mode) {
      document.confirmForm.user_id.value = user_id;
      document.confirmForm.path.value = 'cart';
      if (mode == 0) {
        // remove a comic from the cart
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../removeFromCart';
        document.confirmForm.submit();
      } else if (mode == 1) {
        // confirm of the cart
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../confirmCart';
        document.confirmForm.submit();
      }
    }
  </script>
@stop