<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
               Court
                <small>
                    <i class="icon-double-angle-right"></i>
                    Delete Court
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
            <table class="table table-bordered table-stripped" id="mytable">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Court Name</th>
                </tr>
                </thead>
                <tbody>
                <?php $party = libcase::getCaseAttributeByLawyerID(Auth::user()->id); $court=json_decode($party->case_court);
                if(count($court)!=0){
                    foreach($court as $values){
                        ?>
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" name="case_court[]" value="<?php echo $values; ?>" >
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
    <!-- Start New Court-->
    <div id="add" class="modal hide fade" style="display: none">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>New Court</h3>
        </div>
        <div class="span12 model-body">
            <div class="span2">
                <form action="#"  class="form-inline" id="court_name" onsubmit="return addcourt();">
                    <br>
                    <div class="control-group">
                        <label class="control-label">Court Name:</label>
                        <div class="controls">
                            <input type="text" name="case_court">
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
    <!--END New Court -->
    <script>
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
        function addcourt()
        {

            $.post("<?php echo URL::to_route('AddOppParty'); ?>",$('#court_name').serializeArray())
                .success(function(data){
                    var values=data;
                    $('#mytable tr:last').after('<tr><td><label><input type="checkbox" name="case_court[]" value="'+values+'"/>'
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

    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>