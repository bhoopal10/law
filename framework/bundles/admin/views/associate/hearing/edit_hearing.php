<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-bell"></i>
            Hearing
            <small>
                <i class="icon-double-angle-right"></i>
                Edit Hearing
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');?>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>

<div class="row-fluid">
    <form name="form2" class="form-horizontal" action="<?php echo URL::to_route('UpdateHearing'); ?>" method="post" onsubmit="return dateValidation();">
        <input type="hidden"  value="<?php $user_id=Auth::user()->id;  ?>"/>
        <input type="hidden" value="<?php echo $hearing->hearing_id; ?>" name="hearing_id">
        <?php Session::put('hearing',$hearing);  ?>
        <div class="control-group">
            <label class="control-label" for="case_no">Case No:</label>
            <div class="controls">
                <input type="text" readonly value="<?php  $case=libcase::getcasedetail(); $case_no=get_value_from_multi_object_array($hearing->case_id,$case,'case_id','case_no'); $case_name=get_value_from_multi_object_array($hearing->case_id,$case,'case_id','case_name'); echo $case_no.'('.$case_name.')';?>"/>
<!--                <select name="case_id" id="case_no">-->
<!--                    --><?php //$case=libcase::getcasedetail();foreach($case as $cases){  ?>
<!--                        <option value="--><?php //echo $cases->case_id;  ?><!--" --><?php //if($hearing->case_id==$cases->case_id){?><!--selected="selected" --><?php //}  ?><!-- > --><?php //echo $cases->case_no.'('.$cases->case_name.')';  ?><!--</option>-->
<!--                    --><?php //}  ?>
<!--                </select>-->
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="hearing_date">Hearing Date:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" class="datepicker" id="dup_from"  value="<?php echo date('d/m/Y',strtotime($hearing->hearing_date));  ?>" readonly/>
                <input type="hidden" class="datepicker" id="hearing_date" name="hearing_date" value="<?php echo $hearing->hearing_date;  ?>" readonly/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="next_hearing_date">Next Hearing Date:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" class="datepicker" id="dup_to" value="<?php echo date('d/m/Y',strtotime($hearing->next_hearing_date));  ?>"/>
                <input type="hidden" class="datepicker" id="next_hearing_date" name="next_hearing_date" value="<?php echo $hearing->next_hearing_date;  ?>" onchange="return dateValidation();"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="stage">Stage:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="stage" name="stage" type="text" value="<?php echo $hearing->stage;  ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="court_hall">Court Hall:<span style="color: red">*</span></label>
            <div class="controls">
                <input name="court_hall" id="court_hall" type="text" value="<?php echo $hearing->court_hall;  ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="judge">Judge:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="judge" name="judge" type="text" value="<?php echo $hearing->judge;  ?>"/>

            </div>
        </div>
        <!-- <div class="control-group">
            <label class="control-label" for="docket_no">Docket No:<span style="color: red">*</span></label>
            <div class="controls">
                <input type="text" name="docket_no" id="docket_no" value="<?php echo $hearing->docket_no;  ?>">
            </div>
        </div> -->
        <div class="control-group">
            <label class="control-label" for="doc_no">Document:</label>
            <div class="controls">
                <select id="doc_no" name="doc_no" style="width: 220px">
                    <?php $doc=libdocument::getdocument();
                    $permission=libcase::getcaseIDByassociateID($user_id);
                    foreach($doc as $docs){  foreach($permission as $permission1){ if($docs->doc_case_no==$permission1->case_id && $permission1->permission!=0){?>
                        <option value="<?php echo $docs->doc_id  ?>" <?php if($hearing->doc_no==$docs->doc_id){ ?>selected="selected" <?php }  ?> > <?php echo $docs->doc_name;  ?></option>
                    <?php } } } ?>
                </select>
                <span><a title="Add new document" href="<?php echo URL::to_route('EditHearingDocument').'/'.$hearing->case_id.','.$hearing->hearing_id;?>"> Add New</a></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="action_plan">Action Plan</label>
            <div class="controls">
                <textarea name="action_plan" id="action_plan" rows="2"><?php echo $hearing->action_plan;  ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">Description:</label>
            <div class="controls">
                <textarea name="description" id="description" rows="2"><?php echo $hearing->description;  ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button class="btn btn-primary" type="submit">Update Hearing</button>
                <button class="btn btn-danger" type="reset">Reset</button>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    $(function(){
        $('span').tooltip({placement:'bottom'});
        $('a').tooltip({placement:'bottom'});
    });
    $(document).ready(function(){
       $('#doc_no').select2();
    });
//    $('#dup_from').datepicker({dateFormat:"dd/mm/yy",
//        altField:'#hearing_date',
//        altFormat:'yy-mm-dd',
//        changeMonth: true,
//        changeYear: true
//    });
    $('#dup_to').datepicker({dateFormat:"dd/mm/yy",
        altField:"#next_hearing_date",
        altFormat:'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });
    <?php $case=libcase::getcasedetail(); ?>

    var case_no=<?php $cases=array(); if(isset($case)){foreach($case as $case_no){array_push($cases,$case_no->case_no);} $values=array_unique($cases); echo json_encode($values);} ?>;
    $('#case_no').autocomplete(
        {
            source:case_no,
            autoFocus: true
        }
    )


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
<style type="text/css">
    label{
        color:#F27C38;
    }
</style>
<?php Section::stop(); ?>

<?php echo render('admin::associate/template.main'); ?>

