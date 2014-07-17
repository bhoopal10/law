<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/26/13
 * Time: 1:34 AM
 */

class libbackup extends  Eloquent
{
    public static function getmoduleIds($module)
    {
        $res=DB::table($module)
        ->get();
        return $res;
    }
} 