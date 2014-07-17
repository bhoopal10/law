<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>
        <i class="icon icon-cog"></i>
           Lawyer
            <small>
                <i class="icon-double-angle-right"></i>
                Assign Permission
            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
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
<div class="row-fluid">
    
    
    
    <div class="tabbable">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab1" data-toggle="tab">Assign Permission</a></li>
      <li><a href="#tab2" data-toggle="tab">Assign Associate</a></li>
      
   </ul>
    </div>
   <div class="tab-content">
      <div class="tab-pane active" id="tab1">
         <table class="table table-bordered table-striped" id="table1">
        <thead>
            <tr>
                <th>Lawyer</th>
                <th>Associate</th>
                <th>Appointment</th>
                <th>Billing</th>
                <th>Document</th>
                <th>Message</th>
                <th>Contacts</th>
                <th>Calender</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($user)){ foreach($user->results as $value){ ?>
            <tr>
                <td><?php echo ucfirst($value->first_name).' '.  ucfirst($value->last_name); ?></td>
                <td>
                    <?php if($value->associate_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                    <div class="btn-group">
                        <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($value->id).',:'.Crypter::encrypt(($value->associate_permission == 0) ? '1':'0');  ?>">
                                    <?php if($value->associate_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                
                </td>
                <td>
                 <?php if($value->appointment_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                        <div class="btn-group">
                        <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($value->id).',$'.Crypter::encrypt(($value->appointment_permission == 0) ? '1':'0');  ?>">
                                    <?php if($value->appointment_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                    
                </td>
                <td>
                <?php if($value->document_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                        <div class="btn-group">
                        <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($value->id).',:'.Crypter::encrypt($value->document_permission);  ?>">
                                    <?php if($value->document_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                </td>
                <td>
                 <?php if($value->billing_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                        <div class="btn-group">
                        <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                            Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to_route('AutoUpload').'/'.Crypter::encrypt($value->id).',@'.Crypter::encrypt(($value->billing_permission == 0) ? '1':'0');  ?>">
                                    <?php if($value->billing_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                </a></li>
                        </ul>
                    </div>
                    
                </td>


                <td><?php if($value->message_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                    <div class="btn-group">
                                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($value->id).',$'.Crypter::encrypt($value->message_permission);  ?>">
                                            <?php if($value->message_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                        </a></li>
                                </ul>
                            </div></td>
                <td><?php if($value->contact_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                    <div class="btn-group">
                                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($value->id).',@'.Crypter::encrypt($value->contact_permission);  ?>">
                                            <?php if($value->contact_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                        </a></li>
                                </ul>
                            </div>
                    </td>
                <td>  
                    <?php if($value->calender_permission!=0){echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                    <div class="btn-group">
                                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL::to_route('ActivateUserPermission').'/'.Crypter::encrypt($value->id).',*'.Crypter::encrypt($value->calender_permission);  ?>">
                                            <?php if($value->calender_permission!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                        </a></li>
                                </ul>
                            </div></td>
            </tr>
            <?php }} ?>
        </tbody>
    </table>
    <?php echo $user->links(); ?>
      </div>

      <div class="tab-pane" id="tab2">
          <table class="table table-bordered table-striped" id="table1">
        <thead>
            <tr>
                <th>Lawyer</th>
                <th>Number of associate</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($user)){ $i=1;foreach($user->results as $value){ ?>
            <tr>
                <td><?php echo ucfirst($value->first_name).' '.  ucfirst($value->last_name); ?></td>
                <td>
                    <span><b><?php echo $value->no_associate; ?></b></span>
                </td>
       
                <td>  
                   
                    <form name="form1" class="form-inline" action="<?php echo URL::to_route('NoOfAssociate'); ?>" method="post">
                        <input type="hidden" name="uid" value="<?php echo Crypter::encrypt($value->id); ?>" >
                    <input type="text" name="no_ass">
                    <input type="hidden" name="comp" value="<?php echo $value->no_associate; ?>"/>
                    <input type="submit" name="submit" value="Add"/>
                    
                </form>               
                </td>
                
            </tr>
            <?php }} ?>
        </tbody>
    </table>
    <?php echo $user->links(); ?>
      </div>
     
    
   </div>
</div>
    


<script>
  
    $('[data-toggle=tab]').click(function(){
  if ($(this).parent().hasClass('active')){
	$($(this).attr("href")).toggleClass('active');
  }
})

    </script>
    
    
<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>

