<?php

namespace App\Controllers;

use App\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;


class HomeController extends Controller
{
    public function index($request, $response, $args)
    {

        return $this->view->render($response, 'home.twig');
    }

    public function post($request, $response, $args)
    {
        $mail = new PHPMailer;

        $type = $_POST['type'];
        $name = $_POST['name'];
        $company = $_POST['company'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $details = $_POST['details'];
        
        $subject = 'New ' . $type . ' from CFK Website';

        $mail->setFrom($email, $name);
        $mail->addAddress('info@cfkcanada.org', 'Computers For Kids');
        $mail->addReplyTo('info@cfkcanada.org', 'Computers For Kids');
        $mail->ReturnPath='info@cfkcanada.org';

        $mail->isHTML(true);

        $body = "<p>New " . $type . " from Computers for Kids website:</p>" .
                "<p>Name: " . $name . "<br/>" .
                "Company: " . $company . "<br/>" .
                "Phone: " . $phone . "<br/>" .
                "Email: " . $email . "<br/>" .
                "Details: " . $details . "<br/>";

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $body;

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Success!';
        }

    }
}
