@section('content')
  @if(count($errors)>0)
    <h3>Whoops! C'è stato un errore!!! <br/>
    Se il problema persiste, contattare un amministratore!</h3>
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          Casella {{$user->number}}: {{$user -> name}} {{$user->surname}}
          @if($user->active)
            @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
              <button type="button" title="Rinnova Tessera" onclick="showConfirmModal({{$user->id}},0,6)"
                class="btn btn-warning btn-xs no-radius little-icon little-icon-padding"><i
                  class="fa fa-recycle"></i>
              </button>
            @endif
              <button type="button" title="Disattiva casella"
              onclick="showConfirmModal({{$user->id}},0,4)"
              class="btn btn-danger btn-xs no-radius little-icon"><i
              class="fa fa-remove"></i>
              </button>

          @else
            <button type="button" title="Riattiva casella"
            onclick="showConfirmModal({{$user->id}},0,5)"
            class="btn btn-success btn-sm no-radius little-icon"><i
            class="fa fa-thumbs-o-up"></i>
            </button>
          @endif
          (<i>Saldo</i> : {{ $due }}€)
        </div>
        <div class="panel-body">
          <ul class="nav nav-tabs margin-bottom">
            {{--*/ $active = 'active' /*--}}
            @if($user->active)
              @if (count($comics) > 0)
                <li class="{{ $active }}">
                  <a href="#orderedComics" data-toggle="tab">In arrivo</a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              @if(count($series)>0)
                <li class="{{ $active }}">
                  <a href="#series" data-toggle="tab">Serie Seguite</a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              @if(count($user->availableVouchers)>0)
                <li class="{{ $active }}">
                  <a href="#vouchers" data-toggle="tab">Buoni</a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              <li class="{{ $active }}">
                <a href="#newseries" data-toggle="tab">Nuova Serie</a>
              </li>
              {{--*/ $active = '' /*--}}
              <li class="">
                <a href="#newsinglecomic" data-toggle="tab">Nuovo Arretrato/Singolo</a>
              </li>
              <li class="">
                <a href="#newvoucher" data-toggle="tab">Aggiungi Buono</a>
              </li>
              {{-- <li class=""><a href="#details" data-toggle="tab">Dettagli</a></li> --}}

            @endif
            <li class="{{ $active }}">
              <a href="#contact" data-toggle="tab">Contatta</a>
            </li>
            <li class="">
             <a href="#edit" data-toggle="tab">Modifica</a>
            </li>
            {{--@if(count($purchases)>0)--}}
            {{--<li class="">--}}
            {{--<a href="#purchases" data-toggle="tab">Storico Acquisti</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--<li class=""><a href="#edit" data-toggle="tab">Modifica</a></li>--}}
          </ul>
          <div class="tab-content">
            @if($user->active)
              {{--*/ $active = 'active in' /*--}}
              @if(count($comics)>0)
                <div class="tab-pane fade {{{ $active }}}" id="orderedComics">
                  <table
                    class="table table-striped table-bordered table-hover"
                    id="dataTables-comics">
                    <thead>
                      <tr>
                        <th>Serie</th>
                        <th>Prezzo</th>
                        <th>Azioni Rapide</th>
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
                            <a href="{{$user->id}}/comic/{{$comic->id}}">
                              {{ $comic->comic->series->name}}
                              {{{ isset($comic->comic->series->version) ? ' - '.$comic->comic->series->version : '' }}}
                              # {{ $comic->comic->number}}
                            </a>
                          </td>

                          <td>{{ round($comic->price,2) }}</td>
                          <td>
                            @if($comic->comic->state == 2)
                              <button type="button" title="Acquista"
                                onclick="showConfirmModal({{$comic->id}},{{$user->id}},0)"
                                class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                <span class="glyphicon glyphicon-euro" aria-hidden="true"></span>
                              </button>
                            @endif
                            <button type="button" title="Rimuovi"
                              onclick="showConfirmModal({{$comic->id}},{{$user->id}},1)"
                              class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                            {{--<div class="btn-group">--}}
                            {{--<button data-toggle="dropdown"--}}
                            {{--class="btn btn-primary dropdown-toggle">--}}
                            {{--Azioni <span class="caret"></span>--}}
                            {{--</button>--}}
                            {{--<ul class="dropdown-menu">--}}
                            {{--<li>--}}
                            {{--@if($comic->comic->available > 0)--}}
                            {{--<a href="#"--}}
                            {{--onclick="showConfirmModal({{$comic->id}},{{$user->id}},0)">Acquistato</a>--}}
                            {{--@endif--}}
                            {{--<a href="#"--}}
                            {{--onclick="showConfirmModal({{$comic->id}},{{$user->id}},1)">Rimuovi</a>--}}
                            {{--</li>--}}
                            {{--</ul>--}}
                            {{--</div>--}}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{--*/ $active = '' /*--}}
              @endif

              @if(count($series)>0)
                <div class="tab-pane fade {{{ $active }}}" id="series">
                  <table class="table table-striped table-bordered table-hover"
                    id="dataTables-series">
                    <thead>
                      <tr>
                        <th>Serie</th>
                        <th>Autore</th>
                        <th>Numeri Usciti</th>
                        <th>Azioni Rapide</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($series as $serie)
                        @if ($serie->series->concluded)
                          {{--*/ $tr = 'success' /*--}}
                        @elseif($serie->active)
                          {{--*/ $tr = 'odd gradeX' /*--}}
                        @else
                          {{--*/ $tr = 'danger' /*--}}
                        @endif
                        <tr class="{{{ $tr }}}">
                          <td>
                            {{$serie->series->name}}
                            {{{ ($serie->series->version != null) ? ' - '.$serie->series->version : '' }}}
                          </td>
                          <td>
                            {{$serie->series->author}}
                          </td>
                          <td>
                            {{count($serie->series->listComics)}}
                          </td>
                          <td>
                            @if(!$serie->series->concluded)
                              @if($serie->active)
                                <button type="button" title="Abbandona"
                                  onclick="showConfirmModal({{$serie->id}},{{$user->id}},2)"
                                  class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                                  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </button>
                              @elseif($serie->series->active)
                                <button type="button" title="Segui"
                                  onclick="showConfirmModal({{$serie->id}},{{$user->id}},3)"
                                  class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                  <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                </button>
                              @endif
                              {{--<div class="btn-group">--}}
                              {{--<button data-toggle="dropdown"--}}
                              {{--class="btn btn-primary dropdown-toggle">--}}
                              {{--Azioni <span class="caret"></span>--}}
                              {{--</button>--}}
                              {{--<ul class="dropdown-menu">--}}
                              {{--<li>--}}
                              {{--@if($serie->active)--}}
                              {{--<a href="#"--}}
                              {{--onclick="showConfirmModal({{$serie->id}},{{$user->id}},2)">Abbandona</a>--}}
                              {{--@else--}}
                              {{--<a href="#"--}}
                              {{--onclick="showConfirmModal({{$serie->id}},{{$user->id}},3)">Segui</a>--}}
                              {{--@endif--}}
                              {{--</li>--}}
                              {{--</ul>--}}
                              {{--</div> --}}
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{--*/ $active = '' /*--}}
              @endif

              @if(count($user->availableVouchers)>0)
                <div class="tab-pane fade {{{ $active }}}" id="vouchers">
                  <table class="table table-striped table-bordered table-hover"
                    id="dataTables-vouchers">
                    <thead>
                      <tr>
                        <th>Descrizione</th>
                        <th>Valore</th>
                        <th>Azioni</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($user->availableVouchers as $voucher)
                        <tr class="odd gradeX">
                          <td>{{$voucher->description}}</td>
                          <td>{{$voucher->amount}}</td>
                          <td>
                            <button type="button" title="Usa"
                              onclick="showConfirmModal({{$voucher->id}},{{$user->id}},7)"
                              class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                              <span class="glyphicon glyphicon-euro" aria-hidden="true"></span>
                            </button>
                            <button type="button" title="Rimuovi"
                              onclick="showConfirmModal({{$voucher->id}},{{$user->id}},8)"
                              class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                {{--*/ $active = '' /*--}}
              @endif

              <div class="tab-pane fade {{{ $active }}}" id="newseries">
                {{ Form::open(array('action' => 'SeriesUserController@create', 'class' => 'form-horizontal')) }}
                  <div class="form-group">
                    {{ Form::label('series_id', 'Serie', array('class' => 'col-md-1 label-padding')) }}
                    <div class="col-md-11">
                      <select name="series_id" id="series_id" class="form-control">
                        @foreach($active_series as $serie)
                          <option value="{{ $serie->id }}"
                            rel="{{ $serie->name }}">
                            {{ $serie->name }}
                            {{{ ($serie->version != null) ? ' - '.$serie->version : '' }}}
                          </option>
                        @endforeach
                      </select>
                      {{ Form::hidden('user_id', $user->id) }}
                    </div>
                  </div>
                  <div class="form-group">
                    {{ Form::submit('Aggiungi', array('class' => 'btn btn-primary button-margin no-radius')) }}
                  </div>
                {{ Form::close() }}
              </div>

              <div class="tab-pane fade" id="newsinglecomic">
                {{ Form::open(array('action' => 'ComicUserController@create', 'class' => 'form-horizontal')) }}
                  <div class="form-group">
                    {{ Form::label('single_series_id', 'Serie', array('class' => 'col-md-1 label-padding')) }}
                    <div class="col-md-11">
                      <select name="single_series_id" id="single_series_id" class="form-control">
                        <option value="-1" selected>-- Seleziona una serie --</option>
                        @foreach($active_series as $serie)
                          <option value="{{ $serie->id }}"
                            rel="{{ $serie->name }}">
                            {{ $serie->name }}
                            {{{ ($serie->version != null) ? ' - '.$serie->version : '' }}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    {{ Form::label('number', 'Numero', array('class' => 'col-md-1 label-padding')) }}
                    <div class="col-md-11">
                      <select name="single_number_id" id="single_number_id" class="form-control" disabled>
                      </select>
                    </div>
                    {{ Form::hidden('user_id', $user->id) }}
                  </div>
                  <div class="form-group">
                    {{ Form::submit('Aggiungi', array('id' => 'add_single_number', 'disabled' => 'disabled', 'class' => 'btn btn-primary button-margin no-radius')) }}
                  </div>
                {{ Form::close() }}
              </div>

              <div class="tab-pane fade" id="newvoucher">
                {{ Form::open(array('action' => 'VouchersController@create', 'class' => 'form-horizontal')) }}
                <div class="form-group">
                  {{ Form::label('number', 'Descrizione', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('description', '', array('class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('user_id', $user->id) }}
                </div>
                <div class="form-group">
                  {{ Form::label('amount', 'Valore', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('amount', '', array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::submit('Aggiungi', array('id' => 'add_voucher','disabled' => 'disabled', 'class' => 'btn btn-primary button-margin no-radius')) }}
                </div>
                {{ Form::close() }}
              </div>
              {{--*/ $active = '' /*--}}
            @else
              {{--*/ $active = 'active in' /*--}}
            @endif

            <div class="tab-pane fade {{{ $active }}}" id="contact">
              {{ Form::open(array('action' => 'MailController@mailToCustomer', 'class' => 'form-horizontal')) }}
                <div class="form-group">
                  {{ Form::label('subject', 'Oggetto', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('subject', '', array('class' => 'form-control')) }}
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                    {{ Form::textarea('message', '', array('class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('to',$user->id) }}
                </div>
                <div class="form-group">
                  {{ Form::submit('Invia mail', array('class' => 'btn btn-primary button-margin no-radius')) }}
                </div>
              {{ Form::close() }}
            </div>

            <div class="tab-pane fade" id="edit">
              {{ Form::model($user, array('action' => 'UsersController@update', 'class' => 'form-horizontal')) }}
                <div class="form-group">
                  {{ Form::label('name', 'Nome', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('surname','Cognome', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('surname', $user->surname, array('class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('id')}}
                  {{ Form::hidden('username')}}
                </div>
                <div class="form-group">
                  {{ Form::label('number','Numero', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('number', $user->number, array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::label('pass', 'Password', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::password('pass', array('class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('password','dummypassword') }}
                </div>
                <div class="form-group">
                  {{ Form::label('discount', 'Sconto', array('class' => 'col-md-1 label-padding')) }}
                  <div class="col-md-11">
                    {{ Form::text('discount', $user->discount, array('class' => 'form-control')) }}
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
                </div>
              {{ Form::close() }}
            </div>

            {{--@if(count($purchases)>0)--}}
            {{--<div class="tab-pane fade" id="purchases">--}}
            {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">--}}
            {{--<h5>Storico degli Acquisti</h5>--}}
            {{--</div>--}}
            {{--<div class="table-responsive table-bordered">--}}
            {{--<table class="table table-striped table-bordered table-hover"--}}
            {{--id="dataTables-example">--}}
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th>Data Acquisto</th>--}}
            {{--<th>Fumetto</th>--}}
            {{--<th>Prezzo</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach ($purchases as $purchase)--}}
            {{--<tr class="odd gradeX">--}}
            {{--<td>{{date('d/m/Y',strtotime($purchase->buy_time))}}</td>--}}
            {{--@if($purchase->series->version == null)--}}
            {{--<td>{{$purchase->series->name}}--}}
            {{--nr. {{$purchase->comic->number}}</td>--}}
            {{--@else--}}
            {{--<td>{{$purchase->series->name}} - {{$purchase->series->version}}--}}
            {{--nr. {{$purchase->comic->number}}</td>--}}
            {{--@endif--}}
            {{--<td>{{$purchase->price}}</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
            {{--</table>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
          </div>
        </div>
      </div>
    </div>
  </div>

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
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script>
function showConfirmModal(object_id, user_id, mode) {
  document.confirmForm.user_id.value = user_id;
  if (mode == 0) {
                // buying the comic
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../buyComic';
                $('#confirmPageName').text('Il fumetto è stato acquistato?');
              } else if (mode == 1) {
                // removing the comic from the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteComicUser';
                $('#confirmPageName').text('Sei sicuro di voler togliere il fumetto dalla casella?');
              } else if (mode == 2) {
                // removing the follow of the series from the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteSeriesUser';
                $('#confirmPageName').text('Sei sicuro di voler togliere la serie dalla casella?');
              } else if (mode == 3) {
                // restore the follow of the series in the box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../restoreSeriesUser';
                $('#confirmPageName').text('Sei sicuro di voler ripristinare la seria nella casella?');
              } else if(mode == 4){
                // confirm disabling of a box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteUser';
                $('#confirmPageName').text('Sei sicuro di voler disabilitare questa casella?');
              } else if(mode == 5){
                // confirm re-enabling of a box
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../restoreUser';
                $('#confirmPageName').text('Sei sicuro di voler abilitare nuovamente questa casella?');
              } else if(mode == 6){
                // renewal of shop card of the user
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../renewShopCard';
                $('#confirmPageName').text('Sei sicuro di voler rinnovare la tessera della casella?');
              } else if(mode == 7){
                // user a voucher
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteVoucher';
                $('#confirmPageName').text('Sei sicuro di voler usare il buono?');
              } else if(mode == 8){
                // removing a voucher
                document.confirmForm.id.value = object_id;
                document.confirmForm.action = '../deleteVoucher';
                $('#confirmPageName').text('Sei sicuro di voler rimuovere il buono?');
              }
              $('#modal-confirm').modal({
                show: true
              });
            }
            </script>
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
              $('#dataTables-comics').dataTable();
              $('#dataTables-series').dataTable();
              $('#dataTables-vouchers').dataTable();
            });
            </script>
            <!-- CUSTOM SCRIPTS -->
            <script>
            $('select#single_series_id').on('change', function () {
              var selected_id = $('select#single_series_id').val();
              if (selected_id == -1) {
                $('select#single_number_id').prop('disabled', 'disabled');
                $('select#single_number_id').empty();
                $('#add_single_number').prop('disabled', 'disabled');
              } else {
                $.ajax({
                  url: '../getNumberFromSeries',
                  type: 'POST',
                  data: {'series_id': selected_id},
                  success: function (data) {
                    $('select#single_number_id').empty();
                    $('select#single_number_id').prop('disabled', false);
                    $('select#single_number_id').append('<option value="-1">-- Seleziona un numero --</option>');
                    $.each(data, function (index, value) {
                      $('select#single_number_id').append('<option value="' + value.id + '">' + value.number + '</option>');
                    });
                  },
                  error: function () {
                    $('select#single_number_id').prop('disabled', 'disabled');
                    $('#add_single_number').prop('disabled', 'disabled');
                  }
                });
              }
            });

$('select#single_number_id').on('change', function () {
  var selected_id = $('select#single_number_id').val();
  if (selected_id != -1) {
    $('#add_single_number').prop('disabled', false);
  }
});
</script>
<script>
$('#amount').on('change', function () {
 var actual = $('#amount').val();
 if (actual != ''){
   var other_par = $('#description').val();
   if(other_par != '')
     $('#add_voucher').prop('disabled', false);
 } else
 $('#add_voucher').prop('disabled', 'disabled');
});

$('#description').on('change', function () {
 var actual = $('#amount').val();
 if (actual != ''){
   var other_par = $('#amount').val();
   if(other_par != '')
     $('#add_voucher').prop('disabled', false);
 } else
 $('#add_voucher').prop('disabled', 'disabled');
});
</script>
@stop
