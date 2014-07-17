<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/18/13
 * Time: 9:40 PM
 * To change this template use File | Settings | File Templates.
 */

class libappointment extends Eloquent
{
    public static function getAppointmentByID($id)
    {
        $res=DB::table('appointment')
            ->where('appointment_id','=',$id)
            ->first();
        return $res;

    }

}