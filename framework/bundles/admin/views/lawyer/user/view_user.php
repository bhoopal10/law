<?php echo Section::start('contentWrapper');?>
<script src="<?php echo Config::get('application.url').Config::get('admin::admin_config.ckeditor').'ckeditor.js';  ?>"></script>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
            <i class="icon icon-group"></i>
                Associates
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Associates
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
        <span><?php echo $status; ?></span>
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
    </div>
<?php }?>
    <div class="row-fluid">

        <?php $contact=libcontact::getcontact();
//        echo "<pre>";print_r($user);exit;
        ?>
        <div class="span12">
            <a href="<?php echo URL::to_route('User'); ?>">
                <button title="Add new Associate" class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new Associate</button>
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
                    <th>Subject</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $search=Session::get('search'); if (!isset($search)) { ?>
                <?php if(isset($user)){ $i=1; foreach($user->results as $lawyer){?>
                <tr class="">
                    <td class="left">
                            <label>
                                <input type="checkbox" name="email[]" value="<?php echo $lawyer->user_email; ?>">
                                <span class="lbl"></span>
                            </label>
                    </td>
                    <td><?php $page=$user->page-1;$total=$user->per_page*$page; echo $i+$total;$i++; ?></td>
                    <td><?php echo $lawyer->first_name; ?></td>
                    <td><?php echo $lawyer->username; ?></td>
                    <td><?php echo $lawyer->lawyer_subject;  ?></td>
                    <td><?php echo $lawyer->user_email; ?></td>
                    <td><?php echo $lawyer->mobile;?></td>
                    <td><?php if($lawyer->user_role!=0){$role="0";echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{ $role="3";echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                        <div class="btn-group">
                            <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo URL::to_route('ActivateUser').'/'.$lawyer->id.','.$role;  ?>">
                                        <?php if($lawyer->user_role!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                </a></li>
                            </ul>
                        </div>
                    </td>
                    <td><a href="<?php echo URL::to_route('UserCasePermission').'/'.$lawyer->id; ?>" class="btn btn-mini btn-info">Permission</a> </td>
                    <td class="td-actions ">
                        <div class=" btn-group">

                            <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditUser').'/'.$lawyer->id;  ?>">
                                <i class="icon-edit bigger-120"></i>
                            </a>

                            <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really Want to Delete!');" href="<?php echo URL::to_route('DeleteUser').'/'.$lawyer->id;  ?>">
                                <i class="icon-trash bigger-120"></i>
                            </a>

<!--                            <a title="Permission" class="btn btn-mini btn-warning" href="--><?php //echo URL::to_route('ActivateUser').'/'.Crypter::encrypt($lawyer->id).','.Crypter::encrypt($role);  ?><!--">-->
<!--                                --><?php //if($lawyer->user_role!=0){ ?><!--<i class="icon-unlock"></i>--><?php //}else{?><!-- <i class="icon-lock"></i> --><?php //} ?>
<!--                            </a>-->
                            <a title="View" class="btn btn-mini btn-info" href="<?php echo URL::to_route('UserDetail').'/'.$lawyer->id; ?>">
                                <i class="icon-eye-open bigger-120"></i>
                            </a>
                        </div>

                    </td>
                </tr>
                <?php }} }else{?>
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
                            <td><?php echo $lawyer->username; ?></td>
                            <td><?php echo $lawyer->lawyer_subject;  ?></td>
                            <td><?php echo $lawyer->user_email; ?></td>
                            <td><?php echo $lawyer->mobile;?></td>
                            <td><?php if($lawyer->user_role!=0){$role="0";echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Activated&nbsp;&nbsp;&nbsp;</span>';}else{ $role="3";echo '<span class="label label-large label-success" style="3px 8px 7px">Not activated</span>';}  ?>
                                <div class="btn-group">
                                    <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                        Action
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo URL::to_route('ActivateUser').'/'.$lawyer->id.','.$role;  ?>">
                                                <?php if($lawyer->user_role!=0){ ?><span>Deactivate</span><?php }else{?> <span>Activate</span> <?php } ?>
                                            </a></li>
                                    </ul>
                                </div>
                            </td>
                            <td><a href="<?php echo URL::to_route('UserCasePermission').'/'.$lawyer->id; ?>" class="btn btn-mini btn-info">Permission</a> </td>
                            <td class="td-actions ">
                                <div class="hidden-phone visible-desktop btn-group">

                                    <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditUser').'/'.$lawyer->id;  ?>">
                                        <i class="icon-edit bigger-120"></i>
                                    </a>

                                    <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really Want to Delete!');" href="<?php echo URL::to_route('DeleteUser').'/'.$lawyer->id;  ?>">
                                        <i class="icon-trash bigger-120"></i>
                                    </a>

                                    <!--                            <a title="Permission" class="btn btn-mini btn-warning" href="--><?php //echo URL::to_route('ActivateUser').'/'.Crypter::encrypt($lawyer->id).','.Crypter::encrypt($role);  ?><!--">-->
                                    <!--                                --><?php //if($lawyer->user_role!=0){ ?><!--<i class="icon-unlock"></i>--><?php //}else{?><!-- <i class="icon-lock"></i> --><?php //} ?>
                                    <!--                            </a>-->
                                    <a title="View" class="btn btn-mini btn-info" href="<?php echo URL::to_route('UserDetail').'/'.$lawyer->id; ?>">
                                        <i class="icon-eye-open bigger-120"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                <?php }}} ?>

                </tbody>
                </form>
            </table>
            <?php echo $user->links(); ?>
        </div>
    </div>
    <div id="message_div" style="display:none">
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
       
        $('#send_mail').on('click',function(){
        var n=$("input:checked").length;
        if(n <= 0)
        {
            alert('Select atleast one user');
            return false;
        }
        else{
            $('#message_div').dialog({ 
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
<?php echo render('admin::lawyer/template.main'); ?>