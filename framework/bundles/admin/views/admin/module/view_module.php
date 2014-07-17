<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Module
                <small>
                    <i class="icon-double-angle-right"></i>
                   View Modules
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper'); ?>

    <div class="span5">
        <?php
        $status=Session::get('status');
        if(isset($status)){?>
            <div class="text-success">
                <span><?php echo $status; ?></span>
            </div>
        <?php  } ?>
        <div class="widget-box">
            <div class="widget-header">
                <h3>View Modules</h3>
            </div>
            <div class="widget-body">
                <table class="table-bordered" style="width:100%">
                    <thead class="table-header">
                    <th>Module Id</th>
                    <th>Module Name</th>
                    <th>Test Id</th>
                    <th></th>
                    </thead>
                    <?php if(isset($data)){
                        foreach($data as $module){
                         ?>

                    <tr>
                        <td><?php echo $module->module_id; ?></td>
                        <td><?php echo $module->module_name; ?></td>
                        <td><?php echo $module->test_id; ?></td>
                        <td><a href="<?php echo URL::to_route('EditModule').'/'.$module->module_id; ?>"><i class="icon-2x icon-edit-sign"></i>Edit</a> | <a href="<?php echo URL::to_route('DeleteModule').'/'.$module->module_id; ?>"><i class="icon-2x icon-trash"></i>Delete</a></td>
                    </tr>
                    <?php } } ?>

                </table>
            </div>
        </div>
    </div>

<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>