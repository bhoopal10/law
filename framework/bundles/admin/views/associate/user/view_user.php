<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
                Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Lawyers
                </small>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert-success">
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
    <div class="row-fluid">

        <?php $contact=libcontact::getcontact();  ?>
        <div class="span12">
            <a href="<?php echo URL::to_route('User'); ?>">
                <button class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new Lawyer</button>
            </a>

            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Lawyer Name</th>
                    <th>Lawyer ID</th>
                    <th>Lawyer Specialist</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <?php if(isset($user)){ foreach($user as $lawyer){if($lawyer->updated_by==Auth::user()->id){?>
                <tr class="">
                    <td><?php echo $lawyer->first_name; ?></td>
                    <td><?php echo $lawyer->lawyer_id; ?></td>
                    <td><?php echo $lawyer->lawyer_subject;  ?></td>
                    <td><?php echo $lawyer->user_email; ?></td>
                    <td><?php echo $lawyer->mobile;?></td>
                    <td><?php if($lawyer->user_role!=NULL){$role="0";echo "Active";}else{ $role="3";echo "Pending";}  ?></td>
                    <td class="td-actions ">
                        <div class="hidden-phone visible-desktop btn-group">

                            <a class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditUser').'/'.Crypter::encrypt($lawyer->id);  ?>">
                                <i class="icon-edit bigger-120"></i>
                            </a>

                            <a class="btn btn-mini btn-danger" onclick="return confirm('Really Want to Delete!');" href="<?php echo URL::to_route('DeleteUser').'/'.Crypter::encrypt($lawyer->id);  ?>">
                                <i class="icon-trash bigger-120"></i>
                            </a>

                            <a class="btn btn-mini btn-warning" href="<?php echo URL::to_route('ActivateUser').'/'.Crypter::encrypt($lawyer->id).','.Crypter::encrypt($role);  ?>">
                                <?php if($lawyer->user_role!=NULL){ ?><i class="icon-unlock"></i><?php }else{?> <i class="icon-lock"></i> <?php } ?>
                            </a>
                        </div>

                    </td>
                </tr>
                <?php }} }?>

                </tbody>
            </table>

        </div>
    </div>
    <script type="text/javascript">
        $(function() {

        });
    </script>

<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>