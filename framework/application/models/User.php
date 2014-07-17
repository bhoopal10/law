<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/3/13
 * Time: 3:18 PM
 * To change this template use File | Settings | File Templates.
 */

class User extends Eloquent
{
    public static $table='users';
   
    public static function createDB($data)
    {
        $username= str_replace(array('@','.'),'',$data['username']);
        $db='db_'.$username;
        $sql=DB::query("CREATE Database $db");
        $file=path('public').'bundles/admin/img/lawyers.sql';
        $lines = file($file);
        $templine = '';
        foreach ($lines as $line)
        {
// Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

// Add this line to the current segment
            $templine .= $line;
            $comp=substr($line,'0',26);
            $comp2=substr($line,0,11);
//            echo $comp2;
            if($comp2 == "INSERT INTO")
            {
                $templine=str_replace("INSERT INTO "," INSERT INTO `$db`.",$templine);
            }
            if($comp == "CREATE TABLE IF NOT EXISTS")
            {
                $templine=str_replace("CREATE TABLE IF NOT EXISTS "," CREATE TABLE IF NOT EXISTS `$db`.",$templine);
            }
// If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {


                // Perform the query
                DB::query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                // Reset temp variable to empty

                $templine = '';
            }
        }
        echo "Tables imported successfully";

        return $file;
    }
    /**
     * @param $data
     * @return mixed
     * Add New Users Into DataBase
     */
    public static function addUser($data)
    {
        if(isset($data))
        {
            $res=DB::table(self::$table)
                ->insert_get_id($data);
            if($res)
            {
                return $res;
            }
        }
    }

    /**
     * @param $data
     * to update lawyer (which user added which user)
     * @return mixed
     */
    public static function addLawyers_id($data)
    {
        $res=DB::table('friends')
            ->insert($data);
        return $res;

    }
    public static function getUsers($json=false)
    {
        $res=DB::table(self::$table)
            ->get();
        if($json==false) return $res;
        elseif($json==true) return json_encode($res);
    }
    public static function getUsersByID($id,$email)
    {
        $res=DB::table(self::$table)
            ->where_id_or_user_email($id,$email)
            ->paginate('15',array("id","first_name","username","last_name","lawyer_id","user_email","user_role","lawyer_subject","mobile","phone",
                "city","pincode","updated_by","payment","exp_date","reg_date"
            ));
     return $res;
    }

    public static function usersByUpdatedID($id)
    {
        $res=DB::table(self::$table)
            ->where('updated_by','=',$id)
            ->get(array("id","first_name","username","password","last_name","lawyer_id","user_email","user_role","lawyer_subject","mobile","phone",
                "city","pincode","updated_by","payment","exp_date","reg_date"
            ));
        return $res;
    }
    public static function usersByUpdatedIDPaginate($id)
    {
        $res=DB::table(self::$table)
            ->where('updated_by','=',$id)
            ->paginate('15',array("id","first_name","username","password","last_name","lawyer_id","user_email","user_role","lawyer_subject","mobile","phone",
                "city","pincode","updated_by","payment","exp_date","reg_date"
            ));
        return $res;
    }
      public static function getUserDetails($json=false)
    {
        $res=DB::table(self::$table)
//            ->left_join('contact','contact.contact_id','=','user_contact_id')
            ->get();
        if($json==false) return $res;
        elseif($json==true) return json_encode($res);
    }
    public static function getUserDetailsByID($id,$json=false)
    {
        $res=DB::table(self::$table)
            ->where('id','=',$id)
//            ->left_join('contact','contact.contact_id','=','user_contact_id')
            ->first();
        if($json==false) return $res;
        elseif($json==true) return json_encode($res);
    }

    public static function updatelawyerById($data,$id)
    {
        $res=DB::table(self::$table)
            ->where('id','=',$id)
            ->update($data);
        if($res)
        {
            return $res;
        }

    }

    public static function deleteUserByID($id)
    {
        $res=DB::table(self::$table)
            ->where('id','=',$id)
            ->delete();
        if($res)
        {
            return $res;
        }
    }

    /**
     * @param $data
     * @return mixed
     * add associate lawyer to permission table with caseID
     */
    public static function addCaseToPermission($data)
    {
        $res=DB::table('lawyer_case')
            ->insert($data);
        return $res;

    }

    public static function insertuserIDtoSettings($data)
    {
        $res=DB::table('user_settings')
            ->insert($data);
        return $res;
    }
    public static function uploadImage($data)
    {
        $uid=Auth::user()->id;
        $res=DB::table('user_settings')
            ->where('ui','=',$uid)
            ->update($data);
        return $res;
    }

    public static function newUserUploadImage($data)
    {
        $res=DB::table('user_settings')
            ->insert($data);
        if($res) return $res;
        else return false;

    }

    public static function getimageByID()
    {
        $uid=Auth::user()->id;
        $res=DB::table('user_settings')
            ->where('ui','=',$uid)
            ->first();
        if($res) return $res;
        else return false;
    }

    public static function gettingLawyerIDByAssociateID()
    {
        $uid=Auth::user()->id;
        $res=DB::table('friends')
            ->where('uid1','=',$uid)
            ->first();
        return $res;
    }

    public static function getUserByID($id)
    {
        $res=DB::table(self::$table)
            ->where('id','=',$id)
            ->first();
        if($res) return $res;
        else return false;
    }

    public static function addDocumentAutoUpload($data,$id)
    {
//        print_r($data);exit;
        $res=DB::table('user_settings')
            ->where('ui','=',$id)
            ->update($data);
        return $res;
    }
    public static function addBackupAutoUpload($data,$id)
    {
//        print_r($data);exit;
        $res=DB::table('user_settings')
            ->where('ui','=',$id)
            ->update($data);
        return $res;
    }
    public static function updateUserCasePermission1($datas,$permission)
    {
        foreach ($datas as $data)
        {
            $res=DB::table('lawyer_case')
                    ->where('permission_id','=',$data)
                    ->update($permission);
        }
        return $res;
    }
    public static function updateUserCasePermission($case_id,$permission,$ass_id)
    {
        foreach($case_id as $case)
        {
            $res=DB::table('lawyer_case')
                ->where('case_id','=',$case)
                ->where('uid','=',$ass_id)
                ->get();
            if(count($res)!=0)
            {
                $res1=DB::table('lawyer_case')
                    ->where('case_id','=',$case)
                    ->where('uid','=',$ass_id)
                    ->update(array('permission'=>$permission));
            }
            else
            {
                $res1=DB::table('lawyer_case')
                    ->insert(array('uid'=>$ass_id,'case_id'=>$case,'permission'=>$permission));
            }

        }
        return $res1;
    }
    public static function getlawyerpermission()
    {
        $res=DB::table(self::$table)
                ->where('user_role','=','2')
                ->join('user_settings','user_settings.ui','=','users.id')
                ->paginate('10');
                return $res;
    }
    public static function updateLawyerPermission($data,$uid)
    {

        $res=DB::table('user_settings')
                ->where('ui','=',$uid)
                ->update($data);
        return $res;
    }
    public static function getUserSettings($uid)
    {

        $res=DB::table('user_settings')
            ->where('ui','=',$uid)
            ->first();
        return $res;
    }

    public static function getUserAddressByID($id)
    {
        $res=DB::table(self::$table)
            ->where('id','=',$id)
            ->first(array('first_name','last_name','lawyer_subject','mobile','address','city','pincode','user_email'));
        return $res;
    }
    public static function getLawyerIDByAssociateID($id)
    {
        $res=DB::table('friends')
            ->where('uid1','=',$id)
            ->first();
        return $res;
//$res->uid2;
    }

    public static function getCasesByCaseID($id)
    {
        $res=DB::table('case')
            ->where('case_id','=',$id)
            ->get();
        return $res;
    }

    public static function doSerach($text)
    {
    $res=DB::table('users')
            ->where('first_name','like',"%$text%")
            ->or_where(function($q) use($text){
            $q->where('user_email','like',"%$text%");
            $q->where('mobile','like',"%$text%");
        })
        ->get();

    return $res;


    }

    public static function getUserByEmail($email)
    {
        $res=DB::table(self::$table)
            ->where('user_email','=',$email)
            ->first(array("user_email","id","first_name","username"));
        return $res;
    }
    public static function IsAvailable($column,$value)
    {
        $res=DB::table(self::$table)
            ->where($column,'=',$value)
            ->count();
        return $res;

    }
    public static function userEmail($id,$mail)
    {
        $res=DB::table(self::$table)
            ->where('id','!=',$id)
            ->where('user_email','=',$mail)
            ->get();
        if($res)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public static function userUserName($id,$username)
    {
        $res=DB::table(self::$table)
            ->where('id','!=',$id)
            ->where('username','=',$username)
            ->get();
        if($res)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

}