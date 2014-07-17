<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:14 PM
 */

class Report extends Eloquent
{
    public static function getCaseWise($case_id)
    {
        $res=DB::table('case')
           ->where('case.case_id','=',$case_id)
            ->first(array('case_id','client_id','case_name','case_no','case_type','case_subject'));
        return $res;
    }

    public static function getClientWise($client_id)
    {
        $res=DB::table('client')
            ->where('client_id','=',$client_id)
            ->first(array('client_name','mobile','phone','city','state'));
        return $res;

    }
    public static function getallcase()
    {
        $id=Auth::user()->id;
        $res=DB::table('case')
            ->where('lawyer_id','=',$id)
            ->get();
        return $res;
    }

} 