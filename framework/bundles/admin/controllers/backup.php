<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 12/17/13
 * Time: 7:48 AM
 * To change this template use File | Settings | File Templates.
 */
include_once(path('public').'framework/dbox/curl.class.php');
class Admin_Backup_Controller extends Admin_Base_Controller
{
    public $restful=true;
    private function get_role()
    {
        if(Auth::check())
        {
            $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;
            return $role;
        }
    }
    public function get_CreateBackup($id)
    {

        $user=$this->get_role();
        $verify=User::IsAvailable('id',$id);
        if($verify > 0)
        {
            if($user=='admin')
            {

                return View::make('admin::admin/backup.create_backup')
                 ->with('user',User::getUserDetailsByID($id));
            }
        }
    }

    public function get_DownloadBackup($id)
    {
        $values=explode(',',$id);
        $content='';
        $uid=Crypter::decrypt($values[0]);
        $user_details=(array)User::getUserDetailsByID($uid);
        unset($user_details['password'],$user_details['user_role'],$user_details['user_log'],$user_details['lawyer_subject'],$user_details['user_role']);
        array_splice($user_details,6,12);
        $filename=Str::random(10,'alpha').'.xml';
        $filename2=Str::random(10,'alpha').'.txt';
//        echo "<pre>";
//        print_r($user_details);exit;
        $module=$values[1];
        switch ($module)
        {
            case "appointment":
                $data=Appointment::getAppointmentByUserID($uid);
                $start_element_parent='appointments';
                $start_element_child='appointment';
                break;
            case "case":
                $data=Cases::getCaseDetailsByLawyerID($uid);
                $start_element_parent='cases';
                $start_element_child='case';
                break;
            case "client":
                $data=Client::getClientBylawyerID($uid);
                $start_element_parent='clients';
                $start_element_child='client';
                break;
            case "hearing":
                $data=Hearing::getHearingByLawyerID($uid);
                $start_element_parent='hearings';
                $start_element_child='hearing';
                break;
        }
        if($data){
                    $xml= new XMLWriter();
                    $xml->openURI($filename);
                   $xml->startDocument();
                   $xml->setIndent(true);
                   $xml->startElement($start_element_parent);
                  $xml->startElement('user');
                    foreach($user_details as $key=>$value)
                        {
                           $xml->writeElement($key,$value);
                        }
                   $xml->endElement();
                    foreach($data as $Data1)
                     {
                        $xml->startElement($start_element_child);
                         foreach($Data1 as $key=>$value)
                         {
                             $value=$value!=''?$value:'NULL';
                            $xml->writeElement($key,$value);
                         }
                        $xml->endElement();
                    }
                  $xml->endElement();
                  $xml->flush();

                $handle=fopen($filename,'r');
                $fp=fopen($filename2,"w");
                while(!feof($handle))
                {
                    fwrite($fp,Crypter::encrypt(fgets($handle)).',');
                }
               fclose($fp);
                fclose($handle);

            $newFile=$user_details['first_name'].date("y-m-d-g-i-s").$module.'.txt';
            copy($filename2,path('public').Config::get('admin::admin_config.backup_path').$newFile);
            $datas=file_get_contents($filename2);
            $del=unlink($filename2);
            chmod(realpath($filename),0777);
//            unlink($filename);
            return Response::download(path('public').Config::get('admin::admin_config.backup_path').$newFile);

        }
        else
        {
            return Redirect::back()->with('error','File content not available');
        }
    }

        public function post_UpdateRestoreFile($id)
        {
            $file=Input::File('restore_file');
            $zip = new ZipArchive;
            $res = $zip->open($file['tmp_name']);
            if ($res === TRUE) {
            $zip->extractTo('../img/documents/');
            $file_name=$zip->getNameIndex(0);
            $zip->close();
           
            $file=file_get_contents('../img/documents/'.$file_name);
            $arr=explode("\n",$file);
            $fid=$arr[1];
            if($fid!=$id)
            {
                return Redirect::back()->with('error',"Mismatch lawyers backup file");
            }
            unset($arr[0],$arr[1]);
            array_pop($arr);
            echo "<pre>";
            foreach ($arr as $value) {
                $db=DB::query("$value");
            }

        return Redirect::back()->with('status',"Updated successfully");
            
            }
        }
        public function post_UpdateRestoreFile1($id)
        {
            $ids=explode(',',$id);
            $module=$ids[1];// module like Appointments/contact/cases/hearings
            $user_id=Crypter::decrypt($ids[0]);
            $file=Input::File('restore_file');
            $tmp=$file['tmp_name'];
            $handle=file($tmp);
//            print_r($handle);exit;
            $values=explode(',',$handle[0]);
            array_pop($values);
            $comp='';
           if($values!=null)
           {
            $module1=Crypter::decrypt($values[1]);
            $comp=substr($module1,1,-2);
           }
            if($module==$comp)
            {
                    $fp=fopen('sample.xml','w');
                    foreach($values as $handles)
                    {
                        fwrite($fp,Crypter::decrypt($handles));
                    }
            }
            else
            {
                return Redirect::back()->with('status',"Please select $module backup file");
            }
            $data=file_get_contents('sample.xml');
            $json=simplexml_load_string($data);
            $data1=(array)$json;
            if($data1['user']->id != $user_id)
            {
                return Redirect::back()->with('status',"Mismatch lawyers backup file");
            }
//            print_r($data1);exit;
            unset($data1['user']);
            $element=substr($module,0,-1); // element is singular module(appointments to appointment)
            $data2=$data1[$element];
            $comp_ids=libbackup::getmoduleIds($element);
//            print_r($comp_ids);exit;
            $module_id=$element.'_id'; // module_id is primary key of selected table (if appointment then appointment_id)
//            print_r($module_id);exit;
            $data3=get_array_by_objectId_from_object_array($data2,$comp_ids,$module_id);
            $update_id=end($data3);
            $update_id=$update_id[$module_id];
            $data4=get_array_by_idString_from_object_array($comp_ids,$update_id,$module_id);
            array_pop($data3);
            $diff=multi_array_diff($data3,$data4);
            $res=Backup::updateBackups($diff,$element,$module_id,$update_id);
            if($res) return Redirect::back()->with('status','Updated Successfully');
            else return Redirect::back()->with('status','No change done!');

        }
    public function post_RestoreFile($id)
    {
        $ids=explode(',',$id);
        $module=$ids[1];// module like Appointments/contact/cases/hearings
        $user_id=Crypter::decrypt($ids[0]);
        $file=Input::File('restore_file');
        $tmp=$file['tmp_name'];
        $handle=file($tmp);
        $values=explode(',',$handle[0]);

        array_pop($values);
        $comp='';
        if($values!=null)
        {
            $module1=Crypter::decrypt($values[1]);
            $comp=substr($module1,1,-2);
        }
        if($module==$comp)
        {
            $fp=fopen('sample.xml','w');
            foreach($values as $handles)
            {
                fwrite($fp,Crypter::decrypt($handles));
            }

        }

        else
        {
            return Redirect::back()->with('status',"Please select $module backup file");
        }
        $data=file_get_contents('sample.xml');

        $json=simplexml_load_string($data);
        $data1=(array)$json;

        if($data1['user']->id != $user_id)
        {
            return Redirect::back()->with('status',"Mismatch lawyers backup");
        }
        unset($data1['user']);
        $element=substr($module,0,-1); // element is singular module(appointments to appointment)
        $data2=$data1[$element];
        $data3=multi_object_to_multi_array($data2);
        $delete=Backup::deleteByUserID($user_id,$element);
        $insert=Backup::restoreBackup($element,$data3);
        if($insert) return Redirect::back()->with('status','Successfully restored ');
        return Redirect::back()->with('error','Failed to restore');
    }
   
    public function get_autoBackup()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $fileName = 'mysqlbackup--' . date('d-m-Y') . '@'.date('h.i.s').'.sql' ;
        $newName='mysqlbackup--' . date('d-m-Y') . '@'.date('h.i.s').'.sql' ;
        $fp = fopen($fileName, 'wb');
        $return='';
        $return .= "--\n";
        $return .= "-- A Mysql Backup System \n";
        $return .= "--\n";
        $return .= '-- Export created: ' . date("Y/m/d") . ' on ' . date("h:i") . "\n\n\n";
        $return = "--\n";
        $return .= "-- Database : LAW \n";
        $return .= "--\n";
        $return .= "-- --------------------------------------------------\n";
        $return .= "-- ---------------------------------------------------\n";
        $return .= 'SET AUTOCOMMIT = 0 ;' ."\n" ;
        $return .= 'SET FOREIGN_KEY_CHECKS=0 ;' ."\n" ;
        $tables = array() ;
        $result = DB::query('SHOW TABLES' ) ;
        foreach ($result as  $value) {
            $tables[]=$value->tables_in_law;
        }
        foreach($tables as $table)
        {
            $result = DB::query("SELECT * FROM  `$table`") ;
            $return .= "--\n" ;
            $return .= '-- Tabel structure for table `' . $table . '`' . "\n" ;
            $return .= "--\n" ;
            $return.= 'DROP TABLE IF EXISTS `'.$table.'`;' . "\n" ;
            $schema = DB::query("SHOW CREATE TABLE `$table`");
            $cTable='create table';
            $return.= $schema[0]->$cTable.";" . "\n\n" ;
           
            foreach($result as $rows)
            {
                $return .= 'INSERT INTO `'.$table .'` VALUES ( ' ;
                foreach($rows as $rValues)
                {
                $return .= '"'. mysql_escape($rValues) . "\"," ;
                }
                // Let's remove the last comma
                $return = substr("$return", 0, -1) ;
                $return .= ");" ."\n" ;
            
            }
         $return .= "\n\n" ;

        }
        $return .= 'SET FOREIGN_KEY_CHECKS = 1 ; ' . "\n" ;
        $return .= 'COMMIT ; ' . "\n" ;
        $return .= 'SET AUTOCOMMIT = 1 ; ' . "\n" ;
                fwrite($fp, $return);
                fclose($fp);
                // copy($fileName,path('public').Config::get('admin::admin_config.backup_path').$newName);
         $datas=file_get_contents($fileName);        
        $curl->setHeader('Content-Type','text/x-sql');
        $curl->put('https://api-content.dropbox.com/1/files_put/auto/mysql/'.$newName,$datas);
        print_r(json_decode($curl->response));
        unlink($fileName);
       

    }
    public function get_LawyerBackup1()
    {
        $uid=Auth::user()->id;
        $content='';
        $user_details=(array)User::getUserDetailsByID($uid);
        $user_details=(array)User::getUserDetailsByID($uid);
        unset($user_details['password'],$user_details['user_role'],$user_details['user_log'],$user_details['lawyer_subject'],$user_details['user_role']);
        array_splice($user_details,6,12);
        $filename=Str::random(10,'alpha').'.xml';
        $filename2=Str::random(10,'alpha').'.txt';
        $zipName=$user_details['first_name'].date("y-m-d-g-i-s").'-backup.zip';
        $modules=array();
        $appointment['data']=Appointment::getAppointmentByUserID($uid);
        $appointment['parent']='appointments';
        $appointment['child']='appointment';
        array_push($modules,$appointment);
        $case['data']=Cases::getCaseDetailsByLawyerID($uid);
        $case['parent']='cases';
        $case['child']='case';
        array_push($modules,$case);
        $hearing['data']=Hearing::getHearingByLawyerID($uid);
        $hearing['parent']='hearings';
        $hearing['child']='hearing';
        array_push($modules,$hearing);
        $client['data']=Client::getClientBylawyerID($uid);
        $client['parent']='clients';
        $client['child']='client';
        array_push($modules,$client);
        $zip=new ZipArchive();
        if($zip->open($zipName,ZIPARCHIVE::CREATE)!==TRUE)
        {
            $error .= "* Sorry ZIP creation failed at this time";
        }

        foreach ($modules as $module) {
            if($module['data'])
            {
                $xml= new XMLWriter();
                $xml->openURI($filename);
                $xml->startDocument();
                $xml->setIndent(true);
                $xml->startElement($module['parent']);
                $xml->startElement('user');
                foreach ($user_details as $key => $value) 
                {
                    $xml->writeElement($key,$value);
                }
                $xml->endElement();
                foreach($module['data'] as $Data1)
                 {
                    $xml->startElement($module['child']);
                     foreach($Data1 as $key=>$value)
                     {
                         $value=$value!=''?$value:'NULL';
                        $xml->writeElement($key,$value);
                     }
                    $xml->endElement();
                }
                $xml->endElement();
                $xml->flush();
                $handle=fopen($filename,'r');
                $fp=fopen($filename2,"w");
                while(!feof($handle))
                {
                    fwrite($fp,Crypter::encrypt(fgets($handle)).',');
                }
               fclose($fp);
               fclose($handle);
                $newFile=$user_details['first_name'].date("y-m-d-g-i-s").$module['child'].'.txt';
                copy($filename2,path('public').Config::get('admin::admin_config.backup_path').$newFile);
                $datas=file_get_contents($filename2);
                $del=unlink($filename2);
                chmod(realpath($filename),0777);
                unlink($filename);
                 $zip->addFile(path('public').Config::get('admin::admin_config.backup_path').$newFile,$newFile);
            }
        }

        $zip->close();
        
        if(file_exists($zipName))
        {
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="'.$zipName.'"');
        readfile($zipName);
        unlink($zipName);
        }
        
    }
    public function get_LawyerBackup2($id)
    {
        $uid=$id;
        $content='';
        $user_details=(array)User::getUserDetailsByID($uid);
        unset($user_details['password'],$user_details['user_role'],$user_details['user_log'],$user_details['lawyer_subject'],$user_details['user_role']);
        array_splice($user_details,6,12);
        $filename=Str::random(10,'alpha').'.xml';
        $filename2=Str::random(10,'alpha').'.txt';
        $zipName=$user_details['first_name'].date("y-m-d-g-i-s").'-backup.zip';
        $modules=array();
        $appointment['data']=Appointment::getAppointmentByUserID($uid);
        $appointment['parent']='appointments';
        $appointment['child']='appointment';
        array_push($modules,$appointment);
        $case['data']=Cases::getCaseDetailsByLawyerID($uid);
        $case['parent']='cases';
        $case['child']='case';
        array_push($modules,$case);
        $hearing['data']=Hearing::getHearingByLawyerID($uid);
        $hearing['parent']='hearings';
        $hearing['child']='hearing';
        array_push($modules,$hearing);
        $client['data']=Client::getClientBylawyerID($uid);
        $client['parent']='clients';
        $client['child']='client';
        array_push($modules,$client);
        $contact['data']=Contacts::getContactBylawyerID($uid);
        $contact['parent']='contacts';
        $contact['child']='contact';
        array_push($modules,$contact);
        $document['data']=Document::getdocumentBylawyerID($uid);
        $document['parent']='documents';
        $document['child']='document';
        array_push($modules,$document);
        $zip=new ZipArchive();
        if($zip->open($zipName,ZIPARCHIVE::CREATE)!==TRUE)
        {
            $error .= "* Sorry ZIP creation failed at this time";
        }
       $xml= new XMLWriter();
                $xml->openURI($filename);
                $xml->startDocument();
                $xml->setIndent(true);
                 $xml->startElement('user');
                foreach ($user_details as $key => $value) 
                {
                    $xml->writeElement($key,$value);
                }
                $xml->endElement();
       foreach ($modules as $module) {
            if($module['data'])
            {
                
                $xml->startElement($module['parent']);
                foreach($module['data'] as $Data1)
                 {
                    $xml->startElement($module['child']);
                     foreach($Data1 as $key=>$value)
                     {
                         $value=$value!=''?$value:'NULL';
                        $xml->writeElement($key,$value);
                     }
                    $xml->endElement();
                }
                $xml->endElement();
            }
        }
        $xml->flush();
         $handle=fopen($filename,'r');
        $fp=fopen($filename2,"w");
        while(!feof($handle))
        {
            fwrite($fp,Crypter::encrypt(fgets($handle)).',');
        }
       fclose($fp);
       fclose($handle);
        $newFile=$user_details['first_name'].date("y-m-d-g-i-s").'_All.txt';
        copy($filename2,path('public').Config::get('admin::admin_config.backup_path').$newFile);
        $datas=file_get_contents($filename2);
        $del=unlink($filename2);
        chmod(realpath($filename),0777);
        unlink($filename);
        $zip->addFile(path('public').Config::get('admin::admin_config.backup_path').$newFile,$newFile);
        $zip->close();
        
        if(file_exists($zipName))
        {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zipName.'"');
            readfile($zipName);
            unlink($zipName); 
        }
    }
    public function get_LawyerBackup($id)
    {
        $uid=$id;
        $user_details=(array)User::getUserDetailsByID($uid);
        $filename=Str::random(10,'alpha').'.sql';
        $fp = fopen($filename, 'wb');
        $zipName=$user_details['first_name'].Str::random(5,'alpha').date("y-m-d-g-i-s").'-backup.zip';
        $content='';
        $content.="<user>\n";
        $content.=$user_details['id']."\n";
        $appointment = DB::query("SELECT * FROM  `appointment` where lawyer_id=$uid") ;
        foreach ($appointment as  $rows) 
        {
            $content .= 'REPLACE INTO `appointment` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $case =DB::query("SELECT * FROM  `case` where lawyer_id=$uid");
         foreach ($case as  $rows) 
        {
            $content .= 'REPLACE INTO `case` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $case_setting =DB::query("SELECT * FROM  `case_setting` where lawyer_id=$uid");
         foreach ($case_setting as  $rows) 
        {
            $content .= 'REPLACE INTO `case_setting` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $client =DB::query("SELECT * FROM  `client` where update_by=$uid");
         foreach ($client as  $rows) 
        {
            $content .= 'REPLACE INTO `client` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $contact =DB::query("SELECT * FROM  `contact` where user_id=$uid");

         foreach ($contact as  $rows) 
        {
            $content .= 'REPLACE INTO `contact` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $document =DB::query("SELECT * FROM  `document` where lawyer_id=$uid");
         foreach ($document as  $rows) 
        {
            $content .= 'REPLACE INTO `document` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $hearing =DB::query("SELECT * FROM  `hearing` where lawyer_id=$uid");
         foreach ($hearing as  $rows) 
        {
            $content .= 'REPLACE INTO `hearing` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        $payment =DB::query("SELECT * FROM  `payment` where from_user=$uid");
         foreach ($payment as  $rows) 
        {
            $content .= 'REPLACE INTO `payment` VALUES ( ' ;
            foreach ($rows as $value) 
            {
                $content .='"'.mysql_escape($value) ."\",";
            }
            $content = substr("$content", 0, -1) ;
            $content .= ");" ."\n" ;
        }
        fwrite($fp, $content);
        fclose($fp);
        $zip=new ZipArchive();
        if($zip->open($zipName,ZIPARCHIVE::CREATE)!==TRUE)
        {
            $error .= "* Sorry ZIP creation failed at this time";
        }
        $newFile=$user_details['first_name'].date("y-m-d-g-i-s").'_All.sql';
        copy($filename,path('public').Config::get('admin::admin_config.backup_path').$newFile);
        chmod(realpath($filename),0777);
        unlink($filename);
        $zip->addFile(path('public').Config::get('admin::admin_config.backup_path').$newFile,$newFile);
        $zip->close();
       
        
        if(file_exists($zipName))
        {
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="'.$zipName.'"');
            readfile($zipName);
            unlink($zipName); 
        }
    }

}