@section('content')
  @if(count($errors)>0)
    <div class="alert alert-danger error no-radius">
      <h3>Whhops: E' avvenuto un errore!!<br/>
        Se il problema persiste contattare un amministratore</h3>
      {{$errors->first('shop_card_duration')}}
      {{$errors->first('shop_card_cost')}}
      {{$errors->first('insolvency')}}
      {{$errors->first('defaulting')}}
      {{$errors->first('email')}}
    </div>
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-info no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Gestione Configurazioni
        </div>
        <div class="panel-body">
          <div>
            {{ Form::open(array('action' => 'ShopConfController@update', 'id' => 'shop-configuration', 'class' => 'form-horizontal')) }}
            <div class="form-group has-feedback">
              {{ Form::label('email', 'Email di Contatto', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::text('email', ShopConf::find(3)->value, array('class' => 'form-control', 'placeholder' => 'Email del negoziante')) }}
                <div></div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('shop_card_cost', 'Costo Tessera', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                  {{ Form::text('shop_card_cost', ShopConf::find(4)->value, array('class' => 'form-control', 'placeholder' => 'Prezzo della tessera')) }}
                  <div></div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback">
              {{ Form::label('shop_card_duration', 'Durata Tessera', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::select('shop_card_duration',
                array('1' => '1 mese','2' => '2 mesi','3' => '3 mesi','4' => '4 mesi','5' => '5 mesi','6' => '6 mesi'
                ,'7' => '7 mesi','8' => '8 mesi','9' => '9 mesi','10' => '10 mesi','11' => '11 mesi','12' => '1 anno'),ShopConf::find(5)->value,
                array('class' => 'form-control')) }}
                <div></div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('insolvency', 'Soglia di Insolvenza', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                  {{ Form::select('insolvency',
                  array('25' => '25','50' => '50','75' => '75','100' => '100','150' => '150','200' => '200',
                  '250' => '250','300' => '300'),ShopConf::find(1)->value,
                  array('class' => 'form-control')) }}
                  <div></div>
                </div>
              </div>
            </div>
            <div class="form-group has-feedback">
              {{ Form::label('defaulting', 'Soglia di Dispersione', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                  {{ Form::select('defaulting',
                  array('30' => '1 mese','60' => '2 mesi','90' => '3 mesi','180' => '6 mesi','365' => '1 anno'),ShopConf::find(2)->value,
                  array('class' => 'form-control')) }}
                  <div></div>
              </div>
            </div>

            <div>
              {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
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

        $('#shop-configuration').on('submit', function () {
            $('#alert-1').hide();
            $('#alert-1').find('.success').hide();
            $('#alert-1').find('.error').hide();
            $('#alert-1').find('.success').html("");
            $('#alert-1').find('.error').html("");

            //value
            var email = $('#shop-configuration').find('#email').val();
            var shop_card_cost = $('#shop-configuration').find('#shop_card_cost').val();

            var error_icon ='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id=\"inputIcon\" class=\"sr-only\">(error)</span>';
            var success_icon = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
            var error_icon_select ='<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(error)</span>';
            var success_icon_select = '<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true" style="padding-right:15px"></span><span id="inputIcon" class="sr-only">(success)</span>';

            var notnecessary_icon = '<span class="glyphicon glyphicon-asterisk form-control-feedback" aria-hidden="true"></span><span id="inputIcon" class="sr-only">(success)</span>';
            //submit = true
            var submit = true;
            //start the check!
            //email
            var result = checkInputValue(email, "email", 128, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#shop-configuration').find('#email').closest('.form-group').removeClass('has-success');
              $('#shop-configuration').find('#email').closest('.form-group').addClass('has-error');
              $('#shop-configuration').find('#email ~ div').html(error_icon_select);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "af",
                elementName: "email",
                maxLength: 128,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#shop-configuration').find('#email').closest('.form-group').removeClass('has-error');
              $('#shop-configuration').find('#email').closest('.form-group').addClass('has-success');
              $('#shop-configuration').find('#email ~ div').html(success_icon_select);
            }

            //SHOP CARD COST
            var result = checkInputValue(shop_card_cost, "number", 128, 1);
            if (result['status'] == 'ko') {
              $('#alert-1').show();
              $('#alert-1').find('.error').show();
              $('#shop-configuration').find('#shop_card_cost').closest('.form-group').removeClass('has-success');
              $('#shop-configuration').find('#shop_card_cost').closest('.form-group').addClass('has-error');
              $('#shop-configuration').find('#shop_card_cost ~ div').html(error_icon_select);

              var obj = {
                result: result,
                htmlElement: $('#alert-1').find('.error'),
                sex: "m",
                elementName: "costo della tessera",
                maxLength: 128,
                minLength: 1
              };
              showErrorMsg(obj);
              submit = false;
            } else {
              $('#shop-configuration').find('#shop_card_cost').closest('.form-group').removeClass('has-error');
              $('#shop-configuration').find('#shop_card_cost').closest('.form-group').addClass('has-success');
              $('#shop-configuration').find('#shop_card_cost ~ div').html(success_icon_select);
            }

            //SHOP CARD DURATION
            $('#shop-configuration').find('#shop_card_duration').closest('.form-group').removeClass('has-error');
            $('#shop-configuration').find('#shop_card_duration').closest('.form-group').addClass('has-success');
            $('#shop-configuration').find('#shop_card_duration ~ div').html(success_icon_select);
            $('#shop-configuration').find('#shop_card_duration').css('outline-color', '#3c763d');

            //INSOLVENCY
            $('#shop-configuration').find('#insolvency').closest('.form-group').removeClass('has-error');
            $('#shop-configuration').find('#insolvency').closest('.form-group').addClass('has-success');
            $('#shop-configuration').find('#insolvency ~ div').html(success_icon_select);
            $('#shop-configuration').find('#insolvency').css('outline-color', '#3c763d');

            //DEFAULTING
            $('#shop-configuration').find('#defaulting').closest('.form-group').removeClass('has-error');
            $('#shop-configuration').find('#defaulting').closest('.form-group').addClass('has-success');
            $('#shop-configuration').find('#defaulting ~ div').html(success_icon_select);
            $('#shop-configuration').find('#defaulting').css('outline-color', '#3c763d');

            if (submit){
              //chiamata ajax
            }
            return submit;
        });

    });
  </script>
<!-- CUSTOM SCRIPTS -->
@stop