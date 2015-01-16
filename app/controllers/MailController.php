<?php

class MailController extends BaseController
{
    /**
     * Send a mail to the shop owner
     */
    public function mailToShop()
    {
        $to  = 'ashen@ashen.it';
        $subject = 'Test Mailer';
        $message = 'questa è una prova di mail';
        $headers = 'From: info@magman.it' . "\r\n" .
            'Reply-To: info@magman.it' . "\r\n" .
            'Cc: txtwiz@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        return Redirect::to('box');
    }

    /**
     * Send a mail to the a customer of the shop
     */
    public function mailToCustomer()
    {
        $to      = 'nobody@example.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        return Redirect::to('series');
    }

}

?>
