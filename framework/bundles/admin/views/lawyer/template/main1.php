<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:34 PM
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
    <?php
    echo Asset::container('header')->styles();
    echo Asset::container('header')->scripts();
    ?>
    <?php echo Section::yield('javascript'); ?>


</head>
    <?php echo Section::yield('page-header');?>
    <div class="row-fluid">
        <!--PAGE CONTENT BEGINS HERE-->
        <?php echo Section::yield('contentWrapper')?>
    </div><!--/row-->
</div><!--/#page-content-->
<?php
echo Asset::container('footer')->scripts();
echo Asset::container('footer')->styles();
?>
<?php echo Section::yield('javascript-footer');?>
</body>
