<?php

namespace App\Traits;

trait MailTrait
{
    protected function sendMail($to, $to_name, $sub, $body, $cusSub = false)
    {
        $from = 'nogor@gmail.com';
        $from_name = 'OSD';
        $subject = $sub ? $sub.' | OSD' : 'OSD';
        $subject = ! empty($cusSub) ? $cusSub : $sub;

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("$from", "$from_name");
        $email->setSubject("$subject");
        $email->addTo("$to", "$to_name");

        $email->addContent(
            'text/html',
            "<p>$body</p>"
        );

        // IF SEND ANY IMAGE
        // <img style='margin-top:50px; width:400px; height:80px !important;' src='IMAGE_URL' alt='img' data-responsive='true'>

        $sendgrid = new \SendGrid('API_KEY');
        try {
            $response = $sendgrid->send($email);

            return response()->json(true);
        } catch (Exception $e) {
            return response()->json(false);
        }
    }
}

/**
 * use your controller.
 *
 * @return $this
 */

/******************************************
    use App\Traits\MailTrait;
    use MailTrait; //use it inside the controller

    $toEmail    = "";
    $toName     = "Touch of Technology";
    $subject    = "Test Mail";
    $body       = "Test Mail for testing";

    $this->sendMail(
            $toEmail,
            $toName,
            $subject,
            $body
        );
    return  "success";
 */
