<?php

class MailController extends BaseController
{
    /**
     * Send a mail to the shop owner
     */
    public function mailToShop()
    {
        // TODO VALIDAZIONE PARAMETRI
        $to  = ShopConf::find(3);
        $user = Auth::user()->name . " " . Auth::user()->surname;
        $subject = 'Magman Casellario: email da ' . $user;
        $message = Input::get('message');
        $headers = 'From: info@magman.it' . "\r\n" .
            'Reply-To: info@magman.it' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
        return Redirect::to('box');
    }

    /**
     * Send a mail to a customer of the shop
     */
    public function mailToCustomer()
    {
        // TODO VALIDAZIONE PARAMETRI
        $user_id = Input::get('to');
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

?>
