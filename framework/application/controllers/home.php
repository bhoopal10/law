<?php

    use Symfony\Component\HttpFoundation\RedirectResponse;

    class Home_Controller extends Base_Controller {

public $restful=true;


    public function get_home()
    {
        return View::make('home.index');
    }



    public function post_contactUs()
    {
        $values=Input::all();
        $content=$values['content'];
        $email=$values['email'];
        $name=$values['uname'];
        $mail = new PHPMailer();

        $mail->isSendmail();
//Set who the message is to be sent from
        $mail->setFrom($email,$name);
//Set an alternative reply-to address
        $mail->addReplyTo($email,$name);
//Set who the message is to be sent to
        $mail->addAddress('support@sirigroups.com','sirigroups');
        $mail->addAddress('sirigroupindia@gmail.com','sirigroups');

//Set the subject line
        $mail->Subject = 'Lawyerzz.in Contact Us';
        $mail->Body="Content ".$content."<br>";
        $mail->Body.="Name: ".$name."<br>";
        $mail->Body.="E-mail: ".$email."<br>";

//send the message, check for errors
        if (!$mail->send()) {
            return Redirect::back()->with('contact_fail',$mail->ErrorInfo);
        } else {
            return Redirect::to('/#contact')->with('contact_sent','Mail has been sent secussfully, we will get back to you soon, thank you .. ');
        }


    }
        public function get_Test()
        {
            return View::make('home.test');
        }
        public function get_register()
        {
            return View::make('home.register');
        }

}