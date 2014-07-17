<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 5/14/14
 * Time: 5:59 AM
 */

class Admin_Demo_Controller extends Admin_Base_Controller
{
    public $restful=true;

    public function get_lawyerDemo ()
    {
        return View::make('admin::lawyer/demo.lawyerdemo');
    }
} 