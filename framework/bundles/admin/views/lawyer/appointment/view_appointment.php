<?php echo Section::start('contentWrapper'); ?>
<div id="page-content" class="clearfix">

    <div class="page-header position-relative">
        <h1><i class="icon icon-time"></i>
            Appointment

            <small>
                <i class="icon-double-angle-right"></i>
                View Appointment
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
            <a href="<?php echo URL::to_route('Appointment'); ?>">
                <button title="Add new appointment" class="btn btn-mini btn-file" style="float: right"><i class="icon-plus"></i>Add new appointment</button>
            </a>
            <a href="<?php echo URL::to_route('ViewAppointment'); ?>" title="View All" class="btn btn-mini btn-info pull-right">ViewAll</a>
        </h1>
    </div>
</div>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
    if(isset($error)){ ?>
    <div class="alert alert-alerts">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php } ?>
<div class="row-flow">
    <form class="pull-right">
        <input type="text" id="date" name="date" placeholder="filter by date" class="input-large" onchange="this.form.submit()"/>
    </form>
<div class="row-fluid">

<div class="span12">
<!--    --><?php //print_r($appointments); ?>

<form name="form1"  action="<?php echo URL::to_route('MultiAppointmentDelete'); ?>" method="post" onsubmit="return validate();">
 <span id="del" style="display: none">
    <button title="Delete appointment" class="btn btn-mini btn-danger" type="submit"><i class="icon-trash"></i>Delete</button>
 </span>
<table id="table_bug_report" class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th class="left" style="width: 20px">
        <label>
            <input type="checkbox">
            <span class="lbl"></span>
        </label>
    </th>
    <th>S.no</th>
    <th>Name</th>
    <th>Case NO</th>
    <th>Contact Person</th>
    <th>Appointment Date and Time</th>
    <th>Associate(s)</th>
    <th>Location</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>
<?php if(isset($appointments)){ $case=libcase::getcasedetail();$lawyers=liblawyer::getlawyer();$i=1; foreach($appointments->results as $appointmentValues){ ?>

    <tr class="">
    <td class="left">
        <label>
            <input type="checkbox" name="associate_delete[]" value="<?php echo $appointmentValues->appointment_id; ?>">
            <span class="lbl"></span>
        </label>
    </td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php $page=$appointments->page-1;$total=$appointments->per_page*$page; echo $i+$total;$i++; ?></td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php echo $appointmentValues->event_name; ?></td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php if(isset($case)){foreach($case as $case_name){if($case_name->case_id==$appointmentValues->case_link){echo $case_name->case_no;}}} ?></td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php echo $appointmentValues->contact_person;  ?></td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php echo date('d-M-Y g:i A',strtotime($appointmentValues->from_date));?></td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer">
        <?php
        $lawyer='';
        $pice=explode(',',$appointmentValues->lawyers);

        foreach($pice as $law)
        {
            foreach($lawyers as $lawyer_name)
            {
                if($lawyer_name->id==$law)
                {
                    $lawyer.=','.ucfirst($lawyer_name->first_name);

                }
            }
        }
        echo ltrim($lawyer,',');
        ?>
    </td>
    <td onclick="document.location.href='<?php echo URL::to_route('AppointmentDetail').'/'.$appointmentValues->appointment_id; ?>'" style="cursor:pointer"><?php echo $appointmentValues->location; ?></td>
    <td><span class="label label-large label-success"><?php if($appointmentValues->status==0){echo "Pending&nbsp;&nbsp;&nbsp;&nbsp;";}elseif($appointmentValues->status==1){echo "Processing";}elseif($appointmentValues->status==2){echo "Completed";}  ?></span>
         <div class="btn-group">
                            <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.$appointmentValues->appointment_id.',0';?>">Pending</a></li>
                                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.$appointmentValues->appointment_id.',1';?>">Processing</a></li>
                                <li><a href="<?php echo URL::to_route('AppointmentStatus').'/'.$appointmentValues->appointment_id.',2';?>">Completed</a></li>
                            </ul>
                                </div>
    </td>
    <td class="td-actions ">
        <div class="hidden-phone visible-desktop btn-group">

            <a class="btn btn-mini btn-info" title="Edit" href="<?php echo URL::to_route('EditAppointment').'/'.$appointmentValues->appointment_id; ?>">

                <i class="icon-edit bigger-120"></i>

            </a>

            <a class="btn btn-mini btn-danger" title="Delete" onclick="return confirm('Really want to delete');" href="<?php echo URL::to_route('DeleteAppointment').'/'.$appointmentValues->appointment_id; ?>">
                <i class="icon-trash bigger-120"></i>
            </a>

        </div>

    </td>
</tr>
<?php }} ?>

</tbody>
</table>
    </form>
    <?php echo $appointments->links();  ?>
</div><!--/span-->
</div>

</div>
<script type="text/javascript">

       $('#date').datepicker({
           dateFormat:'dd/mm/yy',
           changeMonth: true,
           changeYear: true
       });

    $('.btn').tooltip({
        placement:'left'
    })
</script>
<script>
    $(function(){
        $('table th input:checkbox').on('click',function(){
            var that=this;

            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked=that.checked;
                    $(this).closest('tr').toggleClass('selected');
                })
        })
    });


    $(document).ready(function () {
        $('#del').hide();
        var count =function(){
            var n=$("input:checked").length;
            if(n >=1 )
            {
                $('#del').show();
            }
            else
            {
                $('#del').hide();
            }
        };
        count();
        $( "input[type=checkbox]" ).on( "click", count );
    });
    $('a').tooltip();
</script>


<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
