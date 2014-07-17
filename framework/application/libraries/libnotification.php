<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/19/13
 * Time: 5:02 PM
 */

class libnotification extends Eloquent
{
    public static $table='notification';

    public static function getnotification()
    {
        $uid=Auth::user()->id;
        $res=DB::table(self::$table)
            ->where('uid1','=',$uid)
            ->get();
        return $res;
    }

    public static function getunreaadnotification($mod)
    {
        $uid=Auth::user()->id;
        $res=DB::table(self::$table)
            ->where('uid1','=',$uid)
            ->where('read_status','=',0)
            ->where('event_id','like',"%$mod%")
            ->get();
        return $res;
    }
    public static function getunreadnotification_appointment($mod)
    {
        $uid=Auth::user()->id;
        $date=date('Y-m-d');
        $res=DB::table(self::$table)
            ->where('uid2','=',$uid)
            ->where('read_status','=',0)
            ->where('event_id','like',"%$mod%")
            ->where('notification_date','=',$date)
            ->get();
        return $res;
    }
    public static function getunreadnotification_ass_appointment($mod,$law_id)
    {
        $uid=Auth::user()->id;
        $date=date('Y-m-d');
        $res=DB::table(self::$table)
            ->where('uid2','=',$uid)
            ->where('uid1','=',$law_id)
            ->where('read_status','=',0)
            ->where('event_id','like',"%$mod%")
            // ->where('notification_date','=',$date)
            ->get();
        return $res;
    }
    public static function getlawyerappointmentnotification()
    {
        $uid=Auth::user()->id;
        $res=DB::table(self::$table)
            ->where('uid1','=',$uid)
            ->get();
        return $res;
    }

    public static function gethearingnotification($id)
    {
        $date=date('Y-m-d');
        $res=DB::table('hearing')
            ->where('lawyer_id','=',$id)
            ->where('next_hearing_date','=',$date)
            ->get();
        return $res;

    }

} 