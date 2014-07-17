<?php echo Section::start('contentWrapper');?>
<script src="<?php echo Config::get('application.url').Config::get('admin::admin_config.ckeditor').'ckeditor.js';  ?>"></script>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
            <i class="icon icon-group"></i>
                Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Lawyers
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                    <i class="icon-double-angle-right"></i>
                    <a title="View All" href="<?php echo URL::to_route('ViewUser') ?>">View All</a>
                </small>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
    <div class="row-fluid">

        <?php $contact=libcontact::getcontact();  ?>
        <div class="span12">

            <a href="<?php echo URL::to_route('User'); ?>" title="Add new Lawyer" class="btn btn-file" style="float: right">
                <i class="icon-plus"></i>Add new Lawyer
            </a>
            <span style="float: right">&nbsp;</span>
            <a title="Send Email" href="javascript:void(0);" id="send_mail" class="btn btn-file" style="float: right">Send Email</a>
            <form action="<?php echo URL::to_route('SearchLawyerView'); ?>" method="get">
                <select id="e1" class="span3" name="id" onchange='this.form.submit()'>
                    <option value="0">Search By lawyer</option>
                    <?php if(isset($user_filter)){ foreach( $user_filter as $val){ if($val->updated_by==Auth::user()->id){?>
                        <option value="<?php echo $val->id; ?>"><?php echo ucfirst($val->first_name) . '&nbsp;' . ucfirst($val->last_name); ?></option>
                    <?php }} } ?>
                </select>
                <select id="e2" class="span3" name="user_email" onchange='this.form.submit()'>
                    <option value="0">Search By Email</option>
                    <?php if(isset($user_filter)){ foreach( $user_filter as $val){ ?>
                        <option value="<?php echo $val->user_email; ?>"><?php echo $val->user_email; ?></option>
                    <?php }}  ?>
                </select>
            </form>


          
                <?php $search=Session::get('search'); if (!isset($search)) { $users=liblawyer::getUserByUpdateIDPaginate(Auth::user()->id,'15'); ?>
                <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <form action="#" method="post" id="send_email" >
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>S.no</th>
                    <th>Lawyer Name</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Payment</th>
                    <th>Exp.Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>

                <?php  if(isset($user)){ $i=1; foreach($user->results as $lawyer){ ?>
                    <tr class="">
                        <td class="left">
                            <label>
                                <input type="checkbox" name="email[]" value="<?php echo $lawyer->user_email; ?>">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php $page=$user->page-1;$total=$user->per_page*$page; echo $i+$total;$i++; ?></td>
                        <td><?php echo $lawyer->first_name; ?></td>
                        <td><?php echo $lawyer->username;  ?></td>
                        <td><?php echo $lawyer->user_email; ?></td>
                        <td><?php echo $lawyer->mobile;?></td>
                        <td><?php echo ($lawyer->payment == 'paid') ? "<span class='label label-success'>Paid</span>":"<span class='label label-warning'>Trial</span>"; ?></td>
                        <td><?php echo ($lawyer->exp_date!='')? date('d-M-Y', strtotime($lawyer->exp_date)):''; ?></td>
                        <td><?php if($lawyer->user_role!=0){$role="0";echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{ $role="2";echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                            <div class="btn-group">
                                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                    Action
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo URL::to_route('ActivateUser').'/'.$lawyer->id.','.$role;  ?>">
                                            <?php if($lawyer->user_role!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                        </a></li>

                                    <li><a href="#trail" data-toggle="modal" uid="<?php echo $lawyer->id ?>" exp_date="<?php echo ($lawyer->exp_date!='')? date('d-M-Y', strtotime($lawyer->exp_date)):''; ?>" exp_date_1="<?php echo ($lawyer->exp_date!='')? $lawyer->exp_date :''; ?>"  class="tra">Change Exp.Date</a></li>
                                    <li><a href="<?php echo URL::to_route('AdminResetPassword').'/'.$lawyer->id.','.$lawyer->user_email.','.$lawyer->first_name; ?>">Reset Password</a></li>

                                </ul>
                            </div>
                        </td>
                        <td class="td-actions ">
                            <div class=" btn-group">

                                <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditUser').'/'.$lawyer->id;  ?>">
                                    <i class="icon-edit bigger-120"></i>
                                </a>

                                <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really Want to Delete!');" href="<?php echo URL::to_route('DeleteUser').'/'.$lawyer->id;  ?>">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                                <a title="View" class="btn btn-mini btn-info" href="<?php echo URL::to_route('UserDetail').'/'.$lawyer->id; ?>">
                                    <i class="icon-eye-open bigger-120"></i>
                                </a>
                                <a title="Setting" class="btn btn-mini btn-warning" href="<?php echo URL::to_route('FileHandle').'/'.$lawyer->id;  ?>">
                                    <i class="icon-cog"></i>
                                </a>
                                <a title="Backup" class="btn btn-mini btn-info" href="<?php echo URL::to_route('CreateBackup').'/'.$lawyer->id;  ?>">
                                    <i class="icon-cloud-download"></i>
                                </a>
                            </div>

                        </td>

                    </tr>


                <?php  }}  ?>
                </tbody>
                </form>
                </table>
                
                    <?php echo $user->links(); ?>
               <?php }else{ ?>
  <form action="#" method="post" name="email">
                    <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                           <th class="left" style="width: 20px">
                                <label>
                                    <input type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>S.no</th>
                            <th>Lawyer Name</th>
                            <th>UserNames</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Payment</th>
                            <th>Exp.Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>

                        <tbody>
                <?php if(isset($user)){ $i=1; foreach($user->results as $lawyer){ ?>
    <tr class="">
        <td class="left">
            <label>
                <input type="checkbox" name="email[]" value="<?php echo $lawyer->user_email; ?>">
                <span class="lbl"></span>
            </label>
        </td>
        <td><?php $page=$user->page-1;$total=$user->per_page*$page; echo $i+$total;$i++; ?></td>
        <td><?php echo $lawyer->first_name; ?></td>
        <td><?php echo $lawyer->username;  ?></td>
        <td><?php echo $lawyer->user_email; ?></td>
        <td><?php echo $lawyer->mobile;?></td>
        <td><?php echo ($lawyer->payment == 'paid') ? "<span class='label label-success'>Paid</span>":"<span class='label label-warning'>Trail</span>"; ?></td>
        <td><?php echo ($lawyer->exp_date!='')? date('d-M-Y', strtotime($lawyer->exp_date)):''; ?></td>
        <td><?php if($lawyer->user_role!=0){$role="0";echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{ $role="2";echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
            <div class="btn-group">
                <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo URL::to_route('ActivateUser').'/'.$lawyer->id.','.$role;  ?>">
                            <?php if($lawyer->user_role!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                        </a></li>
                    <li><a href="#trail" data-toggle="modal" uid="<?php echo $lawyer->id ?>" exp_date="<?php echo ($lawyer->exp_date!='')? date('d-M-Y', strtotime($lawyer->exp_date)):''; ?>" exp_date_1="<?php echo ($lawyer->exp_date!='')? $lawyer->exp_date :''; ?>"  class="tra">Change Exp.Date</a></li>
                    <li><a href="<?php echo URL::to_route('AdminResetPassword').'/'.$lawyer->id.','.$lawyer->user_email.','.$lawyer->first_name; ?>">Reset Password</a></li>

                </ul>
            </div>
        </td>
        <td class="td-actions ">
            <div class="hidden-phone visible-desktop btn-group">

                <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditUser').'/'.$lawyer->id;  ?>">
                    <i class="icon-edit bigger-120"></i>
                </a>

                <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really Want to Delete!');" href="<?php echo URL::to_route('DeleteUser').'/'.$lawyer->id;  ?>">
                    <i class="icon-trash bigger-120"></i>
                </a>
                <a title="View" class="btn btn-mini btn-info" href="<?php echo URL::to_route('UserDetail').'/'.$lawyer->id; ?>">
                    <i class="icon-eye-open bigger-120"></i>
                </a>
                <a title="Setting" class="btn btn-mini btn-warning" href="<?php echo URL::to_route('FileHandle').'/'.$lawyer->id;  ?>">
                    <i class="icon-cog"></i>
                </a>
                <a title="Backup" class="btn btn-mini btn-warning" href="<?php echo URL::to_route('CreateBackup').'/'.$lawyer->id;  ?>">
                    <i class="icon-cloud-download"></i>
                </a>
            </div>

        </td>
    </tr>
           <?php }} ?>
                </tbody>    
            </table>
            </form>
<?php } ?>
        </div>
    </div>
    <div class="modal hide fade" id="trail" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Extend Exp.Date </h3>
        </div>
        <div class="modal-body">
            <form name="trail" action="<?php echo URL::to_route('UpdateUserStatus'); ?>"  class="form-horizontal" method="post" onsubmit="return validation();">
                <br>
                <div class="control-group">
                    <label class="control-label">ExpDate:</label>
                    <div class="controls">
                        <input type="text" id="exp_date" disabled >
                        <input type="hidden" id="exp_date_1" disabled >
                        <input type="hidden" name="id">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="years">Extend Date:</label>
                    <div class="controls">
                        <input type="text" name="year" class="cal">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="message" style="display:none">
        <form id="send_message"  onsubmit="return sendMessage();">
            <textarea name='editor1' id='editor1' class="editor1">
               
            </textarea>
        </form>
    </div>
    <script type="text/javascript">

        $(function() {
            $('.btn').tooltip({placement:'left'});
            $('span').tooltip({placement:'bottom'});
            $('a').tooltip({placement:'bottom'});
            $("#e1").select2();
            $("#e2").select2();
            $('table th input:checkbox').on('click',function(){
                var that=this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                     .each(function(){
                     this.checked=that.checked;
                     $(this).closest('tr').toggleClass('selected');
                });
            });
        });

    </script>
    <script>

            $('.cal').datepicker({
                dateFormat:'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                minDate:0
            });

    $('.tra').on('click',function(){

        var id=$(this).attr('uid');
        var exp_date=$(this).attr('exp_date');
        var exp_date_1=$(this).attr('exp_date_1');
        document.trail.id.value=id;
        document.getElementById('exp_date').value=exp_date;
        document.getElementById('exp_date_1').value=exp_date_1;
    });
    $('#send_mail').on('click',function(){
       var n=$("input:checked").length;
        if(n <= 0)
        {
            alert('Select atleast one user');
            return false;
        }
        else{
            $('#message').dialog({ 
                        minWidth: 700,
                        modal:true,
                         buttons: {
                            Close: function() {
                            $( this ).dialog( "close" );
                            },
                            Send: function(){
                                $('#send_message').submit();
                                 $( this ).dialog( "close" );
                             
                                }
                            }
                         }).fadeIn(300);
            setTimeout(function(){CKEDITOR.replace('editor1')},350);
      
        }
    });

 function sendMessage()
 {
  
     var email  = $('#send_email').serializeArray();
     var data1  = CKEDITOR.instances.editor1.getData();
         data1  = escape(data1);
     var arr    = encodeURIComponent(data1);
     $.post("<?php echo URL::to_route('SendMail'); ?>",{da:arr,email:email})
        .success(function(data){
           alert(data) ;
        })
        .error(function(xhr, textStatus, error){
            alert(xhr.statusText);
            alert(textStatus);
           alert(error) ;
        });
        return false;
 }
    </script>

         
<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>