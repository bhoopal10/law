<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
                Backup
                <small>
                    <i class="icon-double-angle-right"></i>
                    Create Backup
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>

        </div>
    </div>
<div class="row-fluid">
<?php $status=Session::get('status');
        $error=Session::get('error');
if($status){  ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <span><?php echo $status;  ?></span>
    </div>
<?php }elseif($error){  ?>
    <div class=" alert alert-danger">
        <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
        <span><?php echo $error;  ?></span>
    </div>
    <?php } ?>

<?php //print_r($user);  ?>
<!-- <h4><?php echo ucfirst($user->first_name.'&nbsp;&nbsp;'.$user->last_name);  ?></h4> -->

<div class="widget-box widget-color-blue span5  ">
    <div class ="widget-header">
           <h2><?php echo ucfirst($user->first_name.'&nbsp;&nbsp;'.$user->last_name);  ?> - Backups</h2> 
    </div>
    <div class="widget-body">
    <div class="widget-main">
        <div class="row-fluid bordered">
            <div class="span4">
                <h4>Create Backup</h4>
            </div>
            <div class="span5">
                <a href="<?php echo URL::to_route('LawyerBackup').'/'.$user->id; ?>" class="btn btn-info btn-block">Download Backup</a>
            </div>
        </div>
        <hr>
        <div class="row-fluid bordered">
            <div class="span4">
                <h4>Restore Backup</h4>
            </div>
            <div class="span5">
                <button class="btn btn-info btn-block" id="upload">Upload Backup</button>
            </div>
            <form action="<?php echo URL::to_route('UpdateRestoreFile').'/'.$user->id;  ?>" method="post" enctype="multipart/form-data" id="upload_zip">
                <input type="file" name="restore_file" id="update_zip" style="display: none" >
            </form>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">
    $('#upload').on('click',function(){
        $('#update_zip').click();
    });
    $('#update_zip').on('change',function(){
        var up=document.getElementById('update_zip');
        var ext = this.value;
        var ext1=ext.slice(-3);
        
        if(ext1 == 'zip')
        {
            $('#upload_zip').submit();
        }
        else
        {
            alert('Please select valid file');
            return false;
        }
    });
    
    
</script>

<!-- <table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
    <th>Module</th>
    <th>Backup</th>
    <th>Update</th>
    <th>Restore</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><b>Appointments</b></td>
        <td><a href="<?php echo URL::to_route('DownloadBackup').'/'.Crypter::encrypt($user->id).',appointment';  ?>" title="Download Backup" class="btn btn--app btn-purple btn-small"><i class="icon-cloud-download"></i>Create Backup</a></td>
        <td><a id="update_app" title="Update Backup" class="btn btn--app btn-purple btn-small"><i class="icon-refresh"></i>Update Backup</a>
            <form action="<?php echo URL::to_route('UpdateRestoreFile').'/'.Crypter::encrypt($user->id).',appointments';  ?>" method="post" enctype="multipart/form-data" id="upload_appointment" name="upload_appointment">
                <input type="file" name="restore_file" id="update_appointment" style="display: none"/>
            </form></td>
        <td>
            <a title="Restore Backup" class="btn btn--app btn-purple btn-small" id="restore_app"><i class="icon-cloud-upload"></i>Restore Backup</a>
            <form action="<?php echo URL::to_route('RestoreFile').'/'.Crypter::encrypt($user->id).',appointments';  ?>" id="upload_restore_appointment" method="post" enctype="multipart/form-data">
                <input type="file" id="update_restore_appointment" name="restore_file" style="display: none"/>
            </form>
        </td>
    </tr>
    <tr>
        <td><b>Cases</b></td>
        <td><a href="<?php echo URL::to_route('DownloadBackup').'/'.Crypter::encrypt($user->id).',case';  ?>" title="Download Backup" class="btn btn--app btn-purple btn-small"><i class="icon-cloud-download"></i>Create Backup</a></td>
        <td><a id="update_ca" title="Update Backup" class="btn btn--app btn-purple btn-small"><i class="icon-refresh"></i>Update Backup</a>
            <form action="<?php echo URL::to_route('UpdateRestoreFile').'/'.Crypter::encrypt($user->id).',cases';  ?>" method="post" enctype="multipart/form-data" id="upload_case">
                <input type="file" name="restore_file" id="update_case" style="display: none"/>
            </form></td>
        <td><a title="Restore Backup" class="btn btn--app btn-purple btn-small" id="restore_ca"><i class="icon-cloud-upload"></i>Restore Backup</a>
            <form action="<?php echo URL::to_route('RestoreFile').'/'.Crypter::encrypt($user->id).',cases';  ?>" id="upload_restore_case" method="post" enctype="multipart/form-data">
                <input type="file" id="update_restore_case" name="restore_file" style="display: none"/>
            </form>
        </td>

    </tr>
    <tr>
        <td><b>Clients</b></td>
        <td><a href="<?php echo URL::to_route('DownloadBackup').'/'.Crypter::encrypt($user->id).',client';  ?>" title="Download Backup" class="btn btn--app btn-purple btn-small"><i class="icon-cloud-download"></i>Create Backup</a></td>
        <td><a id="update_con" title="Update Backup" class="btn btn--app btn-purple btn-small"><i class="icon-refresh"></i>Update Backup</a>
            <form action="<?php echo URL::to_route('UpdateRestoreFile').'/'.Crypter::encrypt($user->id).',clients';  ?>" method="post" enctype="multipart/form-data" id="upload_client">
                <input type="file" name="restore_file" id="update_client" style="display: none" >
            </form></td>
        <td><a title="Restore Backup" class="btn btn--app btn-purple btn-small" id="restore_con"><i class="icon-cloud-upload"></i>Restore Backup</a>
            <form action="<?php echo URL::to_route('RestoreFile').'/'.Crypter::encrypt($user->id).',clients';  ?>" id="upload_restore_client" method="post" enctype="multipart/form-data">
                <input type="file" id="update_restore_client" name="restore_file" style="display: none"/>
            </form>
        </td>

    </tr>
    <tr>
        <td><b>Hearings</b></td>
        <td><a href="<?php echo URL::to_route('DownloadBackup').'/'.Crypter::encrypt($user->id).',hearing';  ?>" title="Download Backup" class="btn btn--app btn-purple btn-small"><i class="icon-cloud-download"></i>Create Backup</a></td>
        <td><a id="update_he" title="Update Backup" class="btn btn--app btn-purple btn-small"><i class="icon-refresh"></i>Update Backup</a>
            <form action="<?php echo URL::to_route('UpdateRestoreFile').'/'.Crypter::encrypt($user->id).',hearings';  ?>" method="post" enctype="multipart/form-data" id="upload_hearing">
                <input type="file" name="restore_file" id="update_hearing" style="display: none" />
            </form></td>
        <td><a title="Restore Backup" class="btn btn--app btn-purple btn-small" id="restore_he"><i class="icon-cloud-upload"></i>Restore Backup</a>
            <form action="<?php echo URL::to_route('RestoreFile').'/'.Crypter::encrypt($user->id).',hearings';  ?>" id="upload_restore_hearing" method="post" enctype="multipart/form-data">
                <input type="file" id="update_restore_hearing" name="restore_file" style="display: none"/>
            </form>
        </td>

    </tr>
   </tbody>
</table> -->

    <script type="text/javascript">
//         $('.btn').tooltip({placement:'right'});
//         $('span').tooltip({placement:'bottom'});
//         $('#update_app').on('click',function(){
//             $('#update_appointment').click();
//         });
//         $('#update_ca').on('click',function(){
//             $('#update_case').click();
//         });
//         $('#update_con').on('click',function(){
//             $('#update_client').click();
//         });
//         $('#update_he').on('click',function(){
//             $('#update_hearing').click();
//         });
//         $('#restore_app').on('click',function(){
//            $('#update_restore_appointment').click();
//         });
//         $('#restore_ca').on('click',function(){
//             $('#update_restore_case').click();
//         });
//         $('#restore_con').on('click',function(){
//             $('#update_restore_client').click();
//         });
//         $('#restore_he').on('click',function(){
//             $('#update_restore_hearing').click();
//         });


//         var f1 = document.getElementById('update_appointment');
// //        var fl = document.upload_appointment.elements[0].value;
//         var f2 = document.getElementById('update_case');
//         var f3 = document.getElementById('update_client');
//         var f4 = document.getElementById('update_hearing');
//         var f5=document.getElementById('update_restore_appointment');
//         var f6=document.getElementById('update_restore_case');
//         var f7=document.getElementById('update_restore_client');
//         var f8=document.getElementById('update_restore_hearing');
//             var validate=function()
//             {
//                 var ext = this.value.match(/\.(.+)$/)[1];
//                 var val=this.id;
//                 var res=val.replace(/update/g,"upload");
//                 switch(ext)
//                 {
//                     case 'txt':
//                         $('#'+res).submit();
//                         break;
//                     case 'csv':
//                         $('#'+res).submit();
//                         break;
//                     case 'xml':
//                         $('#'+res).submit();
//                         break;

//                     default:
// //                        alert('Upload only Txt/CSV/XML file');
// //                        this.value='';
//                         $('#'+res).submit();
//                 }
//             }

//         f1.onchange =validate;
//         f2.onchange =validate;
//         f3.onchange =validate;
//         f4.onchange =validate;
//         f5.onchange =validate;
//         f6.onchange =validate;
//         f7.onchange =validate;
//         f8.onchange =validate;

    </script>
<?php Section::stop();  ?>
<?php echo render('admin::admin/template.main');  ?>