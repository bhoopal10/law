<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                   View Documents
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
    <div class="row-fluid">

        <div class="span12">
            <a href="<?php echo URL::to_route('Documents'); ?>">
           <button class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new document</button>
            </a>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Case No</th>
                    <th>Case Name</th>
                    <th>Upload Detail</th>
                    <th></th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php $path=path('public').Config::get('admin::admin_config.image_path').'documents/';  ?>
                <?php if (isset($document)) { $case=libcase::getcasedetail();
                    foreach ($document->results as $documents) {?>
                        
                <tr class="">
                    <td><?php echo $documents->doc_name;  ?></td>
                    <td><?php echo $documents->doc_case_no;  ?></td>
                    <td><?php if($case){foreach($case as $cases){if($cases->case_no==$documents->doc_case_no){echo $cases->case_name;}}}  ?></td>
                    <td><?php echo $documents->create_date;  ?></td>
                    <td><?php echo $documents->doc_file_name;  ?></td>
                    <td class="td-actions ">
                        <div class="hidden-phone visible-desktop btn-group">

                            <a class="btn btn-mini btn-info" title="Edit" href="<?php echo URL::to_route('EditDocument').'/'.Crypter::encrypt($documents->doc_id); ?>">
                                <i class="icon-edit bigger-120"></i>
                            </a>

                            <a class="btn btn-mini btn-danger" title="Delete" onclick="return confirm('Really want to delete!');" href="<?php echo URL::to_route('DeleteDocument').'/'.Crypter::encrypt($documents->doc_id); ?>">
                                <i class="icon-trash bigger-120"></i>
                            </a>

                            <a class="btn btn-mini btn-warning" title="Download" href="<?php echo URL::to_route('DocumentDownload').'/'.Crypter::encrypt($path.$documents->doc_file_name);  ?>">
                                <i class="icon-download-alt bigger-120"></i>
                            </a>
                        </div>

                    </td>
                </tr>
                <?php }}  ?>
             

                </tbody>
            </table>
<?php echo $document->links();  ?>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('.btn').tooltip({ placement : 'left'})

        });
    </script>

<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>