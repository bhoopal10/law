<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Module
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Module
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>
<?php echo Section::start("contentWrapper"); ?>

    <div class="span5">
        <?php
        $status=Session::get('status');
        if(isset($status)){?>
            <div class="text-success">
                <span><?php echo $status; ?></span>
            </div>
      <?php  } ?>

        <div class="widget-box table-bordered">
            <div class="widget-header">
                <h3>Module</h3>
            </div>

            <div class="widget-body">

                <br>
                <form class="form-horizontal" action="<?php echo URL::to_route('AddModule'); ?>" method="post">
                    <input type="hidden" name="module_id" value="<?php if(isset($module)){echo $module->module_id; } ?>"/>
                    <div class="control-group">
                        <label class="control-label" for="module_name">Module:</label>
                        <div class="controls">
                            <input type="text" id="module_name" name="module_name" placeholder="Module Name" value="<?php if(isset($module)){ echo $module->module_name; } ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="test_id">Select Test:</label>
                        <div class="controls">
                            <select name="test_id" id="test_id">
                                <?php if(isset($data)){foreach($data as $test){ ?>
                                <option value="<?php echo $test->test_id; ?>"><?php echo $test->test_name; ?></option>
    <?php }} ?>
                            </select>
                        </div>
                        <br>
                        <div class="controls">
                            <button class="btn btn-primary" type="submit" > Add Module</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

<?php Section::stop() ?>
<?php echo render('admin::template.main'); ?>