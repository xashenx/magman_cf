<?php

class ShopConfController extends BaseController
{
  public function update()
  {
    $new = Input::all();
    $rules = array('email' => 'required|email',
      'shop_card_cost' => 'required|regex:/^[0-9]{1,8}[\.\,]?[0-9]{0,2}$/',
      'shop_card_duration' => array('required','regex:/^(1|2|3|4|5|6|7|8|9|10|11|12)$/'),
      'insolvency' => array('required','regex:/^(25|50|75|100|150|200|250|300)$/'),
      'defaulting' => array('required','regex:/^([369][0]|[1][8][0]|[3][6][5])$/')
    );
    echo Input::get('defaulting');
    $validator = Validator::make($new, $rules);
    if ($validator->fails()) {
      return Redirect::to('shop')->withErrors($validator);
    } else {
      DB::table('bm_shop_configurations')->where('id', 1)->update(array('value' => Input::get('insolvency')));
      DB::table('bm_shop_configurations')->where('id', 2)->update(array('value' => Input::get('defaulting')));
      DB::table('bm_shop_configurations')->where('id', 3)->update(array('value' => Input::get('email')));
      DB::table('bm_shop_configurations')->where('id', 4)->update(array('value' => Input::get('shop_card_cost')));
      DB::table('bm_shop_configurations')->where('id', 5)->update(array('value' => Input::get('shop_card_duration')));
      return Redirect::to('shop');
    }
  }

  public function saveDb(){
    $manager = App::make('BigName\BackupManager\Manager');
    $manager->makeBackup()->run('mysql', 'local', 'prova222.sql', 'null');
  }
}

?>