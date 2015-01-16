<?php

class MailController extends BaseController
{
    /**
     * Send a mail to the shop owner
     */
    public function mailToShop()
    {
        $rules = array('message' => 'regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\;\:\n\+\-]*$/');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('box')->withErrors($validator);
        } else {
            $shop_owner = ShopConf::find(3);
            $to = $shop_owner->value;
            $user = Auth::user()->name . " " . Auth::user()->surname;
            $subject = 'Magman Casellario: messaggio da ' . $user;
            $message = Input::get('message');
            $headers = 'From: info@magman.it' . "\r\n" .
                'Reply-To: info@magman.it' . "\r\n" .
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
        $rules = array('message' => 'required|regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\;\:\n\+\-]*$/',
            'subject' => "required|min:4|max:15",
            'to' => 'required|exists:users,id');
        $validator = Validator::make(Input::all(), $rules);
        $user_id = Input::get('to');
        if ($validator->fails()) {
            return Redirect::to('boxes/' . $user_id)->withErrors($validator);
        } else {
            $user = User::find($user_id);
            $to = $user->username;
            $subject_input = Input::get('subject');
            $subject = 'Magman Casellario: ' . $subject_input;
            $message = Input::get('message');
            $headers = 'From: casellario@magman.it' . "\r\n" .
                'Reply-To: casellario@magman.it' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            return Redirect::to('boxes/' . $user_id);
        }
    }
}

?>
