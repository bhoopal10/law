<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/25/13
 * Time: 3:39 PM
 * To change this template use File | Settings | File Templates.
 */

    class Admin_Appointment_Controller extends Admin_Base_Controller {
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
        return View::make('admin::lawyer/appointment.add_appointment')
            ->with('case',Cases::getCasesDetails(false));
        }
        if($user=='admin')
        {
//            return View::make('admin::admin/appointment.add_appointment')
//                ->with('case',Cases::getCasesDetails(false));
            return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
        }
    }
    public function get_ViewAppointment()
    {
        $date=false;
        if(isset($_GET['date']))
        {
            $date=implode('-',array_reverse(explode('/',$_GET['date'])));
            // echo $date;exit;
        }
        $user=$this->get_var();
        if($user=='lawyer')
        {
        return View::make('admin::lawyer/appointment.view_appointment')
            ->with('appointments',Appointment::getAppointment($date));
        }
         if($user=='associate')
        {
            $id=Auth::user()->id;
            $regexp="(^|,)$id(,|$)";

            $appointment=Appointment::where('status','!=','2')
            ->where(function($query) use ($regexp,$date){
                $query->where('lawyers','REGEXP',$regexp);
                if($date)
                {
                    $query->where('from_date','LIKE',"%$date%");
                }
            })
            ->order_by('appointment_id','desc')
            ->paginate(15);
            
// print_r($appointment);exit;           
        return View::make('admin::associate/appointment.view_appointment')
            ->with('appointments',$appointment);
        }
        if($user=='admin')
        {
//            return View::make('admin::admin/appointment.view_appointment')
//                ->with('appointments',Appointment::getAppointment());
            return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
        }

    }
    public function post_AddAppointment()
    {

        $lid=Auth::user()->id;
        $id=Input::get('id');
        $caseId=Input::get('case_link');
        if(!isset($id))
        {
                $values=Input::all();

                $lawyers='';
                if(isset($values['lawyer']))
                {
                    foreach($values['lawyer'] as $val)
                    {
                        $lawyers.=','.$val;
                    }
                }
                $lawyers=ltrim($lawyers,',');
                $fromDate=DateTime::createFromFormat('d/m/Y g:i a',$values['from_date'][0].' '.$values['from_date'][1]);
                $toDate=DateTime::createFromFormat('d/m/Y g:i a',$values['to_date'][0].' '.$values['to_date'][1]);
                $lawyer_id=Crypter::decrypt($values['lawyer_id']);
                 $data=array(
                 'lawyers'=>$lawyers,
                 'case_link'=>$values['case_link'],
                 'event_name'=>$values['event_name'],
                 'contact_person'=>$values['contact_person'],
                 'location'=>$values['location'],
                 'from_date'=>$fromDate,
                 'to_date'=>$toDate,
                 'lawyer_id'=>$lawyer_id,
                 'date_created'=>$values['date_created']
                    );

                $res=Appointment::addAppointment($data);
                $noti=array();
                /* notification for Main lawyers */
                  array_push($noti,array('uid1'=>$lid,'uid2'=>$lid,'event_id'=>'*'.$res,'text'=>$values['event_name']." Today Appointment",'notification_date'=>$values['from_date'][0]));
                if(isset($values['lawyer']))
                {
                    foreach($values['lawyer'] as $law_id)
                    {
                    /*  notification for associate lawyers     */
                        array_push($noti,array('uid1'=>$lid,'uid2'=>$law_id,'event_id'=>'*'.$res,'text'=>$values['event_name']." Today Appointment",'notification_date'=>$values['from_date'][0]));

                    }
                }
                Notifications::addMultiNotification($noti);

                if($res) 
                {
                    /* Mail */
                    $clientId=Cases::getClient($caseId);
                    $client=Client::getClientDetailByID($clientId);
                    $lawyer=liblawyer::lawyerByID($lawyer_id);
                    $body=View::make('admin::lawyer/template.appointment_mail')->with('data',$values);
                    $mail = new PHPMailer();
                    $mail->setFrom($lawyer->user_email,$lawyer->first_name.''.$lawyer->last_name);
                    $mail->addReplyTo($lawyer->user_email,$lawyer->first_name.''.$lawyer->last_name);
                    $mail->addAddress($lawyer->user_email,$lawyer->first_name.''.$lawyer->last_name);
                    $mail->addAddress($client->email,$client->client_name);
                     if(isset($values['lawyer']))
                        {
                            foreach($values['lawyer'] as $val)
                            {
                                $lawyer=liblawyer::lawyerByID($val);
                                $mail->addAddress($lawyer->user_email,$lawyer->first_name.''.$lawyer->last_name);
                            }
                        }
                    $mail->Subject ='Appointment';
                    $mail->Body=$body;
                    $mail->send();
                    /*End Mail function*/
                    /* SMS */
                     $check=liblawyer::SmsCountByLawyerID($lawyer_id);
                     if($check->setting->sms_permission && $check->count <= $check->setting->no_sms)
                      {
                            $ids=$lawyer_id.','.$lawyers;
                            $ids=rtrim($ids,',');
                            $users=liblawyer::userByIds($ids);
                            $nos=count($users);
                            $mobile='';
                            foreach ($users as $value)
                            {
                                $mobs=explode(',',$value->mobile);
                                if($mobs){foreach ($mobs as $num) 
                                    {
                                        $mobile.=($mobile)?',91'.$num:'91'.$num;
                                    }}
                               
                            }
                            // $mobile=urlencode($mobile);
                            $dates=$values['from_date'][0].' '.$values['from_date'][1].' To '.$values['to_date'][0].' '.$values['to_date'][1];
                           $data='appointment: '.$dates."\nperson: ".$values['contact_person']."\nLocation: ".$values['location'];
                           $count=strlen($data);
                           if($count > 159 )
                           {
                              $data=substr($data,0,159);
                           }
                           $data=urlencode($data);
                           $url = "http://bulksms.mysmsmantra.com/WebSMS/SMSAPI.jsp?username=sirigroup&password=India123&sendername=netsms&mobileno=$mobile&message=$data";
                           $ch = curl_init($url);
                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                           $res = curl_exec($ch);
                           curl_close($ch);
                          if($res)
                           {
                             liblawyer::SmsCountUpdate($lawyer_id,$nos);
                            }
                      }
                      else
                      {
                        
                        $ids=$lawyer_id.','.$lawyers;
                            $ids=rtrim($ids,',');
                            $users=liblawyer::userByIds($ids);
                            
                      }
                                             
                    /* End SMS */
                   return Redirect::back()->with('status',"Appointment Added Successfully");
                }
                
                else
                {
                    return Redirect::back()->with('status',"Unable to fix Appointment Please try again");
                }
        }

        $lawyerses='';
        $lawyer=Input::get('lawyer');
        if(isset($lawyer)){
            foreach($lawyer as $val)
            {
                $lawyerses.=','.$val;
            }
        }
        $lawyers=ltrim($lawyerses,',');
        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
        $appointment_id=Input::get('id');
//        $case_link=Input::get('case_link');
        $event_name=Input::get('event_name');
        $location=Input::get('location');
        $from_date=Input::get('from_date');
         $to_date=Input::get('to_date');
        $contact_person=Input::get('contact_person');
        $fromDate=DateTime::createFromFormat('d/m/Y g:i a',$from_date[0].' '.$from_date[1]);
        $toDate=DateTime::createFromFormat('d/m/Y g:i a',$to_date[0].' '.$to_date[1]);
        $data=array(
            'appointment_id' => $appointment_id,
//            'case_link' => $case_link,
            'event_name' => $event_name,
            'contact_person'=>$contact_person,
            'location' => $location,
            'from_date' => $fromDate,
           'to_date' => $toDate,
            'lawyers' => $lawyers
        );

        $app=(array)Session::get('appointment');
        $app1=array_splice($app,0,7);
        $update=$data;
        if($update==null)
            {
                return Redirect::to_route('ViewAppointment')->with('error','Your not edit fields');
            }
        else
            {
                $res=Appointment::updateAppointment($update,$appointment_id);
                if($res) return Redirect::to_route('ViewAppointment')->with('status','Appointment Updated Successfully');
                else return Redirect::to_route('ViewAppointment')->with('error','Appointment failed to update try again');
            }

    }


    public function get_EditAppointment($id)
    {
        $id1=$id;
        $user=$this->get_var();
        $verify=Appointment::IsAvailable('appointment_id',$id1);
        if($verify > 0)
        {
            if($user=='lawyer')
            {
            return View::make('admin::lawyer/appointment.edit_appointment')
                ->with('case',Cases::getCasesDetails(false))
                ->with('appointment',Appointment::getAppointmentByID($id1));
            }
            if($user=='admin')
            {
    //            return View::make('admin::admin/appointment.edit_appointment')
    //                ->with('case',Cases::getCasesDetails(false))
    //                ->with('appointment',Appointment::getAppointmentByID($id1));
                return Redirect::to_route('Login')->with('status','You are not asllowed to access this link!');
            }
        }
        return Redirect::to_route('ViewAppointment');
    }

    public function get_DeleteAppointment($id)
    {
        $res=Appointment::deleteAppointmentByID($id);
        if($res) return Redirect::back()->with('status','Successfully deleted');
        else return Redirect::back()->with('status','Faild to delete');

    }

    public function get_AppointmentStatus($id1)
    {
        $value=explode(',',$id1);
        $id=$value[0];
        $status=$value[1];
        if($status==0)
        {
            $update=array('status'=>'0');
        }
        elseif($status==1)
        {
            $update=array('status'=>'1');
        }
        elseif($status==2)
        {
            $update=array('status'=>'2');
        }
        $res=Appointment::updateAppointment($update,$id);
        return Redirect::back();


    }

    public function post_MultiAppointmentDelete()
    {
        $value=Input::all();
        if($value)
            {
            $ids=$value['associate_delete'];
            $res=Appointment::deleteMultiAppointment($ids);
            return ($res) ? Redirect::back()->with('status','Deleted Successfully') : Redirect::back()->with('error','Error occurred to delete ');
            }
        else{
            return Redirect::back();
        }
    }

    public function get_AppointmentDetail($id)
    {
        $detail=Appointment::getAppointmentByID($id);
        $user=$this->get_var();
        if($user=='lawyer')
        {
        return View::make('admin::lawyer/appointment.appointment_detail')
            ->with('appointments',$detail);
        }
        elseif($user=='associate')
        {
            return View::make('admin::associate/appointment.appointment_detail')
                ->with('appointments',$detail);
        }

    }
    public function post_CheckAppointment()
    {
        $id       = Input::get('val');
        $fromDate = Input::get('from');
        $toDate   = Input::get('to');
        $fromDate = date('Y-m-d H:i:s',$fromDate);
        $toDate   = date('Y-m-d H:i:s',$toDate);
        $sql="SELECT to_date FROM `appointment` WHERE `lawyers` REGEXP '(^|,)$id(,|$)' AND from_date BETWEEN '$fromDate' AND '$toDate' OR to_date BETWEEN '$fromDate' AND '$toDate' ";
        // echo $sql;
        $data=DB::query($sql);
        if($data)
        {
            echo $id;
        }
        else
        {
            echo false;
        }
    }

}