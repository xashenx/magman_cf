@section('content')
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Buono della casella
        </div>
        <div class="panel-body">
          <div class="row" style="padding:15px">
            {{ Form::open(array('action' => 'VouchersController@update', 'id' => 'updated-voucher', 'class' => 'form-horizontal')) }}
            <div class="form-group has-feedback">
              {{ Form::label('description', 'Descrizione', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::text('description', $voucher->description, array('class' => 'form-control', 'placeholder' => 'Descrizione del buono')) }}
                <div></div>
              </div>
              {{ Form::hidden('user_id', $voucher->user_id) }}
              {{ Form::hidden('voucher_id', $voucher->id) }}
            </div>
            <div class="form-group">
              {{ Form::label('amount', 'Valore', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                  {{ Form::text('amount', number_format($voucher->amount,2,'.',''), array('class' => 'form-control', 'placeholder' => 'Valore del buono')) }}
                  <div></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::submit('Aggiorna', array('id' => 'edit_voucher', 'class' => 'btn btn-primary button-margin no-radius')) }}
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
    $('#updated-voucher').on('submit', function () {
      $('#alert-1').hide();
      $('#alert-1').find('.success').hide();
      $('#alert-1').find('.error').hide();
      $('#alert-1').find('.success').html("");
      $('#alert-1').find('.error').html("");

      //value
      var description = $('#updated-voucher').find('#description').val();
      var amount = $('#updated-voucher').find('#amount').val();

      var error_icon = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
      var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
      var error_icon_select = '<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
      var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

      var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
      //submit = true
      var submit = true;
      //start the check!
      //description
      var result = checkInputValue(description, "message", 20, 1);
      if (result['status'] == 'ko') {
        $('#alert-1').show();
        $('#alert-1').find('.error').show();
        $('#updated-voucher').find('#description').closest('.form-group').removeClass('has-success');
        $('#updated-voucher').find('#description').closest('.form-group').addClass('has-error');
        $('#updated-voucher').find('#description ~ div').html(error_icon);

        var obj = {
          result: result,
          htmlElement: $('#alert-1').find('.error'),
          sex: "f",
          elementName: "descrizione",
          maxLength: 20,
          minLength: 1
        };
        showErrorMsg(obj);
        submit = false;
      } else {
        $('#updated-voucher').find('#description').closest('.form-group').removeClass('has-error');
        $('#updated-voucher').find('#description').closest('.form-group').addClass('has-success');
        $('#updated-voucher').find('#description ~ div').html(success_icon);
      }

      //AMOUNT
      var result = checkInputValue(amount, "number", 11, 1);
      if (result['status'] == 'ko') {
        $('#alert-1').show();
        $('#alert-1').find('.error').show();
        $('#updated-voucher').find('#amount').closest('.form-group').removeClass('has-success');
        $('#updated-voucher').find('#amount').closest('.form-group').addClass('has-error');
        $('#updated-voucher').find('#amount ~ div').html(error_icon);

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
        $('#updated-voucher').find('#amount').closest('.form-group').removeClass('has-error');
        $('#updated-voucher').find('#amount').closest('.form-group').addClass('has-success');
        $('#updated-voucher').find('#amount ~ div').html(success_icon);
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