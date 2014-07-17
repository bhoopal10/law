<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrator</title>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo URL('/'); ?>css/font-awesome-ie7.css" />
    <![endif]-->

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo URL('/'); ?>css/ace.min-ie8.css" />

    <![endif]-->
    <!--[if lte IE 9]>
    <script src="<?php echo URL('/'); ?>bundles/admin/js/html5shiv.js"></script>
    <script src="<?php echo URL('/'); ?>bundles/admin/js/respond.min.js"></script>

    <script src="http://code.jquery.com/jquery-1.6.4.js"></script>
    <![endif]-->
    <?php
    echo Asset::container('header')->styles();
    echo Asset::container('header')->scripts();
    ?>
    <?php echo Section::yield('javascript'); ?>


</head>

<body class="skin-2">
<?php echo render('admin::admin/components.navbar'); ?>
<a id="menu-toggler" href="#"> <span></span></a>
 <?php echo render('admin::admin/components.sidebar');?>

<!-- End Sidebar -->

<div id="main-content" class="clearfix">
    <div  style="margin-top: 46px">
        

    </div>



    <?php echo Section::yield('page-header');?>
    <div class="row-fluid">
        <!--PAGE CONTENT BEGINS HERE-->
        <?php echo Section::yield('contentWrapper')?>
    </div><!--/row-->
</div><!--/#page-content-->

<!--[if !IE] -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo URL::to('/'); ?>bundles/admin/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo URL::to('/'); ?>bundles/admin/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<?php
echo Asset::container('footer')->scripts();
echo Asset::container('footer')->styles();
?>
<?php echo Section::yield('javascript-footer');?>
</body>
