<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/3/13
 * Time: 2:44 PM
 * To change this template use File | Settings | File Templates.
 */
use Laravel\Database\Eloquent\Model;
class Cases extends Eloquent
{
    public static $table='case';



    /**
     * @param $data
     * @return mixed
     * upload New Case
     */
    public static function addCases($data)
    {
        if(isset($data))
        {
            $res=DB::table(self::$table)
                ->insert_get_id($data);
            if($res)
            {
                return $res;
            }
        }
    }
    public static function getClient($id)
    {
        $res=DB::table(self::$table)
            ->where('case_id','=',$id)
            ->first();
        return $res->client_id;
    }

    /**
     * @param bool $json
     * @return string
     * Get All case details
     * if json is true then it will encode to json( for AngularJs)
     * otherwise it returns normal array()
     */
    public static function getCasesDetails($json=false)
    {
        $res=DB::table(self::$table)
              ->join('client','client.client_id','=','case.client_id')
            ->join('users','users.id','=','case.lawyer_id')
            ->get(array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by","case.lawyer_id"));
        if($json==false) return $res;
        elseif($json==true) return json_encode($res);
    }

    public static function CaseDetailByUserID($lawyer_id)
    {
        $res=DB::table(self::$table)
            ->where('case.lawyer_id','=',$lawyer_id)
            ->join('client','client.client_id','=','case.client_id')
            ->join('users','users.id','=','case.lawyer_id')
            ->order_by('created_on','desc')
            ->get(array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by"));
        return $res;
    }

    public static function CasesPagination($lawyer_id)
    {
        $res=DB::table(self::$table)
             ->where('case.lawyer_id','=',$lawyer_id)
             ->join('client','client.client_id','=','case.client_id')
             ->join('users','users.id','=','case.lawyer_id')
             ->order_by('created_on','desc')
             ->paginate('10',array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by"));
        return $res;
    }
    public static function AssociateCasesPagination($lawyer_id,$ass_id)
    {
        $res=DB::table(self::$table)
            ->where('case.lawyer_id','=',$lawyer_id)
            ->join('lawyer_case','lawyer_case.case_id','=','case.case_id')
            ->where('lawyer_case.uid','=',$ass_id)
            ->where_not_in('lawyer_case.permission',array("0"))
            ->join('client','client.client_id','=','case.client_id')
            ->join('users','users.id','=','case.lawyer_id')
            ->order_by('lawyer_case.permission','desc')
            ->paginate('10',array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by",'lawyer_case.permission'));
        return $res;
    }
    public static function CasesDetailByAssID($ass_id,$lawyer_id)
    {
        $res=DB::table(self::$table)
            ->where('case.lawyer_id','=',$lawyer_id)
            ->join('lawyer_case','lawyer_case.case_id','=','case.case_id')
            ->where('lawyer_case.uid','=',$ass_id)
            ->where_not_in('lawyer_case.permission',array("0"))
            ->join('client','client.client_id','=','case.client_id')
            ->join('users','users.id','=','case.lawyer_id')
            ->order_by('lawyer_case.permission','desc')
            ->get(array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by",'lawyer_case.permission'));
        return $res;
    }


    public static function getCasesBydate($data)
    {
        $res=DB::table('case')
            ->where_between('case.date_of_filling',$data[0],$data[1])
            ->join('client','client.client_id','=','case.client_id')
            ->join('users','users.id','=','case.lawyer_id')
            ->paginate('15',array("case.case_id","case.case_no","case.case_name","case.case_type","case.client_id","client.client_name","users.id","case.date_of_filling","users.first_name","case.status","case.associate_lawyer","case.updated_by"));
        if($res)
        {
            return $res;
        }
    }

    /**
     * @param $id
     * @return mixed
     * getting case details
     */
    public static function getCaseDetailsByID($id)
    {
        $res=DB::table(self::$table)
            ->where('case_id','=',$id)
            ->first();
        return $res;
    }

    /**
     * @param $id
     * @return mixed
     * getting details by lawyer_id
     */
    public static function getCaseDetailsByLawyerID($id)
    {
        $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->get();
        if($res) return $res;
        else return 0;
    }

    /**
     * @param $id
     * @return mixed
     * delete selected row
     */
    public static function deleteCaseByID($id)
    {
        $res=DB::table(self::$table)
            ->where('case_id','=',$id)
            ->delete();
        return $res;

    }
    public static  function deleteCaseByIDs($ids)
    {
        $res=DB::table(self::$table)
            ->where_in('case_id',$ids)
            ->delete();
        return $res;
    }

    /**
     * @param $data
     * @param $id
     * udate cases by using caseID
     * @return mixed
     */
    public static function updateCaseByID($data, $id)
    {
        $res=DB::table(self::$table)
            ->where('case_id','=',$id)
            ->update($data);
        return $res;
    }

    public static function updateCasePermission($case_id,$permission,$ass_id)
    {
        foreach($ass_id as $ass)
        {
          $res=DB::table('lawyer_case')
              ->where('uid','=',$ass)
              ->where('case_id','=',$case_id)
              ->get();
          if(count($res)!=0)
          {
              $res1=DB::table('lawyer_case')
                  ->where('uid','=',$ass)
                  ->where('case_id','=',$case_id)
                  ->update(array('permission'=>$permission));
          }
            else
            {
                $res1=DB::table('lawyer_case')
                    ->insert(array('uid'=>$ass,'case_id'=>$case_id,'permission'=>$permission));
            }

        }
        return $res1;

    }
    public static function getCaseByAssociateByID($id)
    {
        $res=DB::table('lawyer_case')
            ->where('uid','=',$id)
            ->where_not_in('permission',array('0'))
            ->get(array('case_id'));
        return $res;
    }
    public static function deleteCasePermissionByCaseID($id)
    {
        $res=DB::table('lawyer_case')
            ->where('case_id','=',$id)
            ->delete();
        if($res) return $res;
        else return false;
    }
    public static function caseStatics($value)
    {
        $uid=Auth::user()->id;
        if($value=='total')
        {
            $res=DB::table(self::$table)
                ->where('lawyer_id','=',$uid)
                ->count();
        }
        elseif($value=='pending')
        {
            $res=DB::table(self::$table)
                ->where('lawyer_id','=',$uid)
                ->where('status','=','0')
                ->count();
        }
        elseif($value=='processing')
        {
            $res=DB::table(self::$table)
                ->where('lawyer_id','=',$uid)
                ->where('status','=','1')
                ->count();
        }
        elseif($value=='complete')
        {
            $res=DB::table(self::$table)
                ->where('lawyer_id','=',$uid)
                ->where('status','=','2')
                ->count();
        }
        return $res;
    }

    public static function addCaseStatics($data)
    {
        $res=DB::table('case_statics')
            ->insert($data);
        return $res;
    }
    public static function updateCaseStatics($data)
    {
        $uid=Auth::user()->id;
        $res=DB::table('case_statics')
            ->where('uid','=',$uid)
            ->update($data);
        return $res;
    }


    public static function updateAdminCaseStatics($data)
    {
        $res=DB::table('case_statics')
            ->where('uid','=',1)
            ->update($data);
            return $res;

    }

    public static function adminCaseStatics()
    {
        $total_case=DB::table(self::$table)
            ->count();
        $pending_case=DB::table(self::$table)
            ->where('status','=',0)
            ->count();
        $processing_case=DB::table(self::$table)
            ->where('status','=',1)
            ->count();
        $completed_case=DB::table(self::$table)
            ->where('status','=',2)
            ->count();
        $res=array(
            'total_case'=>$total_case,
            'pending_case'=>$pending_case,
            'processing_case'=>$processing_case,
            'completed_case'=>$completed_case
        );
//        echo "<pre>";
//        print_r($res);exit;
        $res1=Cases::updateAdminCaseStatics($res);
        return $res1;

    }
    public static function addCaseHistory($data)
    {
     $res=DB::table('case_history')
             ->insert($data);
     return $res;
    }
    public static function viewCaseHistroyByCaseID($id)
    {
        $res=DB::table('case_history')
                ->where('case_id','=',$id)
                ->first();
        return $res;
    }
    public static function updateCaseHistory($data,$id)
    {
        $res=DB::table('case_history')
                ->where('case_history_id','=',$id)
                ->update($data);
        return $res;
    }
    public static function searchCase($data)
    {
        $condition=array_unset($data,'from_date,to_date');
        $main_query="SELECT * FROM `case`";
        $query='';
        $from_date1=DateTime::createFromFormat('d/m/Y',$data['from_date']);
        $from_date=($from_date1) ? $from_date1->format('Y-m-d'): '';
        $to_date1=DateTime::createFromFormat('d/m/Y',$data['to_date']);
        $to_date=($to_date1) ? $to_date1->format('Y-m-d') : '';

              foreach($condition as $key=>$value)
              {
                  if($value)
                  {

                     $query.= $key. ' = '. "'$value'" .' AND ';
                  }
              }

        $a=explode('AND',$query);
        array_pop($a);
        $a=implode(' AND ' ,$a);

        if($from_date!='' && $to_date !='')
        {
            $a.= ($a) ? ' AND ' : '';
            $a.="date_of_filling BETWEEN '$from_date' AND '$to_date'";
        }
        $value= ($a) ? 'WHERE '.$a : $a;
//        return $value;
        $res=DB::query($main_query.$value);

        return $res;

    }

    public static function updateOppPartyType($data,$id,$column)
    {
//        $res=Schema::table('case_setting',function($table)
//        {
//            $table->text('case_type');
//            $table->text('party_type');
//            $table->text('opp_advocate');
//            $table->text('case_subject');
//        });
//        return $res;
        $fetch=DB::table('case_setting')
            ->where('lawyer_id','=',$id)
            ->first();

        if($fetch)
        {

            if($fetch->$column !='')
            {
            $val=json_decode($fetch->$column);
            $val=(array)$val;
            array_push($val,$data);
            $update=json_encode($val);
            $res=DB::table('case_setting')
                ->where('lawyer_id','=',$id)
                ->update(array($column=>$update));
                return $res;
            }
            else
            {
                $update=json_encode(array($data));
                $res=DB::table('case_setting')
                    ->where('lawyer_id','=',$id)
                    ->update(array($column=>$update));
                return $res;
            }
        }
        else
        {
            $update=json_encode(array($data));
            $res=DB::table('case_setting')
                ->insert(array('lawyer_id'=>$id,$column=>$update));
            return $res;

        }
    }

    public static function searchCasePermission($val)
    {
        $res=DB::table('users')
            ->where('id','=',$val)
            ->get(array('id','first_name','last_name','user_email'));
        return $res;
    }
    public static function getCaseAttrByColumn($column,$id)
    {
        $res=DB::table('case_setting')
            ->where('lawyer_id','=',$id)
            ->first(array($column));
        return $res;
    }
    public static function updateCaseAttrByLawyerID($id,$data)
    {
        $res=DB::table('case_setting')
            ->where('lawyer_id','=',$id)
            ->update($data);
        return $res;
    }

    public static function IsAvailable($column,$value)
    {
        $res=DB::table(self::$table)
            ->where($column,'=',$value)
            ->count();
        return $res;

    }

}