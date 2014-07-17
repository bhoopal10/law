<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="page-header position-relative">
            <h1>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Documents
                </small>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php } ?>
<?php if(isset($document)){ Session::put('document',$document); ?>
<?php $case=libcase::getcasedetail(); ?>
    <div class="row-fluid">
        <div class="span12">
            <form class="form-horizontal" action="<?php echo URL::to_route('UpdateDocument');  ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="lawyer_id" value="<?php echo Crypter::encrypt(Auth::user()->id);?>"/>
                <input type="hidden" name="doc_id" value="<?php echo Crypter::encrypt($document->doc_id);  ?>"/>
                <div class="control-group">
                    <label class="control-label" for="case_link">Case Link:</label>
                    <div class="controls">
                        <select name="case_link" id="case_link">
                            <option value="">Select Case</option>
                            <?php foreach ($case as $case_id) {?>
                                <option value="<?php echo $case_id->case_no;?>" <?php if($case_id->case_no==$document->doc_case_no){ ?>selected="selected" <?php }  ?>><?php echo $case_id->case_name.'('.$case_id->case_no.')';  ?></option>
                            <?php }  ?>

                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="doc_name">Document Name:</label>
                    <div class="controls">
                        <input type="text" name="doc_name" id="doc_name" value="<?php echo $document->doc_name; ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="doc_file">Document:</label>
                    <div class="controls">
                        <input type="file" name="doc_file" id="doc_file"/>
                        <label>
                         <span class="lbl"><?php echo $document->doc_file_name;  ?></span>
                        </label>
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
    </script>

<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>