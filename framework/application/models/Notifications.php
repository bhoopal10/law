<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/19/13
 * Time: 3:21 PM
 */

class Notifications extends Eloquent
{
    public static $table='notification';

    public static function addNotification($data)
    {

        try{
        $res=DB::table(self::$table)
            ->insert($data);
        return $res;
        }
        catch(Exception $e)
        {
            return 'error is:'.$e->getMessage();
        }
    }

    public static function updateNotification($data, $id)
    {
        $res=DB::table(self::$table)
            ->where('notification_id','=',$id)
            ->delete();
        return $res;
    }
    public static function addMultiNotification($data)
    {

        $res=DB::table(self::$table)
            ->insert($data);
        return $res;
    }

    public static function getNotification()
    {
//        Schema::table('notification',function($table)
//        {
//            $table->string('notification_date','10');
//        });
        $res=DB::table(self::$table)
            ->get();
        return $res;
    }
}