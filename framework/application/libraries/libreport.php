<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:32 PM
 */

class libreport extends Eloquent
{
    public static function getcaseHearingDetailsByCaseID($id)
    {
        $res=DB::table('case')

            ->join('hearing','hearing.case_id','=','case.case_id')
            ->where('case.case_id','=',$id)
            ->order_by('hearing.hearing_date','asc')
            ->get(array(
                'hearing.hearing_id',
                'hearing.hearing_date',
                'hearing.next_hearing_date',
                'case.lawyer_id',
                'case.associate_lawyer',
                'hearing.description',
                'hearing.court_hall',
                'hearing.judge',
                'hearing.stage',

            ));
        return $res;
    }
    public static function getcasehearingByclientID($client_id)
    {
        $res=DB::table('case')
            ->where('case.client_id','=',$client_id)
            ->get(array('case_id','case_name','case_no','case_type','case_subject','case_description'));
        return $res;
    }

} 