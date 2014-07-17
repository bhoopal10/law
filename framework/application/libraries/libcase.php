<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/13/13
 * Time: 4:49 PM
 * To change this template use File | Settings | File Templates.
 */

class libcase extends Eloquent
{
    public static function getcasedetail()
    {
        $res=DB::table('case')
            ->get();
        return $res;
    }

    public static function getcasedetailByID($id)
    {
        $res=DB::table('case')
            ->where('case_id','=',$id)
            ->first();
        if($res) return $res;
        else return NULL;

    }

    public static function getassociateIDBycaseID($id)
    {
        $res=DB::table('lawyer_case')
            ->where('case_id','=',$id)

            ->get();
        return $res;
    }

    public static function getAssociateCasePermissionByAssID($id)
    {
        $res=DB::table('lawyer_case')
            ->where('uid','=',$id)
            ->get();
        return $res;
    }

    public static function getcaseIDByassociateID($id)
    {
        $res=DB::table('lawyer_case')
            ->where('uid','=',$id)
            ->where_not_in('permission',array('0'))
            ->get();
        return $res;
    }
    public static function getcaseIDByassociateIDpaginate($id)
    {
        $res=DB::table('lawyer_case')
            ->where('uid','=',$id)
            ->paginate('10');
        return $res;
    }

    public static function casestatics()
    {
        $uid=Auth::user()->id;
        $res=DB::table('case_statics')
            ->where('uid','=',$uid)
            ->first();
        if($res)
        {
            return $res;
        }
        else
        {
            $res=DB::table('case_statics')
            ->insert(array('uid'=>$uid));
            return $res;
        }
    }
    public static function getcourtBylawyerID($id)
    {
        $res=DB::table('case_setting')
            ->select('case_court')
            ->where('lawyer_id','=',$id)
            ->first();
        return $res;
    }
    public static function getoppPartyBylawyerID($id)
    {
        $res=DB::table('case_setting')
            ->select('case_opp_party_type')
            ->where('lawyer_id','=',$id)
            ->first();
        return $res;
    }

    public static function getCaseByLawyerID($id)
    {
        $res=DB::table('case')
            ->where('lawyer_id','=',$id)
            ->get();
        return $res;

    }
    public static function getCaseAttributeByLawyerID($id)
    {
        $res=DB::table('case_setting')
            ->where('lawyer_id','=',$id)
            ->first();
        return $res;
    }

    public static function getCaseByLawyerIDPaginate($id)
    {
        $res=DB::table('case')
            ->where('lawyer_id','=',$id)
            ->paginate('15',array('case_id','case_name','case_no'));
        return $res;
    }
    public static function caseNoById($id)
    {
        if($id)
        {
            $res=DB::table('case')
            ->where('case_id','=',$id)
                        ->select('case_no')
                        ->first();
            if($res)
            {
                return $res->case_no;
            }
        }
        else
        {
            return false;
        }
    }
    public static function countStatusCase($lawyer_id,$id)
    {
        $res=DB::table('case')
            ->where('lawyer_id','=',$lawyer_id)
            ->where('status','=',$id)
            ->count();
            return $res;
    }


}