
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
                    Edit Appointment
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
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
    <?php  if($appointment){ ?>
        <?php session::put('appointment',$appointment);  ?>
        

    <form class="form-horizontal" action="<?php echo URL::to_route('AddAppointment'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validation();">
        <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);  ?>"/>
        <input type="hidden" name='id' value="<?php echo $appointment->appointment_id; ?>"/>
        <input type="hidden" name="date_created" value="<?php echo date('Y-m-d h:i:s'); ?>"/>
        <div class="control-group">
            <label class="control-label" for="caselink">Case Link:<span style="color:red">*</span></label>
            <div class="controls">
                <input type="text" name="case_link" value="<?php $case_link = get_value_from_multi_object_array($appointment->case_link,$case,'case_id','case_no');$case_name=get_value_from_multi_object_array($appointment->case_link,$case,'case_id','case_name'); echo $case_name.'('.$case_link.')'; ?>" readonly/>

            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="event_name">Event Name:</label>
            <div class="controls">
                <input type="text" id="event_name" name="event_name" value="<?php if(isset($appointment)){echo $appointment->event_name;}  ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="contact_person">Contact Person:</label>
            <div class="controls">
                <input type="text" id="contact_person" name="contact_person" value="<?php if(isset($appointment)){echo $appointment->contact_person;}  ?>" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="from_date">Date:</label>
            <div class="controls">
                <!-- <input type="text" id="dup_from" class="date-picker" style="width: 99px" value="<?php $date=explode(' ',$appointment->from_date);echo date('d/m/Y',strtotime($date[0])); ?>"> -->
                <input type="text" name="from_date[]" id="from" class="date-picker" style="width: 99px" value="<?php $date=explode(' ',$appointment->from_date);echo date('d/m/Y',strtotime($date[0])); ?>">
                <div class="input-append bootstrap-timepicker">
                    <input id="fromtime" type="text" name="from_date[]" value="<?php echo date('g:i A',strtotime($date[1]));  ?>" class=""  style="width: 62px;"/>
                     <span class="add-on"><i class="icon-time"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="to_date">To Date:</label>
            <div class="controls">
               <!-- <input type="text"  class="date-picker" style="width: 99px" id="dup_to"> -->
               <input type="text" name="to_date[]" id="to" class="date-picker" style="width: 99px" value="<?php $date=explode(' ',$appointment->to_date);echo date('d/m/Y',strtotime($date[0])); ?>">
                <div class="input-append bootstrap-timepicker">
                    <input type="text" name="to_date[]" id="totime" class="timepicker2" value="<?php echo date('g:i A',strtotime($date[1]));  ?>" style="width: 62px;"/>
                    <span class="add-on"><i class="icon-time"></i></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label for="lawyer" class="control-label">Associates:<span style="color:red">*</span></label>
            <div class="controls">
                <select id="multiselect" name="lawyer[]" multiple="multiple" style="width: 220px">
                    <?php $lawyer=liblawyer::getlawyer();$ass_id=explode(',',$appointment->lawyers);foreach ($lawyer as $lawyer_name) {if($lawyer_name->updated_by == Auth::user()->id){ ?>

                        <option value="<?php echo $lawyer_name->id;  ?>" <?php foreach($ass_id as $ass_id1){if($ass_id1== $lawyer_name->id){?>selected="selected" <?php }} ?>><?php echo $lawyer_name->first_name;  ?></option>
                    <?php }}  ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="location">Location</label>
            <div class="controls">
                <input type="text" name="location" id="location" value="<?php echo $appointment->location;  ?>">

            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit">UpdateAppointment</button>
                <button class="btn btn-danger" type="reset">Reset</button>
            </div>
        </div>

    </form>
    <?php }?>
</div>

<?php //$location=libautocomplete::get_addr(); ?>
<script type="text/javascript">
<!--    //var city=--><?php //$addr=array(); foreach($location as $locations){ array_push($addr,$locations->city); } echo json_encode($addr); ?><!--;-->
//    $('#location').autocomplete({
//        source:city,
//        minLength:1
//    })

 $(document).ready(function(){
    $('span').tooltip({placement:'bottom'});
     $('#multiselect').select2();
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
  
   
}
   
</script>

<style type="text/css">
    label{
        color:#6C7819;
    }
</style>


<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>