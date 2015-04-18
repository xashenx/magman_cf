@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Fumetto Ordinato
        </div>
        <div class="panel-body">
          <div class="row">
            <strong class="col-md-2 margin-bottom">Fumetto</strong>

            <div class="col-md-10 margin-bottom">
              {{$comic->comic->series->name}}
              {{{ ($comic->comic->series->version != null) ? ' - '.$comic->comic->series->version : '' }}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Numero</strong>

            <div class="col-md-10 margin-bottom">
              {{$comic->comic->number}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Casellante</strong>

            <div class="col-md-10 margin-bottom">
              {{$comic->box->name}} {{$comic->box->surname}}
            </div>
          </div>
          <div class="row">
            <strong class="col-md-2 margin-bottom">Ordinato il</strong>

            <div class="col-md-10 margin-bottom">
              {{date('d-m-Y',strtotime($comic->created_at))}}
            </div>
          </div>

          <hr>
          <div class="row" style="padding:15px">
            {{ Form::model($comic, array('action' => 'ComicUserController@update', 'id' => 'edit-comic-user', 'class' => 'form-horizontal')) }}
            <div class="form-group">
              {{ Form::label('price', 'Prezzo', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                  {{ Form::text('price', number_format($comic->price,2,'.',''), array('class' => 'form-control', 'placeholder' => 'Prezzo per questo cliente')) }}
                  <div></div>
                </div>
              </div>
              {{ Form::hidden('cu_id',$comic->id) }}
              {{ Form::hidden('user_id',$comic->box->id) }}
            </div>
            <div class="form-group">
              {{ Form::label('price', 'Sconto', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">%</span>
                  {{ Form::text('discount', $comic->discount, array('class' => 'form-control', 'placeholder' => 'Sconto per questo fumetto')) }}
                  <div></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary button-margin no-radius')) }}
            </div>
            {{ Form::close() }}
            <div class="cAlert" id="alert-1">
              <div class="alert alert-success success no-radius"></div>
              <div class="alert alert-danger error no-radius"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('../layouts/js-include')
  <script>
    $(document).ready(function () {

      $('#edit-comic-user').on('submit', function () {
        $('#alert-1').hide();
        $('#alert-1').find('.success').hide();
        $('#alert-1').find('.error').hide();
        $('#alert-1').find('.success').html("");
        $('#alert-1').find('.error').html("");

        //value
        var price = $('#edit-comic-user').find('#price').val();
        var discount = $('#edit-comic-user').find('#discount').val();
        var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
        var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
        var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

        var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
        //submit = true
        var submit = true;
        //start the check!

        //PRICE
        var result = checkInputValue(price, "number", 128, 1);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#edit-comic-user').find('#price').closest('.form-group').removeClass('has-success');
          $('#edit-comic-user').find('#price').closest('.form-group').addClass('has-error');
          $('#edit-comic-user').find('#price ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "m",
            elementName: "prezzo",
            maxLength: 128,
            minLength: 1
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-comic-user').find('#price').closest('.form-group').removeClass('has-error');
          $('#edit-comic-user').find('#price').closest('.form-group').addClass('has-success');
          $('#edit-comic-user').find('#price ~ div').html(success_icon);
        }

        //DISCOUNT
        var result = checkInputValueAndRange(discount, "number", 128,1,5,100);
        if (result['status'] == 'ko') {
          $('#alert-1').show();
          $('#alert-1').find('.error').show();
          $('#edit-comic-user').find('#discount').closest('.form-group').removeClass('has-success');
          $('#edit-comic-user').find('#discount').closest('.form-group').addClass('has-error');
          $('#edit-comic-user').find('#discount ~ div').html(error_icon);

          var obj = {
            result: result,
            htmlElement: $('#alert-1').find('.error'),
            sex: "m",
            elementName: "sconto",
            maxLength: 128,
            minLength: 1,
            rangeMin: 5,
            rangeMax: 100
          };
          showErrorMsg(obj);
          submit = false;
        } else {
          $('#edit-comic-user').find('#discount').closest('.form-group').removeClass('has-error');
          $('#edit-comic-user').find('#discount').closest('.form-group').addClass('has-success');
          $('#edit-comic-user').find('#discount ~ div').html(success_icon);
        }

        if (submit) {
          //chiamata ajax
        }
        return submit;
      });


    });
  </script>
  @stop
          <!--TOMU APPROVED! -->