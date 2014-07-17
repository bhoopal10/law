<div id="sidebar" style="position: fixed;margin-top: 46px">
    <div id="sidebar-shortcuts">
        <div id="sidebar-shortcuts-large">
         <a class="btn btn-small btn-danger" href="<?php echo URL::to_route('Home'); ?>">
                <i class="icon-dashboard"></i>
            </a>
            <a class="btn btn-small btn-success" href="<?php echo URL::to_route('ViewClient'); ?>">
                <i class="icon-user"></i>
            </a>

            <a class="btn btn-small btn-info" href="<?php echo URL::to_route('ViewCases'); ?>">
                <i class="icon-briefcase"></i>
            </a>

            <a class="btn btn-small btn-warning" href="<?php echo URL::to_route('ViewHearing'); ?>">
                <i class="icon-bell"></i>
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
        <li id="cases">
            <a href="#" class="dropdown-toggle">
                <i class="icon-briefcase"></i>
                <span>Cases</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Cases'); ?>">
                        <i class="icon-plus"></i>
                        Add Case
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewCases'); ?>">
                        <i class="icon-plus"></i>
                        View Cases
                    </a>
                </li>
            </ul>
        </li>
        <li id="hearing">
            <a href="#" class="dropdown-toggle">
                <i class="icon-bell"></i>
                <span>Hearing</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Hearing'); ?>">
                        <i class="icon-plus"></i>
                        Add Hearing
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewHearing'); ?>">
                        <i class="icon-plus"></i>
                        View Hearing
                    </a>
                </li>
                 <li>
                    <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d') ?>">
                        <i class="icon-plus"></i>
                        Today Hearings
                    </a>
                </li>
                 <li>
                    <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y'))); ?>">
                        <i class="icon-plus"></i>
                        Tomorrow Hearing
                    </a>
                </li>

            </ul>
        </li>
        <li id="client_side">
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span>Clients</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('CreateClient'); ?>">
                        <i class="icon-plus"></i>
                        Create client
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewClient'); ?>">
                        <i class="icon-plus"></i>
                        View client
                    </a>
                </li>
            </ul>
        </li>
        <li id="message">
            <a href="#" class="dropdown-toggle">
                <i class="icon-envelope"></i>
                <span>Message</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('CreateMessage');  ?>">
                        <b class="icon-plus-sign"></b>
                        <span>Create message</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('Inbox');  ?>">
                        <i class="icon-inbox"></i>
                        <span>Inbox</span>

                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('Sentbox');  ?>">
                        <i class="icon-inbox"></i>
                        <span>Sentbox</span>

                    </a>
                </li>
            </ul>
        </li>
        <li id="appointment">
            <a href="#" class="dropdown-toggle" dt="ff">
                <i class="icon-time"></i>
                <span>Appointment</span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('ViewAppointment'); ?>">
                        <i class="icon-plus"></i>
                        View Appointment
                    </a>
                </li>
            </ul>
        </li>
        <li  style="display: none">
            <a href="#" class="dropdown-toggle">
                <i class="icon-book"></i>
                <span>Documents</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Documents') ?>">
                        <i class="icon-plus"></i>
                        Add Document
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewDocuments'); ?>">
                        <i class="icon-plus"></i>
                        View Document
                    </a>
                </li>
            </ul>
        </li>

        <li id="document">
            <a href="#" class="dropdown-toggle">
                <i class="icon-book"></i>
                <span>Documents</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Documents') ?>">
                        <i class="icon-plus"></i>
                        Add Document
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewDocuments'); ?>">
                        <i class="icon-plus"></i>
                        View Document
                    </a>
                </li>
            </ul>
        </li>
        <li id="contact">
            <a href="#" class="dropdown-toggle">
                <i class="icon-user"></i>
                <span>Contacts</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Contacts'); ?>">
                        <i class="icon-plus"></i>
                        Add Contacts
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewContacts'); ?>">
                        <i class="icon-plus"></i>
                        View Contacts
                    </a>
                </li>
            </ul>
        </li>

<!--        <li>-->
<!--            <a href="#" class="dropdown-toggle">-->
<!--                <i class="icon-calendar"></i>-->
<!--                <span>Calender</span>-->
<!--                <b class="arrow icon-angle-down"></b>-->
<!--            </a>-->
<!--            <ul class="submenu">-->
<!--                <li>-->
<!--                <a href="--><?php //echo URL::to_route('Calender'); ?><!--">-->
<!--                    <i class="icon-plus"></i>-->
<!--                    Calender-->
<!--                </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </li>-->


        <?php if(Session::get('user')=='lawyer'){ ?>
        <script type="text/javascript">

            $(function(){
            $('#tasks').hide()
            $('#lawyers').hide()

            $(function()
            {
                $('#tasks').hide()

            });
            });
        </script>
      <?php  }elseif(Session::get('user')=='admin'){?>
        <script type="text/javascript">
            $(function()
            {
                $('#tasks').show()
            });
        </script>
        <?php }?>
<style type="text/css">
    
    #cases a:hover{ background-color:#F26430 !important;}
    #cases i{color:#F26430;}
    #cases a:hover i{color:white;}
    #hearing a:hover{ background-color:#F27C38 !important;}
    #hearing i{color:#F27C38;}
    #hearing a:hover i{color:white;}
    #client_side a:hover{ background-color:#F2D12E !important;}
    #client_side i{color:#F2D12E;}
    #client_side a:hover i{color:white;}
    #appointment a:hover{ background-color:#BACF55 !important;}
    #appointment i{color:#BACF55;}
    #appointment a:hover i{color:white;}
    #message a:hover{ background-color:#55A82E !important;}
    #message i{color:#55A82E;}
    #message a:hover i{color:white;}
    #document a:hover{ background-color:#1EC79D !important;}
    #document i{color:#1EC79D;}
    #document a:hover i{color:white;}
    #contact a:hover{ background-color:#4DD9E1 !important;}
    #contact i{color:#4DD9E1;}
    #contact a:hover i{color:white;}
   
</style>


            <!--/.nav-list-->

