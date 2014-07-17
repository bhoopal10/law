<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/9/13
 * Time: 11:18 AM
 * To change this template use File | Settings | File Templates.
 */

class Client extends Eloquent{
public static $table='client';
    public function user()
    {
        return $this->has_one('Cases');
    }
    public static function addClient($data)
    {

       $res=DB::table(self::$table)
            ->insert_get_id($data);
        return $res;
    }
    public static function getEmail($id)
    {
        $res=DB::table(self::$table)
            ->where('client_id','=',$id)
            ->first();
            return $res->email;
    }
    public static function getClient()
    {
        $res=DB::table(self::$table)
            ->get();
        return $res;
    }
    public static function getClientBylawyerID($id)
    {
        $res=DB::table(self::$table)
            ->where('update_by','=',$id)
            ->get();
        return $res;
    }

    public static function getClientBylawyerIDwithPaginate($id)
    {
        $res=DB::table(self::$table)
            ->where('update_by','=',$id)
            ->paginate('10');
        return $res;
    }
    public static function getClientDetailByID($id)
    {
        $res=DB::table(self::$table)
            ->where('client_id','=',$id)
            ->first();
        return $res;
    }

    public static function getClientByAssociateID()
    {
        $id=User::gettingLawyerIDByAssociateID();
        $res=DB::table(self::$table)
            ->where('update_by','=',$id->uid2)
            ->get();
        return $res;
    }
    public static function updateByClientID($data,$id)
    {
        $res=DB::table(self::$table)
            ->where('client_id','=',$id)
            ->update($data);
        return $res;
    }

    public static function deleteClientByID($id)
    {
        $res=DB::table(self::$table)
            ->where('client_id','=',$id)
            ->delete();
        return $res;
    }
    public static function caseByClientID($id)
    {
        $res=DB::table('case')
            ->where('client_id','=',$id)
            ->get(array('case_id','case_no'));
        return $res;
    }
}