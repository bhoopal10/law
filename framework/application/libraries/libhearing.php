<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/21/13
 * Time: 11:04 AM
 */

class libhearing extends Eloquent
{
    public static $table='hearing';

    public static function gethearing()
    {
        $id=Auth::user()->id;
        $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->get();
        return $res;
    }

} 