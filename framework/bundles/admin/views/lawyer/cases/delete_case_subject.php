<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case Subject
                <small>
                    <i class="icon-double-angle-right"></i>
                    Delete Case subject
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
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
if(isset($error)){ ?>
    <div class="alert alert-alerts">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php } ?>
    <div class="row-fluid">
        <form name="form1"  action="<?php echo URL::to_route('MultiCaseAttriDelete'); ?>" method="post" >
    <span id="del" style="display: none">
                <button class="btn btn-mini btn-danger" type="submit"><i class="icon-trash"></i>Delete</button>
            </span>
            <span>
        <a data-toggle="modal" class="btn btn-mini btn-info" href="#add" >Add New</a>
    </span>
            <table class="table table-bordered table-stripped" id="mytable" >
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Party Type</th>

                </tr>
                </thead>
                <tbody>
                <?php $case = libcase::getCaseAttributeByLawyerID(Auth::user()->id); $case1=json_decode($case->case_subject);
                if(count($case1)!=0){
                    foreach($case1 as $values){
                        ?>
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" name="case_subject[]" value="<?php echo $values; ?>" >
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo ucfirst($values); ?></td>

                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </form>
    </div>
    <!-- Start New Case Subject -->
    <div id="add" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Case Subject</h3>
        </div>
        <div class="span12 model-body">
            <div class="span2">
                <form action="#"  class="form-inline" id="case_subject_form" onsubmit="return addcasesubject();">
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
    </div>
    <!--END New Case Subject -->
    <script>
        function addcasesubject()
        {
            $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#case_subject_form').serializeArray())
                .success(function(data){
                    var values=data;
                    $('#mytable tr:last').after('<tr><td><label><input type="checkbox" name="case_subject[]" value="'+values+'"/>'
                        +'<span class="lbl"></span>'
                        +'</label>'
                        +'</td>'
                        +'<td>'
                        +values
                        +'</td>'
                        +'</tr>'
                    );
                    $('#add').modal('hide');

                });
            return false;
        }
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
<?php echo render('admin::lawyer/template.main'); ?>