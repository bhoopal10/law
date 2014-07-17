
<?php echo Section::start('contentWrapper'); ?>
<div class="row-fluid">
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Appointment

                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Appointment
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
        

    <form class="form-horizontal" action="<?php echo URL::to_route('AddAppointment'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);  ?>"/>
        <input type="hidden" name='id' value="<?php echo $appointment->appointment_id; ?>"/>
        <input type="hidden" name="date_created" value="<?php echo date('Y-m-d h:i:s'); ?>"/>
        <div class="control-group">
            <label class="control-label" for="caselink">Case Link:</label>
            <div class="controls">
                <select name="case_link" id="caselink">
                    <option value="">Select Case</option>
                    <?php if(isset($case)){ foreach($case as $cases){ $x=$cases; ?>

                        <option value="<?php echo $x->case_id; ?>"><?php echo $x->case_name; ?></option>
                    <?php }} ?>
                    <option value="<?php echo $appointment->case_link; ?>" selected="selected"><?php if(libcase::getcasedetailByID($appointment->case_link)){echo libcase::getcasedetailByID($appointment->case_link)->case_name;} ?></option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="event_name">Event Name:</label>
            <div class="controls">
                <input type="text" id="event_name" name="event_name" value="<?php if(isset($appointment)){echo $appointment->event_name;}  ?>" />
            </div>
        </div>
        <div class="control-group">
            <label for="lawyer" class="control-label">Handles:</label>
            <div class="controls">
                <select id="multiselect" name="lawyer[]" multiple="multiple">
                    <?php $lawYers=explode(',',$appointment->lawyers); $lawyer=liblawyer::getlawyer();foreach ($lawyer as $lawyer_name) {?>

                        <option  <?php if(isset($lawYers)){ foreach($lawYers as $lawyers){if($lawyers==$lawyer_name->id){?> selected="selected" <?php }} } ?> value="<?php echo $lawyer_name->id;?>"><?php echo $lawyer_name->first_name;  ?></option>
                    <?php }  ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="from_date">From Date:</label>
            <div class="controls">
                <input type="text" name="from_date[]" id="from_date" class="date-picker" data-date-format="yyyy-mm-dd" style="width: 99px" value="<?php $date=explode(' ',$appointment->from_date);echo $date[0]; ?>">

                <input id="spinner" type="text" name="from_date[]" value="<?php echo $date[1].' '.$date[2];  ?>" class=""  style="width: 68px;border:none;box-shadow: none;padding: 3px"/>

            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="to_date">To Date:</label>
            <div class="controls">
                <input type="text" name="to_date[]" id="to_date" class="date-picker" style="width: 99px" value="<?php $to_date=explode(' ',$appointment->to_date);echo $to_date[0]; ?>">
                <input type="text" name="to_date[]" id="spinner2" class="timepicker2" value="<?php echo $to_date[1].' '.$to_date[2];  ?>" style="width: 68px;border:none;box-shadow: none;padding: 3px"/>
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
<script>
    $.widget( "ui.timespinner", $.ui.spinner, {
        options: {
// seconds
            step: 60 * 1000,
// hours
            page: 60
        },
        _parse: function( value ) {
            if ( typeof value === "string" ) {
// already a timestamp
                if ( Number( value ) == value ) {
                    return Number( value );
                }
                return +Globalize.parseDate( value );
            }
            return value;
        },
        _format: function( value ) {
            return Globalize.format( new Date(value), "t" );
        }
    });

</script>
<?php $location=libautocomplete::get_addr(); ?>
<script type="text/javascript">
    var city=<?php $addr=array(); foreach($location as $locations){ array_push($addr,$locations->city); } echo json_encode($addr); ?>;
    $('#location').autocomplete({
        source:city,
        minLength:1
    })
    $('.date-picker').datepicker({dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true});
    $( "#spinner" ).timespinner();
    $( "#spinner2" ).timespinner();


</script>



<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>