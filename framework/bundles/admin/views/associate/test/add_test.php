<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Test
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Test
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>

<?php echo Section::start("contentWrapper"); ?>
<?php $status=Session::get('status');
if(isset($status)){ ?>
<div class="well">
<span><?php echo $status; ?></span>
</div>
    <?php }?>
<div class="span5">
    <div class="widget-box table-bordered">
    <div class="widget-header">
        <h3>Test</h3>
    </div>

    <div class="widget-body">

            <br>

    <form class="form-horizontal" action="<?php echo URL::to_route('AddTest'); ?>" method="post">
        <input type="hidden" name="test_id" value="<?php if(isset($test)){ echo $test->test_id;} ?>" />
        <div class="control-group">
            <label class="control-label" for="test_name">Test Name:</label>
            <div class="controls">
                <input type="text" id="test_name" name="test_name" placeholder="Test Name" value="<?php if(isset($test)){ echo $test->test_name;} ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="total_marks">Total Marks</label>
            <div class="controls">
                <input type="text" id="total_marks" name="total_marks" placeholder="total marks" value="<?php if(isset($test)){ echo $test->test_total_marks;} ?>"/>
            </div>
            <br>
            <div class="controls">
                <?php if(isset($test)){?>
                    <button class="btn btn-primary" type="submit" > Update Test</button>
                <?php }else{ ?>
                <button class="btn btn-primary" type="submit" > Add Test</button>
    <?php }?>
            </div>
        </div>
    </form>
</div>

</div>
</div>

<?php Section::stop() ?>
<?php echo render('admin::template.main'); ?>