<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>
            User
            <small>
                <i class="icon-double-angle-right"></i>
                Add Role
            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <span><?php echo $status; ?></span>
    </div>
<?php } ?>
<div class="span5">
    <h4>Add role</h4>

    <form class="form-horizontal" action="<?php echo URL::to_route('AddRole'); ?>" method="post">
        <div class="control-group">
            <label class="control-label" for="role">Role Name</label>
            <div class="controls">
                <input type="text" name="role" id="role"/>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit">Add Role</button>
            </div>
        </div>

    </form>

</div>
<div class="span5">
    <h4>Assign Role</h4>
    <form class="form-horizontal" action="<?php echo URL::to_route('AssignRole'); ?>" method="post">
        <div class="control-group">
            <label class="control-label" for="user">Select User</label>
            <div class="controls">
                <select name="user_id" id="user">
                    <option value="">Select User</option>
                    <?php if(isset($user)){foreach($user as $data){?>
                        <option value="<?php echo $data->user_id; ?>"><?php echo $data->user_fname; ?></option>
                    <?php }} ?>
                </select>
            </div>
        </div>
        <div class="control-group">
        <div class="controls">
            <?php if(isset($role_id)){foreach($role_id as $role){?>
            <label for="<?php echo $role->role_id; ?>">
                <input type="checkbox" name="role_id[]" id="<?php echo $role->role_id; ?>" value="<?php echo $role->role_id; ?>"/>
                <span class="lbl"><?php echo $role->role_name; ?></span>

            </label>
            <?php }} ?>
        </div>
</div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit">Add Role</button>
            </div>
        </div>

    </form>
</div>
<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>

