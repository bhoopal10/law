<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/18/14
 * Time: 9:16 PM
 */
echo Section::start('page-header');
?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Settings
                <small>
                    <i class="icon-double-angle-right"></i>
                    Permission
                    <i class="icon-double-angle-left"></i>
                    <a href="<?php echo URL::to_route('ViewUser'); ?>" >Back</a>
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');  ?>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
if(isset($error)){ ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php }?>
    <div class="row-fluid">
        <?php
        $lawyer_id=liblawyer::getlawyerIDByassociateID($id);
        $case2=libcase::getAssociateCasePermissionByAssID($id);
        $cases=libcase::getCaseByLawyerID($lawyer_id->uid2);
        $ass_id=libcase::getCaseByLawyerIDPaginate($lawyer_id->uid2);
        //    print_r($ass_id);exit;
        $ass_name=liblawyer::getlawyername(); ?>

        <div class="span5"></div>
        <div class="span6">
            <form name="form2" action="<?php echo URL::to_route('UserCasePermissionSearch'); ?>" method="get">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="case_id" id="case_id" style="width: 220px" onchange='this.form.submit()'>
                    <option value="">Search By CaseNo.</option>
                    <?php if(isset($_GET['case_id'])){$case_id=$_GET['case_id'];if($case_id){ ?>
                        <option value="<?php echo $case_id; ?>" selected><?php $name=libcase::getcasedetailByID($case_id);echo $name->case_no; ?></option>
                    <?php } }?>
                    <?php if(isset($cases)){foreach($cases as $values){?>
                        <option value="<?php echo $values->case_id; ?>"><?php echo $values->case_no; ?></option>
                    <?php }} ?>
                </select>
            </form>
        </div>

        <div class="span5">

            <form action="<?php echo URL::to_route('UpdateUserCasePermission')  ?>" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="associate_id">Associate Lawyer:</label>
                    <div class="controls">
                        <input type="text" value="<?php echo ucfirst(get_value_from_multi_object_array($id, $ass_name, 'id', 'first_name')); ?>" style="border: none;color:black;font-weight: bold" disabled="disabled">
                        <input type="hidden" value="<?php echo $id; ?>" name="ass_id">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="permission">Permission</label>
                    <div class="controls">
                        <label>
                            <input type="radio" value="0" name="permission"/>
                            <span class="lbl">Not visible</span>
                        </label>
                        <label>
                            <input type="radio" value="1" name="permission"/>
                            <span class="lbl">Read</span>
                        </label>
                        <label>
                            <input type="radio" value="2" name="permission"/>
                            <span class="lbl">Read & Write</span>
                        </label>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary" type="submit">Assign</button>

                    </div>
                </div>

        </div>
        <div class="span5">

            <table class="table table-bordered table-straped">
                <thead class="table-header">
                <tr>
                    <th> <label><input type="checkbox"><span class="lbl"></span></label></th>
                    <th>Case Name</th>
                    <th>Invisible</th>
                    <th>Read</th>
                    <th>Read & Write</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($case) && isset($ass_id)){ foreach($case as $case1){  ?>
                    <tr>
                        <td> <label><input name="case_id[]" type="checkbox" value="<?php echo $case1->case_id; ?>"><span class="lbl"></span></label></td>
                        <td><?php echo ucfirst($case1->case_no); ?></td>
                        <?php $permission = get_value_with_2compare_from_multi_object_array($id, $case1->case_id,$case2,'uid','case_id','permission'); ?>
                        <td><?php if(isset($permission)){echo $permission==0 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>"; } ?></td>
                        <td><?php if(isset($permission)){echo $permission==1 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>";} ?></td>
                        <td><?php if(isset($permission)){echo $permission==2 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>"; }?></td>
                    </tr>
                <?php } }?>
                </tbody>
            </table>

            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $('table th input:checkbox').on('click' , function(){
                var that = this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function(){
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });

            });
        });
        $(document).ready(function(){
            $('#case_id').select2();
        });
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>