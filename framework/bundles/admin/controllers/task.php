<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/27/13
 * Time: 12:47 AM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Task_Controller extends Admin_Base_Controller
{
    public $restful=true;
    private function get_var()
    {
        if(Auth::check()){ $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;}
        return $role;

    }
    public function get_Index()
    {
        $user=$this->get_var();
        if($user=='admin')
        {
            return View::make('admin::admin/task.add_task');
        }

    }
    public function get_ViewTasks()
    {
        $user=$this->get_var();
        if($user=='admin')
        {
            return View::make('admin::task.view_task');
        }
    }

}