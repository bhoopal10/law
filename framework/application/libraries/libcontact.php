<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/21/13
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

class libcontact extends Eloquent
{
    public static function getcontact()
    {
        $res=DB::table('contact')
            ->get();
        if($res){
            return $res;
        }
    }

    /**
     * @param $id
     * @return mixed
     * getting contact groups and city for autoload in view page
     */
    public static function getcontactgroupByID($id)
    {
        $res=DB::table('contact')
        ->where('user_id','=',$id)
        ->select('contact_details')
            ->first();
        return $res;
    }

    public static function getcontactdetailByID($id)
    {
        $res=DB::table('contact')
            ->where('user_id','=',$id)
            ->select('contact_details')
            ->get();
        return $res;
    }

    public static function getcontactByID($id)
    {
        $res=DB::table('contact')
           ->where('user_id','=',$id)
           ->select('contact_details')
           ->first();

        if($res)
        {

            $contact=json_decode($res->contact_details);
            $arr=array();
            if($contact)
            {
                foreach($contact as $value)
                {
                    array_push($arr,(array)$value);
                }
                return $arr;
            }
            else
            {

                return array(0=>'');
            }
        }
        else{
            return null;
        }
        
    }

}