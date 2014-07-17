<?php echo Section::start('contentWrapper'); ?>
<div id="page-content" class="clearfix">

    <div class="page-header position-relative">
        <h1>
            Appointment

            <small>
                <i class="icon-double-angle-right"></i>
                View Appointment
            </small>
        </h1>
    </div>
</div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert-success">
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
<div class="row-flow">
<div class="row-fluid">
<div class="span12">
    <a href="<?php echo URL::to_route('Appointment'); ?>">
        <button class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new appointment</button>
    </a>
<?php   ?>
<table id="table_bug_report" class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th class="center">
        <label>
            <input type="checkbox">
            <span class="lbl"></span>
        </label>
    </th>
    <th>Name</th>
    <th>Case Name</th>
    <th>Appointment Date and Time</th>
    <th>Handles</th>
    <th>Location</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php if(isset($appointments)){ $case=libcase::getcasedetail();$lawyers=liblawyer::getlawyer(); foreach($appointments->results as $appointmentValues){ ?>
<tr class="">
    <td class="center">
        <label>
            <input type="checkbox">
            <span class="lbl"></span>
        </label>
    </td>

    <td><?php echo $appointmentValues->event_name; ?></td>
    <td><?php if(isset($case)){foreach($case as $case_name){if($case_name->case_id==$appointmentValues->case_link){echo $case_name->case_name;}}} ?></td>
    <td><?php $from_date=explode(' ',$appointmentValues->from_date); echo date('d-M-Y',strtotime($from_date[0])).' '.$from_date[1].' '.$from_date[2];?></td>
    <td>
        <?php
        $lawyer='';
        $pice=explode(',',$appointmentValues->lawyers);

        foreach($pice as $law)
        {
            foreach($lawyers as $lawyer_name)
            {
                if($lawyer_name->id==$law)
                {
                    $lawyer.=','.$lawyer_name->first_name;

                }
            }
        }
        echo ltrim($lawyer,',');
        ?>
    </td>
    <td><?php echo $appointmentValues->location; ?></td>
    <td><span class="label label-success arrowed"><?php if($appointmentValues->status==0){echo "Pending&nbsp;&nbsp;&nbsp;&nbsp;";}elseif($appointmentValues->status==1){echo "Processing";}elseif($appointmentValues->status==2){echo "Completed";}  ?></span>
        <div class="btn-group">
            <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                Action
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.Crypter::encrypt($appointmentValues->appointment_id).',0';?>">Pending</a></li>
                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.Crypter::encrypt($appointmentValues->appointment_id).',1';?>">Processing</a></li>
                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.Crypter::encrypt($appointmentValues->appointment_id).',2';?>">Completed</a></li>

            </ul>
        </div>

    </td>
    <td class="td-actions ">
        <div class="hidden-phone visible-desktop btn-group">

            <a class="btn btn-mini btn-info" title="Edit" href="<?php echo URL::to_route('EditAppointment').'/'.Crypter::encrypt($appointmentValues->appointment_id); ?>">

                <i class="icon-edit bigger-120"></i>

            </a>

            <a class="btn btn-mini btn-danger" title="Delete" onclick="return confirm('Really want to delete');" href="<?php echo URL::to_route('DeleteAppointment').'/'.Crypter::encrypt($appointmentValues->appointment_id); ?>">
                <i class="icon-trash bigger-120"></i>
            </a>

        </div>

    </td>
</tr>
<?php }} ?>

</tbody>
</table>
    <?php echo $appointments->links();  ?>
</div><!--/span-->
</div>

</div>
<script type="text/javascript">
    $('.btn').tooltip({
        placement:'left'
    })
</script>

<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>
