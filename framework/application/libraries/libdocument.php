<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/19/13
 * Time: 12:33 PM
 * To change this template use File | Settings | File Templates.
 */

class libdocument extends Eloquent
{
    public static function getdocumentByID($id)
    {
        $res=DB::table('document')
            ->where('doc_id','=',$id)
            ->first();
        return (array)$res;
    }

    public static function getdocumentByLawyerID($id)
    {
        $res=DB::table('document')
            ->where('lawyer_id','=',$id)
            ->order_by('doc_name','asc')
            ->get();
        return $res;

    }

    public static function getDocument()
    {
        $res=DB::table('document')
            ->get();
        return $res;
    }

    public static function getdocumentByAssociateID()
    {
        $id=User::gettingLawyerIDByAssociateID();
        $res=DB::table('document')
            ->where('lawyer_id','=',$id->uid2)
            ->get();
        return $res;
    }
    public static function docSize($lawyer_id)
    {
        if($lawyer_id)
        {
            $res=DB::table('document')
            ->where('lawyer_id','=',$lawyer_id)
            ->sum('file_size');
            return $res;
        }
        else
        {
            $res=DB::table('document')
                ->sum('file_size');
                return $res;    
        }
    }
    public static function getDocByAsso($id)
    {
        $res=DB::query("select * from document where doc_case_no IN
                        (select case_id from lawyer_case where uid=$id AND permission !=0 )");
        return $res;
    }
    public static function caseNoByLawyerId($id)
    {
        $data=DB::query("select `case`.`case_id`,`case`.`case_no` from `case` where `case`.`case_id` IN(select document.doc_case_no from document where document.lawyer_id = $id group by document.doc_case_no)");
        return $data;
    }

}