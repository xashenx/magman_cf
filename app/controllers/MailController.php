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
      $user = Auth::user()->name . ' ' . Auth::user()->surname;
      $userMail = Auth::user()->username;
      $shopMail = ShopConf::find(3)->value;
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->Host = "smtp.magman.it"; // SMTP server example
      $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'caselle@magman.it';                 // SMTP username
      $mail->Password = 'caselle38100';                           // SMTP password
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->From = $userMail;
      $mail->FromName = $user;
      $mail->addAddress($shopMail, 'Magman Caselle');               // Name is optional
      $mail->addReplyTo($userMail, $user);
      $mail->Subject = 'Magman Caselle: messaggio da ' . $user;
      $mail->Body = Input::get('message');
      if (!$mail->send()) {
        $errors = array('mail' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo,
          'message' => Input::get('message'));
        return Redirect::to('mail')->withErrors($errors);
      } else {
        return Redirect::to('box');
      }
    }
  }

  /**
   * Send a mail to a customer of the shop
   */
  public function mailToCustomer()
  {
    $rules = array('message' => array('required', 'regex:/^[A-z 0-9\'àèìòù&,\.\?\!()\$\€%"£^\@\;\:\r\n\s\+\-]*$/'),
      'subject' => "required|min:4|max:25",
      'to' => 'required|exists:bm_users,id');
    $validator = Validator::make(Input::all(), $rules);
    $user_id = Input::get('to');
    if ($validator->fails()) {
      return Redirect::to('boxes/' . $user_id)->withErrors($validator);
    } else {
      $userObj = User::find($user_id);
      $user = $userObj->name . ' ' . $userObj->surname;
      $userMail = $userObj->username;
      $shopMail = ShopConf::find(3)->value;
      $subject_input = Input::get('subject');
      $mail = new PHPMailer();
      $mail->IsSMTP();
      $mail->CharSet = 'UTF-8';
      $mail->Host = "smtp.magman.it"; // SMTP server example
      $mail->SMTPDebug = 0;                     // enables SMTP debug information (for testing)
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'caselle@magman.it';                 // SMTP username
      $mail->Password = 'caselle38100';                           // SMTP password
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->From = $shopMail;
      $mail->FromName = 'Magman Caselle';
      $mail->addAddress($userMail, $user);               // Name is optional
      $mail->addReplyTo($shopMail, 'Magman Caselle');
      $mail->Subject = 'Magman Caselle: ' . $subject_input;
      $mail->Body = Input::get('message');
      if (!$mail->send()) {
        $errors = array('mail' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo,
          'message' => Input::get('message'),
          'subject' => Input::get('subject'));
        return Redirect::to('boxes/' . $user_id)->withErrors($errors);
      } else {
        return Redirect::to('boxes/' . $user_id);
      }
    }
  }
}

?>
