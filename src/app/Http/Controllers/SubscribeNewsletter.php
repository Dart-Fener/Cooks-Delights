<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Newsletter;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SubscribeNewsletter extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('newsletter.subscribe');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        Newsletter::updateOrInsert([
            'email' => $request->input('email')
        ]);

        $mailContact = new PHPMailer(true);

        try {
            //Server settings
            $mailContact->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mailContact->isSMTP();                                            //Send using SMTP
            $mailContact->Host       = 'smtp.mailersend.net';                     //Set the SMTP server to send through
            $mailContact->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mailContact->Username   = 'MS_sE3ruZ@trial-z3m5jgr326ogdpyo.mlsender.net';                     //SMTP username
            $mailContact->Password   = 'mssp.1BVPYE4.pr9084z1pvvgw63d.1GsN69I';                               //SMTP password
            $mailContact->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mailContact->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mailContact->setFrom('MS_sE3ruZ@trial-z3m5jgr326ogdpyo.mlsender.net', 'Mailersend');
            $mailContact->addAddress($request->input('email'));     //Add a recipient
            //$mailContact->addAddress('ellen@example.com');               //Name is optional
            $mailContact->addReplyTo('info@example.com', 'Information');
            //$mailContact->addCC('cc@example.com');
            //$mailContact->addBCC('bcc@example.com');

            //Attachments
            //$mailContact->addAttachment('/var/tmp/file.tar.gz');         //Add attachments or comment they
            //$mailContact->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name or comment they

            //Content
            $mailContact->isHTML(true);                                  //Set email format to HTML
            $mailContact->Subject = 'Thanksgiving';
            $mailContact->Body = '<h1>Thank you for subscribed to our newsletter ,<br>';
            $mailContact->Body .= 'You will be always update to date to our new recipes<br>';
            $mailContact->Body .= 'See ya!!!</h1>';
            $mailContact->AltBody .= 'Messagge without html';

            $mailContact->send();
            'Message has been sent';
        } catch (Exception $e) {
            "Message could not be sent. Mailer Error: {$mailContact->ErrorInfo}";
        }

        $mailOwner = new PHPMailer(true);

        try {
            //Server settings
            $mailOwner->SMTPDebug = SMTP::DEBUG_OFF;  //Enable verbose debug output
            $mailOwner->isSMTP(); //Send using SMTP
            $mailOwner->Host = 'smtp.mailersend.net'; //Set the SMTP server to send through
            $mailOwner->SMTPAuth = true; //Enable SMTP authentication
            $mailOwner->Username = 'MS_sE3ruZ@trial-z3m5jgr326ogdpyo.mlsender.net'; //SMTP username
            $mailOwner->Password = 'mssp.1BVPYE4.pr9084z1pvvgw63d.1GsN69I'; //SMTP password
            $mailOwner->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable implicit TLS encryption
            $mailOwner->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mailOwner->setFrom('MS_sE3ruZ@trial-z3m5jgr326ogdpyo.mlsender.net', 'Mailersend');
            $mailOwner->addAddress('john.doe@example.com', 'John Doe');    //Add a recipient
            //$mailContact->addAddress('ellen@example.com'); //Name is optional
            $mailOwner->addReplyTo('info@example.com', 'Information');
            //$mailContact->addCC('cc@example.com');
            //$mailContact->addBCC('bcc@example.com');

            //Attachments
            //$mailContact->addAttachment('/var/tmp/file.tar.gz');         //Add attachments or comment they
            //$mailContact->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name or comment they

            //Content
            $mailOwner->isHTML(true);                                  //Set email format to HTML
            $mailOwner->Subject = 'Request';
            $mailOwner->Body = '<h1>New subscribed contact<br>';
            $mailOwner->Body .= 'Email: '.$request->input('email').'</h1>';
            $mailOwner->AltBody = 'Messagge without html';

            $mailOwner->send();
            'Message has been sent';
        } catch (Exception $e) {
            "Message could not be sent. Mailer Error: {$mailOwner->ErrorInfo}";
        }

        return view('newsletter.thankyou');
    }

}
