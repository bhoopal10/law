<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 12/3/13
 * Time: 12:03 AM
 * To change this template use File | Settings | File Templates.
 */

class Message extends Eloquent
{
    public static $table='message';

    public static function addMessage($data)
    {
        $res=DB::table(self::$table)
            ->insert_get_id($data);
        return $res;

    }

    public static function getInboxMessage($id)
    {
        $res=DB::table(self::$table)
            ->where('to_id','=',$id)
            ->order_by('date','desc')
            ->get();
        return $res;
    }
    public static function getInboxMessagePaginate($id)
    {
        $res=DB::table(self::$table)
            ->where('to_id','=',$id)
            ->where('to_status','=','0')
            ->order_by('date','desc')
            ->paginate('10');
        return $res;
    }
    public static function getSentboxMessage($id)
    {
        $res=DB::table(self::$table)
            ->where('from_id','=',$id)
            ->order_by('date','desc')
            ->get();
        return $res;
    }
    public static function getSentboxMessagePaginate($id)
    {
        $res=DB::table(self::$table)
            ->where('from_id','=',$id)
            ->where('from_status','=','0')
            ->order_by('date','desc')
            ->paginate('10');
        return $res;
    }
    public static function deleteMessage($data,$id)
    {
        $res=DB::table(self::$table)
                ->where('msg_id','=',$id)
                ->update($data);
        return $res;
    }
    public static function multiMessageDelete($id,$data)
    {
        $res=Message::query()->where_in('msg_id',$id)
            ->update($data);
        return $res;
    }
    public static function getMessageByMsgID($id)
    {
        $res=DB::table(self::$table)
            ->where('msg_id','=',$id)
            ->first();
        return $res;
    }

}