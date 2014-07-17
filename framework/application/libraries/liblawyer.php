<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/11/13
 * Time: 2:00 PM
 * To change this template use File | Settings | File Templates.
 */

class liblawyer extends Eloquent
{
    public static function getlawyer()
    {
        $res=DB::table('users')
             ->get();
        return $res;
    }
    public static function getlawyername()
    {
        $res=DB::table('users')
           ->get();
        return $res;

    }
    public static function getlawyerIDByassociateID($id)
    {
        $res=DB::table('friends')
            ->where('uid1','=',$id)
            ->first();
        return $res;
    }
    public static function LawyerIdByAssoId($id)
    {
        $res=DB::table('friends')
            ->where('uid1','=',$id)
            ->first();
           if($res)
           {
            return $res->uid2;
           }
    }
    public static function getassociateIDByLawyerID()
    {
        $id=Auth::user()->id;
        $res=DB::table('users')
            ->where('updated_by','=',$id)
            ->get(array('id','first_name','username','last_name','user_email'));
        return $res;
    }
    public static function getassociateIDByLawyerIDPaginate()
    {
        $id=Auth::user()->id;
        $res=DB::table('users')
            ->where('updated_by','=',$id)
            ->paginate('15',array('id','first_name','username','last_name','user_email'));
        return $res;
    }
    public static function countlawyerIDs()
    {
        $uid=Auth::user()->id;
        $res=DB::table('friends')
            ->where('uid2','=',$uid)
            ->count();
        return $res;
    }

    public static function lawyerprofile()
    {
        $uid=Auth::user()->id;
        $res=DB::table('users')
            ->where('id','=',$uid)
            ->first();
        return $res;
    }
    public static function lawyerByID($id)
    {
        $res=DB::table('users')
            ->where('id','=',$id)
            ->first();
        return $res;

    }
    
    public static function getimage()
    {
        $uid=Auth::user()->id;
        $res=DB::table('user_settings')
            ->where('ui','=',$uid)
            ->first();
        return $res;

    }
    public static function getimagebyID($id)
    {
        $res=DB::table('user_settings')
                ->select('image')
                ->where('ui','=',$id)
                ->first();
                
        return $res;
    }

    public static function getstatusByID($id)
    {
        $res=DB::table('user_settings')
            ->where('ui','=',$id)
            ->first();
        if($res)  return $res;
        else return false;
    }
    public static function getlawyercount($id)
    {
        $res=DB::table('friends')
                ->where('uid2','=',$id)
                ->get();
        return ($res) ? $res : 0;
    }
    public static function getUserByID($id)
    {
        $res=DB::table('users')
            ->where('id','=',$id)
            ->join('user_settings','user_settings.ui','=','users.id')
            ->first(array('users.first_name','users.username','users.last_name','users.user_email','user_settings.image'));
        return $res;
    }
    public static function getUserByUpdateIDPaginate($id,$num)
    {
        $res=DB::table('users')
            ->where('updated_by','=',$id)
            ->paginate($num);
        return $res;
    }
    public static function SmsCountByLawyerID($id)
    {
        $check=SmsCount::find($id);
        if(!$check)
        {
            $check=SmsCount::create(array('id'=>$id,'count'=>'0'));
        }        
        return $check;
        
    }
    public static function SmsCountUpdate($id,$count)
    {
        $data=SmsCount::find($id);
        $data->count=$data->count+$count;
        $data->save();
        return $data;
    }
    public static function userByIds($ids)
    {
        if(!$ids)
        {
            $ids='0';
        }
        $res=DB::query("select * from users where id in($ids)");
        return $res;
    }
    public static function superLawyer()
    {
        $res=DB::table('users')
        ->where('user_role','=',2)
        ->order_by('first_name','asc')
        ->get(array("id","first_name","last_name"));
        return $res;
    }

}