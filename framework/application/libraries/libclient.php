<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/12/13
 * Time: 9:34 PM
 * To change this template use File | Settings | File Templates.
 */

class libclient extends Eloquent
{
    public static function getclientname()
    {
        $res=DB::table('client')
            ->get();
        return $res;
    }

    public static function getclientByID($id)
    {
        $res=DB::table('client')
            ->where('client_id','=',$id)
            ->first();
        return $res;
    }
      public static function countclient()
    {
        $res=DB::table('client')
            ->count();
        return $res;
    }
    public static function getclientByLawyerID($id)
    {
        $res=DB::table('client')
            ->where('update_by','=',$id)
            ->get();
        return $res;
    }
    public static function getclientnameByLawId($id)
    {
        $res=DB::table('client')
            ->where('update_by','=',$id)
            ->get('client_name');
           
        foreach ($res as $key=>$value) {
            $arr[$key]=$value->client_name;
        }
            return $arr;
    }

}