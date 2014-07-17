<?php $image=liblawyer::getimage();?>
<div class="navbar navbar-inverse navbar-fixed-top">
<div class="navbar-inner">
<div class="container-fluid"  style="background-color: #448FB9 ">
<a href="#" class="brand">
    <small>
        <i class="icon-legal"></i>

        <?php if(Auth::check()){ $roles=libRole::getRole(Auth::user()->user_role); $role=$roles->role_name; echo $role;}?>
    </small>
</a><!--/.brand-->

<ul class="nav ace-nav pull-right">
<li class="pull-right light-blue user-profile" style="float: right">
    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
        <?php $image=liblawyer::getimage(); ?>
        <img class="nav-user-photo" src=" <?php if(isset($image)){if($image->image){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->image;}}else{ echo Config::get('application.url').'img/index.jpg';} ?>" alt="" style="width: 50px;height:40px" />
								<span id="user_info">
									<small>Welcome,</small>
                                    <?php if(Auth::check()){ echo Auth::user()->first_name;} ?>
								</span>

        <i class="icon-caret-down"></i>
    </a>

    <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
        <li>
            <a href="<?php echo URL::to_route('Setting');  ?>">
                <i class="icon-cog"></i>
                Settings
            </a>
        </li>
        <li class="divider"></li>

        <li>
            <a href="<?php echo URL::to_route('Logout'); ?>">
                <i class="icon-off"></i>
                Logout
            </a>
        </li>
    </ul>
</li>
</ul><!--/.ace-nav-->
</div><!--/.container-fluid-->
</div><!--/.navbar-inner-->
</div>
