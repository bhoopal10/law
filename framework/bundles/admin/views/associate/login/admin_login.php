<html>
<head><title>Admin-Authentication</title>
    <?php
    echo Asset::container('header')->styles();
    echo Asset::container('header')->scripts();
    ?>
</head>
<body>
<div class="row-fluid">
            <form class="form-horizontal" action="<?php URL::to_route('Authentication'); ?>" method="post">

                <div class="control-group">
                <br>
                    <?php
                    if(Session::has('status')){?>
                    <div class="alert">
                        <i class="icon-warning-sign"></i>
                        <?php echo Session::get('status');?>
                </div>
                <?php }?>
                    <label class="control-label" for="username">UserName</label>
                    <div class="controls">
                        <input type="text"  name="username" class="input" value="ashes.vats@gmail.com" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" id="password" name="password" value="zxcvbnm" />
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary">Login</button>
                    </div>
                </div>
            </form>
</div>
</body>
</html>