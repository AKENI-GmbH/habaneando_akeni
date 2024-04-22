<?php

namespace App\Services;

use Illuminate\Support\Facades\View;
use Mailjet\Client;
use Mailjet\Resources;

class MailjetEmailService
{
 protected $mailjet;

 public function __construct()
 {
  $this->mailjet = new Client(
   env('MAILJET_API_KEY'),
   env('MAILJET_API_SECRET'),
   true,
   ['version' => 'v3.1']
  );
 }

 public function sendEmail($toEmail, $subject, $template, $data = [])
 {

  $data['subject'] = $subject;

  $htmlContent = View::make($template, $data)->render();



  $body = [
   'Messages' => [
    [
     'From' => [
      'Email' => config('mail.from.address'),
      'Name' => config('mail.from.name')
     ],
     'To' => [
      [
       'Email' => $toEmail,
       'Name' => ''
      ]
     ],
     'subject' => $subject,
     'HTMLPart' => $htmlContent
    ]
   ]
  ];

  $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);

  return $response->success();
 }
}
