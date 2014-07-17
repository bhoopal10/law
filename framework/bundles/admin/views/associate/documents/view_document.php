<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon-book"></i>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                   View Documents
                    <i class="icon-double-angle-right"></i>
                    <span style="cursor: pointer" onclick="history.go(-1);">Back</span>
                <a href="<?php echo URL::to_route('Documents'); ?>" class="btn btn-mini " style="float: right">
                    Add new document
                </a><span class="pull-right">&nbsp;</span>
                <a href="<?php echo URL::to_route('ViewDocuments'); ?>" class="btn btn-mini btn-file" style="float: right">
                    ViewAll
                </a>
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


    <div class="row-fluid">

        <div class="span12">
        <span>
        <?php $user_id=liblawyer::lawyerIdByAssoId(Auth::user()->id);
              $search=libdocument::getdocumentByLawyerID($user_id); ?>

            <form name="search" action="" method='get' onsubmit="return validation()">
                <select class='select2 span2' style="width:200px;" name="doc_name" onchange="this.form.submit()">
                    <option value=''>searchByDocName</option>
                    <?php if($search){foreach($search as $docName){ ?>
                    <option value="<?php echo $docName->doc_name ?>" <?php echo (Input::old('doc_name') == $docName->doc_name )?'selected':'';?>>
                    <?php echo $docName->doc_name; ?>
                    </option>
                        <?php }} ?>
                </select>
                <select class="select2 span2" style="width:200px;" name="case_no" onchange="this.form.submit()">
                    <option value=''>SearchByCaseNo</option>
                    <?php if($search){foreach($search as $caseNo){?>
                        <option value="<?php echo $caseNo->doc_case_no; ?>" <?php echo (Input::old('case_no') == $caseNo->doc_case_no)?'selected':''; ?>>
                        <?php echo libcase::caseNoById($caseNo->doc_case_no); ?>
                        </option>
                        <?php }} ?>
                </select>
                <input type="text" name='from_date' class="span2" placeholder="FromDate" id="from" <?php echo (Input::old('from_date')?'value="'.Input::old('from_date').'"':''); ?> onchange="this.form.submit();">TO
                <input type="text" name='to_date' class="span2" placeholder="ToDate" id="to" <?php echo (Input::old('to_date')?'value="'.Input::old('to_date').'"':''); ?> onchange="this.form.submit()">
            </form>
        </span>
<form action="<?php echo URL::to_route('MultiDocumentDelete') ?>" method="post">
            <span id="del" style="display: none">
                <button class="btn btn-mini btn-danger" type="submit"><i class="icon-trash"></i>Delete</button>
            </span>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Document Name</th>
                    <th>Case No</th>
                    <th>Case Name</th>
                    <th>Upload Detail</th>
                    <th>Download</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php if (isset($document)) { $case=libcase::getcasedetail();
                    foreach ($document->results as $documents) { ?>
                        
                <tr class="">
                    <td class="left">
                        <label>
                            <input type="checkbox" name="document_delete[]" value="<?php echo $documents->doc_id; ?>">
                            <span class="lbl"></span>
                        </label>
                    </td>
                    <td><?php echo $documents->doc_name;  ?></td>
                    <td><?php echo get_value_from_multi_object_array($documents->doc_case_no,$case,'case_id','case_no');  ?></td>
                    <td><?php echo get_value_from_multi_object_array($documents->doc_case_no,$case,'case_id','case_name');  ?></td>
                    <td><?php $date=$documents->create_date; echo date('d/m/Y',strtotime($date)); ?></td>
                    <td><a href="<?php echo URL::to_route('DocumentDownload').'/'.Crypter::encrypt($documents->doc_file_name);  ?>"><i class="icon-file"></i>&nbsp;&nbsp;Document</a></td>
                    <td class="td-actions ">
                        <div class="hidden-phone visible-desktop btn-group">
                            <a class="btn btn-mini btn-info" title="Edit" href="<?php echo URL::to_route('EditDocument').'/'.$documents->doc_id; ?>">
                                <i class="icon-edit bigger-120"></i>
                            </a>
                            <a class="btn btn-mini btn-danger" title="Delete" onclick="return confirm('Really want to delete!');" href="<?php echo URL::to_route('DeleteDocument').'/'.$documents->doc_id; ?>">
                                <i class="icon-trash bigger-120"></i>
                            </a>

                        </div>

                    </td>
                </tr>
                <?php }}  ?>
             

                </tbody>
            </table>
    </form>
<?php echo $document->links();  ?>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('.btn').tooltip({ placement : 'left'})

        });
        $(function(){
            $('table th input:checkbox').on('click',function(){
                var that=this;

                $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function(){
                        this.checked=that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    })
            })


        });


        $(document).ready(function () {
            $('#del').hide();
            $('#from').datepicker({
                dateFormat:'dd/mm/yy',
                defaultDate: "+1w",
                changeMonth:true,
                changeYear:true,
                onClose:function(selectedDate){
                    $("#to").datepicker("option",'minDate',selectedDate);
                }
            });
            $('#to').datepicker({
                 dateFormat:'dd/mm/yy',
                defaultDate: "+1w",
                 changeMonth:true,
                changeYear:true,
                onClose:function(selectedDate){
                    $("#from").datepicker("option","maxDate",selectedDate);
                }
            });
            $('.select2').select2();
            var count =function(){
                var n=$("input:checked").length;
                if(n >=1 )
                {
                    $('#del').show();
                }
                else
                {
                    $('#del').hide();
                }
            };
            count();
            $( "input[type=checkbox]" ).on( "click", count );
        });
   

    </script>

<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>