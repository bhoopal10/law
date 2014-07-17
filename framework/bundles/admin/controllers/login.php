<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 18/10/13
 * Time: 12:50 PM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Login_Controller extends Admin_Base_Controller  {
    public $restful=true;


    public function get_Index()
    {
        if(Auth::check())
        {
            return Redirect::to_route('Home')
                ->with('status',Session::get('status'));
        }
        return View::make('admin::login.admin_login')
            ->with('status',Session::get('status'));
    }

    public function get_ForgetPassword()
    {
        if(Auth::check())
        {
            return Redirect::to_route('Home')
                ->with('status',Session::get('status'));
        }
        return View::make('admin::login.reset_password')
            ->with('status',Session::get('status'));
    }

    public function post_ResetPassword()
    {
        $value=Input::all();
        if($value)
        {
            $email=$value['email'];
            $user=User::getUserByEmail($email);
            if($user)
            {
                $resetPassword=Str::random(5, 'alpha');
                $data=array("password"=>Hash::make($resetPassword));
                $res=User::updatelawyerById($data,$user->id);

                if($res)
                {
                    $mail= new PHPMailer();
                    $mail->isSendmail();
                    $body=View::make('admin::login.mail_reset_password')
                    ->with('username',$user->username)
                    ->with('password',$resetPassword);
                    $mail->setFrom('admin@lawyerzz.in','Lawyerzz.in');
                    $mail->addReplyTo('admin@lawyerz.in','Lawyerzz.in');
                    $mail->addAddress($user->user_email,$user->first_name);
                    $mail->Subject = 'New Password';
                    $mail->Body=$body;

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message sent!";
                }
                    return Redirect::back()->with('status',"<i class=' icon-ok'></i> Your Password Successfully Reset and password sent your E-mail ");
                }
            }
            else
            {
                return Redirect::back()->with('error',"<i class='icon-remove-sign'></i>Email ID not found. Please enter registered Email ID");
            }


        }
    }
    public function post_AdminAuth()
    {

//        echo Session::get('redirect');exit;
        $username=Input::get('username');
        $password=Input::get('password');
        $credential=array(
            'username'=>$username,
            'password'=>$password
        );
        if(Auth::attempt($credential))
        {
            $role=libRole::getRole(Auth::user()->user_role);

            if($role->role_name === 0)
            {
                Auth::Logout();
                Session::forget('user');
                return Redirect::to_route('Login')->with('status','Your account is not activated please contact admin'."<b> (9845554820)</b>");
            }
            else
            {
                return Redirect::to_route('Home');
            }

         }
        else
        {
            return Redirect::to_route('Login')
                ->with('error',"<i class='icon-remove-sign'></i>authentication failed");
        }
    }

}