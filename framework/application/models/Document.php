<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/18/13
 * Time: 2:03 AM
 * To change this template use File | Settings | File Templates.
 */

class Document extends Eloquent
{
    public static $table='document';

    public static function addDocument($data)
    {
//        $res=DB::query('ALTER TABLE `user_settings`  ADD `aa` DOUBLE NOT NULL AFTER `current_storage`');
//        return $res;


        $res=DB::table(self::$table)
            ->insert_get_id($data);
        if($res)
        {
            return $res;
        }
    }

    public static function getDocuments($user)
    {
        if($user)
        {
            $res=DB::table(self::$table)
            ->where('lawyer_id','=',$user)
            ->order_by('doc_id','desc')
            ->paginate('15');
            return $res;
        }
        else
        {
            $res=DB::table(self::$table)
            ->order_by('doc_id','desc')
            ->paginate('15');
            return $res;
        }
        
    }
    public static function getDocumentPaginate($id)
    {
        $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->order_by('doc_id','desc')
            ->paginate('10');
        return $res;
    }
    public static function getDocumentByLawyerId($id)
    {
        $res=DB::table(self::$table)
            ->where('lawyer_id','=',$id)
            ->get();
        return $res;
    }

    public static function getDocumentByID($id)
    {
        $res=DB::table(self::$table)
            ->where('doc_id','=',$id)
            ->first();
        if($res)
        {
            return $res;
        }

    }

    public static function deleteDocumentByID($id)
    {
        $res=DB::table(self::$table)
            ->where('doc_id','=',$id)
            ->delete();
        return $res;

    }

    public static function updateDocumentByID($data,$id)
    {
        $res=DB::table(self::$table)
            ->where('doc_id','=',$id)
            ->update($data);
        if($res){
            return $res;
        }

    }
    public static function IsAvailable($column,$value)
    {
        $res=DB::table(self::$table)
            ->where($column,'=',$value)
            ->count();
        return $res;

    }





}