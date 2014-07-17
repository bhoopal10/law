<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/9/13
 * Time: 11:13 PM
 * To change this template use File | Settings | File Templates.
 */

class libRole extends Eloquent{
    public static function getRole($id)
    {
        if($id != 0)
        {
          $res=DB::table('user_role')
            ->where('role_id','=',$id)
            ->select('role_name')
            ->first();
        return $res;
        }
        else
        {
            return (object)array('role_name'=>0);
        }
    }

}