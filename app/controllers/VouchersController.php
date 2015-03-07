<?php

class VouchersController extends BaseController
{

    public function create()
    {
        $new = Input::all();
        $user_id = Input::get('user_id');
        $voucher = new Voucher;
        if ($voucher->validate($new)) {
            $voucher->description = Input::get('description');
			$voucher->user_id = $user_id;
			$voucher_value = str_replace(',', '.', Input::get('amount'));
			$voucher->amount = $voucher_value;
            $voucher->save();
            return Redirect::to('boxes/' . $user_id);
        } 
        else {
            $errors = $voucher->errors();
            return Redirect::to('boxes/' . $user_id)->withErrors($errors);
        }
    }

    public function update()
    {
        $new = Input::all();
        $user_id = Input::get('user_id');
        $voucher_id = Input::get('voucher_id');
        $voucher = Voucher::find($voucher_id);
        if ($voucher->validate($new)) {
            $voucher->description = Input::get('description');
            $voucher_value = str_replace(',', '.', Input::get('amount'));
            $voucher->amount = $voucher_value;
            $voucher->update();
            return Redirect::to('boxes/' . $user_id . '/voucher/' . $voucher_id);
        }
        else {
            $errors = $voucher->errors();
            return Redirect::to('boxes/' . $user_id)->withErrors($errors);
        }
    }

    public function delete()
    {
        $voucher_id = Input::get('id');
		$user_id = Input::get('user_id');
        $rules = array('id' => 'required|numeric|exists:bm_vouchers,id,active,1',
        				'user_id' => 'required|numeric|exists:bm_users,id,active,1'
		);
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('boxes/' . $user_id)->withErrors($validator);
        } else{
            $voucher = Voucher::find($voucher_id);
            $voucher->active = 0;
            $voucher->update();
            return Redirect::to('boxes/' . $user_id);
        }
    }
}

?>