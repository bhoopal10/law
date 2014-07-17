<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case
                <small>
                    <i class="icon-double-angle-right"></i>
                    Cases Permission
                    <i class="icon-double-angle-right"></i>
                    <a href="<?php echo URL::to_route('ViewCases'); ?>">View Cases</a>
                    <i class="icon-double-angle-right"></i>
                    <span style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
if(isset($error)){ ?>
    <div class="alert alert-alerts">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php } ?>
<?php $id=$id; $ass_id=libcase::getassociateIDBycaseID($id);$ass_name=liblawyer::getlawyername();$associate=liblawyer::getassociateIDByLawyerID(Auth::user()->id);
$case=libcase::getcasedetailByID($id);
$ass_paginate=$associate1;
//    echo "<pre>";
//    print_r($ass_paginate);exit;
?>
    <div class="row-fluid">

        <div class="span5"></div>
        <div class="span7">
            <form name="form2" action="<?php echo URL::to_route('CasePermissionSearch'); ?>" method="get">
                <input type="hidden" name="case_id" value="<?php echo $id; ?>">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="id" id="ass_id" style="width: 220px" onchange='this.form.submit()'>
                    <option value="">Search By Associate</option>
                    <?php if(isset($_GET['id'])){$associate_id=$_GET['id'];if($associate_id){ ?>
                        <option value="<?php echo $associate_id; ?>" selected><?php $name=liblawyer::getUserByID($associate_id);echo $name->first_name; ?></option>
                    <?php } }?>
                    <?php if(isset($associate)){foreach($associate as $associates){?>
                        <option value="<?php echo $associates->id; ?>"><?php echo $associates->first_name; ?></option>
                    <?php }} ?>
                </select>
            </form>
        </div>
        <div class="span5">

            <form action="<?php echo URL::to_route('UpdateCasePermission')  ?>" method="post" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="associate_id">Case No:</label>

                    <div class="controls">
                        <b> <?php echo $case->case_no; ?></b>
                        <input type="hidden" name="case_id" value="<?php echo $id; ?>">
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
                        <th class="left" style="width: 20px">
                            <label>
                                <input type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Associate</th>
                        <th>Invisible</th>
                        <th>Read</th>
                        <th>Read & Write</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($ass_paginate as $ass){  ?>
                        <tr>
                            <td class="left">
                                <label>
                                    <input type="checkbox" name="associate_id[]" value="<?php echo $ass->id; ?>">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo ucfirst($ass->first_name); ?></td>
                            <?php $ids=$ass->id; $permission=get_value_with_2compare_from_multi_object_array($ids,$id,$ass_id,'uid','case_id','permission'); ?>
                            <td><?php if(isset($permission)){echo $permission==0 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>"; } ?></td>
                            <td><?php if(isset($permission)){echo $permission==1 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>";} ?></td>
                            <td><?php if(isset($permission)){echo $permission==2 ? "<i class='icon-check'></i>":"<i class='icon-check-empty'></i>";}else{ echo "<i class='icon-check-empty'></i>"; }?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#ass_id').select2();
        });
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>