<div id="sidebar" style="margin-top: 46px" class="hidden-print">
    <div id="sidebar-shortcuts">
        <div id="sidebar-shortcuts-large">
            <a class="btn btn-small btn-success" href='<?php echo URL::to_route('ViewClient'); ?>'>
                <i class="icon-user"></i>
            </a>

            <a class="btn btn-small btn-info" href='<?php echo URL::to_route('ViewCases'); ?>'>
                <i class="icon-briefcase"></i>
            </a>

            <a class="btn btn-small btn-warning" href='<?php echo URL::to_route('ViewHearing');?>'>
                <i class="icon-bell"></i>
            </a>

            <a class="btn btn-small btn-danger" href='<?php echo URL::to_route('ViewUser');?>'>
                <i class="icon-group"></i>
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
        <li id="associate" style="display:none;">
            <a href="#" class="dropdown-toggle">
                <i class="icon-group"></i>
                <span>Associates</span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">


                <li>
                    <a href="<?php echo URL::to_route('User') ?>">
                        <i class="icon-plus"></i>
                        Add Associates
                    </a>
                </li>

                <li>
                    <a href="<?php echo URL::to_route('ViewUser') ?>">
                        <i class="icon-plus"></i>
                        View Associates
                    </a>
                </li>

            </ul>
        </li>
        <li id='cases'>
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
                <li>
                    <a href="<?php echo URL::to_route('PendingCase').'/0'; ?>">
                        <i class="icon-plus"></i>
                        Pending Cases
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ProcessingCase').'/1'; ?>">
                        <i class="icon-plus"></i>
                        Processing Cases
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('CompletedCase').'/2'; ?>">
                        <i class="icon-plus"></i>
                        Completed Cases
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewPartyType'); ?>">
                        <i class="icon-plus"></i>
                        Party Type
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewCaseSubject'); ?>">
                        <i class="icon-plus"></i>
                        Case Subject
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewCourt'); ?>">
                        <i class="icon-plus"></i>
                        Court
                    </a>
                </li>
            </ul>
        </li>

        <li id='hearing'>
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
                        Today Hearing
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
        <li id='reports'>
            <a href="#" class="dropdown-toggle">
                <i class="icon-file"></i>
                <span>Reports</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('SelectReport'); ?>">
                        <i class="icon-plus"></i>
                        View Reports
                    </a>
                </li>
            </ul>
        </li>
        <li id='clients'>
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
        <li id="appointment" style="display:none">
            <a href="#" class="dropdown-toggle" dt="ff">
                <i class="icon-time"></i>
                <span>Appointment</span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Appointment'); ?>">
                        <i class="icon-plus"></i>
                        Add Appointment
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewAppointment'); ?>">
                        <i class="icon-plus"></i>
                        View Appointment
                    </a>
                </li>
            </ul>
        </li>
        <li id="message" style="display:none">
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

        <li id="documents" style="display:none">
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
        <li id="tasks" style="display: none">
            <a href="#" class="dropdown-toggle">
                <i class="icon-tasks"></i>
                <span>Tasks</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('Tasks') ?>">
                        <i class="icon-plus"></i>
                        Add Task
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewTasks'); ?>">
                        <i class="icon-plus"></i>
                        View Task
                    </a>
                </li>
            </ul>
        </li>


        <li id="contact" style="display:none">
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

        <li id="billing" style="display:none">
            <a href="#" class="dropdown-toggle">
                <i class="icon-money"></i>
                <span>Bill Invoice</span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo URL::to_route('CreateInvoice'); ?>">
                        <i class="icon-plus"></i>
                        Create Invoice
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('ViewInvoice'); ?>">
                        <i class="icon-plus"></i>
                        View Invoice
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('PaidBill'); ?>">
                        <i class="icon-plus"></i>
                        Paid Bill
                    </a>
                </li>
                <li>
                    <a href="<?php echo URL::to_route('PendingBill'); ?>">
                        <i class="icon-plus"></i>
                        Pending Bill
                    </a>
                </li>
            </ul>
        </li>



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
        <?php $user=Auth::user()->id;$perm=liblawyer::getstatusByID($user);?>
        <script type="text/javascript">
            $(function(){
                var msg="<?php echo $perm->message_permission; ?>";
                var contact="<?php echo $perm->contact_permission; ?>";
                var calender="<?php echo $perm->calender_permission; ?>";
                var doc="<?php echo $perm->document_permission; ?>";
                var associate="<?php echo $perm->associate_permission; ?>";
                var appointment="<?php echo $perm->appointment_permission; ?>";
                var billing="<?php echo $perm->billing_permission; ?>";
               
                if(msg!=0)
                {
                     
                    $('#message').show();
                }
                if(contact!=0)
                {
                    $('#contact').show();
                }
                if(doc != 0)
                {
                    $('#document').show();
                }
                if(associate !=0 )
                {
                    $('#associate').show();
                }
                if(appointment != 0)
                {
                    $('#appointment').show();
                }
                if(calender!=0)
                {
                    $('#calender').show();
                }
                if(billing != 0)
                {
                    $('#billing').show();
                }

             
            });
        </script>
        </ul>
    <div id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
    </div>
<style type="text/css">
    #associate a:hover{ background-color:#BF3326 !important;}
    #associate i{color:#BF3326;}
    #associate a:hover i{color:white;}
    #cases a:hover{ background-color:#F26430 !important;}
    #cases i{color:#F26430;}
    #cases a:hover i{color:white;}
    #hearing a:hover{ background-color:#F27C38 !important;}
    #hearing i{color:#F27C38;}
    #hearing a:hover i{color:white;}
    #reports a:hover{ background-color:#F2A03D !important;}
    #reports i{color:#F2A03D;}
    #reports a:hover i{color:white;}
    #clients a:hover{ background-color:#F2D12E !important;}
    #clients i{color:#F2D12E;}
    #clients a:hover i{color:white;}
    #appointment a:hover{ background-color:#BACF55 !important;}
    #appointment i{color:#BACF55;}
    #appointment a:hover i{color:white;}
    #message a:hover{ background-color:#55A82E !important;}
    #message i{color:#55A82E;}
    #message a:hover i{color:white;}
    #documents a:hover{ background-color:#1EC79D !important;}
    #documents i{color:#1EC79D;}
    #documents a:hover i{color:white;}
    #contact a:hover{ background-color:#4DD9E1 !important;}
    #contact i{color:#4DD9E1;}
    #contact a:hover i{color:white;}
    #billing a:hover{ background-color:#5C94E9 !important;}
    #billing i{color:#5C94E9;}
    #billing a:hover i{color:white;}


</style>


        <!--/.nav-list-->

