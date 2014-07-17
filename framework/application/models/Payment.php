<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/24/14
 * Time: 6:01 PM
 */

class Payment extends Eloquent
{
    public static $table='payment';

    public static function addInvoice($data)
    {
        $res=DB::table(self::$table)
            ->insert_get_id($data);
        return $res;
    }

    public static function getInvoice()
    {
        $res=DB::table(self::$table)
            ->get();
        return $res;
    }

    public static function getInvoiceByID($id)
    {
        $res=DB::query("select * from payment where payment_id IN(select max(payment_id) from payment where from_user = $id group by to_user)");
        return $res;
       } 

    public static function getInvoiceDetailByID($id)
    {
        $res=DB::table(self::$table)
            ->where('payment_id','=',$id)
            ->first();
        return $res;
    }

    public static function updateStatus($id, $status)
    {

        $res=DB::table(self::$table)
            ->where('payment_id','=',$id)
            ->update($status);
        return $res;
    }
    public static function getPaymentByLawyerId($id)
    {
        $res=DB::table(self::$table)
            ->where('from_user','=',$id)
            ->get();
        return $res;
    }

} 