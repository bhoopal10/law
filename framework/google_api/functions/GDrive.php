<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/4/14
 * Time: 8:16 PM
 */

//namespace google_api\functions;
require_once path('public').'framework/google_api/src/Google_Client.php';
require_once path('public').'framework/google_api/src/contrib/Google_DriveService.php';
require_once path('public').'framework/google_api/src/contrib/Google_Oauth2Service.php';

class GDrive
{
    public static  $service;
    public function __construct()
    {
        $DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
        $SERVICE_ACCOUNT_EMAIL = '176783101860@developer.gserviceaccount.com';
        $SERVICE_ACCOUNT_PKCS12_FILE_PATH = path('public').'framework/google_api/functions/fbfc462f83a86fa336d86d1d7ca308c2b2915afd-privatekey.p12';


        $client = new Google_Client();
        $permission=new Google_Permission();
        $key=file_get_contents($SERVICE_ACCOUNT_PKCS12_FILE_PATH);
        $auth= new Google_AssertionCredentials(
            $SERVICE_ACCOUNT_EMAIL,array($DRIVE_SCOPE),$key
        );

// Get your credentials from the console
        $client->setClientId('176783101860.apps.googleusercontent.com');
//        $client->setClientSecret('xjo8dr-MFs40U4S9mhNd4vGJ');
        $client->setRedirectUri('http://localhost/lawyers/admin/gapi');
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setApprovalPrompt('auto');
        $client->setAccessType('offline');
        $client->setAssertionCredentials($auth);
        $client->setUseObjects(true);


//    $_SESSION['token']='ya29.1.AADtN_VXi035llIxk857aOy5ocROkNXZ9LrceBgVjk4_mCS5-zMROq-CwA-xs34';

        self::$service=new Google_DriveService($client);

        if (isset($_GET['logout'])) { // logout: destroy token
            unset($_SESSION['token']);
            die('Logged out.');
        }

        if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
            $client->authenticate();
            $_SESSION['token'] = $client->getAccessToken();
        }

        if (isset($_SESSION['token'])) { // extract token from session and configure client
            $token = $_SESSION['token'];
            $client->setAccessToken($token);
        }

        if (!$client->getAccessToken()) { // auth call to google
            $authUrl = $client->createAuthUrl();
            header("Location: ".$authUrl);
            die;
        }
    }
    public function createFolder($title,$description)
    {

        $folder= new Google_DriveFile();

        //Setup the Folder to Create
        $folder->setTitle($title);
        $folder->setDescription($description);
        $folder->setMimeType('application/vnd.google-apps.folder');

        //Set the ProjectsFolder Parent
        $parent=new Google_ParentReference();
        $parent->setId('0AEsiARfIiItqUk9PVA');
        $folder->setParents(array($parent));

        try
        {
            //create the ProjectFolder in the Parent
            $createdFile=self::$service->files->insert($folder,array('mimeType'=>'application/vnd.google-apps.folder',));
            return $createdFile;
        }
        catch (Exception $e)
        {
            print "An error occurred: " . $e->getMessage();
        }

    }
    public function createFile($title,$parentId,$data)
    {

        $file= new Google_DriveFile();

        //Setup the File to Create
        $file->setTitle($title);
        $file->setMimeType('application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        //Set the ProjectsFolder Parent
        $parent=new Google_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));

        try
        {
            //create the ProjectFolder in the Parent
            $createdFile=self::$service->files->insert($file,array('mimeType'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','data'=>$data));
            return $createdFile;
        }
        catch (Exception $e)
        {
            print "An error occurred: " . $e->getMessage();
        }

    }
    public function getFolderList($fileId)
    {
        try {
            $parents = self::$service->parents->listParents($fileId);
            foreach($parents['items'] as $lists)
            {
                print 'File Id:'.$lists['id'];
            }
//return $parents;
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    public function getSubFolderList($folderId)
    {
        $pageToken = NULL;
        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $children = self::$service->children->listChildren($folderId, $parameters);
                echo "<pre>";

                print_r($children->items).'<br>';
//                foreach ($children->getItems() as $child) {
//                    print 'File Id: ' . $child->getId();
//                }
                $pageToken = $children->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);

    }
    /**
     * Retrieve a list of File resources.
     *
     * @param Google_DriveService $service Drive API service instance.
     * @return Array List of Google_DriveFile resources.
     */
    function retrieveAllFiles() {
        $result = array();
        $pageToken = NULL;

        do {
            try {
                $parameters = array();
                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }
                $files = self::$service->files->listFiles($parameters);

                array_push($result, $files);
                $pageToken = $files->getNextPageToken();
            } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
            }
        } while ($pageToken);
        return $result;
    }
    function listFolders()
    {

        $result='';
        $folders=$this->retrieveAllFiles();
        foreach($folders as $folder)
        {
            foreach($folder->items as $Folder)
            {
                if($Folder->mimeType == 'application/vnd.google-apps.folder')
                {
                    $result.=$Folder->title.'->'.$Folder->id.',';
                }
            }
        }
        $results=rtrim($result,',');
        return $results;
    }
    function listFiles()
    {

        $result='';
        $files=$this->retrieveAllFiles();
        foreach($files as $file)
        {
            foreach($file->items as $File)
            {
                if($File->mimeType == 'text/plain')
                {
                    $result.=$File->title.'->'.$File->id.',';
                }
            }
        }
        $results=rtrim($result,',');
        return $results;
    }
    function getRootfolder_id()
    {
        $result='';
        try{
        $root=self::$service->about->get();
            print $root->getRootFolderId();
        }
        catch(Exception $e)
            {
                print "An error occurred: " . $e->getMessage();

            }
    }

} 