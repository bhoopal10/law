    <?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 10/26/13
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
include_once(path('public').'framework/dbox/curl.class.php');
class Admin_Document_Controller extends Admin_Base_Controller
{
    public $restful=true;
    private function get_var()
    {
        if(Auth::check()){ $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;}
        return $role;

    }

    public function get_Index()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {

        return View::make('admin::lawyer/documents.add_document');
        }
        elseif($user=='admin')
        {
            return Redirect::back()
                ->with('status','Your not allow to use this link');
        }
        elseif($user=='associate')
        {
            return View::make('admin::associate/documents.add_document');
        }
    }
    public function get_CaseDocument($id)
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/documents.add_document_by_cases')
                ->with('case_id',$id);
        }

        elseif($user=='associate')
        {
            return View::make('admin::associate/documents.add_document_by_cases')
                ->with('case_id',$id);
        }
    }
    public function get_EditHearingDocument($ids)
    {
        $ids=explode(',',$ids);
        $id=$ids[0];
        $hearing_id=$ids[1];
        $user=$this->get_var();
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/hearing.add_document_by_edit_hearing')
                ->with('hearing_id',$hearing_id)
                ->with('case_id',$id);
        }

        elseif($user=='associate')
        {
            return View::make('admin::associate/hearing.add_document_by_edit_hearing')
                    ->with('hearing_id',$hearing_id)
                    ->with('case_id',$id);
        }
    }
    public function get_ViewDocuments()
   {
        $user=$this->get_var();
        if($user=='lawyer' )
        {
            if($_GET)
            {
                Input::flash();
                if(array_filter(Input::all()))
                {                    
                    $doc_name=Input::get('doc_name','');
                    $case_id=Input::get('case_no','');
                    $from=Input::get('from_date','01/01/1970');
                    $from=implode('-',array_reverse(explode('/',$from)));
                    $to=Input::get('to_date','01/01/4012');
                    $to=implode('-',array_reverse(explode('/',$to)));
                    $res=Document::where('lawyer_id','=',Auth::user()->id)
                                ->where('doc_name','LIKE',"%$doc_name%")
                                ->where(function($query) use($case_id){
                                    if($case_id)
                                    {
                                        $query->where('doc_case_no','=',$case_id);
                                    }
                                })
                                ->where_between('create_date',$from,$to)
                                ->order_by('doc_id','desc')
                                ->paginate('15');
                        return View::make('admin::lawyer/documents.view_document')
                         ->with('document',$res);
                }
                else
                {
                     return View::make('admin::lawyer/documents.view_document')
                ->with('document',Document::getDocumentPaginate(Auth::user()->id));
                }
            }
            else
            {
                return View::make('admin::lawyer/documents.view_document')
                ->with('document',Document::getDocumentPaginate(Auth::user()->id));
            }

            
        }
        elseif($user=='admin')
        {
            return Redirect::back()
                ->with('status','Your not allow to use this link');
        }
        elseif($user=='associate')
        {
            $id=Auth::user()->id;
            $lawyer_id=liblawyer::lawyerIdByAssoId($id);
            if($_GET)
            {
                Input::flash();
                if(array_filter(Input::all()))
                {                    
                    $doc_name=Input::get('doc_name','');
                    $case_id=Input::get('case_no','');
                    $from=Input::get('from_date','01/01/1970');
                    if(!$from)
                    {
                        $from='01/01/1970';
                    }
                    $from=implode('-',array_reverse(explode('/',$from)));
                    $to=Input::get('to_date','01/01/4015');
                    if(!$to)
                    {
                        $to='01/01/4015';
                    }
                    $to=implode('-',array_reverse(explode('/',$to)));

                    $res=Document::where('lawyer_id','=',$lawyer_id)
                                ->where('doc_name','LIKE',"%$doc_name%")
                                ->where(function($query) use($case_id){
                                    if($case_id)
                                    {
                                        $query->where('doc_case_no','=',$case_id);
                                    }
                                })
                                ->where_between('create_date',$from,$to)
                                ->order_by('doc_id','desc')
                                ->paginate('15');
                                
                        return View::make('admin::associate/documents.view_document')
                         ->with('document',$res);
                }
                else{
                     $document=DB::query("select * from document where lawyer_id = $lawyer_id AND  doc_case_no IN
                        (select lawyer_case.case_id from lawyer_case where lawyer_case.uid=$id AND lawyer_case.permission !=0 )");
                    $count=count($document);
                    $document=Paginator::make($document,$count,'15');

                    return View::make('admin::associate/documents.view_document')
                        ->with('document',$document);
                }
            }
            else{
                $document=DB::query("select * from document where lawyer_id = $lawyer_id AND  doc_case_no IN
                        (select lawyer_case.case_id from lawyer_case where lawyer_case.uid=$id AND lawyer_case.permission !=0 )");
            $count=count($document);
            $document=Paginator::make($document,$count,'15');

            return View::make('admin::associate/documents.view_document')
                ->with('document',$document);
            }
            
            
        }
    }

    public function post_AddDocuments()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
       $case_link=Input::get('case_link');
       $doc_name=Input::get('doc_name');
       $doc_description=Input::get('doc_description');
       $associate_id=Input::get('associate_id');
       $file=Input::file('doc_file');
       $storage=User::getUserSettings($lawyer_id);
        /* Start  Condition for Storage capacity  */
       $comp=$storage->storage;
       $curr_storage=$storage->current_storage;
        $cond=bccomp($comp,$curr_storage,'2');
       if($cond < 1)
       {
           return Redirect::back()->with('error','Your Disk Space Full to upgrade Please contact administrator');
       }
        /* End  Condition for Storage capacity  */
        $file_name='';
    /*      if file Exists          */
        if($file['error']!=4)
        {
            $file_type=$file['type'];
            $file_size=$file['size'];
            $f_name=  str_replace(" ",'', $file['name']);
             $file_name.='_'.date('dmHis').$f_name;
             $file_path=$file['tmp_name'];

            $current_storage=$storage->current_storage;
            $append=bcdiv($file_size,'1000000',2);
            $total=bcadd($current_storage,$append,2);
            $daTa=array('current_storage'=>$total);
            $one=User::updateLawyerPermission($daTa,$lawyer_id);
            $upload=move_uploaded_file($file_path,path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name);

       }
        if(isset($associate_id))
        {
            $associate_ids=Crypter::decrypt($associate_id);
            $update_by=$associate_ids;
        }
        else
        {
            $update_by=$lawyer_id;
        }
        $val= Config::get('application.url').Config::get('admin::admin_config.image_path').'documents/'.$file_name;
        $datas=file_get_contents($val);
        $curl->setHeader('Content-Type',$file_type);
        $curl->put('https://api-content.dropbox.com/1/files_put/auto/'.$file_name,$datas);
        $drive_upload=(json_decode($curl->response));

        if($drive_upload){$upload_fileID=$drive_upload->rev;}
        else { $upload_fileID=''; }
        $data=array(
            'lawyer_id'=>$lawyer_id,
            'doc_case_no'=>$case_link,
            'doc_name'=>$doc_name,
            'doc_file_name'=>$file_name,
            'doc_description'=>$doc_description,
            'updated_by'=>$update_by,
            'gdrive_fileID'=>$upload_fileID,
            'file_size'=>$file_size

        );
            $res=Document::addDocument($data);
            if($res) return Redirect::back()->with('status','Document as been uploaded');
            else return Redirect::back()->with('status','Document uploaded failed');
    }
    public function post_AddCaseDocuments()
    {
        $user=$this->get_var();
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
        $case_link=Input::get('case_link');
        $doc_name=Input::get('doc_name');
        $doc_description=Input::get('doc_description');
        $associate_id=Input::get('associate_id');
        $file=Input::file('doc_file');
        $file_name='';
        $storage=User::getUserSettings($lawyer_id);
        /* Start  Condition for Storage capacity  */
        $comp=$storage->storage;
        $curr_storage=$storage->current_storage;
        $cond=bccomp($comp,$curr_storage,'2');
        if($cond < 1)
        {
            return Redirect::back()->with('error','Your Disk Space Full to upgrade Please contact administrator');
        }
        /* End  Condition for Storage capacity  */
        /*      if file Exists          */
        if($file['error']!=4)
        {
            $file_type=$file['type'];
            $file_size=$file['size'];
            $f_name=  str_replace(" ",'', $file['name']);
            $file_name.='_'.date('dmHis').$f_name;
            $file_path=$file['tmp_name'];

            $current_storage=$storage->current_storage;
            $append=bcdiv($file_size,'1000000',2);
            $total=bcadd($current_storage,$append,2);
            $daTa=array('current_storage'=>$total);
            $one=User::updateLawyerPermission($daTa,$lawyer_id);
            $upload=move_uploaded_file($file_path,path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name);

        }
        if(isset($associate_id))
        {
            $associate_ids=Crypter::decrypt($associate_id);
            $update_by=$associate_ids;
        }
        else
        {
            $update_by=$lawyer_id;
        }

        $val= Config::get('application.url').Config::get('admin::admin_config.image_path').'documents/'.$file_name;
//        Session::put('cretital',$val);
//echo file_get_contents($val);
//        require_once path('public').'framework/google_api/functions/GDrive.php';
//        $upld=new GDrive();
        $datas=file_get_contents($val);
//        $cretital=$upld->createFile($file_name,'0AEsiARfIiItqUk9PVA',$datas);
//        Session::put('cretital');
//      exit;
//        return Redirect::to_route('Gapi');
//        $obj=new GDrive_1();
//        $drive_upload=$obj->createFile($file_name,$file_type,$datas);
        $curl->setHeader('Content-Type',$file_type);
        $curl->put('https://api-content.dropbox.com/1/files_put/auto/'.$file_name,$datas);
        $drive_upload=(json_decode($curl->response));
        if($drive_upload){$upload_fileID=$drive_upload->rev;}
        else { $upload_fileID=''; }
        $data=array(
            'lawyer_id'=>$lawyer_id,
            'doc_case_no'=>$case_link,
            'doc_name'=>$doc_name,
            'doc_file_name'=>$file_name,
            'doc_description'=>$doc_description,
            'updated_by'=>$update_by,
            'gdrive_fileID'=>$upload_fileID,
            'file_size'=>$file_size

        );
        $res=Document::addDocument($data);
        if($res)
        {
            $hearing=Hearing::getHearingByCaseID($case_link);
            if($hearing!=NULL)
            {
                if($user=='lawyer')
                {
                    return View::make('admin::lawyer/hearing.add_append_hearing')
                        ->with('hearing',$hearing)
                        ->with('case_id',$case_link);
                }
                elseif($user=='associate')
                {
                    return View::make('admin::associate/hearing.add_append_hearing')
                        ->with('hearing',$hearing)
                        ->with('case_id',$case_link);
                }

            }
            else
            {
                return Redirect::to_route('Hearing')
                    ->with('hearings','YES')
                    ->with('case_id',$case_link);

            }
//            return Redirect::back()->with('status','Document as been uploaded');
        }
        else return Redirect::back()->with('status','Document uploaded failed');
    }
    public function post_AddEditHearingDocument()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $hearing_id=Crypter::encrypt(Input::get('hearing_id'));
        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
        $case_link=Input::get('case_link');
        $doc_name=Input::get('doc_name');
        $doc_description=Input::get('doc_description');
        $associate_id=Input::get('associate_id');
        $file=Input::file('doc_file');
        $file_name='';

        $storage=User::getUserSettings($lawyer_id);
        /* Start  Condition for Storage capacity  */
        $comp=$storage->storage;
        $curr_storage=$storage->current_storage;
        $cond=bccomp($comp,$curr_storage,'2');
        if($cond < 1)
        {
            return Redirect::back()->with('error','Your Disk Space Full to upgrade Please contact administrator');
        }
        /* End  Condition for Storage capacity  */
        /*      if file Exists          */
        if($file['error']!=4)
        {
            $file_type=$file['type'];
            $file_size=$file['size'];
            $f_name=  str_replace(" ",'', $file['name']);
            $file_name.='_'.date('dmHis').$f_name;
            $file_path=$file['tmp_name'];
            $current_storage=$storage->current_storage;
            $append=bcdiv($file_size,'1000000',2);
            $total=bcadd($current_storage,$append,2);
            $daTa=array('current_storage'=>$total);
            $one=User::updateLawyerPermission($daTa,$lawyer_id);
            $upload=move_uploaded_file($file_path,path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name);

        }
        if(isset($associate_id))
        {
            $associate_ids=Crypter::decrypt($associate_id);
            $update_by=$associate_ids;
        }
        else
        {
            $update_by=$lawyer_id;
        }

        $val= Config::get('application.url').Config::get('admin::admin_config.image_path').'documents/'.$file_name;
//        Session::put('cretital',$val);
//echo file_get_contents($val);
//        require_once path('public').'framework/google_api/functions/GDrive.php';
//        $upld=new GDrive();
        $datas=file_get_contents($val);
//        $cretital=$upld->createFile($file_name,'0AEsiARfIiItqUk9PVA',$datas);
//        Session::put('cretital');
//      exit;
//        return Redirect::to_route('Gapi');
//        $obj=new GDrive_1();
//        $drive_upload=$obj->createFile($file_name,$file_type,$datas);
        $curl->setHeader('Content-Type',$file_type);
        $curl->put('https://api-content.dropbox.com/1/files_put/auto/'.$file_name,$datas);
        $drive_upload=(json_decode($curl->response));
        if($drive_upload){$upload_fileID=$drive_upload->rev;}
        else { $upload_fileID=''; }
        $data=array(
            'lawyer_id'=>$lawyer_id,
            'doc_case_no'=>$case_link,
            'doc_name'=>$doc_name,
            'doc_file_name'=>$file_name,
            'doc_description'=>$doc_description,
            'updated_by'=>$update_by,
            'gdrive_fileID'=>$upload_fileID,
            'file_size'=>$file_size

        );
        $res=Document::addDocument($data);
        if($res)
        {
//            $hearing=Hearing::getHearingByCaseID($case_link);

                return Redirect::to('admin/hearing/edit-hearing/'.$hearing_id);

//            return Redirect::back()->with('status','Document as been uploaded');
        }
        else return Redirect::back()->with('status','Document uploaded failed');
    }

    public function post_UpdateDocuments()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $curL=new Curl();
        $curL->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curL->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curL->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');

        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
        $doc_id=Crypter::decrypt(Input::get('doc_id'));
//        $case_link=Input::get('case_link');
        $doc_name=Input::get('doc_name');
        $doc_description=Input::get('doc_description');
        $file=Input::file('doc_file');
        $storage=User::getUserSettings($lawyer_id);
        /* Start  Condition for Storage capacity  */
        $comp=$storage->storage;
        $curr_storage=$storage->current_storage;
        $cond=bccomp($comp,$curr_storage,'2');
        if($cond < 1)
        {
            return Redirect::back()->with('error','Your Disk Space Full to upgrade Please contact administrator');
        }
        /* End  Condition for Storage capacity  */
        if($file['error']==4)
        {
            $docs=(array)Session::get('document');
            if(isset($docs)){
                $file_name=$docs['doc_file_name'];
                $gdrive_fileID=$docs['gdrive_fileid'];
            }
        }
        else
        {
           
            $file_path=$file['tmp_name'];
            $file_type=$file['type'];
            $file_size=$file['size'];
            $f_name=  str_replace(" ",'', $file['name']);
            $file_name='_'.date('dmHis').$f_name;
            $current_storage=$storage->current_storage;
            $append=bcdiv($file_size,'1000000',2);
            $total=bcadd($current_storage,$append,2);
            $daTa=array('current_storage'=>$total);
            $one=User::updateLawyerPermission($daTa,$lawyer_id);
            $upload=move_uploaded_file($file_path,path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name);
            $val= Config::get('application.url').Config::get('admin::admin_config.image_path').'documents/'.$file_name;
             $datas=file_get_contents($val);
             $curl->setHeader('Content-Type',$file_type);
             $curl->put('https://api-content.dropbox.com/1/files_put/auto/'.$file_name,$datas);
             $drive_upload=(json_decode($curl->response));
//            print_r($drive_upload);exit;
             $gdrive_fileID=$drive_upload->rev;

            if($upload)
            {
                $docs=(array)Session::get('document');
                $fileSize=$docs['file_size'];
                $current_storage=$storage->current_storage;
                $append=bcdiv($fileSize,'1000000',2);
                $total=bcsub($current_storage,$append,2);
                $daTa=array('current_storage'=>$total);
                $one=User::updateLawyerPermission($daTa,$docs['lawyer_id']);
            
                $trash=File::delete(path('public').Config::get('admin::admin_config.image_path').'documents/'.$docs['doc_file_name']);

            
                if($trash)
                {
                    $curL->POST('https://api.dropbox.com/1/fileops/delete?root=auto&path=/'.$docs['doc_file_name']);

                 
                }
            }
        }
        $data=array(

            'doc_name'=>$doc_name,
            'doc_file_name'=>$file_name,
            'doc_description'=>$doc_description,
            'gdrive_fileid'=>$gdrive_fileID

            );
        $update=array_diff_assoc($data,$docs);
        if($update==NULL)
        {
            return Redirect::to_route('ViewDocuments')->with('status','your not upload anything');
        }
        else
        {
            $res=Document::updateDocumentByID($update,$doc_id);
            if($res) return Redirect::to_route('ViewDocuments')->with('status','Updated successfully');
            else return Redirect::to_route('ViewDocuments')->with('status','Updated failed');
        }
    }
    public function get_EditDocuments($id)
    {
        $id1=$id;
        $user=$this->get_var();
        $verify=Document::IsAvailable('doc_id',$id1);
        if($verify > 0)
        {
            if($user=='lawyer')
            {
            return View::make('admin::lawyer/documents.edit_document')
                ->with('document',Document::getDocumentByID($id1));
            }
            elseif($user=='associate')
            {
                return View::make('admin::associate/documents.edit_document')
                    ->with('document',Document::getDocumentByID($id1));
            }
        }

    }
    public function get_DeleteDocuments($id)
    { $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
//        $curl->setHeader('Content-Type','application/pdf');
        $id1=$id;
        $verify=Document::IsAvailable('doc_id',$id1);
        if($verify > 0)
        {

                $file_name=(array)Document::getDocumentByID($id1);
                $res=Document::deleteDocumentByID($id1);
                if($res)
                {
                    $fileSize=$file_name['file_size'];
                    $storage=User::getUserSettings($file_name['lawyer_id']);
                    $current_storage=$storage->current_storage;
                    $append=bcdiv($fileSize,'1000000',2);
                    $total=bcsub($current_storage,$append,2);
                    $daTa=array('current_storage'=>$total);
                    $one=User::updateLawyerPermission($daTa,$file_name['lawyer_id']);
                    $val=File::delete(path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name['doc_file_name']);
                    if($val)
                    {
                        $curl->post('https://api.dropbox.com/1/fileops/delete?root=auto&path=/'.$file_name['doc_file_name']);
                    }
                    return Redirect::back()->with('status','Successfully deleted');
                }
                else
                {
                    return Redirect::back()->with('status','Document failed to delete');
                }
        }
    }

    public function post_MultiDocumentDelete()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $values=Input::all();
        if(isset($values['document_delete']))
        {
            $ids=$values['document_delete'];
            foreach($ids as $id)
            {
                $file_name=(array)Document::getDocumentByID($id);
                $res=Document::deleteDocumentByID($id);
                if($res)
                {
                    $fileSize=$file_name['file_size'];
                    $storage=User::getUserSettings($file_name['lawyer_id']);
                    $current_storage=$storage->current_storage;
                    $append=bcdiv($fileSize,'1000000',2);
                    $total=bcsub($current_storage,$append,2);
                    $daTa=array('current_storage'=>$total);
                    $one=User::updateLawyerPermission($daTa,$file_name['lawyer_id']);
                    $val=File::delete(path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name['doc_file_name']);
                    $curl->post('https://api.dropbox.com/1/fileops/delete?root=auto&path=/'.$file_name['doc_file_name']);
                }
            }
                return ($val) ? Redirect::back()->with('status','Deleted Successfully') : Redirect::back()->with('error','Failed to delete');
        }
        return Redirect::back();


    }

    public function get_DocumentDownload($name)
    {
        $names=Crypter::decrypt($name);
       
//         Response::download(path('public').Config::get('admin::admin_config.image_path').'documents/'.$names);
            $file=path('public').Config::get('admin::admin_config.image_path').'documents/'.$names;
            return (file_exists($file)) ? Response::download($file) : Redirect::back();
            
       
    }

    public function get_ListDocuments()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $curl->post('https://api.dropbox.com/1/delta');
        $list=json_decode($curl->response)->entries;
       
        $user=$this->get_var();
        if($user=='admin')
        {
            return View::make('admin::admin/documents.list_documents')
                ->with('document',Document::getDocuments(false))
                ->with('list',$list);


        }
    }

    public function post_AddHearingDocuments()
    {
        $curl=new Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE);
        $curl->setHeader('Authorization','Bearer WpEn9AfTzakAAAAAAAAAAfhL2tRa14NHQmmCZFgdA7MnPhHCV7jyUMGjusnsZc80');
        $lawyer_id=Crypter::decrypt(Input::get('lawyer_id'));
        $case_link=Input::get('case_link');
        $doc_name=Input::get('doc_name');
        $doc_description=Input::get('doc_description');
        $associate_id=Input::get('associate_id');
        $file=Input::file('doc_file');
        $storage=User::getUserSettings($lawyer_id);
        /* Start  Condition for Storage capacity  */
        $comp=$storage->storage;
        $curr_storage=$storage->current_storage;
        $cond=bccomp($comp,$curr_storage,'2');
        if($cond < 1)
        {
            return Redirect::back()->with('error','Your Disk Space Full to upgrade Please contact administrator');
        }
        /* End  Condition for Storage capacity  */
        $file_name='';
        /*      if file Exists          */
        if($file['error']!=4)
        {
            $file_type=$file['type'];
            $file_size=$file['size'];
            $f_name=  str_replace(" ",'', $file['name']);
            $file_name.='_'.date('dmHis').$f_name;
            $file_path=$file['tmp_name'];

            $current_storage=$storage->current_storage;
            $append=bcdiv($file_size,'1000000',2);
            $total=bcadd($current_storage,$append,2);
            $daTa=array('current_storage'=>$total);
            $one=User::updateLawyerPermission($daTa,$lawyer_id);
            $upload=move_uploaded_file($file_path,path('public').Config::get('admin::admin_config.image_path').'documents/'.$file_name);

        }
        if(isset($associate_id))
        {
            $associate_ids=Crypter::decrypt($associate_id);
            $update_by=$associate_ids;
        }
        else
        {
            $update_by=$lawyer_id;
        }
        $val= Config::get('application.url').Config::get('admin::admin_config.image_path').'documents/'.$file_name;
        $datas=file_get_contents($val);
        $curl->setHeader('Content-Type',$file_type);
        $curl->put('https://api-content.dropbox.com/1/files_put/auto/'.$file_name,$datas);
        $drive_upload=(json_decode($curl->response));

        if($drive_upload){$upload_fileID=$drive_upload->rev;}
        else { $upload_fileID=''; }
        $data=array(
            'lawyer_id'=>$lawyer_id,
            'doc_case_no'=>$case_link,
            'doc_name'=>$doc_name,
            'doc_file_name'=>$file_name,
            'doc_description'=>$doc_description,
            'updated_by'=>$update_by,
            'gdrive_fileID'=>$upload_fileID,
            'file_size'=>$file_size

        );
        $res=Document::addDocument($data);
        if($res) echo $res;

    }

}