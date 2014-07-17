<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/25/14
 * Time: 10:37 AM
 */

class ExpDate extends Eloquent
{
    public static function getExpDateByUSerID($id,$days)
    {
        $current_date = new DateTime(date('Y-m-d'));
        $exp_date=DB::table('users')
            ->where('id','=',$id)
            ->first(array('exp_date'));
        $exp_date1=new DateTime($exp_date->exp_date);
        $interval = $exp_date1->diff($current_date);
        $count=$interval->format('%a');
        return $count;

    }
    public static function blockUserAccount($id)
    {
        $res=DB::table('users')
            ->where('id','=',$id)
            ->update(array('user_role'=>0));
        Auth::Logout();
        Session::forget('user');
        return $res;
    }
    public static function getByUserExpDate($day)
    {
        $date1=Date('Y-m-d', strtotime("+$day days"));
        $res=DB::query("SELECT `exp_date`,`id` FROM `users`  WHERE exp_date < DATE('$date1')");
        return $res;
    }
}