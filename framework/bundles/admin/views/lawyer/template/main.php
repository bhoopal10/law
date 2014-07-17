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
    <?php echo render('admin::lawyer/components.navbar'); ?>

    <a id="menu-toggler" href="#"> <span></span></a>
    <?php echo render('admin::lawyer/components.sidebar');?>

    <div id="main-content" class="clearfix" style="margin-top: 0px">
    <?php $profile=liblawyer::lawyerprofile(); if($profile->payment=='trail'){ ?>

    <div id="breadcrumbs1" style="margin-top: 46px" class="hidden-print">
        <ul class="breadcrumb">
            <li>
                <a href="#"><?php
                    libExpdate::getExpDateByUSerID(Auth::user()->id, '10');
                    $current_date = new DateTime(date('Y-m-d'));
                    $exp_date=new DateTime($profile->exp_date);
                    $interval = $current_date->diff($exp_date);
                    // %a will output the total number of days.
                    $count=$interval->format('%R');
                    echo ($count == '-')? '<h3 style="color:red">Your account as been expired please contact (9845554820)  </h3>':'<h3 style="color:red">'.ucfirst($interval->format('%d days Trail Pack')).'</h3>'; ?>
                    </a>
              <span class="divider">
 
              </span>
            </li>
            <li class="active"></li>
        </ul><!--.breadcrumb-->

    </div>
    <?php }else{  ?>
    <div style="margin-top: 46px" class="hidden-print">
        

    </div>
        <?php  $exp=libExpdate::getExpDateByUSerID(Auth::user()->id, '10'); if($exp){ ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
            <i class="icon-animated-vertical"><?php echo $exp." Day(s) to Expire your account";  ?></i>
            
        </div>
    <?php }}  ?>






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
