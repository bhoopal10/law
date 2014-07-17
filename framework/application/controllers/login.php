<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 17/10/13
 * Time: 8:01 PM
 * To change this template use File | Settings | File Templates.
 */

class Login_Controller extends Base_Controller {

    public $restful=true;
    public function get_Index()
    {
        return View::make('login.user_login');
    }
    public function post_UserCredential()
    {
        $username=Input::get('username');
        $password=Input::get('password');
        $credential=array(
            'username'=>$username,
            'password'=>$password
        );
        if(Auth::attempt($credential))
        {
            $history=array();
            $date = Date('Y-m-d-H.i:s');
            $ip=$_SERVER['REMOTE_ADDR'];
            $update=User::viewUserDetailByEmail($username);
            $id=$update->user_id;
            $val=$update->user_history;
            if($val!=NULL)
            {
                $val1=json_decode($val);
                array_push($history,$val1,$date,$ip);
                $res=json_encode($history);

            }
            else
            {
                array_push($history,$date,$ip);
                $res=json_encode($history);
            }

//          User::updateUserByID(array('user_history'=>$res),$id);
            $now=json_decode($res);
           echo "<pre>"; print_r($now);
            echo "ok";


        }
        else
        {
            echo "bye";
        }

    }

}