<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Cases
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
                <a href="<?php echo URL::to_route('Cases'); ?>">
                    <button title="add-new case" class="btn btn-mini" style="float: right"><i class="icon-plus"></i>Add new case</button>
                </a>
                <a title="view-all cases" href="<?php echo URL::to_route('ViewCases'); ?>" class="btn btn-mini" style="float: right">View All </a>
                <small class="pull-right">
                <span class="btn btn-mini btn-info">
                 <?php $tot=libcase::getcaseIDByassociateID(Auth::user()->id); echo 'Total: '.count($tot).' Cases'; ?>
                 </span>
            </small>
            </h1>

        </div>
    </div>

    <!--  Start Search Options   -->
<?php $user = liblawyer::getlawyer();
//echo "<pre>";
//print_r($cases);
?>
    <div class="row-fluid">

        <form name="form2" action="<?php echo URL::to_route('SearchCase'); ?>" method="get">
            <select name="case_name" id="case_name" class="span2" onchange='this.form.submit()'>
                <option value="">Search By Case</option>
                <?php if(isset($_GET['case_name'])){$case_name=$_GET['case_name'];if($case_name){ ?>
                    <option value="<?php echo $case_name; ?>" selected><?php echo $case_name; ?></option>
                <?php } }?>
                <?php if(isset($search_case)){ $uniq=array();foreach($search_case as $case1){ if(in_array($case1->case_name,$uniq)){continue;}$uniq[]=$case1->case_name;?>
                    <option value="<?php echo $case1->case_name; ?>"><?php echo $case1->case_name; ?></option>
                <?php }} ?>
            </select>
            <select name="case_no" id="case_no" class="span2" onchange='this.form.submit()'>
                <option value="">Search By Case_no</option>
                <?php if(isset($_GET['case_no'])){ $case_no=$_GET['case_no'];if($case_no){ ?>
                    <option value="<?php echo $case_no; ?>" selected><?php echo $case_no; ?></option>
                <?php }} ?>
                <?php if(isset($search_case)){foreach($search_case as $case1){?>
                    <option value="<?php echo $case1->case_no; ?>"><?php echo $case1->case_no; ?></option>
                <?php }} ?>
            </select>
            <select name="client_id" id="client" class="span2" onchange='this.form.submit()'>
                <option value="">Search By Client</option>
                <?php if(isset($_GET['client_id'])){ $client=$_GET['client_id']; if($client){ ?>
                    <option value="<?php echo $client; ?>" selected><?php $client_name=libclient::getclientByID($client); echo ucfirst($client_name->client_name); ?></option>
                <?php }} ?>
                <?php if(isset($search_case)){ $name=array();foreach($search_case as $case1){ if(in_array($case1->client_id,$name)){continue;}$name[]=$case1->client_id;?>
                    <option value="<?php echo $case1->client_id; ?>"><?php echo ucfirst($case1->client_name); ?></option>
                <?php }} ?>

            </select>

            &nbsp;&nbsp;&nbsp;<input type="text" class="span2" name="from_date" id="from_date" placeholder="From Date" <?php if(isset($_GET['from_date'])){$from_date=$_GET['from_date'];if($from_date){ ?>value="<?php echo $from_date; ?>" <?php }}?> ><strong>To</strong>
            <input type="text" class="span2"  name="to_date" id="to_date" placeholder="To Date" onchange="return datevalidate();" <?php if(isset($_GET['to_date'])){$to_date=$_GET['to_date'];if($to_date){ ?>value="<?php echo $to_date; ?>" <?php }}?>>

        </form>

        <!--  End Search Options   -->


        <form action="<?php echo URL::to_route('DeleteMultiCaseByIDs'); ?>" method="post">
    <span id="del" style="display: none">
    <button class="btn btn-mini btn-danger" type="submit"><i class="icon-trash"></i>Delete</button>
    </span>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
<!--                    <th class="left" style="width: 20px">-->
<!--                        <label>-->
<!--                            <input type="checkbox">-->
<!--                            <span class="lbl"></span>-->
<!--                        </label>-->
<!--                    </th>-->
                    <th>Case Number</th>
                    <th>Case Name</th>
                    <th>Practice Area</th>
                    <th>Client Name</th>
                    <th>Date of Filed</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($cases->results)) {
                    foreach ($cases->results as $case){ ?>
                        <tr>
<!--                            <td class="left">-->
<!--                                <label>-->
<!--                                    --><?php //if ($case->permission != '1'){ ?>
<!--                                    <input type="checkbox" name="case_id[]" value="--><?php //echo $case->case_id; ?><!--">-->
<!--                                    <span class="lbl"></span>-->
<!--                                    --><?php //} ?>
<!--                                </label>-->
<!--                            </td>-->
                            <td><?php echo $case->case_no; ?></td>
                            <td><?php echo ucfirst($case->case_name); ?></td>
                            <td><?php echo ucfirst($case->case_type); ?></td>
                            <td><?php echo ucfirst($case->client_name); ?></td>
                            <td><?php $date=$case->date_of_filling; echo date('d/m/Y',strtotime($date)); ?></td>
                            <td>
            <span class="label label-success"  style="padding:4px 8px 6px">
                <?php if($case->status==0){echo "Pending&nbsp;&nbsp;&nbsp;&nbsp;";}elseif($case->status==1){echo "Processing";}elseif($case->status==2){echo "Completed";}  ?></span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                                        Action
                                        <span class="caret"></span>
                                    </button>
                                    <?php if ($case->permission != '1'){ ?>
                                    <ul class="dropdown-menu" role="menu">

                                        <li class="dropdown-submenu pull-left">
                                            <a tabindex="0" href="#">Change Status</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',0';?>">Pending</a></li>
                                                <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',1';?>">Processing</a></li>
                                                <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',2';?>">Completed</a></li>
                                            </ul>

                                         <li><a title="Delete"  onclick="return confirm('Are you want to delete!')" href="<?php echo URL::to_route('DeleteCases').'/'.$case->case_id;  ?>">
                                                Delete
                                            </a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                            <td class="td-actions">
                                <div class="hidden-phone visible-desktop btn-group">

                                    <a title="Edit" data-animation="left" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditCases').'/'.$case->case_id;  ?>">
                                        <i class="icon-edit bigger-120"></i>
                                    </a>

                                    <a title="View" class="btn btn-mini btn-info" href="<?php echo URL::to_route('CaseDetail').'/'.$case->case_id;  ?>">
                                        <i class="icon-eye-open"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </form>
        <?php echo $cases->links(); ?>
    </div>
    <script>
        $(document).ready(function() {
            $("#case_name").select2();
            $("#case_no").select2();
            $("#client").select2();
            $("#advocate").select2();
            $("#date").select2();
            $("#court_hall").select2();

        });
        $('#from_date').datepicker({ dateFormat:"dd/mm/yy",
            changeMonth: true,
            changeYear: true

        });
        $('#to_date').datepicker({ dateFormat:"dd/mm/yy",
            changeMonth: true,
            changeYear: true

        });
        function datevalidate()
        {
            var from1=document.form2.from_date.value.split("/");
            var from= new Date(from1[2], from1[1] - 1, from1[0]);
            var to1=document.form2.to_date.value.split("/");
            var to= new Date(to1[2], to1[1] - 1, to1[0]);
            var stDate = new Date(from);
            var enDate = new Date(to);
            var compDate = enDate - stDate;
            if(!(compDate >= 0))
            {
                alert("Please Enter the to date greater than from date ");
                return false;
            }
            else
            {
                document.form2.submit();
            }
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
        $(function() {
            $('.btn').tooltip({ placement : 'left'});
            $('a').tooltip({ placement : 'bottom' });
            $('span').tooltip({ placement : 'bottom' });
            $('button').tooltip({ placement : 'bottom' });
        });
    </script>


<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>