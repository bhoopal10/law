<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-briefcase"></i>
            Cases
            <small>
                <i class="icon-double-angle-right"></i>
                Edit Case
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewCases'); ?>">Back</a>
                <?php
                $caseno=libautocomplete::case_no();

                ?>
            </small>
        </h1>
    </div>
<?php $id=Auth::user()->id; $lawyer_id=liblawyer::getlawyerIDByassociateID($id); $court_setting = libcase::getCaseAttributeByLawyerID($lawyer_id->uid2);?>
    <?php Section::stop();?>
    <?php echo Section::start('contentWrapper');?>
    <?php $status=Session::get('status');
    if(isset($status)){ ?>
        <div class="alert-success">
            <span><?php echo $status; ?></span>
        </div>
    <?php }?>

    <?php if(isset($cases)){ $cases_detail=(array)$cases;
        Session::put('cases',$cases_detail);// cases_detail are loading to to session is useful for comparing updated array and original data
        $case_id=libcase::getcaseIDByassociateID(Auth::user()->id);
        foreach($case_id as $cases)
        {
            if($cases->case_id==$cases_detail['case_id'])
            {
                $permission=$cases->permission;
            }
        }
       ?>
        <?php if($permission==2){  ?>
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
                    <span class="title">Confirmation</span>
                </li>
            </ul>
        </div>

        <hr>

        <div class="step-content row-fluid position-relative">
            <div class="step-pane active" id="step1">
                <!--    Case Form-->


                <form name="form1" action="<?php echo URL::to_route('AddCases'); ?>"  method="post" class="form-horizontal" id="case-form">
                    <input type="hidden" name="lawyer_id" value="<?php echo $lawyer_id->uid2;  ?>"/>
                    <!-- Docket No -->
                    <div class="control-group">
                        <label class="control-label" for="docket_number">Case No:</label>

                        <div class="controls">
                            <input type="text" name="docket_no" id="docket_number" value="<?php echo $cases_detail['docket_no']; ?>"  />

                        </div>
                    </div>
                    <!-- End Docket_No -->
                    <!-- Start CRIME_No -->
                    <div class="control-group">
                        <label class="control-label" for="crime_number">Case No:</label>

                        <div class="controls">
                            <input type="text" name="crime_no" id="case_number" value="<?php echo $cases_detail['crime_no']; ?>"  />

                        </div>
                    </div>
                    <!-- End CRIME NO -->

                    <!-- Start Case_No -->
                    <div class="control-group">
                        <label class="control-label" for="case_number">Case No:<span style="color: red">*</span></label>

                        <div class="controls">
                            <input type="text" name="case_no" id="case_number" value="<?php echo $cases_detail['case_no']; ?>"  />

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
                                        <option value="<?php echo $clients->client_id; ?>" <?php if($clients->client_id==$cases_detail['client_id']) { ?> selected="selected" <?php }  ?>><?php echo $clients->client_name; ?></option>
                                    <?php }} ?>
                            </select>
                            <span><a title="add-new client" data-toggle="modal" href="#new_client1">Add New</a></span>
                        </div>
                    </div>
                    <!-- End Client Name -->
                    <!-- Start Party Type -->
                    <div class="control-group">
                        <label class="control-label" for="party_type">Party Type:</label>
                        <div class="controls">
                            <select name="party_type" id="party_type" style="width: 220px">
                                <option value="<?php echo $cases_detail['party_type']; ?>"><?php echo $cases_detail['party_type']; ?></option>
                                <?php
                                if (isset($court_setting)) {
                                    $json = json_decode($court_setting->party_type);
                                    if(isset($json)){
                                        foreach($json as $value){ ?>
                                            <option value="<?php echo $value; ?>"  ><?php echo $value; ?></option>
                                        <?php }}} ?>
                            </select><span><a title="add-new party type" data-toggle="modal" href="#new_party_type">Add New</a></span>
                        </div>
                    </div>
                    <!-- End Party Type -->
                    <!-- Start Case Subject -->
                    <div class="control-group">
                        <label class="control-label" for="case_subject">Case Subject:<span style="color: red">*</span></label>
                        <div class="controls">
                            <select name="case_subject" id="case_subject" style="width: 220px">
                                <option value="<?php echo $cases_detail[ 'case_subject' ]; ?>"><?php echo $cases_detail[ 'case_subject' ]; ?></option>
                                <?php
                                if (isset($court_setting)) {
                                    $json = json_decode($court_setting->case_subject);
                                    if(isset($json)){
                                        foreach($json as $value){ ?>
                                            <option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
                                        <?php }}} ?>
                            </select><span><a title="Add-new case subject" data-toggle="modal" href="#new_case_subject">Add New</a></span>
                        </div>
                    </div>
                    <!-- End Case Subject -->
                </form>
            </div>

            <!--    case Form End-->
            <!--    Lawyer Assignment   Begins -->

            <div class="step-pane" id="step2">
                <div class="row-fluid">

                    <form class="form-horizontal" action="<?php echo URL::to_route('AddCases'); ?>"  method="post" id="assign-form" >

                        <!-- Start Opp client name -->
                        <div class="control-group">
                            <label class="control-label" for="opp_party_name">Opp.Client Name:</label>
                            <div class="controls">
                                <input type="text" id="opp_party_name" name="opp_party_name" value="<?php echo $cases_detail['opp_party_name']; ?>"/>
                            </div>
                        </div>
                        <!-- End Opp client name -->
                        <!-- Start Opp Party type -->
                        <div class="control-group">
                            <label class="control-label" for="opp_party_type">Opp.Party Type:</label>
                            <div class="controls">
                                <select name="opp_party_type" id="opp_party_type" style="width: 220px">
                                    <option value="<?php echo $cases_detail[ 'opp_party_type' ]; ?>"><?php echo $cases_detail[ 'opp_party_type' ]; ?></option>
                                    <?php
                                    if (isset($court_setting)) {
                                        $json = json_decode($court_setting->case_opp_party_type);
                                        if(isset($json)){
                                            foreach($json as $value){ ?>
                                                <option value="<?php echo $value; ?>"  ><?php echo $value; ?></option>
                                            <?php }}} ?>
                                </select><span><a title="add-new opp-party" data-toggle="modal" href="#new_opp_party">Add New</a></span>
                            </div>
                        </div>
                        <!-- End Opp Party Type -->
                        <!-- Start Opp Advocate -->
                        <div class="control-group">
                            <label class="control-label" for="opp_advocate">Opp. Advocate:</label>
                            <div class="controls">
                                <select name="opp_advocate" id="opp_advocate" style="width: 220px">
                                    <option value="<?php echo $cases_detail[ 'opp_advocate' ]; ?>" ><?php echo $cases_detail[ 'opp_advocate' ]; ?></option>
                                    <?php
                                    if (isset($court_setting)) {
                                        $json = json_decode($court_setting->opp_advocate);
                                        if(isset($json)){
                                            foreach($json as $value){ ?>
                                                <option value="<?php echo $value; ?>" ><?php echo $value; ?></option>
                                            <?php }}} ?>
                                </select><span><a title="add-new opp-advocate" data-toggle="modal" href="#new_opp_advocate">Add New</a></span>
                            </div>
                        </div>
                        <!-- End Opp Advocate -->
                        <!-- Start Court name -->
                        <div class="control-group">
                            <label class="control-label" for="court_name">CourtName:</label>
                            <div class="controls">
                                <select name="court_name" id="court_name" style="width: 220px">
                                    <option value="<?php echo $cases_detail[ 'court_name' ]; ?>"><?php echo $cases_detail[ 'court_name' ]; ?></option>
                                    <?php
                                    if (isset($court_setting)) {
                                        $json = json_decode($court_setting->case_court);
                                        if(isset($json)){
                                            foreach($json as $value){ ?>
                                                <option value="<?php echo $value; ?>"  ><?php echo $value; ?></option>
                                            <?php }}} ?>
                                </select><span><a title="add-new court" data-toggle="modal" href="#new_court">Add New</a></span>

                            </div>
                        </div>
                        <!-- End Court Name -->

                    </form>

                </div>
            </div>

            <!--    Lawyer Assignment End-->

            <!--    Profile Form Begin-->


            <div class="step-pane" id="step3">
                <div class="row-fluid">
                    <form  class="form-horizontal" id="description-form">
                        <!-- Start Case Name -->
                        <div class="control-group">
                            <label class="control-label" for="case_name">Case Name:</label>
                            <div class="controls">
                                <input type="text" name="case_name" id="case_name" value="<?php echo $cases_detail['case_name']; ?>"/>
                            </div>
                        </div>
                        <!-- End Case Name -->
                        <!-- Start Case Type -->
                        <div class="control-group">
                            <label class="control-label" for="case_type">Case Type:</label>
                            <div class="controls">
                                <input type="text" name="case_type" id="case_type" value="<?php echo $cases_detail['case_type']; ?>">
                            </div>
                        </div>
                        <!-- End Case Type -->
                        <!-- Start Case Description  -->
                        <div class="control-group">
                            <label class="control-label" for="case_description">Case description</label>
                            <div class="controls">
                                <textarea name="case_description" id="case_description" rows="2"><?php echo $cases_detail['case_description']; ?></textarea>
                            </div>
                        </div>
                        <!-- End Case Description -->
                        <!-- Start Citation Referred -->
                        <div class="control-group">
                            <label class="control-label" for="citation">Citation Referred/ Title</label>
                            <div class="controls">
                                <textarea name="citation_referred" id="citation" rows="2"><?php echo $cases_detail['citation_referred']; ?></textarea>
                            </div>
                        </div>
                        <!-- End Citation Referred -->
                        <!-- Start claim-->
                        <div class="control-group">
                            <label for="claim" class="control-label">Claim</label>
                            <div class="controls">
                                <input type="text" name="claim" id="claim" value="<?php echo $cases_detail['claim']; ?>"/>
                            </div>
                        </div>
                        <!-- End Claim -->
                    </form>

                </div>
            </div>



            <div class="step-pane" id="step4">
                <div class="center">
                    <h3 class="green">Confirmation!</h3>
                    Your Case detail add to! Click finish to continue!
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

            <button class="btn btn-success btn-next" data-last="Finish ">
                Next
                <i class="icon-arrow-right icon-on-right"></i>
            </button>
            <button class="btn btn-success" style="display: none" id="addNew">
                AddNew

            </button>
        </div>
        </div>
        </div>
        </div>
        <?php } else{  ?>
            </div>



            <div class="row-fluid">
            <div class="span12">

                <div class="span6">
                    <!--    Case Form-->


                    <form action="#"  method="post" class="form-horizontal" id="case-form">
                        <input type="hidden" name="lawyer_id" value="<?php echo $lawyer_id->uid2;  ?>"/>
                        <div class="control-group">
                            <label class="control-label" for="case_number">Case Number:</label>

                            <div class="controls">
                                <input disabled="disabled" type="text" name="case_no" id="case_number"  data-error="Please give a correct login." value="<?php echo $cases_detail['case_no']; ?>"/>

                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="case_name">Case Name:</label>
                            <div class="controls">
                                <input disabled="disabled" type="text" name="case_name" id="case_name" value="<?php echo $cases_detail['case_name'];  ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="case_type">Case Type:</label>

                            <div class="controls">
                                <input disabled="disabled" type="text" name="case_type" id="case_type" value="<?php echo $cases_detail['case_type'];  ?>"/>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="case_subject">Case Subject:</label>
                            <div class="controls">
                                <input disabled="disabled" type="text" name="case_subject" id="case_subject" value="<?php echo $cases_detail['case_subject'];  ?>">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="client_name">Client Name:</label>
                            <div class="controls">
                                <select name="client_id" id="client_name"  disabled style="width: 220px" >
                                    <option value="">Select Client</option>
                                    <?php if(isset($client)){
                                        foreach($client as $clients){
                                            ?>
                                            <option value="<?php echo $clients->client_id; ?>" <?php if($clients->client_id==$cases_detail['client_id']) { ?> selected="selected" <?php }  ?>><?php echo $clients->client_name; ?></option>
                                        <?php }} ?>
                                </select>
<!--                                <span><a data-toggle="modal" href="#new_client1">New Client</a></span>-->
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="brief_given_by">Brief Given By:</label>

                            <div class="controls">
                                <input disabled="disabled" type="text" name="brief_given_by" value="<?php echo $cases_detail['brief_given_by'];  ?>" id="brief_given_by"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="opp_advocate">Opp. Advocate:</label>
                            <div class="controls">
                                <input disabled="disabled" type="text" name="opp_advocate" id="opp_advocate" value="<?php echo $cases_detail['opp_advocate'];  ?>"/>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="opp_party_name">Opp.Party Name:</label>
                            <div class="controls">
                                <input disabled="disabled" type="text" id="opp_party_name" name="opp_party_name" value="<?php echo $cases_detail['opp_party_name'];  ?>"/>
                            </div>
                        </div>
                    </form>
                </div>

                <!--    case Form End-->
                <!--    Lawyer Assignment   Begins -->

                <div class="span6">
                    <div>

                        <form class="form-horizontal" action="<?php echo URL::to_route('AddCases'); ?>"  method="post" id="assign-form" >
                            <!--
                        <div class="control-group">
                            <label class="control-label" for="associate_lawyer">Associate:</label>
                            <div class="controls">
                                <select name="associate_lawyer[]" id="associate_lawyer" multiple="multiple"/>
                                <?php if(isset($lawyer)){
//                                    $lawyer=array_unique($lawyerz);
                                    foreach($lawyer as $lawyers){
                                        if($lawyers->updated_by==Auth::user()->id){
                                            ?>
                                            <option value="<?php echo $lawyers->id; ?>" <?php $lawyer_id=explode(',',$cases_detail['associate_lawyer']); foreach($lawyer_id as $lawyer_ids){if($lawyer_ids==$lawyers->id){ ?>selected="selected" <?php }}  ?> ><?php echo $lawyers->first_name.' '.$lawyers->last_name; ?></option>
                                        <?php }}} ?>
                                </select>
                                <span><a href="<?php echo URL::to_route('User'); ?>">Add New Advocates</a></span>
                            </div>
                        </div> -->


                            <div class="control-group">
                                <label class="control-label" for="party_type">Party Type:</label>
                                <div class="controls">
                                    <input disabled="disabled" type="text" name="party_type" id="party_type" value="<?php echo $cases_detail['party_type'];  ?>"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="opp_party_type">Opp.Party Type:</label>
                                <div class="controls">
                                    <input disabled="disabled" type="text" name="opp_party_type" id="opp_party_type" value="<?php echo $cases_detail['opp_party_type'];  ?>">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="court_name">CourtName:</label>
                                <div class="controls">
                                    <input disabled="disabled" type="text" name="court_name" id="court_name" value="<?php echo $cases_detail['court_name'];  ?>"/>
                                </div>
                            </div>
                            <form  class="form-horizontal" id="description-form">
                                <div class="control-group">
                                    <label for="claim" class="control-label">Claim</label>
                                    <div class="controls">
                                        <input disabled="disabled" type="text" name="claim" id="claim" value="<?php echo $cases_detail['claim'];  ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="citation">Citation Referred/ Title</label>
                                    <div class="controls">
                                        <textarea disabled="disabled" name="citation_referred" id="citation" rows="2"><?php echo $cases_detail['citation_referred'];  ?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="case_description">Case description</label>
                                    <div class="controls">
                                        <textarea disabled="disabled" name="case_description" id="case_description" rows="2"><?php echo $cases_detail['case_description'];  ?></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="case_color">Select Color</label>
                                    <div class="controls">
                                        <select name="case_color" id="case_color" disabled="disabled">
                                            <option value="">Select Color</option>
                                            <option value="red"  style="background-color: red">Red</option>
                                            <option value="green" style="background-color: green">Green</option>
                                            <option value="yellow" style="background-color: #ffff00">Yellow</option>
                                            <option value="<?php echo $cases_detail['case_color']  ?>" selected="selected"><?php echo ucfirst($cases_detail['case_color']);  ?></option>
                                        </select>
                                    </div>
                                </div>

                        </form>

                    </div>
                 </div>

            </div>
            </div>



    <?php } } ?>
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
        <div class="model-body">
            <form action="#"  class="form-horizontal" id="party_type_form" onsubmit="return addpartytype();">
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
<div id="new_client1" class="modal hide fade" style="display: none; ">

    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>New Client</h3>
    </div>
    <div class="modal-body">


        <form class="form-horizontal" action="#" method="post" id="AddClientForm" onsubmit="return a();">
            <div class="control-group">
                <?php $id=Auth::user()->id; $lawyer_id=liblawyer::getlawyerIDByassociateID($id); ?>

                <input type="hidden" name="update_by" value="<?php echo $lawyer_id->uid2;  ?>"/>
                <label class="control-label" for="client_name">Client name:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="client_name" id="client_name"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="mobile" id="mobile"/>
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
                <label class="control-label" for="pincode">Pincode<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="pincode" id="pincode"/>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" id="AddClient">Add</button>
                </div>
            </div>

        </form>

    </div>
<script>
    function a()
    {

        $.post("<?php echo URL::to_route('AddClient'); ?>",$('#AddClientForm').serializeArray())
            .success(function(data){
                var values=data.split(',');
                var select=document.getElementById('client_name');
                var opt=document.createElement('option');
                opt.value=values[1];
                opt.innerHTML=values[0];
                select.appendChild(opt);
               $('#client_name').select2().select2('val',values[1]);
               $('#new_client1').modal('hide');

            }
        );
        return false;
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
        $('#client_name').select2();
        $('#opp_party_type').select2();
        $('#court_name').select2();
        $('#party_type').select2();
        $('#opp_advocate').select2();
        $('#case_subject').select2();

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
            }).
                on('finished' , function(e, info){
                    var a=$("#case-form").serializeArray();
                    var b=$("#assign-form").serializeArray();
                    var c=$("#description-form").serializeArray();
                    var tot= $.merge(a,b);
                    var all= $.merge(tot,c);

                    $.post("<?php echo URL::to_route('UpdateCases'); ?>",all)
                        .success(function(data){
                            alert('Successfully updated');
                            window.location = "<?php echo URL::to_route('ViewCases'); ?>";
                        })
                        .error(function(data){
                            alert('Case failed to add');
                            window.location="<?php echo URL::to_route('ViewCases'); ?>";
                        })
                    ;



                });
            $('#btnAddNew').click(function(){
                alert("ewdfew");
            })


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


<?php echo render('admin::associate/template.main'); ?>