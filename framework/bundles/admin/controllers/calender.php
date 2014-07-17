<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/28/13
 * Time: 10:28 AM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Calender_Controller extends Admin_Base_Controller{
    public $restful=true;
    private function get_var()
    {
        if(Auth::check()){ $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;}
        return $role;

    }
    public function get_Index()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
             $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->message_permission!=0)
            {
            return View::make('admin::lawyer/calender.calender');
             }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
    }

}