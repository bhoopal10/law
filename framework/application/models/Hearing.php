<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/17/13
 * Time: 5:56 PM
 * To change this template use File | Settings | File Templates.
 */

class Hearing extends Eloquent
{
    public static $table='hearing';
    public static function addHearing($data)
    {

        $res=DB::table(self::$table)
            ->insert_get_id($data);
        if($res)
        {
            return $res;
        }

    }

    public static function getHearing()
    {
        $res=DB::table('case')
        ->join('hearing','hearing.case_id','=','case.case_id')
        ->order_by('hearing_date','asc')
        ->get();
        if($res)
        {
            return $res;
        }
    }
    public static function getHearingBydate($data)
    {
        $res=DB::table('case')
            ->join('hearing','hearing.case_id','=','case.case_id')
            ->where_between('hearing.next_hearing_date',$data[0],$data[1])
            ->order_by('hearing.next_hearing_date','asc')
            ->get();
        if($res)
        {
            return $res;
        }
    }

    public static function getHearingByID($id,$json=false)
    {
        $res=DB::table(self::$table)
            ->where('hearing_id','=',$id)
             ->first();
        if($res)
        {
            if($json==true)
            {
                return json_encode($res);
            }
            else
            {
            return $res;
            }
        }

    }

    public static function getHearingByCaseID($id)
    {
        $res=DB::table(self::$table)
            ->where('case_id','=',$id)
            ->order_by('next_hearing_date','desc')
            ->first();
        return ($res) ? $res : NULL;
    }

    public static function getHearingByLawyerID($id)
    {
        $res=DB::table(self::$table)
        ->where('lawyer_id','=',$id)
        ->get();
         if($res) return $res;
        else return 0;
    }
    public static function getHearingByLawyerAssociateID($lawyer_id,$ass_id)
    {
        $res=DB::table(self::$table)
            ->where('hearing.lawyer_id','=',$lawyer_id)
            ->join('lawyer_case','lawyer_case.case_id','=','hearing.case_id')
            ->where('lawyer_case.uid','=',$ass_id)
            ->get();
        if($res) return $res;
        else return 0;
    }
    public static function getHearingByLawyerAssociateIDPaginate($lawyer_id,$ass_id)
    {
        $res=DB::table(self::$table)
            ->where('hearing.lawyer_id','=',$lawyer_id)
            ->join('lawyer_case','lawyer_case.case_id','=','hearing.case_id')
            ->where('lawyer_case.uid','=',$ass_id)
            ->paginate("15");
        if($res) return $res;
        else return 0;
    }
    public static function HearingByLawyerAssociateIDPaginateDate($lawyer_id,$ass_id,$date)
    {
         $res=DB::table(self::$table)
            ->where('hearing.next_hearing_date','=',$date)
            ->where('hearing.lawyer_id','=',$lawyer_id) 
            ->join('lawyer_case','lawyer_case.case_id','=','hearing.case_id')
            ->where('lawyer_case.uid','=',$ass_id)
            ->paginate("15");
        if($res) return $res;
        else return 0;
    }
    public static function getHearingByLawyerIDPaginate($id)
    {
//        $current_date=date('Y-m-d');

        $res=DB::table(self::$table)
//            ->where('hearing.next_hearing_date','=',$current_date)
            ->where('hearing.lawyer_id','=',$id)
            ->join('case','case.last_hearing_id','=','hearing.hearing_id')
            ->paginate('15',array("hearing.hearing_id","hearing.case_id","hearing.lawyer_id","hearing.sms_deliver",
                "hearing.updated_by","hearing.docket_no","hearing.description","hearing.court_hall","hearing.judge","hearing.stage","hearing.action_plan",
                "hearing.hearing_date","hearing.next_hearing_date","hearing.client_id","hearing.opp_party_name","hearing.crime_no"));
        if($res) return $res;
        else return 0;
    }
    public static function getHearingByLidDatePaginate($id,$date)
    {
//        $current_date=date('Y-m-d');

        $res=DB::table(self::$table)
           ->where('hearing.next_hearing_date','=',$date)
            ->where('hearing.lawyer_id','=',$id)
            ->join('case','case.last_hearing_id','=','hearing.hearing_id')
            ->paginate('15',array("hearing.hearing_id","hearing.case_id","hearing.lawyer_id","hearing.sms_deliver",
                "hearing.updated_by","hearing.docket_no","hearing.description","hearing.court_hall","hearing.judge","hearing.stage","hearing.action_plan",
                "hearing.hearing_date","hearing.next_hearing_date","hearing.client_id","hearing.opp_party_name","hearing.crime_no"));
        if($res) return $res;
        else return 0;
    }

    public static function deleteHearingByID($id)
    {
        $res=DB::table(self::$table)
            ->where('hearing_id','=',$id)
            ->delete();
        return $res;
    }

    public static function updateHearingByID($data,$id)
    {
        $res=DB::table(self::$table)
            ->where('hearing_id','=',$id)
            ->update($data);
        return $res;

    }

    public static function getHearingDetails()
    {
        $res=DB::table(self::$table)
            ->get();
        return $res;
    }

    public static function getClientHearingDetails()
    {
        $res=DB::table(self::$table)
            ->join('case','case.case_id','=','hearing.case_id')
            ->join('client','client.client_id','=','case.client_id')
            ->get(array('hearing.hearing_date','client.mobile','client.client_id','case.lawyer_id','hearing.sms_deliver','client.client_name'));
        return $res;
    }

    public static function addSmstoDatabase($data)
    {
        $res=DB::table('sms')
            ->insert_get_id($data);
       return $res;
    }

    public static function getHearingsByAssociateID($id)
    {

        $res=DB::table('lawyer_case')

            ->join('case','case.case_id','=','lawyer_case.case_id')
            ->join('hearing','hearing.case_id','=','case.case_id')
            ->where('lawyer_case.uid','=',$id)
            ->where_not_in('lawyer_case.permission',array('0'))
            ->order_by('hearing.hearing_date','asc')
            ->get();
        return $res;
    }
    public static function getHearingsByAssociateIDPaginate($id)
    {

        $res=DB::table('lawyer_case')

            ->join('case','case.case_id','=','lawyer_case.case_id')
            ->join('hearing','hearing.case_id','=','case.case_id')
            ->where('lawyer_case.uid','=',$id)
            ->where_not_in('lawyer_case.permission',array('0'))
            ->order_by('hearing.hearing_date','asc')
            ->paginate("15");
        return $res;
    }
    public static function getHearingByAssociateBydate($id, $data)
    {
        $res=DB::table('lawyer_case')
            ->join('case','case.case_id','=','lawyer_case.case_id')
            ->join('hearing','hearing.case_id','=','case.case_id')
            ->where('lawyer_case.uid','=',$id)
            ->where_not_in('lawyer_case.permission',array('0'))
            ->where_between('hearing.next_hearing_date',$data[0],$data[1])
            ->order_by('hearing.hearing_date','asc')
            ->get();
        return $res;

    }

    public static function searchHearings($data,$id)
    {
        $condition=array_unset($data,'from_date,to_date');
        $main_query="SELECT * FROM `hearing` JOIN `case` ON `hearing`.`hearing_id`=`case`.`last_hearing_id` WHERE `hearing`.`lawyer_id`= $id ";
        $query='';
        $from_date1=DateTime::createFromFormat('d/m/Y',$data['from_date']);
        $from_date=($from_date1) ? $from_date1->format('Y-m-d'): '';
        $to_date1=DateTime::createFromFormat('d/m/Y',$data['to_date']);
        $to_date=($to_date1) ? $to_date1->format('Y-m-d') : '';
        foreach($condition as $key=>$value)
        {
            if($value)
            {

                $query.= 'hearing.'.$key. ' = '. "'$value'" .' AND ';
            }
        }
        $a=explode('AND',$query);
        array_pop($a);
        $a=implode(' AND ' ,$a);
        if($from_date!='' && $to_date !='')
        {
            $a.= ($a) ? ' AND ' : '';
            $a.="next_hearing_date BETWEEN '$from_date' AND '$to_date'";
        }
        $value= ($a) ? 'AND '.$a : $a;
        
        $res=DB::query($main_query.$value);
        return $res;

    }
    public static function searchHearingsPaginate($data)
    {
        $condition=array_unset($data,'from_date,to_date');
        $main_query="SELECT * FROM `hearing`";
        $query='';
        $from_date1=DateTime::createFromFormat('d/m/Y',$data['from_date']);
        $from_date=($from_date1) ? $from_date1->format('Y-m-d'): '';
        $to_date1=DateTime::createFromFormat('d/m/Y',$data['to_date']);
        $to_date=($to_date1) ? $to_date1->format('Y-m-d') : '';
        foreach($condition as $key=>$value)
        {
            if($value)
            {

                $query.= $key. ' = '. "'$value'" .' AND ';
            }
        }
        $a=explode('AND',$query);
        array_pop($a);
        $a=implode(' AND ' ,$a);
        if($from_date!='' && $to_date !='')
        {
            $a.= ($a) ? ' AND ' : '';
            $a.="next_hearing_date BETWEEN '$from_date' AND '$to_date'";
        }
        $value= ($a) ? 'WHERE '.$a : $a;
//        return $value;
        $res=DB::query($main_query.$value);
        $res1=Paginator::make($res,count($res),'5');
        return $res1;

    }

    public static function deleteMultiHearing($ids)
    {
        $res=DB::table(self::$table)
            ->where_in('hearing_id',$ids)
            ->delete();
        return $res;
    }
    public static function getMultiHearingByIDs($ids)
    {
        $res=DB::table(self::$table)
            ->where_in('hearing_id',$ids)
            ->get();
        return $res;
    }

    public static function updateMultiHearing($data)
    {
        foreach($data as $datas)
        {
            $res=DB::table(self::$table)
                ->where('hearing_id','=',$datas['hearing_id'])
                ->update($datas['data']);
        }
        return $res;
    }
    public static function IsAvailable($column,$value)
    {
        $res=DB::table(self::$table)
            ->where($column,'=',$value)
            ->count();
        return $res;

    }


}