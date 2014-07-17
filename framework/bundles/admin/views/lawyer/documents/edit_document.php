<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="page-header position-relative">
            <h1><i class="icon icon-book"></i>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Documents
                    <i class="icon-double-angle-right"></i>
                    <span style="cursor: pointer" onclick="history.go(-1);">Back</span>
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

<?php if(isset($document)){ Session::put('document',$document);?>
<?php $case=libcase::getcasedetail(); ?>
    <div class="row-fluid">
        <div class="span12">
            <form name="form1" class="form-horizontal" action="<?php echo URL::to_route('UpdateDocument');  ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);?>"/>
                <input type="hidden" name="doc_id" value="<?php echo Crypter::encrypt($document->doc_id);  ?>"/>
                <div class="control-group">
                    <label class="control-label" for="case_link">Case Link:</label>
                    <div class="controls">
                        <input type="text" name="case_link" value="<?php $case_link = get_value_from_multi_object_array($document->doc_case_no,$case,'case_id','case_no');$case_name=get_value_from_multi_object_array($document->doc_case_no,$case,'case_id','case_name'); echo $case_name.'('.$case_link.')'; ?>" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="doc_name">Document Name:<span style="color: red">*</span></label>
                    <div class="controls">
                        <input type="text" name="doc_name" id="doc_name" value="<?php echo $document->doc_name; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="doc_file">Document:</label>
                    <div class="controls">
                        <input type="file" name="doc_file" id="doc_file"/>
<!--                        <label>-->
<!--                         <span class="lbl">--><?php //echo $document->doc_file_name;  ?><!--</span>-->
<!--                        </label>-->
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="description">Description:</label>
                    <div class="controls">
                        <textarea name="doc_description" id="description" rows="2"><?php echo $document->doc_description;  ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <button class="btn btn-danger" type="reset">Reset</button>
                    </div>
                </div>


            </form>

        </div>
    </div>
<?php }  ?>
    <script type="text/javascript">
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
            var doc_name=document.form1.doc_name.value;

            if(!doc_name)
            {
                alert('Please enter document name');
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
<?php echo render('admin::lawyer/template.main'); ?>