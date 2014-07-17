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
        $client=libclient::getclientByLawyerID($user_id);
       $hearings=Session::get('hearings');
        $case_id=Session::get('case_id');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php } ?>

<div class="row-fluid">
    <?php if (!isset($hearings)) { ?>
        <form class="form-horizontal" action="<?php echo URL::to_route('SelectCase'); ?>" method="get">
            <div class="control-group">
                <label class="control-label" for="case_no">Case No:</label>
                <div class="controls">
            <select name="case_id" id="case_no" onchange="this.form.submit()" style="width: 220px">
                <option value="">Select Case</option>
                <?php $case=libcase::getcasedetail();foreach($case as $cases){ if($cases->lawyer_id==$user_id){ ?>
                    <option value="<?php echo $cases->case_id;  ?>"><?php $client_name=get_value_from_multi_object_array($cases->client_id,$client,'client_id','client_name'); echo $cases->case_no.'('.$client_name.')';  ?></option>
                <?php } } ?>
            </select>

                </div>
            </div>
        </form>

    <?php }else { ?>

        <?php if ($case_id) $case = libcase::getcasedetailByID($case_id); ?>
    <form name="form2" class="form-horizontal" action="<?php echo URL::to_route('AddHearing'); ?>" method="post" onsubmit="return dateValidation()">
        <input type="hidden" name="lawyer_id" value="<?php echo $user_id; ?>"/>
        <input type="hidden" name="updated_by" value="<?php echo $user_id; ?>"/>

        <div class="control-group">
            <label class="control-label" for="docket_no">Docket No:</label>
            <div class="controls">
                <input type="text" name="docket_no" readonly value="<?php if($case){ echo $case->docket_no;}?>">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="docket_no">Crime No:</label>
            <div class="controls">
                <input type="text" name='crime_no' readonly value="<?php if($case){ echo $case->crime_no;}?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="case_no">Case No:</label>
            <div class="controls">
                <input type="text" value="<?php if (isset($case_id)){ $case = libcase::getcasedetailByID($case_id);$client_name=get_value_from_multi_object_array($case->client_id,$client,'client_id','client_name'); echo $case->case_no.'('.$client_name.')';} ?>" readonly/>
                <input type="hidden" name="case_id" value="<?php if(isset($case_id)) echo $case_id; ?>"/>
                <input type="hidden" name="client_id" value="<?php if(isset($case_id)) echo $case->client_id; ?>"/>
                <input type="hidden" name="opp_party_name" value="<?php if(isset($case_id)) echo $case->opp_party_name; ?>"/>


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
            <label class="control-label" for="court_hall">Court Hall:<span style="color: red">*</span></label>
            <div class="controls">
                <input name="court_hall" id="court_hall" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="judge">Judge Name:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="judge" name="judge" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="stage">Stage:<span style="color: red">*</span></label>
            <div class="controls">
                <input id="stage" name="stage" type="text"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="doc_no">Document:</label>
            <div class="controls">
                <select id="doc_no" name="doc_no" style="width: 220px">
                    <?php $doc=libdocument::getdocumentByLawyerID($user_id); foreach($doc as $docs){  ?>
                    <option value="<?php echo $docs->doc_id  ?>"><?php echo $docs->doc_name;  ?></option>
                    <?php }  ?>
                </select>
                <span><a title="Add new document" data-toggle="modal" href="#addDocument">Add New</a></span>
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


<?php $case=libcase::getcasedetail(); ?>
<div id="addDocument" class="modal hide fade" style="display: none">
 <div class="modal-header">
<button class="close" data-dismiss="modal">×</button>
<h3>New Document</h3>
</div>


    <div class="span12 modal-body">
        <form id="uploadDoc" name="form1" class="form-horizontal" action="<?php echo URL::to_route('AddHearingDocuments'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);?>"/>

           <div class="control-group">
                <label class="control-label" for="case_link">Case Link:</label>
                <div class="controls">

                    <input type="text" value="<?php if (isset($case_id)){ $case = libcase::getcasedetailByID($case_id);$client_name=get_value_from_multi_object_array($case->client_id,$client,'client_id','client_name'); echo $case->case_no.'('.$client_name.')';} ?>" readonly/>
                    <input type="hidden" name="case_link" value="<?php if(isset($case_id)) echo $case_id; ?>"/>

                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="doc_name">Document Name:</label>
                <div class="controls">
                    <input type="text" name="doc_name" id="doc_name"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="doc_file">Document:</label>
                <div class="controls">
                    <input type="file" name="doc_file" id="doc_file"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="description">Description:</label>
                <div class="controls">
                    <textarea name="doc_description" id="description" rows="2"></textarea>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit">Upload</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>
            </div>


        </form>

    </div>

</div>


<script>
    $(function(){
       $('span').tooltip({placement:'bottom'});
       $('a').tooltip({placement:'bottom'});
    });
    $(document).ready(function(){
       $('#case_no').select2();
        $('#doc_no').select2();
    });
</script>
<script type="text/javascript">
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

        var court_hall=document.form2.court_hall.value;
        var judge=document.form2.judge.value;
        var stage=document.form2.stage.value;
        var require={stage: stage,court_hall: court_hall,judge: judge};
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
    var fl = document.getElementById('doc_file');
    fl.onchange = function(){

        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
            case 'doc':
                return true;

            case 'docx':
                return true;

            case 'pdf':
                return true;
            case 'xls':
                return true;
            case 'jpg':
                return true;
            case 'jpeg':
                return true;
            case 'png':
                return true;
            default:
                alert('Upload only .doc, docx, pdf, excel, jpg, jpeg file');
                this.value='';
        }
    };

        $("#uploadDoc").submit(function(e)
        {

            var formObj = $(this);
            var formURL = formObj.attr("action");
            var formData = new FormData(this);
            var doc_name=document.form1.doc_name.value;
            $.ajax({
                url:formURL,
                type: 'POST',
                data:  formData,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR)
                {
                    var values=doc_name;
                    var select=document.getElementById('doc_no');
                    var opt=document.createElement('option');
                    opt.value=data;
                    opt.innerHTML=doc_name;
                    select.appendChild(opt);
                      $('#doc_no').select2().select2('val',data);
                    $('#addDocument').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                }
            });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });








</script>
<style type="text/css">
    label{
        color:#F27C38;
    }
</style>
<?php Section::stop(); ?>

<?php echo render('admin::lawyer/template.main'); ?>

