@section('content')
  @if(count($errors)>0)
    <h3>Whoops! C'è stato un errore!!! <br/>
      Se il problema persiste, contattare un amministratore!</h3>
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          Casella {{$user->number}}: {{$user -> name}} {{$user->surname}}
          @if($user->active)
            @if(date('Y-m-d', strtotime($user->shop_card_validity)) < date('Y-m-d',strtotime('now')))
              <button type="button" title="Rinnova Tessera" onclick="showConfirmModal({{$user->id}},0,6)"
                      class="btn btn-warning btn-xs no-radius little-icon little-icon-padding">
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
              </button>
            @endif
            <button type="button" title="Disattiva casella"
                    onclick="showConfirmModal({{$user->id}},0,4)"
                    class="btn btn-danger btn-xs no-radius little-icon little-icon-padding">
              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
            </button>
          @else
            <button type="button" title="Riattiva casella"
                    onclick="showConfirmModal({{$user->id}},0,5)"
                    class="btn btn-success btn-xs no-radius little-icon little-icon-padding">
              <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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
                  <a href="#orderedComics" data-toggle="tab">
                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                    <span class="titoli-tab">In arrivo</span>
                  </a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              @if(count($user->availableVouchers)>0)
                <li class="{{ $active }}">
                  <a href="#vouchers" data-toggle="tab">
                    <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                    <span class="titoli-tab">Buoni</span>
                  </a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              @if(count($series)>0)
                <li class="{{ $active }}">
                  <a href="#series" data-toggle="tab">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    <span class="titoli-tab">Serie Seguite</span>
                  </a>
                </li>
                {{--*/ $active = '' /*--}}
              @endif
              <li class="{{ $active }}">
                <a href="#newseries" data-toggle="tab">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                  <span class="titoli-tab">Nuova Serie</span>
                </a>
              </li>
              {{--*/ $active = '' /*--}}
              <li class="">
                <a href="#newsinglecomic" data-toggle="tab">
                  <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
                  <span class="titoli-tab">Nuovo Arretrato/Singolo</span>
                </a>
              </li>
              <li class="">
                <a href="#newvoucher" data-toggle="tab">
                  <span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
                  <span class="titoli-tab">Aggiungi Buono</span>
                </a>
              </li>
              {{-- <li class=""><a href="#details" data-toggle="tab">Dettagli</a></li> --}}

            @endif
            <li class="{{ $active }}">
              <a href="#contact" data-toggle="tab">
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                <span class="titoli-tab">Contatta</span>
              </a>
            </li>
            @if(count($purchases)>0)
              <li class="">
                <a href="#purchases" data-toggle="tab">Storico Acquisti</a>
              </li>
            @endif
            <li class="">
              <a href="#edit" data-toggle="tab">
                <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                <span class="titoli-tab">Modifica</span>
              </a>
            </li>
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
                      <th>Editore</th>
                      <th>Fumetto</th>
                      <th>Cover</th>
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
                        <td>{{ $comic->comic->series->publisher }}</td>
                        <td>
                          <a href="{{$user->id}}/comic/{{$comic->id}}">
                            {{ $comic->comic->series->name}}
                            {{{ isset($comic->comic->series->version) ? ' - '.$comic->comic->series->version : '' }}}
                            # {{ $comic->comic->number}}
                          </a>
                        </td>
                        <td>
                          @if($comic->comic->image)
                            <a href="{{$comic->comic->image}}" target="_blank"><img src="{{$comic->comic->image}}"
                                                                                    alt="" height="42" width="42"></a>
                          @endif
                        </td>
                        <td>{{ round($comic->price,2) }} €</td>
                        <td>
                          @if($comic->comic->state == 2)
                            <button type="button" title="Acquista"
                                    onclick="showConfirmModal({{$comic->id}},{{$user->id}},0)"
                                    class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                                            <span class="glyphicon glyphicon-euro"
                                                                  aria-hidden="true"></span>
                            </button>
                          @endif
                          <button type="button" title="Rimuovi"
                                  onclick="showConfirmModal({{$comic->id}},{{$user->id}},1)"
                                  class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                                                        <span class="glyphicon glyphicon-trash"
                                                              aria-hidden="true"></span>
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
                      <th>Editore</th>
                      <th>Nome</th>
                      <th>Autore</th>
                      <th>Numeri</th>
                      <th>Azioni</th>
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
                        <td>{{ $serie->series->publisher }}</td>
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
                                                                <span class="glyphicon glyphicon-remove"
                                                                      aria-hidden="true"></span>
                              </button>
                            @elseif($serie->series->active)
                              <button type="button" title="Segui"
                                      onclick="showConfirmModal({{$serie->id}},{{$user->id}},3)"
                                      class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                                                <span class="glyphicon glyphicon-heart"
                                                                      aria-hidden="true"></span>
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
                        <td>{{$voucher->amount}} €</td>
                        <td>
                          <button type="button" title="Usa"
                                  onclick="showConfirmModal({{$voucher->id}},{{$user->id}},7)"
                                  class="btn btn-success btn-sm no-radius medium-icon little-icon-padding">
                                                        <span class="glyphicon glyphicon-euro"
                                                              aria-hidden="true"></span>
                          </button>
                          <button type="button" title="Rimuovi"
                                  onclick="showConfirmModal({{$voucher->id}},{{$user->id}},8)"
                                  class="btn btn-danger btn-sm no-radius medium-icon little-icon-padding">
                                                        <span class="glyphicon glyphicon-remove"
                                                              aria-hidden="true"></span>
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
                  {{ Form::label('series_id', 'Serie', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    <select name="series_id" id="series_id" class="form-control">
                      @foreach($not_followed_series as $serie)
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
                  {{ Form::label('single_series_id', 'Serie', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
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
                  {{ Form::label('number', 'Numero', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    {{--<select name="single_number_id" id="single_number_id" class="form-control"--}}
                            {{--disabled>--}}
                    {{--</select>--}}
                    {{ Form::text('single_number_value','', array('id' => 'single_number_value','disabled' => 'disabled','class' => 'form-control')) }}
                  </div>
                  {{ Form::hidden('user_id', $user->id) }}
                </div>
                <div class="form-group">
                  {{ Form::submit('Aggiungi', array('id' => 'add_single_number', 'disabled' => 'disabled', 'class' => 'btn btn-primary button-margin no-radius')) }}
                </div>
                {{ Form::close() }}
              </div>

              <div class="tab-pane fade" id="newvoucher">
                {{ Form::open(array('action' => 'VouchersController@create', 'id' => 'new-voucher', 'class' => 'form-horizontal')) }}
                <div class="form-group has-feedback">
                  {{ Form::label('description', 'Descrizione', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    {{ Form::text('description', '', array('class' => 'form-control')) }}
                    <div></div>
                  </div>
                  {{ Form::hidden('user_id', $user->id) }}
                </div>
                <div class="form-group">
                  {{ Form::label('amount', 'Valore', array('class' => 'col-md-2 label-padding')) }}
                  <div class="col-md-10">
                    <div class="input-group">
                      <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                      {{ Form::text('amount', '', array('class' => 'form-control')) }}
                      <div></div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  {{ Form::submit('Aggiungi', array('id' => 'add_voucher', 'class' => 'btn btn-primary button-margin no-radius')) }}
                </div>
                {{ Form::close() }}
                <div class="cAlert" id="alert-1">
                  <div class="alert alert-success success no-radius"></div>
                  <div class="alert alert-danger error no-radius"></div>
                </div>
              </div>
              {{--*/ $active = '' /*--}}
            @else
              {{--*/ $active = 'active in' /*--}}
            @endif

            <div class="tab-pane fade {{{ $active }}}" id="contact">
              {{ Form::open(array('action' => 'MailController@mailToCustomer','id' => 'mail-contact' , 'class' => 'form-horizontal')) }}
              <div class="form-group has-feedback">
                {{ Form::label('subject', 'Oggetto', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::text('subject', $errors->first('subject') ? $errors->first('subject') : '', array('class' => 'form-control')) }}
                  <div></div>
                </div>
              </div>

              <div class="form-group has-feedback">
                <div class="col-md-12">
                  {{ Form::textarea('message', $errors->first('message') ? $errors->first('message') : '', array('id' => 'message', 'class' => 'form-control')) }}
                  <div></div>
                </div>
                {{ Form::hidden('to',$user->id) }}
              </div>
              <div class="form-group">
                {{ Form::submit('Invia mail', array('class' => 'btn btn-primary button-margin no-radius')) }}
              </div>
              {{ Form::close() }}
              <div class="cAlert" id="alert-2">
                <div class="alert alert-success success no-radius"></div>
                <div class="alert alert-danger error no-radius"></div>
              </div>
            </div>

            <div class="tab-pane fade" id="edit">
              {{ Form::model($user, array('action' => 'UsersController@update', 'id' => 'edit-user', 'class' => 'form-horizontal')) }}
              <div class="form-group has-feedback">
                {{ Form::label('name', 'Nome', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::text('name', $user->name, array('class' => 'form-control')) }}
                  <div></div>
                </div>
              </div>
              <div class="form-group has-feedback">
                {{ Form::label('surname','Cognome', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::text('surname', $user->surname, array('class' => 'form-control')) }}
                  <div></div>
                </div>
                {{ Form::hidden('id')}}
                {{--{{ Form::hidden('username')}}--}}
              </div>
              <div class="form-group has-feedback">
                {{ Form::label('number','Numero', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::text('number', $user->number, array('class' => 'form-control')) }}
                  <div></div>
                </div>
              </div>
              <div class="form-group has-feedback">
                {{ Form::label('newusername', 'Username', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::text('newusername', $user->username, array('class' => 'form-control')) }}
                  <div></div>
                </div>
                {{ Form::hidden('username','dummy@user.it') }}
              </div>
              <div class="form-group has-feedback">
                {{ Form::label('newpassword', 'Password', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::password('newpassword', array('class' => 'form-control')) }}
                  <div></div>
                </div>
                {{ Form::hidden('password','dummypassword') }}
              </div>
              <div class="form-group has-feedback">
                {{ Form::label('show_price', 'Visualizza Conto', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  {{ Form::select('show_price',array('1' => 'Sì','0' => 'No'),$user->show_price,array('class' => 'form-control')) }}
                  <div></div>
                </div>
              </div>
              <div class="form-group">
                {{ Form::label('discount', 'Sconto', array('class' => 'col-md-2 label-padding')) }}
                <div class="col-md-10">
                  <div class="input-group">
                    <span class="input-group-addon no-radius" id="basic-addon1">%</span>
                    {{ Form::text('discount', $user->discount, array('class' => 'form-control')) }}
                    <div></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
              </div>
              {{ Form::close() }}
              <div class="cAlert" id="alert-3">
                <div class="alert alert-success success no-radius"></div>
                <div class="alert alert-info necessary no-radius">
                  I campi con
                  <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                  sono opzionali.
                </div>
                <div class="alert alert-danger error no-radius"></div>
              </div>
            </div>

              @if(count($purchases)>0)
                <div class="tab-pane fade" id="purchases">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h5>Storico degli Acquisti</h5>
                    </div>
                    <div class="table-responsive table-bordered">
                      <table class="table table-striped table-bordered table-hover"
                             id="dataTables-example">
                        <thead>
                        <tr>
                          <th>Data Acquisto</th>
                          <th>Fumetto</th>
                          <th>Prezzo</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($purchases as $purchase)
                          <tr class="odd gradeX">
                            <td>{{date('d/m/Y',strtotime($purchase->buy_time))}}</td>
                            @if($purchase->series->version == null)
                              <td>{{$purchase->series->name}}
                                nr. {{$purchase->comic->number}}</td>
                            @else
                              <td>{{$purchase->series->name}} - {{$purchase->series->version}}
                                nr. {{$purchase->comic->number}}</td>
                            @endif
                            <td>{{round($purchase->price,2)}}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              @endif
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
      } else if (mode == 4) {
        // confirm disabling of a box
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../deleteUser';
        $('#confirmPageName').text('Sei sicuro di voler disabilitare questa casella?');
      } else if (mode == 5) {
        // confirm re-enabling of a box
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../restoreUser';
        $('#confirmPageName').text('Sei sicuro di voler abilitare nuovamente questa casella?');
      } else if (mode == 6) {
        // renewal of shop card of the user
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../renewShopCard';
        $('#confirmPageName').text('Sei sicuro di voler rinnovare la tessera della casella?');
      } else if (mode == 7) {
        // user a voucher
        document.confirmForm.id.value = object_id;
        document.confirmForm.action = '../deleteVoucher';
        $('#confirmPageName').text('Sei sicuro di voler usare il buono?');
      } else if (mode == 8) {
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
//        $('select#single_number_id').prop('disabled', 'disabled');
//        $('select#single_number_id').empty();
        $('#single_number_value').prop('disabled', 'disabled');
        $('#single_number_value').empty();
        $('#add_single_number').prop('disabled', 'disabled');
      } else {
        $.ajax({
          url: '../getNumberFromSeries',
          type: 'POST',
          data: {'series_id': selected_id},
          success: function (data) {
//            $('select#single_number_id').empty();
//            $('select#single_number_id').prop('disabled', false);
//            $('select#single_number_id').append('<option value="-1">-- Seleziona un numero --</option>');
            $('#single_number_value').empty();
            $('#single_number_value').prop('disabled', false);
//            $.each(data, function (index, value) {
//              $('select#single_number_id').append('<option value="' + value.id + '">' + value.number + '</option>');
//            });
          },
          error: function () {
//            $('select#single_number_id').prop('disabled', 'disabled');
            $('#single_number_value').prop('disabled', 'disabled');
            $('#add_single_number').prop('disabled', 'disabled');
          }
        });
      }
    });

//    $('select#single_number_id').on('change', function () {
    $('#single_number_value').on('change', function () {
      var selected_id = $('#single_number_value').val();
      if (selected_id != -1) {
        $('#add_single_number').prop('disabled', false);
      }
    });
  </script>
  <script>
    $(document).ready(function () {
      $('#new-voucher').on('submit', function () {
        $('#alert-1').hide();
        $('#alert-1').find('.success').hide();
        $('#alert-1').find('.error').hide();
        $('#alert-1').find('.success').html("");
        $('#alert-1').find('.error').html("");

        //value
        var description = $('#new-voucher').find('#description').val();
        var amount = $('#new-voucher').find('#amount').val();

        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!
        //description
        var result = checkInputValue(description, "message", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-voucher').find('#description').closest('.form-group').removeClass('has-success');
          $('#new-voucher').find('#description').closest('.form-group').addClass('has-error');
          $('#new-voucher').find('#description ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "f",
            elementName: "descrizione",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-voucher').find('#description').closest('.form-group').removeClass('has-error');
          $('#new-voucher').find('#description').closest('.form-group').addClass('has-success');
          $('#new-voucher').find('#description ~ div').html(success_icon);
        }

        //AMOUNT
        var result = checkInputValue(amount, "number", 11, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#new-voucher').find('#amount').closest('.form-group').removeClass('has-success');
          $('#new-voucher').find('#amount').closest('.form-group').addClass('has-error');
          $('#new-voucher').find('#amount ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "m",
            elementName: "valore del buono",
            maxLength: 11,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#new-voucher').find('#amount').closest('.form-group').removeClass('has-error');
          $('#new-voucher').find('#amount').closest('.form-group').addClass('has-success');
          $('#new-voucher').find('#amount ~ div').html(success_icon);
        }
        if (submit) {
          //chiamata ajax
        }
        return submit;
      });

      $('#mail-contact').on('submit', function () {
        $('#alert-2').hide();
        $('#alert-2').find('.success').hide();
        $('#alert-2').find('.error').hide();
        $('#alert-2').find('.success').html("");
        $('#alert-2').find('.error').html("");

        //value
        var subject = $('#mail-contact').find('#subject').val();
        var message = $('#mail-contact').find('#message').val();

        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!
        //subject
        var result = checkInputValue(subject, "message", 150, 1);
        if (result['status'] == 'ko') {
          $('#alert-2').show();
          $('#alert-2').find('.error').show();
          $('#mail-contact').find('#subject').closest('.form-group').removeClass('has-success');
          $('#mail-contact').find('#subject').closest('.form-group').addClass('has-error');
          $('#mail-contact').find('#subject ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-2').find('.error'),
            sex: "am",
            elementName: "oggetto",
            maxLength: 150,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#mail-contact').find('#subject').closest('.form-group').removeClass('has-error');
          $('#mail-contact').find('#subject').closest('.form-group').addClass('has-success');
          $('#mail-contact').find('#subject ~ div').html(success_icon);
        }

        //message
        var result = checkInputValue(message, "message", 1000, 1);
        if (result['status'] == 'ko') {
          $('#alert-2').show();
          $('#alert-2').find('.error').show();
          $('#mail-contact').find('#message').closest('.form-group').removeClass('has-success');
          $('#mail-contact').find('#message').closest('.form-group').addClass('has-error');
          $('#mail-contact').find('#message ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-2').find('.error'),
            sex: "m",
            elementName: "messaggio",
            maxLength: 1000,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#mail-contact').find('#message').closest('.form-group').removeClass('has-error');
          $('#mail-contact').find('#message').closest('.form-group').addClass('has-success');
          $('#mail-contact').find('#message ~ div').html(success_icon);
        }
        if (submit) {
          //chiamata ajax
        }
        return submit;
      });

      $('#edit-user').on('submit', function () {
        $('#alert-3').hide();
        $('#alert-3').find('.success').hide();
        $('#alert-3').find('.error').hide();
        $('#alert-3').find('.necessary').hide();
        $('#alert-3').find('.success').html("");
        $('#alert-3').find('.error').html("");

        //value
        var name = $('#edit-user').find('#name').val();
        var surname = $('#edit-user').find('#surname').val();
        var number = $('#edit-user').find('#number').val();
        var newusername = $('#edit-user').find('#newusername').val();
        var newpassword = $('#edit-user').find('#newpassword').val();
        var show_price = $('#edit-user').find('#show_price').val();
        var discount = $('#edit-user').find('#discount').val();

        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var notnecessary_icon_select = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!
        //NAME
        var result = checkInputValue(name, "text", 30, 1);
        if (result['status'] == 'ko') {
          $('#alert-3').show();
          $('#alert-3').find('.error').show();
          $('#edit-user').find('#name').closest('.form-group').removeClass('has-success');
          $('#edit-user').find('#name').closest('.form-group').addClass('has-error');
          $('#edit-user').find('#name ~ div').html(error_icon_select);

          var obj = {
            result: result,
            htmlElement: $('#alert-3').find('.error'),
            sex: "m",
            elementName: "nome",
            maxLength: 30,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-user').find('#name').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#name').closest('.form-group').addClass('has-success');
          $('#edit-user').find('#name ~ div').html(success_icon_select);
        }

        //SURNAME
        var result = checkInputValue(surname, "text", 30, 1);
        if (result['status'] == 'ko') {
          $('#alert-3').show();
          $('#alert-3').find('.error').show();
          $('#edit-user').find('#surname').closest('.form-group').removeClass('has-success');
          $('#edit-user').find('#surname').closest('.form-group').addClass('has-error');
          $('#edit-user').find('#surname ~ div').html(error_icon_select);

          var obj = {
            result: result,
            htmlElement: $('#alert-3').find('.error'),
            sex: "m",
            elementName: "cognome",
            maxLength: 30,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-user').find('#surname').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#surname').closest('.form-group').addClass('has-success');
          $('#edit-user').find('#surname ~ div').html(success_icon_select);
        }

        //NUMBER
        var result = checkInputValue(number, "integer", 11, 1);
        if (result['status'] == 'ko') {
          $('#alert-3').show();
          $('#alert-3').find('.error').show();
          $('#edit-user').find('#number').closest('.form-group').removeClass('has-success');
          $('#edit-user').find('#number').closest('.form-group').addClass('has-error');
          $('#edit-user').find('#number ~ div').html(error_icon_select);

          var obj = {
            result: result,
            htmlElement: $('#alert-3').find('.error'),
            sex: "m",
            elementName: "numero casella",
            maxLength: 11,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-user').find('#number').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#number').closest('.form-group').addClass('has-success');
          $('#edit-user').find('#number ~ div').html(success_icon_select);
        }

        //NEWUSERNAME
        var result = checkInputValue(newusername, "email", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-3').show();
          $('#alert-3').find('.error').show();
          $('#edit-user').find('#newusername').closest('.form-group').removeClass('has-success');
          $('#edit-user').find('#newusername').closest('.form-group').addClass('has-error');
          $('#edit-user').find('#newusername ~ div').html(error_icon_select);

          var obj = {
            result: result,
            htmlElement: $('#alert-3').find('.error'),
            sex: "am",
            elementName: "username",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-user').find('#newusername').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#newusername').closest('.form-group').addClass('has-success');
          $('#edit-user').find('#newusername ~ div').html(success_icon_select);
        }

        //NEWPASSWORD
        if (newpassword.length != 0) {
          var result = checkInputValue(newpassword, "pwd", 30, 8);
          if (result['status'] == 'ko') {
            $('#alert-3').show();
            $('#alert-3').find('.error').show();
            $('#edit-user').find('#newpassword').closest('.form-group').removeClass('not-necessary');
            $('#edit-user').find('#newpassword').closest('.form-group').removeClass('has-success');
            $('#edit-user').find('#newpassword').closest('.form-group').addClass('has-error');
            $('#edit-user').find('#newpassword ~ div').html(error_icon_select);

            var obj = {
              result: result,
              htmlElement: $('#alert-3').find('.error'),
              sex: "f",
              elementName: "nuova password",
              maxLength: 30,
              minLength: 8
            };
            showErrorMsg(obj);
            submit = false;
          } else {
            $('#edit-user').find('#newpassword').closest('.form-group').removeClass('has-error');
            $('#edit-user').find('#newpassword').closest('.form-group').addClass('has-success');
            $('#edit-user').find('#newpassword ~ div').html(success_icon_select);
          }
        } else {
          $('#alert-3').find('.necessary').show();
          $('#edit-user').find('#newpassword').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#newpassword').closest('.form-group').addClass('not-necessary');
          $('#edit-user').find('#newpassword ~ div').html(notnecessary_icon_select);
        }

        //SHOW PRICE
        $('#edit-user').find('#show_price').closest('.form-group').removeClass('has-error');
        $('#edit-user').find('#show_price').closest('.form-group').addClass('has-success');
        $('#edit-user').find('#show_price ~ div').html(success_icon_select);
        $('#edit-user').find('#show_price').css('outline-color', '#3c763d');

        //DISCOUNT
        var result = checkInputValue(discount, "number", 2, 1);
        if (result['status'] == 'ko') {
          $('#alert-3').show();
          $('#alert-3').find('.error').show();
          $('#edit-user').find('#discount').closest('.form-group').removeClass('has-success');
          $('#edit-user').find('#discount').closest('.form-group').addClass('has-error');
          $('#edit-user').find('#discount ~ div').html(error_icon_select);

          var obj = {
            result: result,
            htmlElement: $('#alert-3').find('.error'),
            sex: "f",
            elementName: "percentuale di sconto",
            maxLength: 2,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-user').find('#discount').closest('.form-group').removeClass('has-error');
          $('#edit-user').find('#discount').closest('.form-group').addClass('has-success');
          $('#edit-user').find('#discount ~ div').html(success_icon_select);
        }

        if (submit) {
          //chiamata ajax
        }
        return submit;
      });
    });
  </script>
@stop
