<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/2/14
 * Time: 1:37 PM
 */ ?>
<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="page-header position-relative">
            <h1><i class="icon icon-bell"></i>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Documents
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
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
            <form name="form1" class="form-horizontal" action="<?php echo URL::to_route('AddEditHearingDocument');  ?>" method="post" enctype="multipart/form-data" onsubmit="return validation();">
                <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);?>"/>
                <div class="control-group">
                    <label class="control-label" for="case_link">Case Link:</label>
                    <div class="controls">
                        <input type="hidden" name="hearing_id" value="<?php echo $hearing_id; ?>">
                        <input type="text" value="<?php if (isset($case_id)) $case = libcase::getcasedetailByID($case_id);{echo $case->case_no . '(' . $case->case_name . ')';} ?>" readonly/>
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
    <script type="text/javascript">
        $(function(){
           $('span').tooltip({placement:'bottom'})
        });
        $(document).ready(function(){
            $('#case_link').select2();
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
        color:#F27C38;
    }
</style>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>