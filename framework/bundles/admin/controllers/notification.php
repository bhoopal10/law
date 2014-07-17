<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/19/13
 * Time: 10:03 PM
 */

class Admin_Notification_Controller extends Admin_Base_Controller
{
    public $restful=true;
    public function get_ReadNotification($ids)
    {
        $value=explode(',',$ids);
//        print_r($value);
//        echo $ids;exit;
        $notf_id=$value[0];
        $event_id=$value[1];
        $prefix=$event_id[0];
        $data=array('read_status'=>1);
        $res=Notifications::updateNotification($data,$notf_id);

        if($prefix=='$')
        {
            return Redirect::to_route('CaseDetail',array(substr($event_id,'1')));
        }
        elseif($prefix=='@')
        {
            return Redirect::to_route('MessageDetail',array(substr($event_id,'1')));
        }
        elseif($prefix='*')
        {
            return Redirect::to_route('AppointmentDetail',array(substr($event_id,'1')));
        }
    }

} 