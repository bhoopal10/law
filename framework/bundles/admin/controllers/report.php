<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:04 PM
 */

class Admin_Report_Controller extends Admin_Base_Controller
{
    public $restful=true;
    private function get_var()
    {
        if(Auth::check())
        {
            $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;
            return $role;
        }
    }

    public function get_SelectReport()
    {
        $user=$this->get_var();

        if($user=='lawyer')
        {
            $id=Auth::user()->id;
            return View::make('admin::lawyer/report.report_select')
                ->with('client',Client::getClientBylawyerID($id))
                ->with('case',Cases::getCaseDetailsByLawyerID($id));
        }
    }

    public function get_ReportCase()
    {
        $case_id=$_GET['id'];
        if($case_id == '0')
        {
            return Redirect::back();
        }
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/report.report_case_detail')
                ->with('report',Report::getCaseWise($case_id));
        }
    }
    public function get_ReportClient()
    {
        $client_id=$_GET['id'];
        if($client_id == '0')
        {
            return Redirect::back();
        }
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/report.report_client_detail')
                ->with('report',Report::getClientWise($client_id))
                ->with('client_id',$client_id);
        }
    }
    public function get_reportAllCases()
    {

        $user=$this->get_var();

        if($user =='lawyer')
        {
            return View::make('admin::lawyer/report.report_all_case')
                ->with('report',Report::getallcase());
        }
    }

} 