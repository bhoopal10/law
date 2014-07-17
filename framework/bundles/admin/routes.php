<?php

Route::get('(:bundle)/backup-please/go',array('uses'=>'admin::backup@autoBackup'));
Route::get('(:bundle)',array('as'=>'Login','uses'=>'admin::login@Index'));
Route::get('(:bundle)/forget-password',array('as'=>'ForgetPassword','uses'=>'admin::login@ForgetPassword'));

Route::post('(:bundle)/reset-password',array('as'=>'ResetPassword','uses'=>'admin::login@ResetPassword'));

Route::post('(:bundle)',array('as'=>'Authentication','uses'=>'admin::login@AdminAuth'));
Route::post('(:bundle)/User/add',array('as'=>'AddUser','uses'=>'admin::user@AddUser'));

Route::get('(:bundle)/gapi',array('as'=>'Gapi','uses'=>'admin::gapi@Document'));

Route::get('(:bundle)/logout', array('as' => 'Logout', function () {

    Auth::logout();
    Session::forget('user');
    return Redirect::to('/');
}));

Route::group(array('before' => 'auth'),function()
{

Route::get('(:bundle)/home',array('as'=>'Home','uses'=>'admin::home@home'));



//Route::get('(:bundle)/database/backup/create-backup',array('as'=>'CreateBackup','uses'=>'admin::backup@CreateBackup'));







});
Route::get('(:bundle)/tasks',array('as'=>'Tasks','uses'=>'admin::task@Index'));
Route::get('(:bundle)/tasks/view-tasks',array('as'=>'ViewTasks','uses'=>'admin::task@ViewTasks'));
/*
 * All the routes for admin
 * */
Route::group(array('before' => 'admin-lawyer-auth'), function()
{
    Route::get('(:bundle)/User',array('as'=>'User','uses'=>'admin::user@Index'));

    Route::get('(:bundle)/User/view',array('as'=>'ViewUser','uses'=>'admin::user@ViewUser'));
    Route::get('(:bundle)/User/edit/(:all)',array('as'=>'EditUser','uses'=>'admin::user@EditUser'));
    Route::get('(:bundle)/User/activation/(:all)',array('as'=>'ActivateUser','uses'=>'admin::user@ActivateUser'));
    Route::post('(:bundle)/User/update-user',array('as'=>'UpdateUser','uses'=>'admin::user@UpdateUser'));
    Route::get('(:bundle)/User/delete/(:all)',array('as'=>'DeleteUser','uses'=>'admin::user@DeleteUser'));
    Route::post('(:bundle)/user/action',array('as'=>'Action','uses'=>'admin::user@Action'));
    Route::post('(:bundle)/user/add-file',array('as'=>'UserFile','uses'=>'admin::user@File'));
    Route::get('(:bundle)/user/role',array('as'=>'Role','uses'=>'admin::user@Role'));
    Route::post('(:bundle)/user/role/add',array('as'=>'AddRole','uses'=>'admin::user@AddRole'));
    Route::post('(:bundle)/user/role/Assign-role',array('as'=>'AssignRole','uses'=>'admin::user@AssignRoleToUser'));
    Route::get('(:bundle)/User/view/search-lawyer-view',array('as'=>'SearchLawyerView','uses'=>'admin::user@SearchLawyerView'));

    Route::post('(:bundle)/User/send-mail',array('as'=>'SendMail','uses'=>'admin::user@SendMail'));

   
    Route::get('(:bundle)/user/setting/user-file_handle/(:all)',array('as'=>'FileHandle','uses'=>'admin::user@FileHandle'));
    Route::get('(:bundle)/user/setting/auto-upload/(:all)',array('as'=>'AutoUpload','uses'=>'admin::user@AutoUpload'));

    Route::get('(:bundle)/user/user-detail/(:all)',array('as'=>'UserDetail','uses'=>'admin::user@UserDetail'));

    Route::get('(:bundle)/backup/(:any)',array('as'=>'CreateBackup','uses'=>'admin::backup@CreateBackup'));
    Route::get('(:bundle)/backup/download-backup/(:all)',array('as'=>'DownloadBackup','uses'=>'admin::backup@DownloadBackup'));
    Route::post('(:bundle)/backup/update-restore-file/(:all)',array('as'=>'UpdateRestoreFile','uses'=>'admin::backup@UpdateRestoreFile'));
    Route::post('(:bundle)/backup/restore-file/(:all)',array('as'=>'RestoreFile','uses'=>'admin::backup@RestoreFile'));
    Route::get('(:bundle)/backup/backup-please/go/(:num)',array('as'=>'LawyerBackup','uses'=>'admin::backup@LawyerBackup'));

    Route::get('(:bundle)/document/list-document',array('as'=>'ListDocuments','uses'=>'admin::document@ListDocuments'));


});
Route::group(array('before'=>'lawyer-associate-auth'),function(){

    Route::get('(:bundle)/message/inbox',array('as'=>'Inbox','uses'=>'admin::message@Inbox'));
    Route::get('(:bundle)/message/create-message',array('as'=>'CreateMessage','uses'=>'admin::message@CreateMessage'));
    Route::post('(:bundle)/message/send-message',array('as'=>'SendMessage','uses'=>'admin::message@SendMessage'));
    Route::get('(:bundle)/message/sentbox',array('as'=>'Sentbox','uses'=>'admin::message@Sentbox'));
    Route::get('(:bundle)/message/delete-message/(:all)',array('as'=>'DeleteMessage','uses'=>'admin::message@DeleteMessage'));
    Route::post('(:bundle)/message/delete-multi-message',array('as'=>'MultiMessageDelete','uses'=>'admin::message@MultiMessageDelete'));
    Route::get('(:bundle)/message/message-details/(:all)',array('as'=>'MessageDetail','uses'=>'admin::message@messageDetail'));

    Route::post('(:bundle)/client/add-client',array('as'=>'AddClient','uses'=>'admin::client@AddClient'));
    Route::post('(:bundle)/client/client-add',array('as'=>'ClientAdd','uses'=>'admin::client@ClientAdd'));
    Route::get('(:bundle)/client/create-client',array('as'=>'CreateClient','uses'=>'admin::client@CreateClient'));
    Route::get('(:bundle)/client/view-client',array('as'=>'ViewClient','uses'=>'admin::client@ViewClient'));
    Route::get('(:bundle)/client/edit-client/(:all)',array('as'=>'EditClient','uses'=>'admin::client@EditClient'));
    Route::post('(:bundle)/client/update-client',array('as'=>'ClientUpdate','uses'=>'admin::client@ClientUpdate'));
    Route::get('(:bundle)/client/delete-client/(:all)',array('as'=>'DeleteClient','uses'=>'admin::client@DeleteClient'));
    Route::get('(:bundle)/client/search-client',array('as'=>'SearchClient','uses'=>'admin::client@SearchClient'));


    Route::get('(:bundle)/cases',array('as'=>'Cases','uses'=>'admin::cases@Index'));
    Route::get('(:bundle)/cases/view-cases',array('as'=>'ViewCases','uses'=>'admin::cases@ViewCases'));
    Route::post('(:bundle)/cases/add-cases',array('as'=>'AddCases','uses'=>'admin::cases@AddCases'));
    Route::get('(:bundle)/cases/edit-cases/(:all)',array('as'=>'EditCases','uses'=>'admin::cases@EditCases'));
    Route::get('(:bundle)/cases/delete-cases/(:all)',array('as'=>'DeleteCases','uses'=>'admin::cases@DeleteCases'));
    Route::post('(:bundle)/cases/update-cases',array('as'=>'UpdateCases','uses'=>'admin::cases@UpdateCases'));
    Route::get('(:bundle)/cases/cases-status/(:all)',array('as'=>'CaseStatus','uses'=>'admin::cases@CaseStatus'));
    Route::get('(:bundle)/cases/cases-permission/(:all)',array('as'=>'CasePermission','uses'=>'admin::cases@CasePermission'));
    Route::post('(:bundle)/cases/cases-update-permission',array('as'=>'UpdateCasePermission','uses'=>'admin::cases@UpdateCasePermission'));
    Route::get('(:bundle)/cases/cases-detail/(:all)',array('as'=>'CaseDetail','uses'=>'admin::cases@CaseDetail'));
    Route::post('(:bundle)/cases/search-view-case',array('as'=>'SearchViewCase','uses'=>'admin::cases@SearchViewCase'));
    Route::get('(:bundle)/cases/search-case',array('as'=>'SearchCase','uses'=>'admin::cases@SearchCase'));
    Route::post('(:bundle)/cases/add-opp-party',array('as'=>'AddOppParty','uses'=>'admin::cases@AddOppParty'));
    Route::post('(:bundle)/cases/delete-multi-case',array('as'=>'DeleteMultiCaseByIDs','uses'=>'admin::cases@DeleteMultiCaseByIDs'));
    Route::get('(:bundle)/cases/view-cases/hearing-case/(:any)',array('as'=>'CaseHearings','uses'=>'admin::cases@CaseHearings'));
    Route::get('(:bundle)/cases/view-cases/pending-case/(:num)',array('as'=>'PendingCase','uses'=>'admin::cases@ViewStatic'));
    Route::get('(:bundle)/cases/view-cases/processing-case/(:num)',array('as'=>'ProcessingCase','uses'=>'admin::cases@ViewStatic'));
    Route::get('(:bundle)/cases/view-cases/completed-case/(:num)',array('as'=>'CompletedCase','uses'=>'admin::cases@ViewStatic'));


    Route::get('(:bundle)/contacts',array('as'=>'Contacts','uses'=>'admin::contact@Index'));
    Route::get('(:bundle)/contacts/view-contacts',array('as'=>'ViewContacts','uses'=>'admin::contact@ViewContacts'));
    Route::post('(:bundle)/contacts/add-contacts',array('as'=>'AddContacts','uses'=>'admin::contact@AddContacts'));
    Route::get('(:bundle)/contacts/edit-contacts/(:all)',array('as'=>'EditContact','uses'=>'admin::contact@EditContact'));
    Route::get('(:bundle)/contacts/delete-contacts/(:all)',array('as'=>'DeleteContact','uses'=>'admin::contact@DeleteContact'));
    Route::post('(:bundle)/contacts/update-contacts',array('as'=>'UpdateContact','uses'=>'admin::contact@UpdateContact'));

    Route::get('(:bundle)/hearing',array('as'=>'Hearing','uses'=>'admin::hearing@Index'));
    Route::get('(:bundle)/hearing/view-hearing',array('as'=>'ViewHearing','uses'=>'admin::hearing@ViewHearing'));
    Route::post('(:bundle)/hearing/add-hearing',array('as'=>'AddHearing','uses'=>'admin::hearing@AddHearing'));
    Route::get('(:bundle)/hearing/edit-hearing/(:all)',array('as'=>'EditHearing','uses'=>'admin::hearing@EditHearing'));
    Route::get('(:bundle)/hearing/edit-hearing-detail/(:all)',array('as'=>'EditHearingDetail','uses'=>'admin::hearing@EditHearingDetail'));
    Route::get('(:bundle)/hearing/delete-hearing/(:all)',array('as'=>'DeleteHearing','uses'=>'admin::hearing@DeleteHearing'));
    Route::post('(:bundle)/hearing/update-hearing',array('as'=>'UpdateHearing','uses'=>'admin::hearing@UpdateHearing'));
    Route::post('(:bundle)/hearing/update-hearing-detail',array('as'=>'UpdateHearingFromDetail','uses'=>'admin::hearing@UpdateHearingFromDetail'));
    Route::get('(:bundle)/hearing/hearing-detail/(:all)',array('as'=>'HearingDetail','uses'=>'admin::hearing@HearingDetail'));
    Route::get('(:bundle)/hearing/search-hearing',array('as'=>'SearchHearingView','uses'=>'admin::hearing@SearchHearingView'));
    Route::get('(:bundle)/hearing/select-case-hearing',array('as'=>'SelectCase','uses'=>'admin::hearing@SelectCase'));
    Route::get('(:bundle)/hearing/search-hearings',array('as'=>'SearchHearings','uses'=>'admin::hearing@SearchHearings'));
    Route::post('(:bundle)/hearing/multi-hearing-update',array('as'=>'MultiHearingUpdate','uses'=>'admin::hearing@MultiHearingUpdate'));
    Route::post('(:bundle)/hearing/update-multi-hearing',array('as'=>'UpdateMultiHearing','uses'=>'admin::hearing@UpdateMultiHearing'));
    Route::post('(:bundle)/hearing/add-multi-hearing',array('as'=>'AddMultiHearing','uses'=>'admin::hearing@AddMultiHearing'));
    Route::get('(:bundle)/hearing/future-hearing/(:all)',array('as'=>'FutureHeaing','uses'=>'admin::hearing@futureHearing'));
    Route::get('(:bundle)/hearing/hearings-json',array('as'=>'HearingsJson','uses'=>'admin::hearing@HearingsJson'));


    Route::get('(:bundle)/document',array('as'=>'Documents','uses'=>'admin::document@Index'));
    Route::get('(:bundle)/document/view-documents',array('as'=>'ViewDocuments','uses'=>'admin::document@ViewDocuments'));
    Route::post('(:bundle)/document/add-documents',array('as'=>'AddDocument','uses'=>'admin::document@AddDocuments'));
    Route::get('(:bundle)/document/edit-documents/(:all)',array('as'=>'EditDocument','uses'=>'admin::document@EditDocuments'));
    Route::get('(:bundle)/document/delete-documents/(:all)',array('as'=>'DeleteDocument','uses'=>'admin::document@DeleteDocuments'));
    Route::post('(:bundle)/document/update-documents',array('as'=>'UpdateDocument','uses'=>'admin::document@UpdateDocuments'));
    Route::get('(:bundle)/document/documents-download/(:all)',array('as'=>'DocumentDownload','uses'=>'admin::document@DocumentDownload'));
    Route::post('(:bundle)/document/multi-document-delete',array('as'=>'MultiDocumentDelete','uses'=>'admin::document@MultiDocumentDelete'));
    Route::get('(:bundle)/document/case-document/(:all)',array('as'=>'CaseDocument','uses'=>'admin::document@CaseDocument'));
    Route::post('(:bundle)/document/add-case-documents',array('as'=>'AddCaseDocument','uses'=>'admin::document@AddCaseDocuments'));
    Route::get('(:bundle)/document/edit-hearing-document/(:all)',array('as'=>'EditHearingDocument','uses'=>'admin::document@EditHearingDocument'));
    Route::post('(:bundle)/document/add-hearing-edit-documents',array('as'=>'AddEditHearingDocument','uses'=>'admin::document@AddEditHearingDocument'));
    Route::post('(:bundle)/document/add-hearing-add-documents',array('as'=>'AddHearingDocuments','uses'=>'admin::document@AddHearingDocuments'));



    Route::get('(:bundle)/calender',array('as'=>'Calender','uses'=>'admin::calender@Index'));

    Route::get('(:bundle)/notification/read-notification/(:all)',array('as'=>'ReadNotification','uses'=>'admin::notification@ReadNotification'));

    Route::get('(:bundle)/report/select-report',array('as'=>'SelectReport','uses'=>'admin::report@SelectReport'));
    Route::get('(:bundle)/report/cases',array('as'=>'ReportCase','uses'=>'admin::report@Reportcase'));
    Route::get('(:bundle)/report/client',array('as'=>'ReportClient','uses'=>'admin::report@ReportClient'));
    Route::get('(:bundle)/report/all-cases',array('as'=>'ReportAllCases','uses'=>'admin::report@ReportAllCases'));

    Route::get('(:bundle)/appointment/appointment-detail/(:all)',array('as'=>'AppointmentDetail','uses'=>'admin::appointment@AppointmentDetail'));
     Route::get('(:bundle)/appointment/view',array('as'=>'ViewAppointment','uses'=>'admin::appointment@ViewAppointment'));  
     Route::get('(:bundle)/appointment/appointment-status/(:all)',array('as'=>'AppointmentStatus','uses'=>'admin::appointment@AppointmentStatus'));
 Route::get('(:bundle)/appointment/delete-appointment/(:all)',array('as'=>'DeleteAppointment','uses'=>'admin::appointment@DeleteAppointment'));
 Route::get('(:bundle)/select/select-list/(:num)',array('as'=>'selectList','uses'=>'admin::selectlist@selectList'));

});
Route::group(array('before'=>'lawyers-auth'),function(){

    Route::get('(:bundle)/appointment',array('as'=>'Appointment','uses'=>'admin::appointment@Index'));
    Route::post('(:bundle)/appointment/add-appointment',array('as'=>'AddAppointment','uses'=>'admin::appointment@AddAppointment'));
    Route::get('(:bundle)/appointment/edit-appointment/(:all)',array('as'=>'EditAppointment','uses'=>'admin::appointment@EditAppointment'));
   
    
    Route::post('(:bundle)/appointment/multi-delete-appointment',array('as'=>'MultiAppointmentDelete','uses'=>'admin::appointment@MultiAppointmentDelete'));
    Route::post('(:bundle)/appointment/check-appointment',array('as'=>'CheckAppointment','uses'=>'admin::appointment@CheckAppointment'));


    Route::get('(:bundle)/invoice/create-invoice',array('as'=>'CreateInvoice','uses'=>'admin::payment@CreateInvoice'));
    Route::post('(:bundle)/invoice/add-invoice',array('as'=>'AddInvoice','uses'=>'admin::payment@AddInvoice'));
    Route::get('(:bundle)/invoice/edit-invoice/(:any)',array('as'=>'EditInvoice','uses'=>'admin::payment@EditInvoice'));
    Route::post('(:bundle)/invoice/update-invoice',array('as'=>'UpdateInvoice','uses'=>'admin::payment@UpdateInvoice'));
    Route::get('(:bundle)/invoice/view-invoice',array('as'=>'ViewInvoice','uses'=>'admin::payment@ViewInvoice'));
    Route::get('(:bundle)/invoice/invoice-detail/(:all)',array('as'=>'InvoiceDetail','uses'=>'admin::payment@InvoiceDetail'));
    Route::post('(:bundle)/invoice/update-payment',array('as'=>'UpdatePayment','uses'=>'admin::payment@UpdatePayment'));
    Route::post('(:bundle)/invoice/send-invoice',array('as'=>'SendInvoice','uses'=>'admin::payment@SendInvoice'));
    Route::get('(:bundle)/invoice/delete-invoice/(:any)',array('as'=>'DeleteInvoice','uses'=>'admin::payment@DeleteInvoice'));
    Route::get('(:bundle)/invoice/pending-bill',array('as'=>'PendingBill','uses'=>'admin::payment@PendingBill'));
    Route::get('(:bundle)/invoice/paid-bill',array('as'=>'PaidBill','uses'=>'admin::payment@PaidBill'));
    Route::get('(:bundle)/invoice/history-invoice',array('as'=>'HistoryInvoice','uses'=>'admin::payment@HistoryInvoice'));

    Route::get('(:bundle)/User/permission/(:all)',array('as'=>'UserCasePermission','uses'=>'admin::user@UserCasePermission'));
    Route::get('(:bundle)/User/permission/search-case-permission',array('as'=>'UserCasePermissionSearch','uses'=>'admin::user@UserCasePermissionSearch'));
    Route::post('(:bundle)/User/permission/update-case_permission',array('as'=>'UpdateUserCasePermission','uses'=>'admin::user@UpdateCasePermission'));

    
    
    Route::get('(:bundle)/case/case-history/(:all)',array('as'=>'CaseHistoryDetail','uses'=>'admin::cases@CaseHistoryDetail'));
    Route::get('(:bundle)/case/case-permission-search',array('as'=>'CasePermissionSearch','uses'=>'admin::cases@CasePermissionSearch'));

    Route::get('(:bundle)/sms/send',array('as'=>'SendSms','uses'=>'admin::hearing@SmsUpdate'));
    Route::get('(:bundle)/case/view-party-type',array('as'=>'ViewPartyType','uses'=>'admin::cases@ViewPartyType'));
    Route::get('(:bundle)/case/view-case-subject',array('as'=>'ViewCaseSubject','uses'=>'admin::cases@ViewCaseSubject'));
    Route::get('(:bundle)/case/view-court',array('as'=>'ViewCourt','uses'=>'admin::cases@ViewCourt'));
    Route::post('(:bundle)/case/multi-delete-case-attri',array('as'=>'MultiCaseAttriDelete','uses'=>'admin::cases@MultiCaseAttriDelete'));


    Route::post('(:bundle)/hearing/view/HearingDetailsByID',array('as'=>'HearingDetailsByID','uses'=>'admin::hearing@HearingDetailsByID'));
    Route::post('(:bundle)/client/CaseByClient',array('as'=>'CaseByClient','uses'=>'admin::client@CaseByClient'));

    Route::get('(:bundle)/lawyer-demo',array('as'=>'lawyerDemo','uses'=>'admin::demo@lawyerDemo'));

});

Route::group(array('before'=>'admin-auth'),function(){
    
    Route::get('(:bundle)/user/permission/assign-permission',array('as'=>'AssignUserPermission','uses'=>'admin::user@AssignUserPermission'));
    Route::get('(:bundle)/user/permission/activation-permission/(:all)',array('as'=>'ActivateUserPermission','uses'=>'admin::user@ActivateUserPermission'));
    Route::post('(:bundle)/User/permission/no-of-associate',array('as'=>'NoOfAssociate','uses'=>'admin::user@NoOfAssociate'));
    Route::post('(:bundle)/User/permission/no-of-sms',array('as'=>'NoOfSms','uses'=>'admin::user@NoOfSms'));
    Route::post('(:bundle)/User/status/update-status',array('as'=>'UpdateUserStatus','uses'=>'admin::user@UpdateUserStatus'));
    Route::post('(:bundle)/User/status/add-storage',array('as'=>'Storage','uses'=>'admin::user@UpdateStorage'));
    Route::get('(:bundle)/User/settings/reset-password/(:all)',array('as'=>'AdminResetPassword','uses'=>'admin::user@AdminResetPassword'));



});


Route::group(array('before'=>'admin-lawyer-associate-auth'),function(){
    
    Route::get('(:bundle)/user/setting',array('as'=>'Setting','uses'=>'admin::user@UserSetting'));
    Route::post('(:bundle)/user/setting/upload-image',array('as'=>'UploadImage','uses'=>'admin::user@UploadImage'));
    Route::post('(:bundle)/user/setting/profile-update',array('as'=>'ProfileUpdate','uses'=>'admin::user@ProfileUpdate'));
    Route::post('(:bundle)/user/setting/profile-change-password',array('as'=>'ChangePassword','uses'=>'admin::user@ChangePassword'));


});


    Route::get('(:bundle)/hearing/view-hearing/searchbycase',array('as'=>'HearingSearchByCase','uses'=>'admin::hearing@SearchByCase'));


Route::get('(:bundle)/auto-msg',array('uses'=>'admin::automsg@sendMessage'));

Route::filter('admin-auth', function()
{
    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
            if($roles->role_name!='admin' )
            {
                return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
            }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }

});
Route::filter('lawyers-auth', function()
{
    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
            if($roles->role_name!='lawyer' )
            {
                return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
            }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }

});
Route::filter('lawyer-associate-auth',function(){


    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
            if($roles->role_name!='lawyer' && $roles->role_name!='associate' )
            {
                return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
            }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }

});

Route::filter('admin-lawyer-associate-auth',function(){


    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
            if($roles->role_name!='lawyer' && $roles->role_name!='associate' && $roles->role_name!='admin')
            {
                return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
            }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }

});


Route::group(array('before'=>'user'),function(){

});

/*
 * All the routes for Lawyers
 * */


Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function($exception)
{
	return Response::error('500');
});



Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest())
  {
        Session::put('redirect',URL::full());
        return Redirect::to_route('Login');
    }
    if ($redirect = Session::get('redirect')) {
        Session::forget('redirect');
        return Redirect::to($redirect);
    }

});
/* To validate admin level authentication
*/

//Route::filter('pattern: admin/*', array('name' => 'admin-auth', function()
//{
//
//}));

/* To validate lawyers level authentication
*/

//Route::filter('pattern: user/*', array('name' => 'lawyer-auth', function()
//{
//
//}));
Route::filter('admin-lawyer-auth',function()
{
    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
            if($roles->role_name!='admin' && $roles->role_name!='lawyer' )
            {
                return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
            }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }
});

Route::filter('admin-auth',function()
{
    if(Auth::check()){
        $roles=libRole::getRole(Auth::user()->user_role);
        if($roles)
        {
              if($roles->role_name!='admin')
              {
                  return Redirect::to_route('Login')->with('status','You are not allowed to access this link!');
              }
        }
    }
    else{
        return Redirect::to_route('Login')->with('status','Please login!');
    }
});

