<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/12/14
 * Time: 1:01 AM
 */ ?>
<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-bell"></i>
            Hearing
            <small>
                <i class="icon-double-angle-right"></i>
                Edit Hearing Date
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewHearing'); ?>">Back</a>
            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
<?php $status=Session::get('status');
      $error=Session::get('error');
if(isset($status)){ ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php } elseif(isset($error)){?>
<div class=" alert alert-alert">
    <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
    <span><?php echo $error; ?></span>
</div>
<?php } ?>

<div class="row-fluid">
    <form class="form-horizontal" action="<?php echo URL::to_route('AddMultiHearing') ?>" method="post">
        <table class="span8">
            <thead>
            <tr>
                <th>Case.No</th>
                <th>Current hearing date</th>
                <th>Next Hearing Date</th>
                <th>Stage</th>
                <th>View</th>
            </tr>
            </thead>
        <tbody>
        <?php foreach ($hearing as $hearings){ ?>
            <tr>
            <td><?php $case=libcase::getcasedetailByID($hearings->case_id); echo ucfirst($case->case_no); ?></td>
            <td><input type="text" name="hearing_date[]"  value="<?php echo date('d/m/Y',strtotime($hearings->next_hearing_date)); ?>" readonly="readonly"></td>
            <td> <input type="text" name="next_hearing_date[]" class="date" required="required"> </td>
            <td><input type="text" name="stage[]" value="<?php echo $hearings->stage; ?>"></td>
            <td><a data-toggle="modal" title="View hearing detail" href="#view" class="view" hearing_id="<?php echo $hearings->hearing_id; ?>">View</a></td>
            <div class="controls">
                <input type="hidden" name="case_id[]" value="<?php echo $hearings->case_id; ?>">
                <input type="hidden" name="client_id[]" value="<?php echo $hearings->client_id; ?>">
                <input type="hidden" name="opp_party_name[]" value="<?php echo $hearings->opp_party_name; ?>">
                <input type="hidden" name="lawyer_id[]" value="<?php echo $hearings->lawyer_id; ?>">
                <input type="hidden" name="sms_deliver[]" value="<?php echo $hearings->sms_deliver; ?>">
                <input type="hidden" name="updated_by[]" value="<?php echo $hearings->updated_by; ?>">
                <input type="hidden" name="doc_no[]" value="<?php echo $hearings->doc_no; ?>">
                <input type="hidden" name="docket_no[]" value="<?php echo $hearings->docket_no; ?>">
                <input type="hidden" name="description[]" value="<?php echo $hearings->description; ?>">
                <input type="hidden" name="court_hall[]" value="<?php echo $hearings->court_hall; ?>">
                <input type="hidden" name="judge[]" value="<?php echo $hearings->judge; ?>">
                <input type="hidden" name="action_plan[]" value="<?php echo $hearings->action_plan; ?>">
            </div>
        </div>
        <?php } ?>
        </tr>
        <tr>
            <td>
                <button class="btn btn-primary">Update</button>
            </td>
        </tr>
    </tbody>
</table>
    </form>
</div>
<div id="view" class="modal hide fade" style="display: none;">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Hearing Details</h3>
    </div>
    <div class=" model-body" id="jqueryInput">
        <table class="table table-bordered table-striped">

        </table>

    </div>
    <div class="">
        <button class="btn btn-danger btn-mini" data-dismiss="modal" aria-hidden="true" style="float: right">Close</button>
        </div>
</div>

<script type="text/javascript">
    $('.view').on('click',function(){
       var view=$(this).attr("hearing_id");
        $.post("<?php echo URL::to_route('HearingDetailsByID'); ?>",{hearing_id:view})
            .success(function(data){

                obj= $.parseJSON(data);
//                $("#jqueryInput").html("<table>");
                $.each(obj,function(key,value){

                    $(".table").append(
                        "<tr>" +
                            "<td>" +
                            key +
                            "</td>" +
                            "<td>" +
                            value +
                            "</tr>"
                    );
                });


            });
        $(".table").empty();

    });
$(function(){
    $('a').tooltip({placement:'bottom'});
});
    $('.date').datepicker({dateFormat:"dd/mm/yy",
        changeMonth: true,
        changeYear: true
    });
    
    function dateValidation()
    {
        var from=document.form2.hearing_date.value;
        var to=document.form2.next_hearing_date.value;
        var stDate = new Date(from);
        var enDate = new Date(to);
//        var todayDate=new Date();
        var compDate = enDate - stDate;
        if(!to)
        {
            return true;
        }

        if(!(compDate >= 0))
        {
            alert("Next Hearing date must greater than Hearing date ");
            return false;
        }



    }

</script>
<style type="text/css">
    label{
        color:#F27C38;
    }
</style>
<?php Section::stop(); ?>

<?php echo render('admin::lawyer/template.main'); ?>

