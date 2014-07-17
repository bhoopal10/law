<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-bell"></i>
            Hearing
            <small>
                <i class="icon-double-angle-right"></i>
                Add Hearing
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
<?php $status=Session::get('status');
$user_id=Auth::user()->id;
$case=libcase::getcaseIDByassociateID($user_id);

$hearings=Session::get('hearings');
$case_id=Session::get('case_id');
//echo "<pre>";print_r($case);exit;
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>

<div class="row-fluid">
    <?php if (!isset($hearings)) { ?>
        <form class="form-horizontal" action="<?php echo URL::to_route('SelectCase'); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="case_no">Case No:</label>
                <div class="controls">
                    <select name="case_id" id="case_no" onchange="this.form.submit()" style="width: 220px">
                        <option value="">Select Case</option>
                        <?php foreach($case as $cases){  ?>
                            <option value="<?php echo $cases->case_id;  ?>"><?php $case_name=libcase::getcasedetailByID($cases->case_id);if($case_name!=""){ echo $case_name->case_no.'('.$case_name->case_name.')';  ?></option>
                        <?php }} ?>
                    </select>
                    <span><a href="<?php echo URL::to_route('Cases');  ?>">New Case</a></span>
                </div>
            </div>
        </form>

    <?php }else { ?>
        <?php if ($case_id) $case = libcase::getcasedetailByID($case_id); ?>
    <form name="form2" class="form-horizontal" action="<?php echo URL::to_route('AddHearing'); ?>" method="post" onsubmit="return dateValidation();">
        <input type="hidden" name="lawyer_id" value="<?php  $law_id=liblawyer::getlawyerIDByassociateID($user_id); echo $law_id->uid2; ?>"/>
        <input type="hidden" name="updated_by" value="<?php  echo $user_id; ?>"/>

        <div class="control-group">
            <label class="control-label" for="docket_no">Docket No:</label>
            <div class="controls">
                <input type="text" readonly name="docket_no" value="<?php if($case){ echo $case->docket_no;}?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="crime_no">Crime No:</label>
            <div class="controls">
                <input type="text" readonly name="crime_no" value="<?php if($case){ echo $case->crime_no;}?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="case_no">Case No:</label>
            <div class="controls">
                <input type="text" value="<?php if (isset($case_id)) $case1 = libcase::getcasedetailByID($case_id);{echo $case1->case_no . '(' . $case1->case_name . ')';} ?>" readonly/>
                <input type="hidden" name="case_id" value="<?php if(isset($case_id)) echo $case_id; ?>"/>
                <input type="hidden" name="client_id" value="<?php if(isset($case_id)) echo $case1->client_id; ?>"/>
                <input type="hidden" name="opp_party_name" value="<?php if(isset($case_id)) echo $case1->opp_party_name; ?>"/>

                <!--                <span><a href="--><?php //echo URL::to_route('Cases');  ?><!--">New case</a></span>-->
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="hearing_date">Hearing Date:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text"  id="dup_from" />
                <input type="hidden" class="datepicker" id="hearing_date" name="hearing_date"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="next_hearing_date">Next Hearing Date:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" id="dup_to" />
                <input type="hidden" class="datepicker" id="next_hearing_date" name="next_hearing_date"  />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="stage">Stage:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="stage" name="stage" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="court_hall">Court Hall:<span style="color: red">*</span></label>
            <div class="controls">
                <input name="court_hall" id="court_hall" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="judge">Judge:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="judge" name="judge" type="text"/>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="doc_no">Document:</label>
            <div class="controls">
                <select id="doc_no" name="doc_no" style="width: 220px">
                    <?php $doc=libdocument::getdocument();
                    $permission=libcase::getcaseIDByassociateID($user_id);
                    foreach($doc as $docs){  foreach($permission as $permission1){ if($docs->doc_case_no==$permission1->case_id && $permission1->permission!=0){?>
                        <option value="<?php echo $docs->doc_id  ?>"><?php echo $docs->doc_name;  ?></option>
                    <?php } } } ?>
                </select>
                <span><a title="Add new document" href="<?php echo URL::to_route('CaseDocument').'/'.$case_id;?>">Add New</a></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="action_plan">Action Plan</label>
            <div class="controls">
                <textarea name="action_plan" id="action_plan" rows="2"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">Description:</label>
            <div class="controls">
                <textarea name="description" id="description" rows="2"></textarea>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit">Add Hearing</button>
                <button class="btn btn-danger" type="reset">Reset</button>
            </div>
        </div>

    </form>
    <?php } ?>
</div>

<script type="text/javascript">
$(function(){
   $('span').tooltip({placement:'bottom'});
   $('a').tooltip({placement:'bottom'});
});
    <?php $case=libcase::getcasedetail(); ?>


    var case_no=<?php $cases=array(); if(isset($case)){foreach($case as $case_no){array_push($cases,$case_no->case_no);} $values=array_unique($cases); echo json_encode($values);} ?>;
    $('#case_no').autocomplete(
        {
            source:case_no,
            autoFocus: true
        }
    )

    $('#dup_from').datepicker({dateFormat:"dd/mm/yy",
        altField:'#hearing_date',
        altFormat:'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    $('#dup_to').datepicker({dateFormat:"dd/mm/yy",
        altField:"#next_hearing_date",
        altFormat:'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    function dateValidation()
    {
        var dup_from=document.getElementById('dup_from').value;
        var dup_to=document.getElementById('dup_to').value;
        var from=document.form2.hearing_date.value;
        var to=document.form2.next_hearing_date.value;
        var stDate = new Date(from);
        var enDate = new Date(to);
        var compDate = enDate - stDate;
        var docket_no=document.form2.docket_no.value;
        var court_hall=document.form2.court_hall.value;
        var judge=document.form2.judge.value;
        var stage=document.form2.stage.value;

        var require={stage: stage,court_hall: court_hall,judge: judge,docket_no: docket_no};
        if(!dup_from)
        {
            alert("Please Enter Hearing Date");
            document.getElementById('dup_from').focus();
            return false;
        }
        if(!dup_to)
        {
            alert("Please Enter Next Hearing Date");
            document.getElementById('dup_to').focus();
            return false;
        }
        if(!(compDate >= 0))
        {
            alert("Next Hearing date must greater than Hearing date");
            document.getElementById('dup_to').focus();
            return false;
        }
        for( var requires in require)
        {

            if(!require[requires])
            {
                alert("Please Enter "+requires+" field");
                document.form2.elements[requires].focus();
                return false;
            }
        }





    }



</script>
<script>
    $(document).ready(function(){
        $('#case_no').select2();
        $('#doc_no').select2();
//        alert('sdfs');
    });
</script>
<style type="text/css">
    label{
        color:#F27C38;
    }
</style>
<?php Section::stop(); ?>

<?php echo render('admin::associate/template.main'); ?>

