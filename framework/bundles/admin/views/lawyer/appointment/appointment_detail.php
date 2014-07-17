<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/14/14
 * Time: 4:50 PM
 */
?>
<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-time"></i>
                Appointment
                <small>
                    <i class="icon-double-angle-right"></i>
                    Details
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>
        </div>
    </div>
    <div class="row-fluid">
        <?php 
        if($appointments)
        {
        $appointment1=(array)$appointments;
        $appointment=array_unset($appointment1,'appointment_id,date_created,date_updated');
        //        print_r($appointment);exit;
        $lawyer=liblawyer::getlawyer();
        ?>

        <table class="table table-bordered table-hover table-striped">
            <thead class="table-header">
            <tr>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody class="table table-bordered">
            <tr>
                <td>Case NO</td>
                <td><?php $case=libcase::getcasedetailByID($appointment['case_link']);
                    echo ($case)?$case->case_no:''; ?>
                </td>
            </tr>
            <tr>
                <td>Event Name</td>
                <td><?php echo ucfirst($appointment['event_name']); ?></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td><?php echo ucfirst($appointment['contact_person']); ?></td>
            </tr>
            <tr>
                <td>Location</td>
                <td><?php echo ucfirst($appointment['location']); ?></td>
            </tr>
            <tr>
                <td>Date</td>
                <td><?php echo "<span class='label label-success'>".date('d-M-Y g:i A',strtotime($appointment['from_date']))."</span> TO  <span class='label label-success'>".date('d-M-Y g:i A',strtotime($appointment['to_date']))."</span>"; ?></td>
            </tr>
            <tr>
                <td>Associate(S)</td>
                <td>
                  <?php  echo ucfirst(get_multi_value_from_object_array($appointment['lawyers'],$lawyer,'id','first_name')); ?>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td><?php  if($appointment['status']==0){echo "Pending";}elseif($appointment['status']==1){echo "Processing";}elseif($appointment['status']==2){echo "Completed";} ?></td>
            </tr>

            
            </tbody>

        </table>

        <?php } ?>
    </div>
    <script type="text/javascript">
    $('span').tooltip();
    </script>
<?php Section::stop();  ?>
<?php echo render('admin::lawyer/template.main');  ?>