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
    <li class="purple">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

        <span class="badge badge-important"><?php
            $law_id=liblawyer::getlawyerIDByassociateID(Auth::user()->id);
            $appointment_notification=libnotification::getunreadnotification_ass_appointment('*',$law_id->uid2);
            $user_name=liblawyer::getlawyer();
            $user=array();
            foreach($user_name as $uname)
            {
                array_push($user,(array)$uname);
            }
            $total=count($appointment_notification );
            echo $total;
            ?>
        </span>
            <?php if($total>0){ ?>
                <i class="icon-time icon-only "></i>
            <?php }else{ ?>
                <i class="icon-time icon-only "></i>
            <?php } ?>
        </a>

        <ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-closer">
            <li class="nav-header">
                <?php echo $total."&nbsp;&nbsp;Notifications";  ?>
            </li>
            <?php foreach($appointment_notification as $notifications){ ?>
                <li>
                    <a href="<?php echo URL::to_route('ReadNotification').'/'.$notifications->notification_id.','.$notifications->event_id;  ?>">
                        <div class="clearfix">
                        <span class="pull-left">
                                <i class="btn btn-mini no-hover btn-pink icon-briefcase"></i>
                            <?php  echo $notifications->text; ?>
                        </span>
                        </div>
                    </a>
                </li>
            <?php }  ?>
        </ul>
    </li>

<li class="green">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="icon-envelope-alt icon-only icon-animated-vertical"></i>
        <span class="badge badge-success">
            <?php $m_notification=libnotification::getunreaadnotification('@'); echo count($m_notification);
            $user_name=liblawyer::getlawyer();
            $user=array();
            foreach($user_name as $uname)
            {
                array_push($user,(array)$uname);
            }
            ?>
            </span>
    </a>

    <ul class="pull-right dropdown-navbar dropdown-menu dropdown-caret dropdown-closer">
        <li class="nav-header">
            <i class="icon-envelope"></i>
            <?php echo count($m_notification)."&nbsp;&nbsp;Message(s)"; ?>
        </li>
<?php foreach($m_notification as $m_notifications){ ?>
          <li>
              <?php $user_image=liblawyer::getimagebyID($m_notifications->uid2); ?>
            <a href="<?php echo URL::to_route('ReadNotification').'/'.$m_notifications->notification_id.','.$m_notifications->event_id;  ?>">
<!--                <img src="--><?php //echo ($user_image->image) ? Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$user_image->image : Config::get('application.url').Config::get('admin::admin_config.image_path').'images/index.jpg'; ?><!--" class="msg-photo" alt="image" />-->
                    <span class="msg-body">
                        <span class="msg-title">
                            <span class="blue"><?php echo ucfirst(get_value_from_array($m_notifications->uid2,$user,'id','first_name')); ?>:</span>
                             <?php  echo $m_notifications->text;?>
                        </span>

                        <span class="msg-time">
                            <i class="icon-time"></i>
                            <span><?php echo date('d-M H:i',strtotime($m_notifications->created_date)); ?></span>
                        </span>
                    </span>
            </a>
        </li>
<?php } ?>
        <li>
            <a href="<?php echo URL::to_route('Inbox'); ?>">
                See all messages
                <i class="icon-arrow-right"></i>
            </a>
        </li>
        </ul>
        

<li class="light-blue user-profile">
    <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
        <?php $image=liblawyer::getimage();  ?>
        <img class="nav-user-photo" src=" <?php if($image->image){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->image;}else{ echo Config::get('application.url').'img/index.jpg';} ?>" alt="<?php $image->image;  ?>" />
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
