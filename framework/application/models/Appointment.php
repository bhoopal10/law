<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/9/13
 * Time: 2:42 PM
 * To change this template use File | Settings | File Templates.
 */

class Appointment extends Eloquent {
    public static $table='appointment';
    public static function addAppointment($data)
    {

        $res=DB::table(self::$table)
            ->insert_get_id($data);
        return $res;
    }

    public static function updateAppointment($data,$id)
    {
        $res=DB::table(self::$table)
            ->where('appointment_id','=',$id)
            ->update($data);
        return $res;
    }
    public static function getAppointment($date=false)
    {
        $id=Auth::user()->id;
        if($date)
        {
            $res=DB::table(self::$table)
                ->where('lawyer_id','=',$id)
                ->where('from_date','LIKE','%'.$date.'%')
                ->order_by('appointment_id','desc')
                ->paginate('15');
            return $res;
        }
        else
        {
            $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->order_by('appointment_id','desc')
                  ->paginate('15');
            return $res;
        }
    }
    public static function getAppointmentByID($id)
    {
        $res=DB::table(self::$table)
            ->where('appointment_id','=',$id)
            ->first();
        if($res)return $res;
        else return NULL;

    }

    public static function deleteAppointmentByID($id)
    {
        $id1=$id;
        $res=DB::table(self::$table)
            ->where('appointment_id','=',$id1)
            ->delete();
        if($res) return $res;
        else return NULL;

    }

    public static function getAppointmentByUserID($id)
    {
        $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->get();
        if($res) return $res;
        else return 0;
    }
    public static function getAppointmentIds()
    {
        $res=DB::table(self::$table)
            ->select('appointment_id')
            ->get();
        return $res;
    }

    public static function updateMultiAppointment($data)
    {
        foreach($data as $data1)
        {
            $id=$data1['appointment_id'];
            unset($data1['appointment_id']);
//            print_r($data1);exit;
            $res=DB::table(self::$table)
                ->where('appointment_id','=',$id)
                ->update($data1);
            if($res) continue;
            else return false;
        }
      echo "success";
    }

    public static function deleteMultiAppointment($id)
    {
        $res=DB::table(self::$table)
                ->where_in('appointment_id',$id)
                ->delete();
        return $res;
    }
    public static function IsAvailable($column,$value)
    {
        $res=DB::table(self::$table)
            ->where($column,'=',$value)
            ->count();
        return $res;

    }

}