
<?php echo Section::start('page-header') ?>

    <?php
$status=Session::get('status');
    if(isset($status))
    {?>
        <div class="alert">
            <i class="icon-warning-sign"></i>
      <?php  echo $status; ?>
        </div>
        <?php } ?>

<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>