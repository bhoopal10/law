<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/24/13
 * Time: 2:23 PM
 * To change this template use File | Settings | File Templates.
 */

class Admin_Cases_Controller extends Admin_Base_Controller {
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

        return View::make('admin::lawyer/cases.add_cases')
            ->with('client',Client::getClientBylawyerID(Auth::user()->id))
            ->with('lawyer',User::getUsers(false));
        }
        if($user=='admin')
        {
            return View::make('admin::admin/cases.add_cases')
                ->with('client',Client::getClient())
                ->with('lawyer',User::getUsers(false));
        }
        if($user=='associate')
        {
            return View::make('admin::associate/cases.add_cases')
                ->with('client',Client::getClientByAssociateID())
                ->with('lawyer',User::getUsers(false));
        }
    }
    public function post_AddCases()
    {
        $values=Input::all();
        $associate=$values;

        unset($values['associate_id']);
        $update=$values;

        $res=Cases::addCases($update);
//        print_r($update);exit;
        $total=Cases::caseStatics('total');
        $pending=Cases::caseStatics('pending');
        $processing=Cases::caseStatics('processing');
        $complete=Cases::caseStatics('complete');
        $case_stats=array(
            'total_case'=>$total,
            'pending_case'=>$pending,
            'processing_case'=>$processing,
            'completed_case'=>$complete
        );
//        print_r($case_stats);exit;
        Cases::updateCaseStatics($case_stats);
        Cases::adminCaseStatics();
        if($res)
        {
            if(isset($associate['associate_id']))//if associate added case then associate id added to Lawyer_case table
            {
                $data=array(
                  'uid'=>$associate['associate_id'],
                    'case_id'=>$res,
                    'permission'=>2

                );
                Cases::updateCaseByID(array('associate_lawyer'=>$associate['associate_id']),$res);
                User::addCaseToPermission($data);
                $user_id=User::gettingLawyerIDByAssociateID();
                Notifications::addNotification(array('uid1'=>$user_id->uid2,'uid2'=>$associate['associate_id'],'event_id'=>'$'.$res,'text'=>'New Case Added'));
            }
            if(isset($associate['associate_lawyer']))//if lawyer added case then associate ids added to Lawyer_case table
            {

                    $data=array(
                        'uid'=>$associate['associate_lawyer'],
                        'case_id'=>$res,
                        'permission'=>2
                    );

                    User::addCaseToPermission($data);
//                    $user_id=User::gettingLawyerIDByAssociateID();
//                   $re= Notifications::addNotification(array('uid1'=>$user_id->uid2,'uid2'=>$associate,'event_id'=>$res,'text'=>'New case added'));

            }
            /*   case History   */
            $modify='initial';
             $histories=array();
            $history=array(
                'uid'=>$values['updated_by'],
                'modify'=>$modify,
                'time'=>date('Y-m-d H:i:s')
                );
            array_push($histories,$history);
            $json_history= json_encode($histories);
            $history_data=array('case_id'=>$res,
                    'history'=>$json_history);
            Cases::addCaseHistory($history_data);
            
            return $res;
        }
        else
        {
            return false;
        }
    }

    public function post_UpdateCases()
    {
        $cases=Input::all();

        $orig_cases=Session::get('cases');
        $id=$orig_cases['case_id'];
        if(isset($cases['associate_lawyer']))
        {
            $law_id=$cases['lawyer_id'];
            $associate_id=Cases::deleteCasePermissionByCaseID($id);
            $data=array(
                        'uid'=>$cases['associate_lawyer'],
                        'case_id'=>$id,
                        'permission'=>2

                         );
             User::addCaseToPermission($data);
           $update=$cases;
        }
        else
        {
            $law_id=$cases['lawyer_id'];
            unset($cases['lawyer_id']);
         
            $update=$cases;
        }
        $res=array_diff_assoc($update,$orig_cases);
        $total=Cases::caseStatics('total');
        $pending=Cases::caseStatics('pending');
        $processing=Cases::caseStatics('processing');
        $complete=Cases::caseStatics('complete');
        $case_stats=array(
            'total_case'=>$total,
            'pending_case'=>$pending,
            'processing_case'=>$processing,
            'completed_case'=>$complete
        );

//        print_r($case_stats);exit;
        Cases::updateCaseStatics($case_stats);
        Cases::adminCaseStatics();
        if($res!=null)
        {
            $old_history=Cases::viewCaseHistroyByCaseID($id);
            if($old_history)
            {
                $history_id=$old_history->case_history_id;
                $history=json_decode($old_history->history);
                $new_history=array('uid'=>Auth::user()->id,
                                    'modify'=>$res,
                                     'time'=>date('Y-m-d H:i:s'));
                array_push($history, $new_history);
                $history_data=array('history'=>json_encode($history));
                Cases::updateCaseHistory($history_data, $history_id);
                
            }
           
            $res1=Cases::updateCaseByID($res,$id);
            if($res1) return true;  //javascript prints success message and redirects
            else return false;
        }
        else
        {
            return false;   //jquery prints error value in view page
        }

    }

    public function get_ViewCases()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
            $lawyer_id=Auth::user()->id;
            $search_case=Cases::CaseDetailByUserID($lawyer_id);
            $cases=Cases::CasesPagination($lawyer_id);
            return View::make('admin::lawyer/cases.view_case1')
                ->with('cases',$cases)
                ->with('search_case',$search_case);
        }

        if($user=='associate')
        {
            $case_id=User::getLawyerIDByAssociateID(Auth::user()->id);
            $cases=Cases::AssociateCasesPagination($case_id->uid2,Auth::user()->id);
            $search_case=Cases::CasesDetailByAssID(Auth::user()->id,$case_id->uid2);
                return View::make('admin::associate/cases.view_case1')
                    ->with('search_case',$search_case)
                ->with('cases',$cases);
        }
    }

    public function get_EditCases($id1)
    {
        $id=$id1;
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/cases.edit_cases')
                ->with('client',Client::getClientBylawyerID(Auth::user()->id))
                ->with('cases',Cases::getCaseDetailsByID($id))
            ->with('lawyer',User::getUsers(false));
        }
        if($user=='admin')
        {
            return View::make('admin::admin/cases.edit_cases')
                ->with('client',Client::getClient())
                ->with('cases',Cases::getCaseDetailsByID($id))
                ->with('lawyer',User::getUsers(false));
        }
        if($user=='associate')
        {
            return View::make('admin::associate/cases.edit_cases')
                ->with('client',Client::getClientByAssociateID())
                ->with('cases',Cases::getCaseDetailsByID($id))
                ->with('lawyer',User::getUsers(false));
        }

    }

    public function get_DeleteCases($id1)
    {
        $user=$this->get_var();
        $id=$id1;
        $client=DB::first("select count(client_id) as count,client_id from `case` where client_id = (
        select client_id from `case` where case_id = ?)",array($id));
        $res=Cases::deleteCaseByID($id);
        if($res){
            if($user == 'lawyer')
            {
                $hearing=DB::query("delete from hearing where case_id = ? and lawyer_id = ?",array($id,Auth::user()->id));     
                $lawyerCase=DB::query("delete from lawyer_case where case_id not in ( select case_id from `case`)");                
                $id2='$'.$id;                
                $notif=DB::query("delete from notification where event_id = ?",array($id2));
            }
            if($user == 'associate')
            {
                $lawyerId=User::getLawyerIDByAssociateID(Auth::user()->id);
                $hearing=DB::query("delete from hearing where case_id = ? and lawyer_id = ?",array($id,$lawyerId->uid2));
                $lawyerCase=DB::query("delete from lawyer_case where case_id not in ( select case_id from `case`)");                
                $id2='$'.$id;                
                $notif=DB::query("delete from notification where event_id = ?",array($id2));
            }
           
            if($client->count ==1 )
            {
                $delete=DB::query("delete from client where client_id = ?",array($client->client_id));
            }
            $total=Cases::caseStatics('total');
            $pending=Cases::caseStatics('pending');
            $processing=Cases::caseStatics('processing');
            $complete=Cases::caseStatics('complete');
            $case_stats=array(
                'total_case'=>$total,
                'pending_case'=>$pending,
                'processing_case'=>$processing,
                'completed_case'=>$complete
            );
    //        print_r($case_stats);exit;
            Cases::updateCaseStatics($case_stats);
            Cases::adminCaseStatics();
        }
        return Redirect::to_route('ViewCases');
    }

    public function get_CaseStatus($id1)//this $id contains both encrypted id and status with (,) separated
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
        $res=Cases::updateCaseByID($update,$id);
        $total=Cases::caseStatics('total');
        $pending=Cases::caseStatics('pending');
        $processing=Cases::caseStatics('processing');
        $complete=Cases::caseStatics('complete');
        $case_stats=array(
            'total_case'=>$total,
            'pending_case'=>$pending,
            'processing_case'=>$processing,
            'completed_case'=>$complete
        );
//        print_r($case_stats);exit;
        Cases::updateCaseStatics($case_stats);
        Cases::adminCaseStatics();
        return Redirect::to_route('ViewCases');

    }

    public function get_CasePermission($ids)
    {
        $id=$ids;
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/cases.case_permission')
                ->with('id',$id);
        }

    }

    public function post_UpdateCasePermission()
    {
       $values=Input::all();
        $case_id=$values['case_id'];
        if(isset($values['permission']))
        {
            if(isset($values['associate_id']))
            {
                $res=Cases::updateCasePermission($case_id,$values['permission'],$values['associate_id']);
                return Redirect::back()->with('status',"successfully Assigned");
//              print_r($res);exit;
            }
            else
            {
                return Redirect::back()->with('error','Please Select atleast one associate');
            }
        }
        else
        {
            return Redirect::back()->with('error','Please Select Permission');
        }


    }
    public function get_CaseDetail($id)
    {
        $case_id=$id;
        $avil=DB::query("select case_id from `case` where case_id=$case_id");
        $avil=count($avil);
        $user=$this->get_var();
        if($user=='lawyer')
        {
            if($avil){
                return View::make('admin::lawyer/cases.case_detail')
                    ->with('client',Client::getClient())
                    ->with('cases',Cases::getCaseDetailsByID($case_id))
                    ->with('lawyer',User::getUsers(false));
                }
        }
        elseif($user=='associate')
        {
            if($avil){
                return View::make('admin::associate/cases.case_detail')
                ->with('client',Client::getClient())
                ->with('cases',Cases::getCaseDetailsByID($case_id))
                ->with('lawyer',User::getUsers(false));
            }
            
        }
    }
    public function get_CaseHistoryDetail($ids)
    {
        $id=$ids;
        return View::make('admin::lawyer/cases.case_history')
                ->with('history',Cases::viewCaseHistroyByCaseID($id));
    }
    public function post_SearchViewCase()
    {
        $values=Input::all();
        $user=$this->get_var();
        if($user=='lawyer')
        {
             if($values['case_name']!='')
            {
               $search=array('case_name'=> $values['case_name']);
            }
            elseif($values['case_no']!='')
            {
                $search=array('case_no'=> $values['case_no']);
            }
            elseif($values['client_id']!='')
            {
                $search=array('client_id'=> $values['client_id']);
            }
            elseif($values['updated_by']!='')
            {
                $search=array('updated_by'=> $values['updated_by']);
            }
             elseif($values['from_date']!='' && $values['to_date']!='')
             {
                 $search=array($values['from_date'],$values['to_date']);

                 return View::make('admin::lawyer/cases.view_cases')
                     ->with('cases',Cases::getCasesDetails())
                     ->with('cases_select',Cases::getCasesBydate($search));

             }
            return Redirect::to_route('ViewCases')->with('search',$search);
        }
        elseif($user='associate')
        {
            if($values['case_name']!='')
            {
                $search=array('case_name'=> $values['case_name']);
            }
            elseif($values['case_no']!='')
            {
                $search=array('case_no'=> $values['case_no']);
            }
            elseif($values['client_id']!='')
            {
                $search=array('client_id'=> $values['client_id']);
            }
            elseif($values['updated_by']!='')
            {
                $search=array('updated_by'=> $values['updated_by']);
            }
            elseif($values['from_date']!='' && $values['to_date']!='')
            {
                $search=array($values['from_date'],$values['to_date']);
                $cases=Cases::getCasesDetails();
                $cases_select=Cases::getCasesBydate($search);
                $case_id=Cases::getCaseByAssociateByID(Auth::user()->id);
                $ids=multi_value_from_object_array($case_id,'case_id');
                $case=get_array_by_idString_from_object_array($cases,$ids,'case_id');
                $case_select=get_array_by_idString_from_object_array($cases_select,$ids,'case_id');
                return View::make('admin::associate/cases.view_cases')
                    ->with('cases',$case)
                    ->with('cases_select',$case_select);

            }
            return Redirect::to_route('ViewCases')->with('search',$search);
        }
    }
    public function get_SearchCase()
    {
        $values=$_GET;
        $user=$this->get_var();
        $cases=Cases::getCasesDetails();
        $cases_select=Cases::searchCase($values);
        if (!array_filter($values)) {
            return Redirect::to_route('ViewCases');
        }
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/cases.view_cases')
                ->with('cases',$cases)
                ->with('cases_select',$cases_select);
        }
        if($user=='associate')
        {
            $case_id=Cases::getCaseByAssociateByID(Auth::user()->id);
            $ids=multi_value_from_object_array($case_id,'case_id');
            $case1=get_array_by_idString_from_object_array($cases,$ids,'case_id');
            $case=get_array_by_idString_from_object_array($cases_select,$ids,'case_id');
            return View::make('admin::associate/cases.view_cases')
                ->with('cases',$case1)
                ->with('cases_select',$case);
        }
    }

    public function post_AddOppParty()
    {
        $user=$this->get_var();
        $id=Auth::user()->id;
        $value=Input::all();

        if($user=='lawyer')
        {
            foreach($value as $key=>$value1)
            {
                $res=Cases::updateOppPartyType($value1,$id,$key);
            }
            return $value1;
        }
        elseif($user=='associate')
        {
            $ass_id1=liblawyer::getlawyerIDByassociateID($id);
            $lawyer_id=$ass_id1->uid2;
            foreach($value as $key=>$value1)
            {
                $res=Cases::updateOppPartyType($value1,$lawyer_id,$key);
            }
            return $value1;
        }
    }
    public function get_CasePermissionSearch()
    {
       $val=$_GET['id'];
        $case_id=$_GET['case_id'];

        if(isset($val))
        {
            if($val=='')
            {
                $ass=liblawyer::getassociateIDByLawyerID();
                return View::make('admin::lawyer/cases.search_case_permission')
                    ->with('associate1',$ass)
                    ->with('id',$case_id);
            }
            else{
            $ass=Cases::searchCasePermission($val);
            return View::make('admin::lawyer/cases.search_case_permission')
                ->with('associate1',$ass)
                ->with('id',$case_id);
            }
        }

    }

    public function get_ViewPartyType()
    {
        return View::make('admin::lawyer/cases.delete_party_type');
    }
    public function get_ViewCaseSubject()
    {
        return View::make('admin::lawyer/cases.delete_case_subject');
    }

    public function get_ViewCourt()
    {
        return View::make('admin::lawyer/cases.delete_court');
    }
    public function post_MultiCaseAttriDelete()
    {
        $id=Auth::user()->id;
        $value=Input::all();
        if(count($value)==0)
        {
            return Redirect::back();
        }
        $attr=array_keys($value);
        $column=$attr['0'];
        $Attr=Cases::getCaseAttrByColumn($column,$id);
        $Attr_res=json_decode($Attr->$column);
        $a=(array)$Attr_res;
        $b=$value[$column];
        $res=array_diff($a,$b);
        $data1=json_encode($res);
        $data=array($column=>$data1);
        $res1=Cases::updateCaseAttrByLawyerID($id,$data);
        return ($res)? Redirect::back():Redirect::back();
    }
    public function post_DeleteMultiCaseByIDs()
    {
        $values=Input::all();
        $ids=$values['case_id'];

        foreach($ids as $id)
        {

            $client=DB::first("select count(client_id) as count,client_id from `case` where client_id = (
                     select client_id from `case` where case_id = ?)",array($id));
            $res=Cases::deleteCaseByID($id);
            if($res){
                $hearing=DB::query("delete from hearing where case_id = ? and lawyer_id = ?",array($id,Auth::user()->id));
                $lawyerCase=DB::query("delete from lawyer_case where case_id not in ( select case_id from `case`)");                
                $id2='$'.$id;                
                $notif=DB::query("delete from notification where event_id = ?",array($id2));                
                if($client->count ==1 )
                {
                    $delete=DB::query("delete from client where client_id = ?",array($client->client_id));
                }
                $total=Cases::caseStatics('total');
                $pending=Cases::caseStatics('pending');
                $processing=Cases::caseStatics('processing');
                $complete=Cases::caseStatics('complete');
                $case_stats=array(
                    'total_case'=>$total,
                    'pending_case'=>$pending,
                    'processing_case'=>$processing,
                    'completed_case'=>$complete
                );
                //        print_r($case_stats);exit;
                Cases::updateCaseStatics($case_stats);
                Cases::adminCaseStatics();
            }
            else{
                return Redirect::back()->with('error','Failed to delete');
            }
        }

         return Redirect::back()->with('status',"Successfully Deleted ");
    }

    public function get_CaseHearings($id)
    {
        if($id == '0')
        {
            return Redirect::back();
        }
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/cases.case_hearings')
                ->with('report',Report::getCaseWise($id));
        }
        if($user=='associate')
        {

        }

    }
    public function get_ViewStatic($id)
    {
        $stat=($id==2)?"Completed":($id==1?"Processing":"Pending");
        $user_id=Auth::user()->id;
        $inputs=Input::all();
        unset($inputs['page']);
        if($_GET && array_filter($inputs))
        {
            Input::flash();
            $case_id   =$inputs['case_no'];
            $client_id =$inputs['client_id'];
            $lawyer_id =$inputs['lawyer_id'];
            $from      =$inputs['from_date'];
            $to        =$inputs['to_date'];
            $from_date =($from)? implode('-',array_reverse(explode('/',$from))):'1970-01-01';
            $to_date   =($to)?implode('-',array_reverse(explode('/',$to))):'4015-01-01';
            $sql       ="select * from `case` where lawyer_id = $user_id AND status = $id ";
            $sql       .=($case_id)?" AND case_id = $case_id":'';
            $sql       .=($client_id)?" AND client_id = $client_id":'';
            $sql       .=($lawyer_id)?" AND associate_lawyer LIKE '%$lawyer_id%'":'';
            $sql       .=" AND date_of_filling BETWEEN '$from_date' AND '$to_date'";
            $page = Input::get('page', 1);
            $val=DB::query($sql);
            $per_page=20;
            $offset = ($page * $per_page) - $per_page;
            $total=count($val);
            $total_page=ceil($total / $per_page);
            if($page > $total_page or $page < 1)
            {
                $page=1;
            }
            $val = array_slice($val, $offset, $per_page);
            // echo $sql."<br>";
            // echo "<pre>";
            // print_r($val);
            // echo $count;
            // exit;
            $cases=Paginator::make($val, $total, $per_page);
            // echo "<pre>";
            // print_r($cases);exit;
        }
        else
        {
            $cases=Cases::where('lawyer_id','=',$user_id)
                ->where('status','=',$id)
                ->paginate(15);
        }
        
        return View::make('admin::lawyer/cases.case_static')
            ->with('cases',$cases)
            ->with('stat_id',$id)
            ->with('stat',$stat);
    }

}