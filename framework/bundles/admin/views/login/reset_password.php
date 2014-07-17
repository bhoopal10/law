<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 3/11/14
 * Time: 12:47 PM
 */ ?>
<html>
<head><title>Reset Password</title>
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/font-awesome-ie7.min.css" />
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <style>
        body{
            margin-top: 20px !important;
            margin-left: 400px !important;

        }
    </style>
    <![endif]-->

    <!--[if lte IE 8]>
    <style>
        body{
            padding-top: 20px;;
            padding-left: 450px;
        }
    </style>
    <link rel="stylesheet" href="css/ace-ie.min.css" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <?php
    echo Asset::container('header')->styles();
    echo Asset::container('header')->scripts();
    ?>
</head>
<body class="login-layout">
<div class="login-layout">
<div class="container-fluid" id="main-container">
    <div id="main-content">
        <div class="row-fluid">
            <div class="span12">
                <div class="login-container">
                    <div class="row-fluid">
                        <div class="center">
                            <h1>
                                <a href="<?php echo URL::to('/'); ?>">
                                <i class="icon-legal"></i>
                                <span class="white">Lawyerz</span>
                                    </a>
                            </h1>
                            <h4 class="blue">Reset Password</h4>
                        </div>
                    </div>

                    <div class="space-6"></div>

                    <div class="row-fluid">
                        <div class="position-relative">
                            <div id="login-box" class="visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="icon-coffee green"></i>
                                            Please Enter Your Email

                                        </h4>

                                        <div class="space-6"></div>

                                        <form action="<?php echo URL::to_route('ResetPassword');  ?>" method="post">
                                            <fieldset>
                                                <div class="row-fluid">
                                                <label>
															<span class="block input-icon input-icon-right">
																<input type="text" name="email" class="span12" placeholder="Email" />
																<i class="icon-user"></i>
															</span>
                                                </label>

                                                    </div>
                                                <div class="row-fluid">
                                                       <button class="span12 btn btn-small btn-primary" type="submit">
                                                        <i class="icon-refresh"></i>
                                                        Reset
                                                    </button>
                                                </div>

                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="row-fluid">
                                        <?php
                                        if(Session::get('status')){?>

                                            <div class="alert alert-info">
                                                <i class="icon-animated-vertical">
                                                <?php echo Session::get('status');?>
                                                </i>
                                            </div>

                                        <?php }
                                        elseif(Session::get('error')){?>

                                            <div class="alert alert-danger">
                                                <i class="icon-animated-vertical">
                                                <?php echo Session::get('error');?>
                                                </i>
                                            </div>

                                        <?php }?>
                                    </div>

  </div>

</body>
</html>