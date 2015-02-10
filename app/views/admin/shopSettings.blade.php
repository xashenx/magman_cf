@section('content')
  @if(count($errors)>0)
    <h3>Whhops: E' avvenuto un errore!!<br/>
      Se il problema persiste contattare un amministratore</h3>
    {{$errors->first('shop_card_duration')}}
    {{$errors->first('shop_card_cost')}}
    {{$errors->first('insolvency')}}
    {{$errors->first('defaulting')}}
    {{$errors->first('email')}}
  @endif
  <div class="row">
    <div class="col-md-12 col-sm-12">
      <div class="panel panel-default no-radius">
        <div class="panel-heading no-radius">
          <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Gestione Configurazioni
        </div>
        <div class="panel-body">
          <div>
            {{ Form::open(array('action' => 'ShopConfController@update', 'class' => 'form-horizontal')) }}
            <div class="form-group">
              {{ Form::label('email', 'Email', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::text('email', ShopConf::find(3)->value, array('class' => 'form-control')) }}
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('shop_card_cost', 'Costo Tessera', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                <div class="input-group">
                  <span class="input-group-addon no-radius" id="basic-addon1">€</span>
                  {{ Form::text('shop_card_cost', ShopConf::find(4)->value, array('class' => 'form-control')) }}
                </div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('shop_card_duration', 'Durata Tessera', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                {{ Form::select('shop_card_duration',
                array('1' => '1 mese','2' => '2 mesi','3' => '3 mesi','4' => '4 mesi','5' => '5 mesi','6' => '6 mesi'
                ,'7' => '7 mesi','8' => '8 mesi','9' => '9 mesi','10' => '10 mesi','11' => '11 mesi','12' => '1 anno'),ShopConf::find(5)->value,
                array('class' => 'form-control')) }}
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
                </div>
              </div>
            </div>
            <div class="form-group">
              {{ Form::label('defaulting', 'Soglia di Dispersione', array('class' => 'col-md-2 label-padding')) }}
              <div class="col-md-10">
                  {{ Form::select('defaulting',
                  array('30' => '1 mese','60' => '2 mesi','90' => '3 mesi','180' => '6 mesi','365' => '1 anno'),ShopConf::find(2)->value,
                  array('class' => 'form-control')) }}
              </div>
            </div>

            <div>
              {{ Form::submit('Aggiorna', array('class' => 'btn btn-primary no-radius')) }}
            </div>
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('../layouts/js-include')
@stop