<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="page-header position-relative">
            <h1><i class="icon-book"></i>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Documents
                </small>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button class="close" type="button" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
if(isset($error)){ ?>
    <div class="alert alert-alert">
        <button class="close" type="button" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $error; ?></span>
    </div>
<?php }?>
<?php $case=libcase::getcasedetail(); ?>
    <div class="row-fluid">
        <div class="span12">
            <form name="form1" onsubmit="return validation();" class="form-horizontal" action="<?php echo URL::to_route('AddDocument');  ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="associate_id" value="<?php $user_id=Auth::user()->id; echo Crypter::encrypt($user_id);?>"/>
                <input type="hidden" name="lawyer_id" value="<?php $law_id=liblawyer::getlawyerIDByassociateID($user_id);echo Crypter::encrypt($law_id->uid2); ?>"/>

                <div class="control-group">
                    <label class="control-label" for="case_link">Case Link: <span style="color: red">*</span> </label>
                    <div class="controls">
                        <select name="case_link" id="case_link" style="width: 220px">
                            <option value="">Select Case</option>
                            <?php $case_detail=libcase::getcasedetail(); $case=libcase::getcaseIDByassociateID($user_id);foreach($case as $cases){ if($cases->permission != 0){ ?>
                                <option value="<?php echo $cases->case_id;  ?>"><?php $case_no=get_value_from_multi_object_array($cases->case_id,$case_detail,'case_id','case_no');$case_name=get_value_from_multi_object_array($cases->case_id,$case_detail,'case_id','case_name');echo $case_no.'('.Ucfirst($case_name).')';  ?></option>
                            <?php } } ?>
                        </select>
<!--                        <span><a href="--><?php //echo URL::to_route('Cases')  ?><!--">New case</a></span>-->
                    </div>
                </div>

                <!--            <div class="control-group">-->
                <!--                <label class="control-label" for="hearing">Hearing:</label>-->
                <!--                <div class="controls">-->
                <!--                    <select name="hearing" id="hearing">-->
                <!--                        <option value="">Select Hearing</option>-->
                <!--                        --><?php //$hearing=libhearing::gethearing(); foreach ($hearing as $hearings) { ?>
                <!--                            <option value="--><?php //echo $hearings->hearing_id;  ?><!--">--><?php //echo $hearings->;  ?><!--</option>-->
                <!--                        --><?php //}  ?>
                <!--                    </select>-->
                <!--                    <span><a href="--><?php //echo URL::to_route('Cases')  ?><!--">New case</a></span>-->
                <!--                </div>-->
                <!--            </div>-->

                <div class="control-group">
                    <label class="control-label" for="doc_name">Document Name:<span style="color: red">*</span></label>
                    <div class="controls">
                        <input type="text" name="doc_name" id="doc_name"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="doc_file">Document:<span style="color: red">*</span></label>
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
    function validation()
    {

        var case_link=document.form1.case_link.value;
        var doc=document.getElementById('doc_file');

        if(!case_link)
        {
            alert("please select case link");
            return false;
        }
            if(!doc)
            {
                alert('please select any document');
                return false;
            }
    }
</script>
   <script>
       $(document).ready(function(){
           $('#case_link').select2();
       });
        $(function() {

        });
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

       function validation()
       {
           var case_link=document.form1.case_link.value;
           var doc_name=document.form1.doc_name.value;
           var doc_file=document.form1.doc_file.value;

           if(!case_link)
           {
               alert('Please select case link');
               return false;
           }
           if(!doc_name)
           {
               alert('Please enter document name');
               return false;
           }
           if(!doc_file)
           {
               alert('Please upload document');
               return false;
           }
       }
    </script>
<style type="text/css">
    label{
        color:#1EC79D;
    }
</style>
<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>