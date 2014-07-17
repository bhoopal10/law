<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/7/13
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 */

class libautocomplete extends Eloquent
{
    public static function case_no()
    {
        $res=DB::table('case')
             ->get();
        return $res;
    }
    public static function get_addr()
    {
        $res=DB::table('contact')
            ->get();

        return $res;
    }

}