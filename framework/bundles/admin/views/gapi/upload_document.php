<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/5/14
 * Time: 9:25 PM
 */

        require_once path('public').'framework/google_api/functions/GDrive.php';
        $val=Session::get('cretital');
        Session::forget('cretital');
        $onemore=Session::get('onemore');
            if(isset($val)){
                    $upld=new GDrive();
                    $datas=file_get_contents($val);
                    $cretital=$upld->createFile('onedoc','0AEsiARfIiItqUk9PVA',$datas);
                $permission=new Google_Permission();
                echo $permission->getAuthKey().'Etag:'.$permission->getEtag();
//                    echo'<script> window.location="http://localhost/lawyers/admin/document/"; </script> ';

}
elseif(isset($onemore))
{
    $upld=new GDrive();
    $datas=file_get_contents($onemore);
    $cretital=$upld->createFile('onemore','0AEsiARfIiItqUk9PVA',$datas);
    print_r($cretital);
}
