<?php


class Admin_User_Controller extends Admin_Base_Controller {
    public $restful=true;

    private function get_var()
    {
        if(Auth::check()){ $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name;
        return $role;
        }
    }
        public function get_Index()
    {
        $user=$this->get_var();
        $id=Auth::user()->id;
        $status=  liblawyer::getstatusByID($id);
        $limit=  liblawyer::getlawyercount($id);
        $limit1=count($limit);
//        echo $status->no_associate;exit;
        if($user=='lawyer')
        {
            if($limit1 <= $status->no_associate){
            return View::make('admin::lawyer/user.add_user');
            }
            else
            {
                return Redirect::to_route('Home')->with('status',"Users exceeds limit");
            }
        }
        if($user=='admin')
        {
            return View::make('admin::admin/user.add_user');
        }
    }

    /**
     * @return mixed
     *
     * Data send to user table
     */
    public function post_AddUser()
    {
        $user=$this->get_var();
        $date = date("Y-m-d");
        $date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
        $exp_date=date('Y-m-d',$date);
        if(Auth::guest())
        {
            $values=Input::all();
            Input::flash();
            $input=array('email'=>$values['user_email'],'username'=>$values['username']);
            $rule=array('email'=>'required|email|unique:users,user_email','username'=>'required|unique:users,username');
            $validation=Validator::make($input,$rule);
            if($validation->fails())
            {
                return Redirect::back()->with('error',$validation->errors->first());
            }
            $data=array(
                'first_name'=>$values['first_name'],
                'last_name'=>$values['last_name'],
                'user_email'=>$values['user_email'],
                'username'=>$values['username'],
                'password'=>Hash::make($values['password']),
                'lawyer_subject'=>$values['lawyer_subject'],
                'mobile'=>$values['mobile'],
                'phone'=>$values['phone'],
                'address'=>$values['address'],
                'city'=>$values['city'],
                'exp_date'=>$exp_date,
                'payment'=>'trail',
                'updated_by'=>Crypter::decrypt($values['user_id'])
            ) ;
            $res=User::addUser($data);
            $case_statics=array('uid'=>$res);//to add user_id to case_static table
            Cases::addCaseStatics($case_statics);
            User::insertuserIDtoSettings(array('ui'=>$res,'no_associate'=>'1','storage'=>'20'));
            if($res)
            {

                $body=View::make('template.email_new_user')
                    ->with('name',$values['first_name'])
                    ->with('username',$values['username'])
                    ->with('email',$values['user_email']);
                $email= new PHPMailer();
                $email->isSendmail();
                $email->setFrom('admin@lawyerzz.in','Lawyerzz');
                $email->addReplyTo('admin@lawyerzz.in','Lawyerzz');
                $email->addAddress($values['user_email'],$values['first_name']);
                $email->addAddress('sirigroupindia@gmail.com','Lawyerzz');
                $email->Subject = 'Trial User';
                $email->Body=$body;
                $email->send();
                $update=array('uid1'=>$res,'uid2'=>Crypter::decrypt($values['user_id']));
                User::addLawyers_id($update);//to update lawyers_id table
                return Redirect::to('/')->with('status',"<i class='icon-ok'></i> Your account as been created successfully please contact admin to activate your account<b> (9845554820)</b>");
            }
            else
            {
                return Redirect::back()->with('status','Problem to new register');
            }
        }

        $values=Input::all();
         Input::flash();
        $input=array('email'=>$values['user_email'],'username'=>$values['username']);
        $rule=array('email'=>'required|email|unique:users,user_email','username'=>'required|unique:users,username');
        $validation=Validator::make($input,$rule);
            if($validation->fails())
            {
                return Redirect::back()->with('error',$validation->errors->first());
            }
            if(isset($values['exp_date']))
            {
                if($values['exp_date'])
                {
                    $exp_date = DateTime::createFromFormat('d/m/Y', $values['exp_date']);
                    $exp_date=$exp_date->format('Y-m-d');
                }
                else{
                    $date = date("Y-m-d");
                    $date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
                    $exp_date=date('Y-m-d',$date);
                }
            }
            else{
                $date = date("Y-m-d");
                $date = strtotime(date("Y-m-d", strtotime($date)) . " +12 month");
                $exp_date=date('Y-m-d',$date);
            }

           $data=array(
              'first_name'=>$values['first_name'],
               'last_name'=>$values['last_name'],
               'username'=>$values['username'],
               'user_email'=>$values['user_email'],
               'password'=>Hash::make($values['password']),
               'lawyer_id'=>$values['lawyer_id'],
               'lawyer_subject'=>$values['lawyer_subject'],
               'mobile'=>$values['mobile'],
               'phone'=>$values['phone'],
               'address'=>$values['address'],
               'city'=>$values['city'],
               'exp_date'=>$exp_date,
               'pincode'=>$values['pincode'],
               'payment'=>'unpaid',
               'updated_by'=>Crypter::decrypt($values['user_id'])
                 ) ;
           
            $res=User::addUser($data);
            $case_statics=array('uid'=>$res);//to add user_id to case_static table
            Cases::addCaseStatics($case_statics);
            User::insertuserIDtoSettings(array('ui'=>$res,'no_associate'=>'1','storage'=>'20'));
            if($res)
            {
                $body=View::make('template.email_new_user')
                ->with('name',$values['first_name'])
                ->with('username',$values['username'])
                ->with('email',$values['user_email']);
                $email= new PHPMailer();
                $email->isSendmail();
                $email->setFrom('admin@lawyerzz.in','Lawyerzz');
                $email->addReplyTo('admin@lawyerzz.in','Lawyerzz');
                $email->addAddress($values['user_email'],$values['first_name']);
                $email->addAddress('sirigroupindia@gmail.com','SiriGroups');
                $email->Subject = 'New User';
                $email->Body=$body;
                $email->send();
                $update=array('uid1'=>$res,'uid2'=>Crypter::decrypt($values['user_id']));
                User::addLawyers_id($update);//to update lawyers_id table
                return Redirect::to_route('ViewUser')->with('status','Lawyer Added Successfully');
            }
            else
            {
                return Redirect::to_route('ViewUser')->with('status','Problem to Add Lawyers details');
            }
    }
    public function get_EditUser($id1)
    {
        $id=$id1;
        $verify=User::IsAvailable('id',$id);
        if($verify > 0)
        {
            $user=$this->get_var();
            if($user=='lawyer')
            {
            return View::make('admin::lawyer/user.edit_user')
                ->with('user',User::getUserDetailsByID($id));
            }
            if($user=='admin')
            {
                return View::make('admin::admin/user.edit_user')
                    ->with('user',User::getUserDetailsByID($id));
            }
        }
    }

    public function post_UpdateUser()
    {
        $user_detail=(array)Session::get('User_detail');
        $values=Input::all();
        $id=Crypter::decrypt($values['id']);
        if(isset($values['exp_date']))
        {
            $exp_date = DateTime::createFromFormat('d/m/Y', $values['exp_date']);
            $exp_date=$exp_date->format('Y-m-d');
            $data=array(
                'updated_by'=>Crypter::decrypt($values['user_id']),
                'first_name'=>$values['first_name'],
                'last_name'=>$values['last_name'],
                'user_email'=>$values['user_email'],
                'exp_date'=>$exp_date,
                'lawyer_subject'=>$values['lawyer_subject'],
                'lawyer_id'=>$values['lawyer_id'],
                'mobile'=>$values['mobile'],
                'phone'=>$values['phone'],
                'address'=>$values['address'],
                'city'=>$values['city'],
                'pincode'=>$values['pincode']
            );
        }
        else{
            $data=array(
                'updated_by'=>Crypter::decrypt($values['user_id']),
                'first_name'=>$values['first_name'],
                'last_name'=>$values['last_name'],
                'user_email'=>$values['user_email'],
                'lawyer_subject'=>$values['lawyer_subject'],
                'lawyer_id'=>$values['lawyer_id'],
                'mobile'=>$values['mobile'],
                'phone'=>$values['phone'],
                'address'=>$values['address'],
                'city'=>$values['city'],
                'pincode'=>$values['pincode']
            );
        }
        $update=array_diff_assoc($data,$user_detail);

        if($update!=null)
        {
            $res=User::updatelawyerById($data,$id);
            if($res)
            {
                return Redirect::to_route('ViewUser')
                    ->with('status','Successfully Updated');
            }
        }
        else
        {
                return Redirect::to_route('ViewUser')
                    ->with('status','Your not change anything');
        }


    }

    public function post_ProfileUpdate()
    {
        $uid=Auth::user()->id;
        $values=Input::all();
        $profile=liblawyer::lawyerprofile();
        $update=array_diff_assoc($values,(array)$profile);
        if($update!=null)
        {
            $res=User::updatelawyerById($update,$uid);
            if($res)
            {
                return Redirect::back();
            }
        }
        return Redirect::back();
    }

    public function post_ChangePassword()
    {
        if (Hash::check(Input::get('current_password'), Auth::user()->password))
        {
            if(Input::get('new_password') == Input::get('confirm_password') )
            {
                $uid=Auth::user()->id;
                $data=array('password'=>Hash::make(Input::get('new_password')));
                $res=User::updatelawyerById($data,$uid);
                if($res) return Redirect::back()->with('status',"Password successfully updated");
                else return Redirect::back()->with('error',"Password Failed to change");
            }
            else
            {
                return Redirect::back()->with('error',"Password mismatch Try Again");
            }
        }
        else{
            return Redirect::back()->with('error',"Please enter correct current password");
        }
    }
    public function get_ViewUser()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
        return View::make('admin::lawyer/user.view_user')
            ->with('user',User::usersByUpdatedIDPaginate(Auth::user()->id))
            ->with('user_filter',User::usersByUpdatedID(Auth::user()->id));
        }
        if($user=='admin')
        {
            return View::make('admin::admin/user.view_user')
                ->with('user',User::usersByUpdatedIDPaginate(Auth::user()->id))
                ->with('user_filter',User::usersByUpdatedID(Auth::user()->id));
        }


//    $res=User::viewUser(false,'');
//
//        print_r($res);
    }

    public function get_ActivateUser($id1)
    {
        $id2=explode(',',$id1);
        $id=$id2[0];
        $role=$id2[1];
            $update=array(
            'user_role'=>$role
        );

        if($update!=NULL)
        {
            $res=User::updatelawyerById($update,$id);
            if($res) return Redirect::back()->with('status','Activated Successfully');
            else return Redirect::back()->with('status','No changes done!');
        }
        else
        {
            $res=User::updatelawyerById($update,$id);
            if($res) return Redirect::back()->with('status','Deactivated successfully');
            else return Redirect::back()->with('status','No changes done!');
        }

    }
    public function get_DeleteUser($id1)
    {
        $id=$id1;

         $res=User::deleteUserByID($id);
        if($res)
        {
            return Redirect::to_route('ViewUser')
                ->with('status',' Deleted Successfully');
        }
        else
        {
            return Redirect::to_route('ViewUser')
                ->with('status','Failed to Delete');
        }
    }

    public function post_Action()
    {
        $options=Input::get('check');
        $action=Input::get('action');
        if($options==NULL)
        {
            return Redirect::to_route('ViewUser')
                ->with('status','Your Not Select any User');
        }

        if($action=='delete')
        {
          for($i=0;$i<count($options);$i++)
          {
              $res=User::deleteUserByID($options[$i]);
          }
          return Redirect::to_route('ViewUser')
              ->with('status','Deleted');
        }
        if($action=='activate')
        {

            for($i=0;$i<count($options);$i++)
            {
                $status=User::viewUserByID($options[$i]);
                $state=$status->status;
                if($state!='activate' || $state==NULL)
                {
                    $data=array('status'=>'activate');
                    $res=User::updateUserByID($data,$options[$i]);
                }

            }
            return Redirect::to_route('ViewUser')
                ->with('status','Activated');
        }
        if($action=='deactivate')
        {
            for($i=0;$i<count($options);$i++)
            {
                $status=User::viewUserByID($options[$i]);
                $state=$status->status;
                if($state!='deactivate' || $state==NULL)
                {
                    $data=array('status'=>'deactivate');
                    $res=User::updateUserByID($data,$options[$i]);
                }

            }
            return Redirect::to_route('ViewUser')
                ->with('status','Deactivated');
        }



    }
    public function post_File()
    {

        $file=Input::file('user');
        $path=$file['tmp_name'];
        if($path!=NULL)
        {

            $handle=fopen($path,'r');

            while (($cols = fgetcsv($handle, 1000, "\t")) !== FALSE) {
                foreach( $cols as $key => $val  ) {
                    $cols[$key] = trim( $cols[$key] );
                    foreach($cols as $v)
                        $user=explode(",",$v);
                    $data=array(
                        'user_fname'=>$user[0],
                        'user_lname'=>$user[1],
                        'user_email'=>$user[2],
                        'user_password'=>Hash::make(Str::random(8))
                    );
                    $res=User::addUser($data);
                }

            }
            return Redirect::to_route('User')
                ->with('status','File Users are Uploaded Successfully');

         }
        else
        {
            return Redirect::to_route('User')
                ->with('status','your Not Select Any file');
        }
    }
    public function get_Role()
    {
        $user=$this->get_var();
        if($user=='lawyer')
        {
        return View::make('admin::lawyer/user.add_roles')
            ->with('user',User::viewUser())
            ->with('role_id',User::viewRole());
        }
        if($user=='admin')
        {
            return View::make('admin::admin/user.add_roles')
                ->with('user',User::viewUser())
                ->with('role_id',User::viewRole());
        }

    }
    public function post_AddRole()
    {
        $role=Input::get('role');
        $data=array('role_name'=>$role);
        if($role!=NULL)
        {
            $res=User::addRole($data);
            if($res)
            {
                return Redirect::to_route('Role')
                    ->with('status',$role." is Added Successfully");
            }
            else
            {
                return Redirect::to_route('Role')
                    ->with('status',$role." is Failed to Add");
            }
        }
        else
        {
            return Redirect::to_route('Role')
                ->with('status',"Your Not Add Any Data");
        }
    }
    public function post_AssignRoleToUser()
    {
        $user_id=Input::get('user_id');
        $role_id=Input::get('role_id');
        $option=array();
        foreach($role_id as $role)
        {
            array_push($option,$role);
        }
      $value=json_encode($option);
        $data=array(
            'roles'=>$value
        );
        $res=User::updateUserByID($data,$user_id);
        if($res)
        {
            return Redirect::to_route('ViewUser')
                ->with('status',"Role Assigned  Successfully");
        }
        else
        {
            return Redirect::to_route('ViewUser')
                ->with('status',"Failed to Assign role");
        }
    }

    public function get_UserSetting()
    {
        $user=$this->get_var();
       if($user=='admin')
        {
            return View::make('admin::admin/setting.profile');
        }
        if($user=='lawyer')
        {
            return View::make('admin::lawyer/setting.setting');
        }
        if($user=='associate')
        {
            return View::make('admin::associate/setting.setting');
        }
    }

    public function post_UploadImage()
    {
        $value=Input::all();
        $key=array_keys($value);
        $key=$key['0'];
        $value=$value[$key];

        $name='_'.date('dmHis').str_replace(' ','_',$value['name']);
        $temp=$value['tmp_name'];
        $upload=move_uploaded_file($temp,path('public').Config::get('admin::admin_config.image_path').'images/'.$name);
        if($upload)
        {
            $file=User::getimageByID();
            if($file)
            {
                $trash=File::delete(path('public').Config::get('admin::admin_config.image_path').'images/'.$file->$key);
                $data=array($key=>$name);
                $res=User::uploadImage($data);
            }
            else
            {
               $data=array($key=>$name,'ui'=>Auth::user()->id);
               $res=User::newUserUploadImage($data);
            }
            return Redirect::back();
        }
    }

    public function get_UserDetail($ids)
    {
        $id=$ids;
        $user=$this->get_var();
        $verify=User::IsAvailable('id',$id);
        if($verify > 0){
            if($user=='lawyer')
            {
                return View::make('admin::lawyer/user.user_detail')
                    ->with('user',User::getUserByID($id));
            }
            elseif($user=='admin')
            {
                return View::make('admin::admin/user.user_detail')
                    ->with('user',User::getUserByID($id));
            }
    }

    }
    public function get_FileHandle($ids)
    {
        $id=$ids;
        $verify=User::IsAvailable('id',$id);
        if($verify > 0) {
            $user=$this->get_var();
            if($user=='admin')
            {
                return View::make('admin::admin/setting.setting')
                    ->with('user',User::getUserByID($id));
            }
        }
    }
    public function get_AutoUpload($ids)
    {
        $parameter=explode(',',$ids);
        $id=Crypter::decrypt($parameter[0]);
        $value=$parameter[1];
        $compare=$value[0];
        if($compare == '@')
        {
            $value1=ltrim($value,'@');
            $data=Crypter::decrypt($value1);
            $res=User::addDocumentAutoUpload(array('billing_permission'=>$data),$id);
        }
        elseif($compare == '*')
        {
            $value1=ltrim($value,'*');
            $data=Crypter::decrypt($value1);
            $res=User::addBackupAutoUpload(array('backup_auto_upload'=>$data),$id);
        }
         elseif($compare == ':')
        {
            $value1=ltrim($value,':');
            $data=Crypter::decrypt($value1);
            $res=User::addBackupAutoUpload(array('associate_permission'=>$data),$id);
        }
          elseif($compare == '$')
        {
            $value1=ltrim($value,'$');
            $data=Crypter::decrypt($value1);
            $res=User::addBackupAutoUpload(array('appointment_permission'=>$data),$id);
        }
         elseif($compare == '=')
        {

            $value1=ltrim($value,'=');
            $data=Crypter::decrypt($value1);
            $res=User::addBackupAutoUpload(array('sms_permission'=>$data),$id);
        }

            return Redirect::back()->with('status','Updated Successfully');

    }
    public function get_UserCasePermission($ids)
    {
        $user=$this->get_var();
        $id= $ids;
         if($user=='lawyer')
        {
             return View::make('admin::lawyer/user.permission')
                      ->with('cases',Cases::getCasesDetails())
                      ->with('id',$id);
        }
    }
    public function post_UpdateCasePermission()
    {
         $user=$this->get_var();
         if($user=='lawyer')
        {
           $values=Input::all();

            if(isset($values['permission']))
            {
                if(isset($values['case_id']))
                {
                    $res=User::updateUserCasePermission($values['case_id'],$values['permission'],$values['ass_id']);
                    return Redirect::back()->with('status',"successfully Assigned");
                }
                else
                {
                    return Redirect::back()->with('error','Please select altleast Case No.');
                }

            }
            else
            {
                return Redirect::back()->with('error','Please select permission');
            }
        }


    }

    public function get_AssignUserPermission()
    {
        $user=$this->get_var();
        if($user=='admin')
        {
            return View::make('admin::admin/user.lawyer_permission')
                    ->with('user',User::getlawyerpermission());
        }
    }
    public function get_ActivateUserPermission($ids)
    {
        $ids1=explode(',',$ids);
       
        $user_id=Crypter::decrypt($ids1[0]);
        $module= substr($ids1[1],0,1);
        $permission_id=  substr($ids1[1], 1);
        
        $permission_id1=Crypter::decrypt($permission_id);
        if($permission_id1==0)
        {
            $permission='1';
        }
        else
        {
            $permission='0';
        }
        $user=$this->get_var();
        if($user=='admin')
        {
            switch ($module)
            {
                case '$': // message permission
                    $data=array('message_permission'=>$permission);
                    break;
                case '@': // contact permission
                    $data=array('contact_permission'=>$permission);
                    break;
                case '*': // calender permission
                    $data=array('calender_permission'=>$permission);
                    break;
                case ':': // document permission
                
                $data=array('document_permission'=>$permission);
                break;
                default :
                    return Redirect::back()->with('error','Problem to activate try again.');
                    break;
            }            
            $res=  User::updateLawyerPermission($data, $user_id);
            if($res) return Redirect::back()->with('status','Updated Successfully');
            else return Redirect::back()->with('error','Problem to update try again');
        }
    }
    public function post_NoOfAssociate()
    {
        $value=Input::get('no_ass');
        $uid=Crypter::decrypt(Input::get('uid'));
        $comp=Input::get('comp');
        if(isset($value))
        {
            if($value<=$comp)
            {
                return Redirect::back()->with('error',"Must enter greater than $comp");
            }
            $data=array('no_associate'=>$value);
            $res=User::updateLawyerPermission($data, $uid);
        }
        return ($res) ? Redirect::back()->with('status','Added Successfully') : Redirect::back()->with('error','Failed to add try again');
    }
    public function post_NoOfSms()
    {
        $value=Input::get('no_sms');
        $uid=Crypter::decrypt(Input::get('uid'));
        $comp=Input::get('comp');
        if(isset($value))
        {
            if($value<=$comp)
            {
                return Redirect::back()->with('error',"Must enter greater than $comp");
            }
            $data=array('no_sms'=>$value);
            $res=User::updateLawyerPermission($data, $uid);
        }
        return ($res) ? Redirect::back()->with('status','Added Successfully') : Redirect::back()->with('error','Failed to add try again');
    }

    public function get_SearchLawyerView()
    {
        $value=Input::all();
        $search=User::getUsersByID($value['id'],$value['user_email']);
        $user=$this->get_var();
        if($user=='lawyer')
        {

            return View::make('admin::lawyer/user.view_user')
                ->with('user',$search)
                ->with('user_filter',User::usersByUpdatedID(Auth::user()->id));

        }
        if($user=='admin')
        {
            return View::make('admin::admin/user.view_user')
                ->with('user',$search)
                ->with('user_filter',User::usersByUpdatedID(Auth::user()->id));


        }
    }

    public function get_UserCasePermissionSearch()
    {
        $val=$_GET['id'];
        $case_id=$_GET['case_id'];

        if(isset($case_id))
        {
            if($case_id=='')
            {
                $case=libcase::getCaseByLawyerID(Auth::user()->id);
                return View::make('admin::lawyer/user.search_permission')
                    ->with('case',$case)
                    ->with('id',$val);
            }
            else{
                $case=User::getCasesByCaseID($case_id);
                return View::make('admin::lawyer/user.search_permission')
                    ->with('case',$case)
                    ->with('id',$val);
            }
        }
    }

    public function post_UpdateUserStatus()
    {
        $val=Input::all();
        $date=implode('-',array_reverse(explode('/',$val['year'])));
        $data=array('payment'=>'paid','exp_date'=>$date);
        $res=User::updatelawyerById($data,$val['id']);
        return ($res)? Redirect::back()->with('status','successfully updated'): Redirect::back()->with('error','Failed to update');
    }

    public function post_UpdateStorage()
    {
        $value=Input::get('storage');
        $uid=Crypter::decrypt(Input::get('uid'));
        $comp=Input::get('comp');
        if(isset($value))
        {
//            if($value<=$comp)
//            {
//                return Redirect::back()->with('error',"Must enter greater than $comp");
//            }
            $data=array('storage'=>$value);
            $res=User::updateLawyerPermission($data, $uid);
        }
        return ($res) ? Redirect::back()->with('status','Added Successfully') : Redirect::back()->with('error','Failed to add try again');
    }

    public function get_AdminResetPassword($id)
    {

        $ids=$id;
        $values=explode(',',$ids);
        $uid=$values[0];
        $user_email=$values[1];
        $name=$values[2];
        $resetPassword=Str::random(5, 'alpha');
        $data=array("password"=>Hash::make($resetPassword));
        $res=User::updatelawyerById($data,$uid);

        if($res)
        {
            $body="
            <table class='table table-bordered table-responsive' >
            <tr>
            <td style='background-color: lightskyblue'>First Name</td>
            <td>$name</td>
            </tr>
            <tr>
            <td style='background-color: lightskyblue'>Email</td>
            <td>$user_email</td>
            </tr>
            <tr>
            <td style='background-color: lightskyblue'>New Password</td>
            <td>$resetPassword</td>
            </tr>
            </table>
            ";
            $mail= new PHPMailer();
            $mail->isSendmail();
            $mail->setFrom('admin@lawyerzz.in','Lawyerzz');
            $mail->addReplyTo('admin@lawyerzz.in','Lawyerzz');
            $mail->addAddress($user_email,$name);
            $mail->addAddress('sirigroupindia@gmail.com','SiriGroups');
            $mail->Subject = 'Password Reset';
            $mail->Body=$body;
            

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
            else {
                echo "Message sent!";
                
            }
            
            return Redirect::back()->with('status',"Password reset successfully and sent to your E-mail address ");

        }

    }
    public function post_SendMail()
    {
        $value=Input::all();
        // $body= $value['da'][1];
        // echo $body;exit;
        // print_r($value);exit;
        $body = urldecode(html_entity_decode(urldecode($value['da'])));
        $mail= new PHPMailer();
        $mail->isSendmail();
        $mail->setFrom('admin@lawyerzz.in','Lawyerzz');
        $mail->addReplyTo('sirigroups@gmail.com','Lawyerzz');
        foreach ($value['email'] as $value) {
            $mail->AddBCC($value['value'],'Lawyerzz');
        }
        $mail->Subject='Lawyerzz';
        $mail->Body=$body;
        if($mail->send())
        {
            echo "Message has been sent!";
        }
        else
        {
            echo $mail->getMessages();
        }
    }
}
