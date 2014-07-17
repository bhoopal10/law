<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/25/14
 * Time: 10:55 AM
 */

class libExpdate extends Eloquent
{
    public static function getExpDateByUSerID($id,$days)
    {
        $current_date = new DateTime(date('Y-m-d'));
        $exp_date=DB::table('users')
            ->where('id','=',$id)
            ->first(array('exp_date'));
        $exp_date1=new DateTime($exp_date->exp_date);
        $interval = $current_date->diff($exp_date1);
        $counts=$interval->format('%R%a');
        $count=(integer)$counts;

        if($count>0)
        {
           if($count<=$days)
           {
               return $count;
           }
            else
            {
                return false;
            }
        }
        else
        {
            ExpDate::blockUserAccount($id);
        }

    }

    public static function blockUserAccount($id)
    {
        $res=DB::table('users')
            ->where('id','=',$id)
            ->update(array('user_role'=>0));
        return $res;
    }


} 