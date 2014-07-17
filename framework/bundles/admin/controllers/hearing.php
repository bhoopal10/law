<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/1/13
 * Time: 4:13 PM
 * To change this template use File | Settings | File Templates.
 */
include("automsg.php");
class Admin_Hearing_Controller extends Admin_Base_Controller {
    public $restful=true;

    private function get_var()
    {
        if(Auth::check())
        {
            $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;
            return $role;
        }
    }
    public function get_Index()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/hearing.add_hearing');
        }
        elseif($user=='admin')
        {
            return Redirect::back()
                ->with('status','Your not allow to use this link');
        }
        elseif($user=='associate')
        {
            return View::make('admin::associate/hearing.add_hearing');
        }
    }
    public function get_ViewHearing()
    {

        $user=$this->get_var();
        if($user=='lawyer')
        {
            $hearing=Hearing::getHearing();
            $hearing_paginate=Hearing::getHearingByLawyerIDPaginate(Auth::user()->id);
//            print_r($hearing_paginate);exit;
            return View::make('admin::lawyer/hearing.view_hearing')
                ->with('hearing',$hearing_paginate)
                ->with('hearing_select',$hearing);
        }
        elseif($user=='admin')
        {
            return Redirect::back()
                ->with('status','Your not allow to use this link');
        }
        elseif($user=='associate')
        {
            $lawyer_id=User::gettingLawyerIDByAssociateID(Auth::user()->id);
            $hearing=Hearing::getHearingByLawyerAssociateID($lawyer_id->uid2,Auth::user()->id);
            $hearing_paginate=Hearing::getHearingByLawyerAssociateIDPaginate($lawyer_id->uid2,Auth::user()->id);
            return View::make('admin::associate/hearing.view_hearing')
                ->with('hearing_select',$hearing)
                ->with('hearing',$hearing_paginate);
        }
    }
    public function post_AddHearing()
    {
        $data=Input::all();
        $res=Hearing::addHearing($data);
        if($res)
        {
            $hearings=(object)$data;
            $case_id=$data['case_id'];
            $case_data=array('last_hearing_id'=>$res);
            Cases::updateCaseByID($case_data,$case_id);
            $case=Cases::getCaseDetailsByID($case_id);
            $lawyer=DB::query("SELECT first_name,last_name,username,user_email,mobile,address from users where id= ?",array($data['lawyer_id']));
            $client=DB::query("SELECT client_name,mobile,email from client where client_id =?",array($data['client_id']));
            if($lawyer && $client)
            {
                $body=View::make('admin::lawyer/template.hearing_message')
                    ->with('lawyer',$lawyer[0])
                    ->with('client',$client[0])
                    ->with('hearing',$hearings);
                $mail = new PHPMailer();
                $mail->isSendmail();
                $mail->setFrom($lawyer[0]->user_email,$lawyer[0]->first_name.''.$lawyer[0]->last_name);
                $mail->addReplyTo($lawyer[0]->user_email,$lawyer[0]->first_name.''.$lawyer[0]->last_name);
                $mail->addAddress($client[0]->email,$client[0]->client_name);
                $mail->addAddress($lawyer[0]->user_email,$lawyer[0]->first_name);
                $mail->Subject = $client[0]->client_name.'Hearings';
                $mail->Body=$body;
                if (!$mail->send()) {
                    $error=$mail->ErrorInfo;
                }
                $lawyer_name=$lawyer[0]->first_name.''.$lawyer[0]->last_name;
                $client_name=$client[0]->client_name;
                $hearing_date=$hearings->next_hearing_date;
                $mobile=array($client[0]->mobile,$lawyer[0]->mobile);
                $case_no=$case->case_no;
                $sms_data=array('lawyer'=>$lawyer_name,'client'=>$client_name,'case'=>$case_no,'date'=>$hearing_date,'mobile'=>$mobile);
                $sms=new Admin_Automsg_Controller();
                $s=$sms->sendSms($sms_data);


               return Redirect::to_route('Hearing')
                        ->with('status',"Successfully added");

            }
        }
        else
        {
            return Redirect::back()
                ->with('status',"Failed to add");
        }

    }

    public function get_EditHearing($ids)
    {
        $id=$ids;
        $verify=Hearing::IsAvailable('hearing_id',$id);
        if($verify > 0)
        {
            $user=$this->get_var();
            if($user=='lawyer')
            {
                return View::make('admin::lawyer/hearing.edit_hearing')
                    ->with('hearing',Hearing::getHearingByID($id));
            }
            elseif($user=='admin')
            {
                return Redirect::back()
                    ->with('status','Your not allow to use this link');
            }
            elseif($user=='associate')
            {
                return View::make('admin::associate/hearing.edit_hearing')
                    ->with('hearing',Hearing::getHearingByID($id));
            }
        }
    }
    public function get_EditHearingDetail($ids)
    {
        $id=$ids;
        $verify=Hearing::IsAvailable('hearing_id',$id);
        if($verify > 0)
        {
            $user=$this->get_var();
            if($user=='lawyer')
            {
                return View::make('admin::lawyer/hearing.hearing_detail_edit')
                    ->with('hearing',Hearing::getHearingByID($id));
            }
            elseif($user=='admin')
            {
                return Redirect::back()
                    ->with('status','Your not allow to use this link');
            }
            elseif($user=='associate')
            {
                return View::make('admin::associate/hearing.edit_hearing')
                    ->with('hearing',Hearing::getHearingByID($id));
            }
        }
    }

    public function get_DeleteHearing($ids)
    {
        $id=$ids;
        $case_hearing=Hearing::getHearingByID($id);
        $res=Hearing::deleteHearingByID($id);
        if($res)
        {
            if($case_hearing)
            {
            $case_id=$case_hearing->case_id;
            $hearings=Hearing::getHearingByCaseID($case_id);
                if($hearings)
                {
                    $case_data=array('last_hearing_id'=>$hearings->hearing_id);
                    Cases::updateCaseByID($case_data,$case_id);
                }
            }
            return Redirect::back() ->with('status',"Successfully deleted ");
        }
        else
        {
         return Redirect::back() ->with('status',"Delete failed ");
        }
    }

    public function post_UpdateHearing()
    {
        $values=Input::all();
        $update=array(
            'hearing_date'      =>  $values['hearing_date'],
            'next_hearing_date' =>  $values['next_hearing_date'],
            'court_hall'        =>  $values['court_hall'],
            'judge'             =>  $values['judge'],
            'stage'             =>  $values['stage'],
            // 'docket_no'         =>  $values['docket_no'],
            // 'crime_no'          =>  $values['crime_no'],
            'doc_no'            =>  $values['doc_no'],
            'action_plan'       =>  $values['action_plan'],
            'description'       =>  $values['description']
            );
            $id=$values['hearing_id'];
            $res=Hearing::updateHearingByID($update,$id);
            if($res)
            {

                return Redirect::to('admin/hearing/hearing-detail/'.$id)->with('status','Successfully updated');
            }
            else
            {
                return Redirect::to('admin/hearing/hearing-detail/'.$id)->with('status',"No changes done");
            }

    }
    public function post_UpdateHearingFromDetail()
    {
        $values=Input::all();
        $update=array(
            'hearing_date'      =>  $values['hearing_date'],
            'next_hearing_date' =>  $values['next_hearing_date'],
            'court_hall'        =>  $values['court_hall'],
            'judge'             =>  $values['judge'],
            'stage'             =>  $values['stage'],
            'docket_no'         =>  $values['docket_no'],
            'crime_no'          =>  $values['crime_no'],
            'doc_no'            =>  $values['doc_no'],
            'action_plan'       =>  $values['action_plan'],
            'description'       =>  $values['description']
            );
            $id=$values['hearing_id'];
            $res=Hearing::updateHearingByID($update,$id);
            if($res)
            {

                return Redirect::to('admin/hearing/hearing-detail/'.$id)->with('status','Successfully updated');
            }
            else
            {
                return Redirect::to('admin/hearing/hearing-detail/'.$id)->with('status',"No changes done");
            }
       
    }

    public function get_HearingDetail($ids)
    {
        $id=$ids;
        $verify=Hearing::IsAvailable('hearing_id',$id);
        if($verify > 0)
        {
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/hearing.hearing_detail')
                ->with('hearing',Hearing::getHearingByID($id));
        }
        elseif($user=='admin')
        {
            return Redirect::back()
                ->with('status','Your not allow to use this link');
        }
        elseif($user == 'associate')
        {
            return View::make('admin::associate/hearing.hearing_detail')
                ->with('hearing',Hearing::getHearingByID($id));
        }
        }
    }
    public function get_SearchbyCase()
    {
        echo "jjj";
    }

    public function get_SearchHearingView1()
    {
        $values=Input::all();
        $user=$this->get_var();
        $id=Auth::user()->id;
        if($user=='lawyer')
        {

            if($values['case_name']!='0')
            {

                $search=array('case_name'=> $values['case_name']);
            }
            elseif($values['case_no']!='0')
            {
                $search=array('case_no'=> $values['case_no']);
            }
            elseif($values['client_id']!='0')
            {
                $search=array('client_id'=> $values['client_id']);
            }
            elseif($values['updated_by']!='0')
            {
                $search=array('updated_by'=> $values['updated_by']);
            }
            elseif($values['court_hall']!='0')
            {
                $search=array('court_hall'=> $values['court_hall']);
            }
            elseif($values['from_date']!='0' && $values['to_date']!='0')
            {
                $search=array($values['from_date'],$values['to_date']);

                return View::make('admin::lawyer/hearing.view_hearing')
                    ->with('hearing',Hearing::getHearingBydate($search))
                    ->with('hearing_select',Hearing::getHearing());

            }
//            print_r($search);exit;
            return Redirect::to_route('ViewHearing')->with('search',$search);
        }
        elseif($user=='associate')
        {
            if($values['case_name']!='0')
            {
                $search=array('case_name'=> $values['case_name']);
            }
            elseif($values['case_no']!='0')
            {
                $search=array('case_no'=> $values['case_no']);
            }
            elseif($values['client_id']!='0')
            {
                $search=array('client_id'=> $values['client_id']);
            }
            elseif($values['updated_by']!='0')
            {
                $search=array('updated_by'=> $values['updated_by']);
            }
            elseif($values['court_hall']!='0')
            {
                $search=array('court_hall'=> $values['court_hall']);
            }
            elseif($values['from_date']!='0' && $values['to_date']!='0')
            {
                $search=array($values['from_date'],$values['to_date']);
                $hearing=Hearing::getHearingsByAssociateID(Auth::user()->id);
                return View::make('admin::associate/hearing.view_hearing')
                    ->with('hearing',Hearing::getHearingByAssociateBydate($id,$search))
                    ->with('hearing_select',$hearing);

            }
            return Redirect::to_route('ViewHearing')->with('search',$search);
        }
    }
    public function get_SearchHearingView()
    {
        $user_id=Auth::user()->id;
        $values=$_GET;
//        print_r($values);exit;
        Input::flash();
        if($values['case_id']==0 && $values['client_id']==0 && $values['court_hall']== '0' && $values['from_date']=='' && $values['to_date']=='' && $values['docket_no'] == '0' && $values['crime_no'] == '0')
        {
           return Redirect::to_route('ViewHearing');
        }
        $user=$this->get_var();

        if($user=='lawyer')
        {
            $hearing_select=Hearing::getHearing();
            $hearing=Hearing::searchHearings($values,$user_id);
            return View::make('admin::lawyer/hearing.view_hearing')
                 ->with('key_search','yes')
                ->with('hearing',$hearing)
                ->with('hearing_select',$hearing_select);
        }
        if($user=='associate')
        {


            $lawyer_id=User::gettingLawyerIDByAssociateID();
            $hearing=Hearing::searchHearings($values,$lawyer_id->uid2);
//            print_r($lawyer_id);exit;

            return View::make('admin::associate/hearing.view_hearing')
                ->with('key_search','yes')
                ->with('hearing',$hearing)
                ->with('hearing_select',Hearing::getHearingByLawyerID($lawyer_id->uid2));
        }
//        print_r($values);
    }
    public function get_SmsUpdate()
    {
        $user=$this->get_var();
        $current_date=date('Y-m-d');
        if($user=='lawyer')
        {
         $value=Hearing::getClientHearingDetails();
            foreach($value as $values)
            {
                $datetime1 = date_create($current_date);
                $datetime2 = date_create($values->hearing_date);
                $interval = date_diff($datetime1, $datetime2);
                $diff= $interval->format('%R%a');
                $val="$values->sms_deliver";
                if($diff=="+$val")
                {
                    $data=array(
                        'client_id'=>$values->client_id,
                        'lawyer_id'=>$values->lawyer_id,
                        'message'=>"hearing date remaining $val days"
                            );
                    $res=Hearing::addSmstoDatabase($data);
                    echo $res;
                }

            }

        }
    }
    public function get_SelectCase()
    {
        $values=Input::get('case_id');
        $case_id=$values;
        $user=$this->get_var();
        if($user=='lawyer')
        {
            $hearing=Hearing::getHearingByCaseID($case_id);

            if($hearing!=NULL)
            {
                return View::make('admin::lawyer/hearing.add_append_hearing')
                    ->with('hearing',$hearing)
                    ->with('case_id',$case_id);
            }
            else
            {
                return Redirect::to_route('Hearing')
                    ->with('hearings','YES')
                    ->with('case_id',$case_id);

            }

        }
        if($user=='associate')
        {
            $hearing=Hearing::getHearingByCaseID($case_id);
            if($hearing!=NULL)
            {
                return View::make('admin::associate/hearing.add_append_hearing')
                    ->with('hearing',$hearing)
                    ->with('case_id',$case_id);
            }
            else
            {
                return Redirect::to_route('Hearing')
                    ->with('hearings','YES')
                    ->with('case_id',$case_id);

            }

        }
    }
    public function get_SearchHearings()
    {
        $value=$_GET;
        $user=$this->get_var();
        if($user=='lawyer')
        {
            $user_id=Auth::user()->id;
            $hearing=Hearing::getHearing();
            $hearing_select=Hearing::searchHearings($value,$user_id);
            return View::make('admin::lawyer/hearing.view_hearing')
                ->with('hearing',$hearing)
                ->with('hearing_select',$hearing_select);
        }
        elseif($user=='associate')
        {
            $hearing=Hearing::getHearingsByAssociateID(Auth::user()->id);
            return View::make('admin::associate/hearing.view_hearing')
                ->with('hearing_select',$hearing)
                ->with('hearing',$hearing);
        }
    }
    public function post_MultiHearingUpdate()
    {
        $value=Input::all();
        if(isset($value['hearing_id']))
        {
            $del=$value['delete'];
            $update=$value['update'];
            $hearing_id=$value['hearing_id'];

            if($update==1)
            {
                $res=Hearing::getMultiHearingByIDs($hearing_id);
                return View::make('admin::lawyer/hearing.edit_hearing_date')
                    ->with('hearing',$res);
            }
            if($del==1)
            {

                    foreach($hearing_id as $hearings)
                    {

                        $case_hearing=Hearing::getHearingByID($hearings);
                        Hearing::deleteMultiHearing($hearing_id);
//                        print_r($case_hearing);exit;
                        if($case_hearing)
                        {
                            $case_id=$case_hearing->case_id;
                            $hearings=Hearing::getHearingByCaseID($case_id);
                            if($hearings)
                            {
                                $case_data=array('last_hearing_id'=>$hearings->hearing_id);
                                Cases::updateCaseByID($case_data,$case_id);
                            }
                        }

                    }

                return Redirect::back();
            }
        }
        else{
            return Redirect::back();
        }

    }

    public function post_UpdateMultiHearing()
    {
        $values=Input::all();
        $data=array();
        $i=0;
        foreach($values['hearing_id'] as $hearing)
        {
            if($values['next_hearing_date'][$i]!='')
            {
                $hearing_date=implode('-',array_reverse(explode('/',$values['hearing_date'][$i])));
                $next_hearing=implode('-',array_reverse(explode('/',$values['next_hearing_date'][$i])));
                $diff=date_diff(date_create($hearing_date),date_create($next_hearing));
                $comp=$diff->format("%R%a");
                if($comp >0 ){
                $val=array('hearing_id'=>$hearing,
                    'data'=>array('hearing_date'=>$hearing_date,
                                   'next_hearing_date'=>$next_hearing));
                array_push($data,$val);
                }
                else
                {
                    return Redirect::back()->with('error',"Next Hearing date is greater than Present Hearing Date");

                }
            }
            $i++;
        }
        if(count($data)!=NULL)
        {
            $res=Hearing::updateMultiHearing($data);
            return Redirect::to_route('ViewHearing')->with('status',"Hearings Successfully updated");
        }
        return Redirect::to_route('ViewHearing')->with('error',"Hearings Failed to update");


    }
    public function post_AddMultiHearing()
    {
        echo "<pre>";
        $value=Input::all();
        $count=count($value['case_id']);
        $final=array();
        for($i=0;$i<$count;$i++)
        {
            $vals=array();
           foreach($value as $key=>$values)
           {
               if($key =='hearing_date')
               {
                $vals[$key]=implode('-',array_reverse(explode('/',$value[$key][$i])));
               }
               elseif($key=='next_hearing_date')
               {
                $vals[$key]=implode('-',array_reverse(explode('/',$value[$key][$i])));
               }
              else
              {
                  $vals[$key]= $value[$key][$i];
              }
           }
            $hearing_date=$vals['hearing_date'];
            $next_hearing_date=$vals['next_hearing_date'];
            $diff=date_diff(date_create($hearing_date),date_create($next_hearing_date));
            $comp=$diff->format("%R%a");
            if($comp >0 )
            {
                array_push($final,$vals);
            }
        }
        if(count($final)!=NULL)
        {
           foreach($final as $finals)
           {
               $case_id=$finals['case_id'];
               $hearing_id=Hearing::addHearing($finals);
               if($hearing_id)
               {
                   Cases::updateCaseByID(array('last_hearing_id'=>$hearing_id),$case_id);
               }
           }
          return Redirect::to_route('ViewHearing')->with('status',"Hearings Successfully updated");
        }
        return Redirect::to_route('ViewHearing')->with('error',"Hearings Failed to update");



    }

    public function post_HearingDetailsByID()
    {
        $value=Input::all();
        $res=Hearing::getHearingByID($value['hearing_id']);
        unset($res->hearing_id,$res->doc_no,$res->sms_deliver,$res->docket_no,$res->action_plan,$res->updated_by,$res->created_date);
        $data=array();
        $trans=translation_array();
        $lawyer=liblawyer::getlawyer();
        foreach($res as $key=>$value)
        {
            $keys=$trans[$key];
            switch($key)
            {
                case 'lawyer_id':
                    $value=ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name'));
                    break;

                case 'client_id':
                    $client=libclient::getclientByID($value);
                    $value=get_value_from_object_array($value,$client,'client_id','client_name');
                    break;
                case 'case_id':
                    $case=libcase::getcasedetailByID($value);
                    $value=get_value_from_object_array($value,$case,'case_id','case_no');
                    break;
                case 'hearing_date':
                    $value=date('d-M-Y',strtotime($value));
                    break;
                case 'next_hearing_date':
                    $value=date('d-M-Y',strtotime($value));
                    break;

            }
            $data[$keys]=$value;
        }
        return json_encode($data);
    }
    public function get_futureHearing($date)
    {
        $user=$this->get_var();   
         if($user =='lawyer')
         {
            $hearing=Hearing::getHearing();
            $hearing_paginate=Hearing::getHearingByLidDatePaginate(Auth::id(),$date);
//            print_r($hearing_paginate);exit;
            return View::make('admin::lawyer/hearing.view_hearing')
                ->with('hearing',$hearing_paginate)
                ->with('hearing_select',$hearing);
         }
         elseif($user == 'associate')
         {
            $lawyer_id=User::gettingLawyerIDByAssociateID(Auth::user()->id);
            $hearing=Hearing::getHearingByLawyerAssociateID($lawyer_id->uid2,Auth::user()->id);
            $hearing_paginate=Hearing::HearingByLawyerAssociateIDPaginateDate($lawyer_id->uid2,Auth::user()->id,$date);
            return View::make('admin::associate/hearing.view_hearing')
                ->with('hearing_select',$hearing)
                ->with('hearing',$hearing_paginate);
         }

    }

    public function get_HearingsJson()
    {
        $id=Auth::user()->id;
        $pro=Auth::user()->user_role;
        if($pro == 2)
        {
            $data   =   DB::table('hearing')
                        ->where('hearing.lawyer_id','=',$id)
                        ->join('case','case.last_hearing_id','=','hearing.hearing_id')
                        ->get(array("hearing.hearing_id","hearing.case_id","hearing.lawyer_id","hearing.sms_deliver",
                            "hearing.updated_by","hearing.docket_no","hearing.description","hearing.court_hall","hearing.judge","hearing.stage","hearing.action_plan",
                            "hearing.hearing_date","hearing.next_hearing_date","hearing.client_id","hearing.opp_party_name","hearing.crime_no","case.case_no")
                            );
             echo json_encode($data);

        }
    }


}