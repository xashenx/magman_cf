<?php

class MailController extends BaseController
{
    /**
     * Send a mail to the shop owner
     */
    public function mailToShop()
    {
        $rules = array('message' => 'required|regex:/^[A-z 0-9àèìòù&\',\.\?\!()\$\€%"£^\@\;\:\r\n\+\-]*$/');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('box')->withErrors($validator);
        } else {
            $shop_owner = ShopConf::find(3);
            $to = $shop_owner->value;
            $user = Auth::user()->name . " " . Auth::user()->surname;
            $subject = 'Magman Casellario: messaggio da ' . $user;
            $message = Input::get('message');
            $headers = 'From: ' . Auth::user()->username . "\r\n" .
                'Reply-To: ' . Auth::user()->username . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
            return Redirect::to('box');
        }
    }

    /**
     * Send a mail to a customer of the shop
     */
    public function mailToCustomer()
    {
        $rules = array('message' => array('required','regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\;\:\r\n\s\+\-]*$/'),
            'subject' => "required|min:4|max:25",
            'to' => 'required|exists:bm_users,id');
        $validator = Validator::make(Input::all(), $rules);
        $user_id = Input::get('to');
        if ($validator->fails()) {
            return Redirect::to('boxes/' . $user_id)->withErrors($validator);
        } else {
            $shop_owner = ShopConf::find(3);
            $from = $shop_owner->value;
            $user = User::find($user_id);
            $to = $user->username;
            $subject_input = Input::get('subject');
            $subject = 'Magman Casellario: ' . $subject_input;
            $message = Input::get('message');
            $headers = 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            return Redirect::to('boxes/' . $user_id);
        }
    }
}

?>
