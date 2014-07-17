<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/25/13
 * Time: 11:58 AM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Contact_Controller extends Admin_Base_Controller {
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
            if($perm->contact_permission!=0)
            {
             return View::make('admin::lawyer/contact.add_contact');
              }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/contact.add_contact');
        }
        if($user=='associate')
        {
            return View::make('admin::associate/contact.add_contact');
        }
    }
    public function get_ViewContacts()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
            $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->contact_permission!=0)
            {
            $contact=libcontact::getcontactgroupByID(Auth::user()->id);
                if($contact)
                    {
                        $contacts=json_decode($contact->contact_details);
                        $con=Paginator::make($contacts,count($contacts),15);
                        return View::make('admin::lawyer/contact.view_contacts')
                           ->with('contact',$con);
                      }
                else
                {
                    return View::make('admin::lawyer/contact.view_contacts');
                }
            }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/contact.view_contacts');
        }
        if($user=='associate')
        {
            return View::make('admin::associate/contact.view_contacts');
        }
    }

    public function get_EditContact($contactId)
    {
        $contactID=Crypter::decrypt($contactId);
        $id=Auth::user()->id;
        $user=$this->get_var();
        if($user=='lawyer')
        {
            $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->contact_permission!=0)
            {
        
            return View::make('admin::lawyer/contact.edit_contact')
            ->with('id',$contactID)
            ->with('contact',Contacts::getContactByID($id,$contactID));
              }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/contact.edit_contact')
                ->with('id',$contactID)
                ->with('contact',Contacts::getContactByID($id,$contactID));
        }
        if($user=='associate')
        {
            return View::make('admin::associate/contact.edit_contact')
                ->with('id',$contactID)
                ->with('contact',Contacts::getContactByID($id,$contactID));
        }
    }

    public function get_DeleteContact($contactId)
    {
        $contactID=Crypter::decrypt($contactId);
        $id=Auth::user()->id;
        $arr=Contacts::getContactByID($id);
        array_splice($arr,$contactID,1);
        if($arr!=null)
        {
        $update=json_encode($arr);
        $data=array('contact_details'=>$update);
        }
        else
        {
           $data=array('contact_details'=>'');
        }
        $res=Contacts::updateContacts($data,$id);
        if($res) return Redirect::back()->with('status','Deleted Successfully');
        else return Redirect::back()->with('status','Failed to delete');


    }

    public function post_AddContacts()
    {
        $contacts=array();
        $values=Input::all();
        $id=$values['lawyer_id'];
        array_splice($values,0,1);//remove lawyer_id in values
        array_push($contacts,$values);//push values to contact
        $contact=json_encode($contacts);//encode to json format
        $con=libcontact::getcontactByID(Auth::user()->id);

        if($con!=null)
        {
            array_push($con,$values);
            $conFilter=array_filter($con);//remove empty value element
            $contactValues=array_values($conFilter);//arrange index order wise
            $contactDetail=array('contact_details'=>json_encode($contactValues));//array to update database
//            print_r($contactDetail);exit;
            $res=Contacts::updateContacts($contactDetail,$id);
            if($res) return Redirect::to_route('Contacts')->with('status','Contact is successfully updated');
            else return Redirect::to_route('Contacts')->with('status','Contact is unable to updated');
        }
//        new lawyer contacts
        $contactDetail=array(
            'user_id'=>$id,
            'contact_details'=>$contact
        );
        $res=Contacts::addContacts($contactDetail);
        if($res) return Redirect::to_route('Contacts')->with('status','Contact is successfully Added');
        else return Redirect::to_route('Contacts')->with('status','Contact is unable to Add');

        }

    public function post_UpdateContact()
    {
        $values=Input::all();
        $id=$values['lawyer_id'];
        $key=$values['key'];
        array_splice($values,0,2);//remove lawyer_id in values
        $contact=Contacts::getContactByID($id);
        $arr=array();
        foreach($contact as $value)
        {
            array_push($arr,(array)$value);
        }
        $arr1=array($key=>$values);
        $replace=array_replace($arr,$arr1);
        $update=json_encode($replace);
        $update1=array('contact_details'=>$update);
        $res=Contacts::updateContacts($update1,$id);

        if($res) return Redirect::to_route('ViewContacts')->with('status','Contact updated successfully');
        else return Redirect::to_route('ViewContacts')->with('status','Contact update failed');
    }
}