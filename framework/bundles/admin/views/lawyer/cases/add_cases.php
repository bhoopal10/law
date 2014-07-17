<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
            <i class="icon icon-briefcase"></i>
                Cases
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Case
                    <?php  $caseno=libautocomplete::case_no(); ?>
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>
        </div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>




    <div class="row-fluid">
    <div class="span12">
    <div class="row-fluid">
    <div id="fuelux-wizard" class="row-fluid">
        <ul class="wizard-steps">
            <li data-target="#step1" class="active" style="min-width: 25%; max-width: 25%;">
                <span class="step">1</span>
                <span class="title">Client Detail</span>
            </li>

            <li data-target="#step2" style="min-width: 25%; max-width: 25%;">
                <span class="step">2</span>
                <span class="title">Opp Client Detail</span>
            </li>

            <li data-target="#step3" style="min-width: 25%; max-width: 25%;">
                <span class="step">3</span>
                <span class="title">Brief Description</span>
            </li>

            <li data-target="#step4" style="min-width: 25%; max-width: 25%;">
                <span class="step">4</span>
                <span class="title">Other Info</span>
            </li>
        </ul>
    </div>

    <hr>
    <div class="step-content row-fluid position-relative">
        <div class="step-pane active" id="step1">
            <!--    Case Form-->
            <?php $id=Auth::user()->id; $court_setting = libcase::getCaseAttributeByLawyerID($id); ?>

            <form name="form1" action="<?php echo URL::to_route('AddCases'); ?>"  method="post" class="form-horizontal" id="case-form">
                <input type="hidden" name="lawyer_id" value="<?php echo $id;  ?>" required="required"/>
                <!-- Start Docket_No -->
                <div class="control-group">
                    <label class="control-label" for="docket_no">Docket No:</label>

                    <div class="controls">
                        <input type="text" name="docket_no" id="docket_no"   />

                    </div>
                </div>
                <!-- Start Crime_No -->
                <div class="control-group">
                    <label class="control-label" for="crime_no">Crime No:</label>

                    <div class="controls">
                        <input type="text" name="crime_no" id="crime_no"   />

                    </div>
                </div>
                <!-- Start Case_No -->
                <div class="control-group">
                    <label class="control-label" for="case_number">Case No:<span style="color: red">*</span></label>

                    <div class="controls">
                        <input type="text" name="case_no" id="case_number"   />

                    </div>
                </div>
                <!-- End Case_No -->
                <!-- Start Client Name -->
                <div class="control-group">
                    <label class="control-label" for="client_name">Client Name:<span style="color: red">*</span></label>
                    <div class="controls">
                        <select name="client_id" id="client_name" style="width: 220px" >
                            <option value="">Select Client</option>
                            <?php if(isset($client)){
                                foreach($client as $clients){
                                    ?>
                                    <option value="<?php echo $clients->client_id; ?>"><?php echo $clients->client_name; ?></option>
                                <?php }} ?>
                        </select>
                        <span><a title="Add new client" data-toggle="modal" href="#new_client1">Add New</a></span>
                    </div>
                </div>
                <!-- End Client Name -->
                <!-- Start Party Type -->
                <div class="control-group">
                    <label class="control-label" for="party_type">Party Type:</label>
                    <div class="controls">
                        <select name="party_type" id="party_type" style="width: 220px">
                            <?php
                            if (isset($court_setting)) {
                                $json = json_decode($court_setting->party_type);
                                if(isset($json)){
                                    foreach($json as $value){ ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php }}} ?>
                        </select><span><a title="Add new party-type" data-toggle="modal" href="#new_party_type">Add New</a></span>
                    </div>
                </div>
                <!-- End Party Type -->
                <!-- Start Advocate Name -->
                <div class="control-group">
                    <label class="control-label" for="associate_lawyer">Associate:</label>
                    <div class="controls">
                        <select name="associate_lawyer" id="associate_lawyer"  style="width: 220px"/>
                        <?php if(isset($lawyer)){
//                                    $lawyer=array_unique($lawyerz);
                            foreach($lawyer as $lawyers){
                                if($lawyers->updated_by==Auth::user()->id){ //condition for only assoc lawyer who are uploaded by this lawyer
                                    ?>
                                    <option value="<?php echo $lawyers->id; ?>"><?php echo $lawyers->first_name.' '.$lawyers->last_name; ?></option>
                                <?php }}} ?>
                        </select>
                    </div>
                </div>
                <!-- End Advocate Name -->
                <!-- Start Case Subject -->
                <div class="control-group">
                    <label class="control-label" for="case_subject">Case Subject:<span style="color: red">*</span></label>
                    <div class="controls">
                        <select name="case_subject" id="case_subject" style="width: 220px">
                            <?php
                            if (isset($court_setting)) {
                                $json = json_decode($court_setting->case_subject);
                                if(isset($json)){
                                    foreach($json as $value){ ?>
                                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                    <?php }}} ?>
                        </select><span><a title="Add new case-subject" data-toggle="modal" href="#new_case_subject">Add New</a></span>
                    </div>
                </div>
                <!-- End Case Subject -->
                <!--Start Date of Filling -->
                <div class="control-group">
                    <label class="control-label" for="date_of_filling">Date of Filing:</label>

                    <div class="controls">
                        <input type="text" id="dup_date" class="span3 date-picker" data-date-format="yyyy-mm-dd" style="width: 220px">
                        <input type="hidden" name="date_of_filling" id="date_of_filling" class="span3 date-picker" data-date-format="yyyy-mm-dd">
                    </div>
                </div>
                <!-- End Date of filling  -->
            </form>
        </div>
    <!-- Step 2 -->
        <div class="step-pane" id="step2">
            <div class="row-fluid">

                <form class="form-horizontal" action="<?php echo URL::to_route('AddCases'); ?>"  method="post" id="assign-form" >
                    <!-- Start Opp client name -->
                    <div class="control-group">
                        <label class="control-label" for="opp_party_name">Opp.Client Name:</label>
                        <div class="controls">
                            <input type="text" id="opp_party_name" name="opp_party_name"/>
                        </div>
                    </div>
                    <!-- End Opp client name -->
                    <!-- Start Opp Party type -->
                    <div class="control-group">
                        <label class="control-label" for="opp_party_type">Opp.Party Type:</label>
                        <div class="controls">
                            <select name="opp_party_type" id="opp_party_type" style="width: 220px">
                                <?php
                                if (isset($court_setting)) {
                                    $json = json_decode($court_setting->case_opp_party_type);
                                    if(isset($json)){
                                        foreach($json as $value){ ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php }}} ?>
                            </select><span><a title="Add new opp-party" data-toggle="modal" href="#new_opp_party">Add New</a></span>
                        </div>
                    </div>
                    <!-- End Opp Party Type -->
                    <!-- Start Opp Advocate -->
                    <div class="control-group">
                        <label class="control-label" for="opp_advocate">Opp. Advocate:</label>
                        <div class="controls">
                            <select name="opp_advocate" id="opp_advocate" style="width: 220px">
                                <?php
                                if (isset($court_setting)) {
                                    $json = json_decode($court_setting->opp_advocate);
                                    if(isset($json)){
                                        foreach($json as $value){ ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php }}} ?>
                            </select><span><a title="Add new opp-advocate" data-toggle="modal" href="#new_opp_advocate">Add New</a></span>
                        </div>
                    </div>
                    <!-- End Opp Advocate -->
                    <!-- Start Court name -->
                    <div class="control-group">
                        <label class="control-label" for="court_name">CourtName:</label>
                        <div class="controls">
                            <select name="court_name" id="court_name" style="width: 220px">
                                <?php
                                if (isset($court_setting)) {
                                    $json = json_decode($court_setting->case_court);
                                    if(isset($json)){
                                        foreach($json as $value){ ?>
                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                        <?php }}} ?>
                            </select><span><a title="Add new court" data-toggle="modal" href="#new_court">Add New</a></span>

                        </div>
                    </div>
                    <!-- End Court Name -->
                </form>

            </div>
        </div>
        <!-- Step 3 -->
        <div class="step-pane" id="step3">
            <div class="row-fluid">
                <form  class="form-horizontal" id="description-form">
                    <!-- Start Case Name -->
                    <div class="control-group">
                        <label class="control-label" for="case_name">Case Name:</label>
                        <div class="controls">
                            <input type="text" name="case_name" id="case_name"/>
                        </div>
                    </div>
                    <!-- End Case Name -->
                    <!-- Start Case Type -->
                    <div class="control-group">
                        <label class="control-label" for="case_type">Case Type:</label>
                        <div class="controls">
<!--                            <select name="case_type" id="case_type" style="width: 220px">-->
<!--                                --><?php
                                //if (isset($court_setting)) {
//                                    $json = json_decode($court_setting->case_type);
//                                    if(isset($json)){
//                                        foreach($json as $value){ ?>
<!--                                            <option value="--><?php //echo $value; ?><!--">--><?php //echo $value; ?><!--</option>-->
<!--                                        --><?php //}}} ?>
<!--                            </select><span><a data-toggle="modal" href="#new_case_type">New Case Type</a></span>-->
                            <input type="text" name="case_type" id="case_type">
                        </div>
                    </div>
                    <!-- End Case Type -->
                    <!-- Start Case Description  -->
                    <div class="control-group">
                        <label class="control-label" for="case_description">Case description</label>
                        <div class="controls">
                            <textarea name="case_description" id="case_description" rows="2"></textarea>
                        </div>
                    </div>
                    <!-- End Case Decription  -->
                    <!-- Start Citation Reffered -->
                    <div class="control-group">
                        <label class="control-label" for="citation">Citation Referred/ Title</label>
                        <div class="controls">
                            <textarea name="citation_referred" id="citation" rows="2"></textarea>
                        </div>
                    </div>
                    <!-- End Citation Reffered -->
                    <!-- Start claim-->
                    <div class="control-group">
                        <label for="claim" class="control-label">Claim</label>
                        <div class="controls">
                            <input type="text" name="claim" id="claim"/>
                        </div>
                    </div>
                    <!-- End Claim -->
                    <!-- Start Breif Given by -->
                    <div class="control-group">
                        <label class="control-label" for="brief_given_by">Brief Given By:</label>

                        <div class="controls">
                            <input type="text" name="brief_given_by" id="brief_given_by"/>
                        </div>
                    </div>
                    <!-- End Breif Given By -->
                    <input type="hidden" name="updated_by" value="<?php echo $id;  ?>"/>
                </form>

            </div>
        </div>
        <div class="step-pane" id="step4">
            <div class="center">
                <h3 class="green">Confirmation!</h3>
                Your Client detail add to! Click finish to continue!
                <div style="display: none">
                    <form action="<?php echo URL::to_route('AddCases'); ?>" method="post" id="submit-form" name="toSubmit">

                    </form>

                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row-fluid wizard-actions">
        <button class="btn btn-prev">
            <i class="icon-arrow-left"></i>
            Prev
        </button>

        <button class="btn btn-success btn-next" data-last="Save & Add new Case" id="next">
            Next
            <i class="icon-arrow-right icon-on-right"></i>
        </button>
        <span id="final">

        </span>
    </div>
    </div>
    </div>
    </div>
    </div>

<!-- Start Opp Party -->
<div id="new_opp_party" class="modal hide fade" style="display: none">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>New Opp Party Type</h3>
    </div>
    <div class="model-body">
        <form action="#"  class="form-horizontal" id="addOppParty" onsubmit="return addOppParty();">
            <br>
            <div class="control-group">
                <label class="control-label">Opp Party Type</label>
                <div class="controls">
                    <input type="text" name="case_opp_party_type">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Add</button>

                </div>
            </div>

        </form>
    </div>
</div>
<!-- End Opp Party -->

    <!-- Start Case Subject -->
    <div id="new_case_subject" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Case Subject</h3>
        </div>
        <div class="model-body">
            <form action="#"  class="form-horizontal" id="case_subject_form" onsubmit="return addcasesubject();">
                <br>
                <div class="control-group">
                    <label class="control-label">Case Subject:</label>
                    <div class="controls">
                        <input type="text" name="case_subject">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- End Case Subject -->

<!-- Start New Court-->
    <div id="new_court" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>New Court</h3>
        </div>
        <div class="model-body">
            <form action="#"  class="form-horizontal" id="addcasecourt" onsubmit="return addcasecourt();">
                <br>
                <div class="control-group">
                    <label class="control-label">Court Name:</label>
                    <div class="controls">
                        <input type="text" name="case_court">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
<!--End New Court-->
<!-- Start Party Name-->
    <div id="new_party_type" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>New Party Type</h3>
        </div>
        <div class="span12 model-body">
            <div class="span2">
            <form action="#"  class="form-inline" id="party_type_form" onsubmit="return addpartytype();">
                <br>
                <div class="control-group">
                    <label class="control-label">Party Type:</label>
                    <div class="controls">
                        <input type="text" name="party_type">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>

            </form>
            </div>

        </div>
    </div>
<!--END OPP Party Type-->

<!--Start New Opp Advocate-->
    <div id="new_opp_advocate" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>New Opp Advocate</h3>
        </div>
        <div class="model-body">
            <form action="#"  class="form-horizontal" id="opp_advocate_form" onsubmit="return addoppadvocate();">
                <br>
                <div class="control-group">
                    <label class="control-label">Opp Advocate:</label>
                    <div class="controls">
                        <input type="text" name="opp_advocate">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
<!--End Opp Advocate-->
<!-- Start Case Type-->
    <div id="new_case_type" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>New Case Type</h3>
        </div>
        <div class="model-body">
            <form action="#"  class="form-horizontal" id="case_type_form" onsubmit="return addcasetype();">
                <br>
                <div class="control-group">
                    <label class="control-label">Case Type:</label>
                    <div class="controls">
                        <input type="text" name="case_type">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Add</button>

                    </div>
                </div>

            </form>
        </div>
    </div>
<!-- End Case type -->
<!-- Start New Client -->
<div id="new_client1" class="modal hide fade" style="display: none; ">

    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>New Client</h3>
    </div>
<div class="modal-body">



    <form class="form-horizontal" action="#" method="post" id="AddClientForm" onsubmit="return addClient();">
        <div class="control-group">
            <input type="hidden" name="update_by" value="<?php echo Auth::user()->id; ?>"/>
            <label class="control-label" for="client_name">Client name:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" name="client_name" id="client_name" required="required"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" name="mobile" id="mobile" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="phone">Phone</label>
            <div class="controls">
                <input type="text" name="phone" id="mobile"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="email">Email<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" name="email" id="email"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="address">Address</label>
            <div class="controls">
                <input type="text" name="address" id="address"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="city">City</label>
            <div class="controls">
                <input type="text" name="city" id="city"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="state">State</label>
            <div class="controls">
                <input type="text" name="state" id="state"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="pincode">Pincode</label>
            <div class="controls">
                <input type="text" name="pincode" id="pincode"/>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" id="AddClient">Add</button>
                <button class="btn btn-danger" type="reset">Reset</button>
            </div>
        </div>

    </form>

</div>

<script>

    $('#next').on('click',function()
    {
//        document.getElementById('case_number').focus();
        return false;
    });
    function validate_form()
    {
        var case_no=document.form1.case_no.value;
        if(!case_no)
        {
            alert("please enter Case number");
//            document.form1.case_no.focus();
            return false;
        }
    }
   function addClient()
   {

       $.post("<?php echo URL::to_route('AddClient'); ?>",$('#AddClientForm').serializeArray())
           .success(function(data){
               var values=data.split(',');
               var select=document.getElementById('client_name');
               var opt=document.createElement('option');
               opt.value=values[1];
               opt.selected='selected';
               opt.innerHTML=values[0];
               select.appendChild(opt);
               $('#client_name').select2().select2('val',values[1]);
               $('#new_client1').modal('hide');

           }
     );
                return false;




//       $("#client_name").
   }
    function addOppParty()
    {

        $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#addOppParty').serializeArray())
            .success(function(data){
                var values=data;
                var select=document.getElementById('opp_party_type');
                var opt=document.createElement('option');
                opt.value=values;
                opt.innerHTML=values;
                select.appendChild(opt);
                 $('#opp_party_type').select2().select2('val',values);
                $('#new_opp_party').modal('hide');
            });
        return false;
    }
    function addcasecourt()
    {
        $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#addcasecourt').serializeArray())
            .success(function(data){
                var values=data;
                var select=document.getElementById('court_name');
                var opt=document.createElement('option');
                opt.value=values;
                opt.innerHTML=values;
                select.appendChild(opt);
                 $('#court_name').select2().select2('val',values);
                $('#new_court').modal('hide');
            });
        return false;
    }
   function addpartytype()
   {

       $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#party_type_form').serializeArray())
           .success(function(data){
               var values=data;
               var select=document.getElementById('party_type');
               var opt=document.createElement('option');
               opt.value=values;
               opt.innerHTML=values;
            select.appendChild(opt);
            $('#party_type').select2().select2('val',values);

               $('#new_party_type').modal('hide');

               });
       return false;
   }
   function addoppadvocate()
   {
       $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#opp_advocate_form').serializeArray())
           .success(function(data){
               var values=data;
               var select=document.getElementById('opp_advocate');
               var opt=document.createElement('option');
               opt.value=values;
               opt.innerHTML=values;
               select.appendChild(opt);
                $('#opp_advocate').select2().select2('val',values);
               $('#new_opp_advocate').modal('hide');
           });
       return false;
   }
<!--   function addcasetype()-->
<!--   {-->
<!--       $.post("--><?php //echo URL::to_route('AddOppParty'); ?><!--",$('#case_type_form').serializeArray())-->
<!--           .success(function(data){-->
<!--               var values=data;-->
<!--               var select=document.getElementById('case_type');-->
<!--               var opt=document.createElement('option');-->
<!--               opt.value=values;-->
<!--               opt.innerHTML=values;-->
<!--               select.appendChild(opt);-->
<!--               $('#new_case_type').modal('hide');-->
<!--           });-->
<!--       return false;-->
<!--   }-->
   function addcasesubject()
   {
       $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#case_subject_form').serializeArray())
           .success(function(data){
               var values=data;
               var select=document.getElementById('case_subject');
               var opt=document.createElement('option');
               opt.value=values;
               opt.innerHTML=values;        
               select.appendChild(opt);
               $('#case_subject').select2().select2('val',values);
               $('#new_case_subject').modal('hide');
           });
       return false;
   }
</script>


    <script type="text/javascript">
$(document).ready(function(){

    $('#associate_lawyer').select2();
    $('#client_name').select2();
    $('#opp_party_type').select2();
    $('#court_name').select2();
//    $('#case_type').select2();
    $('#party_type').select2();
    $('#opp_advocate').select2();
    $('#case_subject').select2();
});
$('#dup_date').datepicker({ dateFormat:"dd/mm/yy",
    altField:"#date_of_filling",
    altFormat:"yy-mm-dd",
    changeMonth: true,
    changeYear: true
});

    </script>
<?php Section::stop();?>
<?php echo Section::start('javascript-footer'); ?>
    <script type="text/javascript">






        $(function() {


            $('#new_client').modal('hide');
            $('.btn').tooltip({ placement : 'left'});
            $('a').tooltip({ placement : 'bottom' });
            $('span').tooltip({ placement : 'bottom' });
            $('button').tooltip({ placement : 'bottom' });



            $('[data-rel=tooltip]').tooltip();

            $(".chzn-select").css('width','150px').chosen({allow_single_deselect:true , no_results_text: "No such state!"})
                .on('change', function(){
                    $(this).closest('form').validate().element($(this));
                });



            $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
                if(info.step == 1) {
                    var case_no=document.form1.case_no.value;
                    var client_name=document.form1.client_id.value;
                    var case_subject=document.form1.case_subject.value;

                    var all={case_no:case_no,client_Name:client_name,case_subject:case_subject}
                    for(var val in all)
                    {
                        if(!all[val])
                        {
                            alert("Please Fill (*) fields");
                            document.form1.elements[val].focus();
                            return false;
                        }
                    }

                }
                if(info.step ==3 )
                {
                    $('#final').html('<button class="btn btn-success">' +
                        'Save & Add Hearing' +
                        '  <i class="icon-arrow-right icon-on-right"></i>' +
                        '</button>');
                }

            }).
                on('finished' , function(e, info){
                    var a=$("#case-form").serializeArray();
                    var b=$("#assign-form").serializeArray();
                    var c=$("#description-form").serializeArray();
                    var tot= $.merge(a,b);
                    var all= $.merge(tot,c);


                    $.post("<?php echo URL::to_route('AddCases'); ?>",all)
                        .success(function(data){
                            alert('Congratulations Your Case has been added successfully');
                            window.location = "<?php echo URL::to_route('Cases'); ?>";
                        })
                            .error(function(data){
                            alert('Faild to add please try again later');
                                window.location="<?php echo URL::to_route('Cases'); ?>";
                            })
                        ;
                });
            $('#final').click(function(e,info){
                var a=$("#case-form").serializeArray();
                var b=$("#assign-form").serializeArray();
                var c=$("#description-form").serializeArray();
                var tot= $.merge(a,b);
                var all= $.merge(tot,c);


                $.post("<?php echo URL::to_route('AddCases'); ?>",all)
                    .success(function(data){
                        alert('Congratulations Your Case has been added successfully');
                        window.location = '<?php echo URL::to('admin/hearing/select-case-hearing?case_id='); ?>'+data;
                    })
                    .error(function(data){
                        alert('Faild to add please try again later');
                        window.location="<?php echo URL::to_route('Cases'); ?>";
                    });
            });


            $('#skip-validation').removeAttr('checked').on('click', function(){
                $validation = this.checked;
                if(this.checked) {
                    $('#case-form').show();
                    $('#profile-form').show();
                }
                else {
                    $('#validation-form').hide();
                    $('#sample-form').show();
                }
            });


            //documentation : http://docs.jquery.com/Plugins/Validation/validate


            $('#pincode').mask('999999');
            $('#mobile').mask('9999999999?,9999999999');

            jQuery.validator.addMethod("phone", function (value, element) {
                return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
            }, "Enter a valid phone number.");
            jQuery.validator.addMethod("mobile",function (value,element){
                return this.optional(element) || /^d{10}?$/.test(value);
            },"Enter Valid Mobile number");

            $('#profile-form').validate({
                errorElement: 'span',
                errorClass: 'help-inline',
                focusInvalid: false,
                rules: {
                    email: {
                        required: true,
                        email:true
                    },

                    password: {
                        required: true,
                        minlength: 5
                    },
                    password2: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    name: {
                        required: true
                    },
                    phone: {
                        required: true,
                        phone: 'required'
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    comment: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    platform: {
                        required: true
                    },
                    subscription: {
                        required: true
                    },
                    gender: 'required',
                    agree: 'required'
                },

                messages: {
                    email: {
                        required: "Please provide a valid email.",
                        email: "Please provide a valid email."
                    },
                    password: {
                        required: "Please specify a password.",
                        minlength: "Please specify a secure password."
                    },

                    subscription: "Please choose at least one option",
                    gender: "Please choose gender",
                    agree: "Please accept our policy"
                },

                invalidHandler: function (event, validator) { //display error alert on form submit
                    $('.alert-error', $('.login-form')).show();
                },

                highlight: function (e) {
                    $(e).closest('.control-group').removeClass('info').addClass('error');
                },

                success: function (e) {
                    $(e).closest('.control-group').removeClass('error').addClass('info');
                    $(e).remove();
                },

                errorPlacement: function (error, element) {
                    if(element.is(':checkbox') || element.is(':radio')) {
                        var controls = element.closest('.controls');
                        if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                        else error.insertAfter(element.nextAll('.lbl').eq(0));
                    }
                    else if(element.is('.chzn-select')) {
                        error.insertAfter(element.nextAll('[class*="chzn-container"]').eq(0));
                    }
                    else error.insertAfter(element);
                },

                submitHandler: function (form) {
                },
                invalidHandler: function (form) {
                }
            });

        });

    </script>
    <style type="text/css">
    label{
        color:#F26430;
    }
    </style>
<?php Section::stop(); ?>


<?php echo render('admin::lawyer/template.main'); ?>