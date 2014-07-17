<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/5/13
 * Time: 12:36 PM
 * To change this template use File | Settings | File Templates.
 */

class Contacts extends Eloquent {
    public static $table='contact';
    public static function addContacts($data)
    {

        $res=DB::table(self::$table)
            ->insert_get_id($data);
        return $res;
    }
    public static function updateContacts($data,$id)
    {
        $res=DB::table(self::$table)
           ->where('user_id','=',$id)
           ->update($data);
        return $res;
    }

    public static function getContactByID($id)
    {
        $contact=DB::table(self::$table)
            ->where('user_id','=',$id)
            ->first();
//        return $contact;
        if($contact){
        $contacts=json_decode($contact->contact_details);
        return $contacts;
        }
        else{ return 0;}
    }
    public static function getContactByIDPaginate($id,$perpage)
    {
        $contact=DB::table(self::$table)
            ->where('user_id','=',$id)
            ->first();
        if($contact){
            $contacts=json_decode($contact->contact_details);
            return $contacts;
        }
        else{ return 0;}
    }
    public static function getContactByLawyerId($id)
    {
        $contact=DB::table(self::$table)
            ->where('user_id','=',$id)
            ->get();
        return $contact;
    }


}