<?php echo Section::start('contentWrapper'); ?>
<script src="<?php echo URL('/'); ?>bundles/admin/js/bootstrap-timepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo URL('/'); ?>css/bootstrap-timepicker.css" />
<div class="row-fluid">
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-time"></i>
            Appointment
            <small>
                <i class="icon-double-angle-right"></i>
                Add Appointment
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
    <?php $status=Session::get('status');
    if(isset($status)){ ?>
        <div class="alert alert-success">
            <button class="close" type="button" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
            <span><?php echo $status; ?></span>
        </div>
    <?php }?>

    <form name="form1" class="form-horizontal" action="<?php echo URL::to_route('AddAppointment'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validation();">
    <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);?>"/>
    <input type="hidden" name="date_created" value="<?php echo date('Y-m-d h:i:s'); ?>"/>
    <div class="control-group">
        <label class="control-label" for="case_link">Case Link:<span style="color:red">*</span></label>
        <div class="controls">
            <select name="case_link" id="case_link" style="width: 220px">
                <option value="">Select Case</option>
                <?php if(isset($case)){ foreach($case as $cases){if($cases->lawyer_id==Auth::user()->id){   ?>
                <option value="<?php echo $cases->case_id; ?>"><?php echo $cases->case_name.'('.$cases->case_no.')'; ?></option>
                <?php }}} ?>
            </select>
            <span><a title="Add new case" href="<?php echo URL::to_route('Cases') ;?>">Add New</a></span>

        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="event_name">Event Name:</label>
        <div class="controls">
            <input type="text" id="event_name" name="event_name" data-type="string" />
        </div>
    </div>
        <div class="control-group">
            <label class="control-label" for="contact_person">Contact Person:</label>
            <div class="controls">
                <input type="text" id="contact_person" name="contact_person" />
            </div>
        </div>
   
    <div class="control-group">
        <label class="control-label" for="from_date">From Date:</label>
        <div class="controls">
            <!-- <input type="text" class="date-picker1"  style="width: 99px" id="dup_from"> -->
            <input type="text" name="from_date[]" id="from" class="date-picker" data-date-format="yyyy-mm-dd" style="width: 99px">

            <div class="input-append bootstrap-timepicker">
                <input id="fromtime" value="08:30 AM" type="text" name="from_date[]" class="input-small" style="width: 62px;">
                <span class="add-on"><i class="icon-time"></i></span>
            </div>
        </div>
    </div>
     <div class="control-group">
        <label class="control-label" for="to_date">To Date:</label>
        <div class="controls">
           <!-- <input type="text"  class="date-picker" style="width: 99px" id="dup_to"> -->
           <input type="text" name="to_date[]" id="to" class="date-picker" style="width: 99px">
            <div class="input-append bootstrap-timepicker">
                <input id="totime" value="08:30 PM" type="text" name="to_date[]" class="input-small" style="width: 62px;">
                <span class="add-on"><i class="icon-time"></i></span>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label for="lawyer" class="control-label">Associates: <span style="color:red">*</span> </label>
        <div class="controls">
            <select id="multiselect" name="lawyer[]" multiple="multiple" style="width: 220px">

                <?php $lawyer=liblawyer::getlawyer();foreach ($lawyer as $lawyer_name) {if($lawyer_name->updated_by == Auth::user()->id){ ?>
                    
                <option value="<?php echo $lawyer_name->id;  ?>"><?php echo $lawyer_name->first_name;  ?></option>
                <?php }}  ?>

                </select>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="location">Location</label>
        <div class="controls">
            <input type="text" name="location" id="location"/>

        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button class="btn btn-primary" type="submit">FixAppointment</button>
            <button class="btn btn-danger" type="reset">Reset</button>
        </div>
    </div>

</form>
</div>


<?php $location=libautocomplete::get_addr(); 
    $clients=libclient::getclientnameByLawId(Auth::user()->id);
    $clients=json_encode($clients);
?>
<script type="text/javascript">
    $(document).ready(function()
    {
         $('#case_link').select2();
        $('#multiselect').select2();

        $( "#fromtime" ).timepicker({
                         minuteStep: 1
                        });
        $( "#totime" ).timepicker({
                        minuteStep: 1
                        });
        $( "#from" ).datepicker({
        dateFormat: "dd/mm/yy",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear:true,
        onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
        });

        $( "#to" ).datepicker({
            dateFormat: "dd/mm/yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear:true,
            onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
        $('#from').change(function(){
            $('#multiselect').select2().select2('val','');
        });
        $('#to').change(function(){
            $('#multiselect').select2().select2('val','');
        });
        $('#fromtime').change(function(){
            $('#multiselect').select2().select2('val','');
        });
        $('#totime').change(function(){
            $('#multiselect').select2().select2('val','');
        });

        $("#multiselect").change(function()
        {
            
            var date1 = $("#from").val().split('/');
            var date2 = $("#to").val().split('/');
            var time1 = $("#fromtime").val();
            var time2 = $("#totime").val();

            var fromDate=date1[2]+'/'+date1[1]+'/'+date1[0];
            var toDate=date2[2]+'/'+date2[1]+'/'+date2[0];
            var fromdate=new Date(fromDate+' '+time1);
            var fromdate=parseInt(fromdate.getTime()/1000);
            var todate=new Date(toDate+' '+time2);
            var todate=parseInt(todate.getTime()/1000);
            if(date1 =='' || date2 =='' || time1 == '' || time2 == '')
            {
               alert('Please select From and To dates');
            $('#multiselect').select2().select2('val','');

                          
            }
            else
            {
                var id = $("option:selected",this).val();
                if(id)
                {
                    $.post('<?php echo URL::to_route('CheckAppointment') ?>',{val:id,from:fromdate,to:todate})
                    .success(function(data)
                    {
                        if(data)
                        {
                           alert('This associate has one appointment for given time');
                           $('#multiselect option[value='+data+']').prop("selected",false).parent().trigger("change");
                        }
                        else
                        {
                            return true;
                        }
                    });
                }
            }
        });

   });
   
function validation()
{
    var lawyer=document.getElementById('multiselect').value;
    var case_link=document.form1.case_link.value;
    var from=document.getElementById('from').value;
    var to=document.getElementById('to').value;
    var fromtime=document.getElementById('fromtime').value;
    var totime=document.getElementById('totime').value;
    var fromDate=from.split('/');
    var fromDate=fromDate[2]+'/'+fromDate[1]+'/'+fromDate[0];
    var fromdate=new Date(fromDate+' '+fromtime);
    var toDate=to.split('/');
    var toDate=toDate[2]+'/'+toDate[1]+'/'+toDate[0];
    var todate=new Date(toDate+' '+totime);
    if(!lawyer)
    {
        alert('Please select atleast one associate');
        return false;
    }
     if(!from)
     {
        alert('Please select from date');
        return false;
     }
     if(!to)
     {
        alert('Please select to Date');
        return false;
     }
    if(from == to)
    {
         if(fromdate > todate)
         {
            alert('From datetime must lessthan To datetime');
            return false;
         }
    }
    if(!fromtime.match(/^(0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/))
     {
        alert('Invalid from time TimeFormat must hh:mm AM or PM');
        document.getElementById('fromtime');
        return false;
     }
     if(!totime.match(/^(0?[1-9]|1[012])(:[0-5]\d) [APap][mM]$/))
     {
        alert('Invalid totime TimeFormat must hh:mm AM or PM');
        document.getElementById('totime');
        return false;
     }
    if(!case_link)
    {
        alert('Please select case link');
        return false;
    }

  
   
}
    $(function()
    {
        var client=<?php echo $clients; ?>;
        $('#contact_person').autocomplete({

            source:client,
            minLength:1
        });
      
       $('span').tooltip({placement:'bottom'});
       $('a').tooltip({placement:'bottom'});
     
    });
</script>
<style type="text/css">
    label{
        color:#6C7819;
    }
</style>


<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>


