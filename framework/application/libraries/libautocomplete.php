<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/7/13
 * Time: 2:39 PM
 * To change this template use File | Settings | File Templates.
 */

class libautocomplete extends Eloquent
{
    public static function case_no()
    {
        $res=DB::table('case')
             ->get();
        return $res;
    }
    public static function get_addr()
    {
        $res=DB::table('contact')
            ->get();

        return $res;
    }
    public static function selectList($id)
    {
        $clients=DB::table('client')
            ->where('update_by','=',$id)
            ->get(array('client_id','client_name'));
        $lawyers=DB::table('users')
        ->where('updated_by','=',$id)
        ->get(array('id','first_name'));
        $case=DB::table('case')
        ->where('lawyer_id','=',$id)
        ->get(array('case_id','case_no'));
        $tot=array('cases'=>$case,
                    'client'=>$clients,
                    'lawyer'=>$lawyers);

        return $tot;
    }

}