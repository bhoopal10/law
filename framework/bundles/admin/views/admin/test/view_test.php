<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Test
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Test
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>

<?php echo Section::start('contentWrapper'); ?>

<div class="span12">
    <?php $status=Session::get('status');
    if(isset($status)){ ?>
        <div class="success text-success">
            <span><?php echo $status; ?></span>
        </div>
    <?php }?>
    <div>
            <h3>View Tests</h3>
        </div>
        <div>
        <table class="table-bordered table-striped" style="width:100%">
            <thead class="table-header">
<tr>

            <th>Test Id</th>
            <th>Test Name</th>
            <th>Total marks</th>
            <th></th>
</tr>
            </thead>
            <?php if(isset($test)){
             foreach($test as $data){
                 ?>

            <tr>

                <td><?php echo $data->test_id; ?></td>
                <td><?php echo $data->test_name; ?></td>
                <td><?php echo $data->test_total_marks; ?></td>
                <td><a href="<?PHP echo URL::to_route('TestEdit').'/'.$data->test_id; ?>"><i class="icon-1x icon-edit"></i>Edit</a> / <a href="<?php echo URL::to_route('TestDelete').'/'.$data->test_id; ?>"><i class="icon-1x icon-trash"></i>Delete</a></td>
            </tr>
                 <?php } } ?>

        </table>
        </div>
    </div>
</div>

<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>