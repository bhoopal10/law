<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 12/17/13
 * Time: 7:51 AM
 * To change this template use File | Settings | File Templates.
 */

class Backup extends Eloquent
{
    public static function createBackup()
    {
        $res='mysqldump' > 'backups';
        return $res;
    }

    public static function updateBackups($data,$table_name,$id_key,$ids)
    {
        $id=explode(',',$ids);
        $i=0;
        $result='';
        foreach($data as $data1)
        {
            if($data1!=null)
            {
            $res=DB::table($table_name)
                ->where($id_key,'=',$id[$i])
                ->update($data1);
                $result.=$res;
            }
            $i++;
        }
        if($result!=null) return true;
        else return false;
    }

    public static function deleteByUserID($id,$table_name)
    {
        if($table_name=='client')
        {
        $res=DB::table($table_name)
            ->where('update_by','=',$id)
            ->delete();
        return $res;
        }
        else
        {
            $res=DB::table($table_name)
                ->where('lawyer_id','=',$id)
                ->delete();
            return $res;
        }
    }

    public static function restoreBackup($table_name,$data)
    {
        $results='';
        foreach($data as $data1)
        {
            if($data!=null)
            {
                $res=DB::table($table_name)
                    ->insert($data1);
                $results.=$res;
            }
        }
        if($results!=null) return true;
        else return false;
    }


}