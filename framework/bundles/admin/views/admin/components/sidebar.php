<div id="sidebar" style="margin-top: 46px" class="hidden-print">
    <div id="sidebar-shortcuts">
        <div id="sidebar-shortcuts-large">
        <a class="btn btn-small btn-warning" href="<?php echo URL::to_route('Home'); ?>">
                <i class="icon-dashboard"></i>
            </a>
            <a class="btn btn-small btn-success" href='<?php echo URL::to_route('ViewUser'); ?>'>
                <i class="icon-group"></i>
            </a>

            <a class="btn btn-small btn-info" href='<?php echo URL::to_route('ListDocuments'); ?>'>
                <i class="icon-file-alt"></i>
            </a>

             <a class="btn btn-small btn-danger" href="<?php echo URL::to_route('AssignUserPermission'); ?>">
                <i class="icon-cogs"></i>
            </a>
        </div>

        <div id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!--#sidebar-shortcuts-->

    <ul class="nav nav-list">
        <li class="active">
            <a href="<?php echo URL::to_route('Home'); ?>">
                <i class="icon-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-group"></i>
                        <span>Lawyers</span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">


                        <li>
                            <a href="<?php echo URL::to_route('User') ?>">
                                <i class="icon-plus"></i>
                                Add Lawyer
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo URL::to_route('ViewUser') ?>">
                                <i class="icon-plus"></i>
                                View Lawyer
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo URL::to_route('AssignUserPermission'); ?>">
                                <i class="icon-plus"></i>
                                 Lawyer Permission
                            </a>
                        </li>

                    </ul>
                 </li>
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="icon-file-alt"></i>
                <span>Documents</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">

                <li>
                    <a href="<?php echo URL::to_route('ListDocuments'); ?>">
                        <i class="icon-plus"></i>
                        List Documents
                    </a>
                </li>

            </ul>
        </li>
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="icon-envelope-alt"></i>
                <span>SMS</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">

                <li>
                    <a href="#">
                        <i class="icon-plus"></i>
                        Inbox
                    </a>
                </li>

            </ul>
        </li>

</ul>
    <div id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
    </div>


            <!--/.nav-list-->

