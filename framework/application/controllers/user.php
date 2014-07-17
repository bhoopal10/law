<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/19/13
 * Time: 12:37 AM
 */

class User_Controller extends Base_Controller
{
    public $restful=true;
    public function post_AddTrailUser()
    {
        $values=Input::all();
        $date=date_create(date('Y-m-d'));
        date_add($date, date_interval_create_from_date_string('15 days'));
        $exp_date=date_format($date, 'Y-m-d');
        $input=array('email'=>$values['user_email'],'username'=>$values['username']);
        $rule=array('email'=>'required|email|unique:users,user_email','username'=>'required|unique:users,username');
        $validation=Validator::make($input,$rule);
        if($validation->fails())
        {
            return Redirect::back()->with('error',$validation->errors->first());
        }
        $data=array(
            'first_name'=>$values['first_name'],
            'last_name'=>$values['last_name'],
            'user_email'=>$values['user_email'],
            'username'=>$values['username'],
            'password'=>Hash::make($values['password']),
            'lawyer_id'=>$values['lawyer_id'],
            'lawyer_subject'=>$values['lawyer_subject'],
            'mobile'=>$values['mobile'],
            'exp_date'=>$exp_date,
            'updated_by'=>1,
            'user_role'=>2,
            'payment'=>'trail'

        ) ;
        $res=User::addUser($data);
        $case_statics=array('uid'=>$res);//to add user_id to case_static table
        Cases::addCaseStatics($case_statics);
        User::insertuserIDtoSettings(array('ui'=>$res));
        if($res)
        {
            $update=array('uid1'=>$res,'uid2'=>'1');
            User::addLawyers_id($update);//to update lawyers_id table
            $admin=User::find(1);
            $body=View::make('template.email_new_user')
            ->with('name',$values['first_name'])
            ->with('username',$values['username'])
            ->with('email',$values['user_email']);
              $email= new PHPMailer();
                $email->isSendmail();
                $email->setFrom('admin@lawyerzz.in','Lawyerzz');
                $email->addReplyTo('admin@lawyerzz.in','Lawyerzz');
                $email->addAddress($values['user_email'],$values['first_name']);
                $email->addAddress('sirigroupindia@gmail.com','Lawyerzz');
                $email->Subject = 'Trial User';
                $email->Body=$body;
                $email->send();
          // echo $admin->user_email;
          //    echo $mail->ErrorInfo;exit;
            return Redirect::to_route('home')->with('status','Your account is created Successfully');
        }
        else
        {
            return Redirect::to_route('home')->with('status','Problem to create an account');
        }
    }

} 