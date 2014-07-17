<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/30/13
 * Time: 5:47 PM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Message_Controller extends Admin_Base_Controller
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

    public function get_Inbox()
    {
        $user=$this->get_var();
        if($user=='associate')
        {
            return View::make('admin::associate/message.inbox')
                ->with('inbox',Message::getInboxMessagePaginate(Auth::user()->id));
        }
        if($user=='lawyer')
        {
            $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->message_permission!=0)
            {
                return View::make('admin::lawyer/message.inbox')
                ->with('inbox',Message::getInboxMessagePaginate(Auth::user()->id));
             }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
            
        }
        if($user=='admin')
        {
            return View::make('admin::admin/message.inbox')
                ->with('inbox',Message::getInboxMessagePaginate(Auth::user()->id));
        }

    }
    public function get_Sentbox()
    {
        $user=$this->get_var();
        if($user=='associate')
        {
            return View::make('admin::associate/message.sentbox')
                ->with('inbox',Message::getSentboxMessagePaginate(Auth::user()->id));
        }
        if($user=='lawyer')
        {
             $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->message_permission!=0)
            {
            return View::make('admin::lawyer/message.sentbox')
                ->with('inbox',Message::getSentboxMessagePaginate(Auth::user()->id));
             }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/message.sentinbox')
                ->with('inbox',Message::getSentboxMessagePaginate(Auth::user()->id));
        }

    }

    public function get_CreateMessage()
    {
        $user=$this->get_var();
        if($user=='associate')
        {
            return View::make('admin::associate/message.create_message');
        }
        if($user=='lawyer')
        {
            $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->message_permission!=0)
            {
            return View::make('admin::lawyer/message.create_message');
             }
             else{
                 return Redirect::to_route('Home')->with('status','Your no allow to access this link');
             }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/message.create_message');
        }


    }

    public function post_SendMessage()
    {
        $values=Input::all();
        $to=  explode(',', $values['to']);
        foreach($to as $val){
        $data=array(
            'from_id'=>$values['from'],
            'to_id'=>$val,
            'text'=>$values['message']
            );
            
        $res=Message::addMessage($data);
        Notifications::addNotification(array('uid1'=>$val,'uid2'=>$values['from'],'event_id'=>'@'.$res,'text'=>'New Message'));
        }
        if($res)
        {
            return Redirect::back()->with('status',"Your message as been sent");

        }
        else
        {
            return Redirect::back()->with('status',"Failed to send message");
        }
    }
    public function get_DeleteMessage($ids)
    {
        $mod=  substr($ids, 0, 1);
        $id=substr($ids,1);
        if($mod=='@')
        {
            $data=array('to_status'=>1);
        }
        elseif($mod=='$')
        {
            $data=array('from_status'=>1);
        }
        $res=  Message::deleteMessage($data, $id);
        return ($res) ? Redirect::back()->with('status','Successfully Deleted') : Redirect::back()->with('status','Not deleted'); 
                
       
    }
    public function post_MultiMessageDelete()
    {
        $value=Input::all();
        $mod=key($value);
        if($mod == 'sentbox_delete')
        {
           $id=$value['sentbox_delete'];
            $data=array('from_status'=>1);
           $res=Message::multiMessageDelete($id,$data);
        }
       if($mod == 'inbox_delete')
       {
           $id=$value['inbox_delete'];
           $data=array('to_status'=>1);
           $res=Message::multiMessageDelete($id,$data);
       }
       return ($res) ? Redirect::back()->with('status','Successfully deleted') : Redirect::back()->with('error','Failed to delete');

    }
    public function get_MessageDetail($id)
    {
        $user=$this->get_var();
        if($user=='associate')
        {
            return View::make('admin::associate/message.message_detail')
                ->with('message',Message::getMessageByMsgID($id));
        }
        if($user=='lawyer')
        {
            $perm=liblawyer::getstatusByID(Auth::user()->id);
            if($perm->message_permission!=0)
            {
                return View::make('admin::lawyer/message.message_detail')
                    ->with('message',Message::getMessageByMsgID($id));
            }
            else
            {
                return Redirect::to_route('Home')->with('status','Your no allow to access this link');
            }
        }
    }

}