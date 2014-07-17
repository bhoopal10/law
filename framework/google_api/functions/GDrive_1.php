<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/8/14
 * Time: 1:45 PM
 */

require_once path('public').'framework/google_api/src/Google_Client.php';
require_once path('public').'framework/google_api/src/contrib/Google_DriveService.php';
require_once path('public').'framework/google_api/src/contrib/Google_Oauth2Service.php';


// ...
const DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
const SERVICE_ACCOUNT_EMAIL = '176783101860@developer.gserviceaccount.com';
class GDrive_1{

    public function buildClient()
    {
        $SERVICE_ACCOUNT_PKCS12_FILE_PATH = path('public').'framework/google_api/functions/fbfc462f83a86fa336d86d1d7ca308c2b2915afd-privatekey.p12';
        $key = file_get_contents($SERVICE_ACCOUNT_PKCS12_FILE_PATH);
        $auth = new Google_AssertionCredentials(
            SERVICE_ACCOUNT_EMAIL,
            array(DRIVE_SCOPE),
            $key);

//    $auth->sub='bhoopal10@gmail.com';

        $client = new Google_Client();
        $client->setUseObjects(true);
        $client->setAssertionCredentials($auth);
        return $client;
    }
/**
 * Build and returns a Drive service object authorized with the service accounts.
 *
 * @return Google_DriveService service object.
 */
 public function buildService() {
    $client=$this->buildClient();
    return new Google_DriveService($client);
}
public function createFolder($title,$description)
{
    $service=$this->buildService();
    $folder= new Google_DriveFile();

    //Setup the Folder to Create
    $folder->setTitle($title);
    $folder->setDescription($description);
    $folder->setMimeType('application/vnd.google-apps.folder');

    //Set the ProjectsFolder Parent
    $parent=new Google_ParentReference();
//    $parent->setId('0B0rWVYtf4dPyTEZHRVBoUEVLNzQ');
    $folder->setParents(array($parent));

    try
    {
        //create the ProjectFolder in the Parent
        $createdFile=$service->files->insert($folder,array('mimeType'=>'application/vnd.google-apps.folder',));
        return $createdFile;
    }
    catch (Exception $e)
    {
        print "An error occurred: " . $e->getMessage();
    }

}
    public function createFile($title,$type,$data)
    {
        $service=$this->buildService();
        $folder= new Google_DriveFile();

        //Setup the Folder to Create
        $folder->setTitle($title);
//        $folder->setDescription($description);
        $folder->setMimeType($type);

        //Set the ProjectsFolder Parent
        $parent=new Google_ParentReference();
//    $parent->setId('0B0rWVYtf4dPyTEZHRVBoUEVLNzQ');
        $folder->setParents(array($parent));

        try
        {
            //create the ProjectFolder in the Parent
            $createdFile=$service->files->insert($folder,array('data'=>$data,'mimeType'=>'application/vnd.google-apps.folder',));
            return $createdFile;
        }
        catch (Exception $e)
        {
            print "An error occurred: " . $e->getMessage();
        }

    }
    public function deleteFile($fileID)
    {
        $ids=explode(',',$fileID);
        $service=$this->buildService();
        try
        {
            foreach($ids as $id)
            {
            $service->files->delete($id);
            }
        }
        catch(Exception $e)
        {
            print "An error occured: ".$e->getMessage();
        }

    }
public function getFolderList()
{
    $service=$this->buildService();
    try {
        $parents =$service->parents->listParents('0B4t6RvVF7erSOHc3U0hQOFlySDg');
//        foreach($parents['items'] as $lists)
//        {
//            print 'File Id:'.$lists['id'];
//        }
        return $parents;
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
}
public function retrieveAllFiles() {
    $service=$this->buildService();
    $result = array();
    $pageToken = NULL;

    do {
        try {
            $parameters = array();
            if ($pageToken) {
                $parameters['pageToken'] = $pageToken;
            }
            $files = $service->files->listFiles($parameters);

            array_push($result, $files);
            $pageToken = $files->getNextPageToken();
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
            $pageToken = NULL;
        }
    } while ($pageToken);
    return $result;
}
  public function downloadFile($fileID) {
      $client=$this->buildClient();
      $service=$this->buildService();
      $file=$service->files->get($fileID);
        $downloadUrl =  $file->getDownloadUrl();
//        return $downloadUrl;
        if ($downloadUrl) {
            $request = new Google_HttpRequest($file->getDownloadUrl(), 'GET', null, null);
            $httpRequest = $client->getIo()->authenticatedRequest($request);
            if ($httpRequest->getResponseHttpCode() == 200) {
                return $httpRequest->getResponseBody();
            } else {
                // An error occurred.
                return null;
            }
        } else {
            // The file doesn't have any content stored on Drive.
            return null;
        }
    }
    public function insertPermission($fileID,$value,$type,$role)
    {
        $service=$this->buildService();
        $newPermission = new Google_Permission();
        $newPermission->setValue($value);
        $newPermission->setType($type);
        $newPermission->setRole($role);
        try {
            return $service->permissions->insert($fileID,$newPermission);
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
        return NULL;
    }

    }




