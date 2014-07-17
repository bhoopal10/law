<html>
<head><title>Admin-Authentication</title>
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
<div class="container-fluid" id="main-container">
    <div id="main-content">
        <div class="row-fluid">
            <div class="span12">
                <div class="login-container">
                    <div class="row-fluid">
                        <div class="center">
                            <h1>
                                <i class="icon-legal"></i>
                                <span class="white">Lawyerz</span>
                            </h1>
                            <h4 class="blue">Login</h4>
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
                                            Please Enter Your Information

                                        </h4>

                                        <div class="space-6"></div>

                                        <form action="<?php URL::to_route('Authentication');  ?>" method="post">
                                            <fieldset>
                                                <label>
															<span class="block input-icon input-icon-right">
																<input type="text" name="username" class="span12" placeholder="Username" />
																<i class="icon-user"></i>
															</span>
                                                </label>

                                                <label>
															<span class="block input-icon input-icon-right">
																<input type="password" name="password" class="span12" placeholder="Password" />
																<i class="icon-lock"></i>
															</span>
                                                </label>




                                                <div class="row-fluid">
                                                    <label class="span8">
                                                        <input type="checkbox" class="span1" />
                                                        <span class="lbl"> Remember Me</span>
                                                    </label>

                                                    <button class="span4 btn btn-small btn-primary" type="submit">
                                                        <i class="icon-key"></i>
                                                        Login
                                                    </button>
                                                </div>
                                                <div class="row-fluid">
                                                    <span>Forget Password ? <a href="<?php echo URL::to_route('ForgetPassword'); ?>">Click Here</a></span>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>

                                    <div class="row-fluid">
                                        <?php
                                        if(Session::has('status')){?>

                                            <div class="alert alert-info">
                                                <i class="icon-animated-vertical">
                                                <?php echo Session::get('status');?>
                                                </i>
                                            </div>

                                        <?php }
                                        elseif(Session::has('error')){?>
                                            <div class="alert alert-danger">
                                                <i class="icon-animated-vertical">
                                                <?php echo Session::get('error');?>
                                                </i>
                                            </div>
                                        <?php }?>
                                    </div>
</body>
</html>