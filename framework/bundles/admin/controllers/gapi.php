<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/5/14
 * Time: 9:22 PM
 */

class Admin_Gapi_Controller extends Admin_Base_Controller
{
    public $restful=true;
    public function get_Document()
    {
        return View::make('admin::gapi.upload_document');
    }

} 