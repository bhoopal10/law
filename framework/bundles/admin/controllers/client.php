<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/9/13
 * Time: 11:24 AM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Client_Controller extends Admin_Base_Controller {
    public $restful=true;
    private function get_role()
    {
        if(Auth::check())
        {
            $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;
            return $role;
        }
    }
    public function post_AddClient()
    {
        $detail=Input::all();
        $data=array('update_by'=>$detail['update_by'],
                    'client_name'=>$detail['client_name'],
                    'mobile'=>$detail['mobile'],
                    'phone'=>$detail['phone'],
                    'email'=>$detail['email'],
                    'address'=>$detail['address'],
                    'city'=>$detail['city'],
                    'state'=>$detail['state'],
                    'pincode'=>$detail['pincode']);
        $val=$detail['client_name'];
            $res=Client::addClient($data);
            if($res){ return $val.','.$res;}
            else{ return Redirect::to_route('Cases')->with('status','Problem to Add Client details');}


    }
    public function post_ClientAdd()
    {
        $detail=Input::all();
        $data=array('update_by'=>$detail['update_by'],
                    'client_name'=>$detail['client_name'],
                    'mobile'=>$detail['mobile'],
                    'phone'=>$detail['phone'],
                    'email'=>$detail['email'],
                    'address'=>$detail['address'],
                    'city'=>$detail['city'],
                    'state'=>$detail['state'],
                    'pincode'=>$detail['pincode']);

         $res=Client::addClient($data);

        if($res){ return Redirect::back()->with('status','Your Client details added successfully');}
        else{ return Redirect::back()->with('error','Problem to Add Client details');}


    }

    public function get_CreateClient()
    {
        $user=$this->get_role();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/client.create_client');
        }
        elseif($user=='associate')
        {
            return View::make('admin::associate/client.create_client');
        }
    }

    public function get_ViewClient()
    {
        $user=$this->get_role();
        $userID=Auth::user()->id;
        if($user=='lawyer')
        {

            return View::make('admin::lawyer/client.view_client')
                ->with('client',Client::getClientBylawyerIDwithPaginate($userID));
        }
        elseif($user=='associate')
        {
            $ass_id=User::gettingLawyerIDByAssociateID($userID);
            return View::make('admin::associate/client.view_client')
                ->with('client',Client::getClientBylawyerIDwithPaginate($ass_id->uid2));
        }
    }

    public function get_EditClient($ids)
    {
        $id=$ids;
        $user=$this->get_role();
        if($user=='lawyer')
        {

            return View::make('admin::lawyer/client.edit_client')
                ->with('client',Client::getClientDetailByID($id));
        }
        elseif($user=='associate')
        {

            return View::make('admin::associate/client.edit_client')
                ->with('client',Client::getClientDetailByID($id));
        }
    }

    public function post_ClientUpdate()
    {
        $values=Input::all();
        $client=(array)Session::get('client');
        $update=array_diff_assoc($values,$client);
        $id=$client['client_id'];
        if($update!=null)
        {
            $res=Client::updateByClientID($update,$id);
            if($res) return Redirect::to_route('ViewClient')->with('status','Successfully updated');
            else return Redirect::to_route('ViewClient')->with('error',"update failed");
        }
        else
        {
            return Redirect::to_route('ViewClient')->with('error',"Your not changed anything");
        }
    }
    public function get_DeleteClient($id)
    {
        $verify=Cases::IsAvailable('client_id',$id);
        if($verify > 0)
        {
            return Redirect::back()->with('status',"This Client Already has case <a href='../cases/view-cases' >Click Here</a> to view cases");
        }
        $res=Client::deleteClientByID($id);
        return ($res) ? Redirect::back()->with('status','Your Client is successfully deleted') : Redirect::back()->with('status','Your Client is failed to delete');
    }
    public function get_SearchClient()
    {
        $value=$_GET['client_id'];
        $client=Client::getClientDetailByID($value);
        $user=$this->get_role();
        if($user=='lawyer')
        {
        return View::make('admin::lawyer/client.search_client')
            ->with('client',$client);
        }
    }
    public function post_CaseByClient()
    {
       if($_POST)
       {
           if($clientId=Input::get('client_id'))
           {
            $case=Client::caseByClientID($clientId);
            $due=Payment::where('to_user','=',$clientId)
                    ->order_by('payment_id','desc')
                    ->first();
            $due=($due)?$due->due_amount:'0';
            $cases['due']=$due;
            $cases['case_id']=(array)$case;
            echo json_encode($cases);
           }
       }
    }

}