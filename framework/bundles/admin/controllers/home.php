<?php

class Admin_Home_Controller extends Admin_Base_Controller {

public $restful=true;

    private function get_var()
    {
        if(Auth::check())
        {
            $roles=libRole::getRole(Auth::user()->user_role);
            $role=$roles->role_name;
        }
        return $role;
    }

    public function get_home()
    {

        $user=$this->get_var();
        if($user=='admin')
        {
           return View::make('admin::admin/home.index');
        }
        elseif($user=='lawyer')
        {

           return View::make('admin::lawyer/home.index');
        }
        elseif($user=='associate')
        {
            return View::make('admin::associate/home.index');
        }

    }

}