<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/7/14
 * Time: 3:35 PM
*/
?>
<?php echo Section::start('page-header');
?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>
        <i class="icon icon-cog"></i>
            Settings

            <small>
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewUser'); ?>">Back</a></small>
        </h1>
    </div>
</div>
<div class="row-fluid">
    <?php $status=Session::get('status');
    $error=Session::get('error');
    if(isset($status)){ ?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
                <i class="icon-remove"></i>
            </button>
            <span><?php echo $status; ?></span>
        </div>
    <?php } ?>
    <?php if(isset($error)){ ?>
        <div class="alert alert-alert">
            <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
                <i class="icon-remove"></i>
            </button>
            <span><?php echo $error; ?></span>
        </div>
    <?php } ?>

    <h4><?php echo ucfirst($user->first_name).'&nbsp;&nbsp;'.ucfirst($user->last_name);  ?></h4>
    <?php $status=liblawyer::getstatusByID($user->id); $totSms=libsms::getcount($user->id); ?>
<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th>Module</th>
        <th>Actions</th>

    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Document</td>
        <td>
             <?php if($status->document_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($user->id).',:'.Crypter::encrypt($status->document_permission);  ?>">
                            <?php if($status->document_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td>Auto Backup</td>
        <td>
         <?php if($status->backup_auto_upload!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($user->id).',*'.Crypter::encrypt(($status->backup_auto_upload == 0) ? '1':'0');  ?>">
                            <?php if($status->backup_auto_upload!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
            
        </td>
    </tr>
    <tr>
        <td>Billing</td>
        <td>
         <?php if($status->billing_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($user->id).',@'.Crypter::encrypt(($status->billing_permission == 0) ? '1':'0');  ?>">
                            <?php if($status->billing_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
            
        </td>
    </tr>
    <tr>
        <td>Associate</td>
        <td>
         <?php if($status->associate_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($user->id).',:'.Crypter::encrypt(($status->associate_permission == 0) ? '1':'0');  ?>">
                            <?php if($status->associate_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
            
        </td>
    </tr>
    <tr>
        <td>Appointment</td>
        <td>
         <?php if($status->appointment_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($user->id).',$'.Crypter::encrypt(($status->appointment_permission == 0) ? '1':'0');  ?>">
                            <?php if($status->appointment_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
            
        </td>
    </tr>
    <tr>
        <td>Messages</td>
        <td>
            <?php if($status->message_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
            <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($user->id).',$'.Crypter::encrypt($status->message_permission);  ?>">
                            <?php if($status->message_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <tr>
        <td>SMS</td>
        <td>
            <?php if($status->sms_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
            <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($user->id).',='.Crypter::encrypt(($status->sms_permission == 0) ? '1':'0');  ?>">
                            <?php if($status->sms_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td>Contacts</td>
        <td>
            <?php if($status->contact_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
            <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($user->id).',@'.Crypter::encrypt($status->contact_permission);  ?>">
                            <?php if($status->contact_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td>Calender</td>
        <td>
            <?php if($status->calender_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
            <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($user->id).',*'.Crypter::encrypt($status->calender_permission);  ?>">
                            <?php if($status->calender_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                </ul>
            </div>
        </td>
    </tr>
    <tr>
        <td>Number of Associates ( current: <b><?php echo $status->no_associate; ?></b> )</td>
        <td>
            <form name="form1" class="form-inline" action="<?php echo URL::to_route('NoOfAssociate'); ?>" method="post" onsubmit="return validation();">
                <input type="hidden" name="uid" value="<?php echo Crypter::encrypt($user->id); ?>" >
                <input type="text" name="no_ass" class="span3">
                <input type="hidden" name="comp" value="<?php echo $status->no_associate; ?>"/>
                <input type="submit" name="submit" value="Add"/>
            </form>
        </td>
    </tr>
<tr>
    <!-- <td>Number of SMS ( current: <b><?php echo $status->no_sms; ?></b> )(Used: <?php   echo $totSms;  ?>)(Remaining: <?php  echo ($status->no_sms-$totSms); ?>)</td> -->
    <td>Number of SMS ( current: <b><?php echo $status->no_sms; ?></b> )</td>
    <td>
        <form name="form2" class="form-inline" action="<?php echo URL::to_route('NoOfSms'); ?>" method="post" onsubmit="return validation1();">
            <input type="hidden" name="uid" value="<?php echo Crypter::encrypt($user->id); ?>" >
            <input type="text" name="no_sms" class="span3">
            <input type="hidden" name="comp" value="<?php echo $status->no_sms; ?>"/>
            <input type="submit" name="submit" value="Add"/>
        </form>
    </td>
</tr>
<tr>
    <td>Storage Memory ( current: <b><?php echo $status->storage; ?></b> )</td>
    <td>
        <form name="form3" class="form-inline" action="<?php echo URL::to_route('Storage'); ?>" method="post" onsubmit="return validation2();">
            <input type="hidden" name="uid" value="<?php echo Crypter::encrypt($user->id); ?>" >
            <input type="text" name="storage" class="span3"><span>MB</span>
            <input type="hidden" name="comp" value="<?php echo $status->storage; ?>"/>
            <input type="submit" name="submit" value="Add"/>
        </form>
    </td>
</tr>
    </tbody>
</table>
</div>
<script type="text/javascript">
    $('a').tooltip();
    function validation()
    {
        var no_ass=document.form1.no_ass.value;
        if(isNaN(no_ass))
        {
            alert("Number of associate must number");
            document.form1.no_ass.focus();
            return false;
        }
    }
    function validation1()
    {
        var no_ass=document.form2.no_sms.value;
        if(isNaN(no_ass))
        {
            alert("Number of SMS must number");
            document.form2.no_sms.focus();
            return false;
        }
    }
    function validation2()
    {
        var no_ass=document.form3.storage.value;
        if(isNaN(no_ass))
        {
            alert("Storage Memory must number");
            document.form3.storage.focus();
            return false;
        }
    }
</script>
<?php Section::stop(); ?>
<?php echo  render('admin::admin/template.main'); ?>