<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case
                <small>
                   
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
                <a  href="<?php echo URL::to_route('Cases'); ?>">
                    <button title="add new case" class="btn btn-mini" style="float: right"><i class="icon-plus"></i>Add new case</button>
                </a>
                <a title="View all cases" href="<?php echo URL::to_route('ViewCases'); ?>" class="btn btn-mini" style="float: right">View All </a>
                <small class="pull-right">
                <span class="btn btn-mini btn-info">
                 <?php $tot=libcase::getCaseByLawyerID(Auth::user()->id); echo 'Total: '.count($tot).' Cases'; ?>
                 </span>
            </small>
            </h1>
        </div>
    </div>
<?php $id=Auth::user()->id;$cl=libclient::getclientname(); $user=liblawyer::getlawyer(); ?>
<?php $status=Session::get('status'); if($status){  ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        </button>
        <span><?php echo $status;  ?></span>
    </div>
<?php }
$search=Session::get('search');
if(isset($search))
{
    $key_search=key($search);
} ?>
<?php //echo "<pre>";print_r($cases);exit; ?>
    <div class="row-fluid">

        <div class="span12">
            <form name="form2" action="<?php echo URL::to_route('SearchCase'); ?>" method="get">
                <select name="case_name" id="case_name" class="span2" onchange='this.form.submit()'>
                    <option value="">Search By Case</option>
                    <?php if(isset($_GET['case_name'])){$case_name=$_GET['case_name'];if($case_name){ ?>
                    <option value="<?php echo $case_name; ?>" selected><?php echo $case_name; ?></option>
                    <?php } }?>
                    <?php if(isset($cases)){$uniq=array();foreach($cases as $case1){if($case1->lawyer_id==$id){if(in_array($case1->case_name,$uniq)){continue;}$uniq[]=$case1->case_name;?>
                        <option value="<?php echo $case1->case_name; ?>"><?php echo $case1->case_name; ?></option>
                    <?php }}} ?>
                </select>
                <select name="case_no" id="case_no" class="span2" onchange='this.form.submit()'>
                    <option value="">Search By Case_no</option>
                    <?php if(isset($_GET['case_no'])){ $case_no=$_GET['case_no'];if($case_no){ ?>
                        <option value="<?php echo $case_no; ?>" selected><?php echo $case_no; ?></option>
                    <?php }} ?>
                    <?php if(isset($cases)){foreach($cases as $case1){if($case1->lawyer_id==$id){?>
                        <option value="<?php echo $case1->case_no; ?>"><?php echo $case1->case_no; ?></option>
                    <?php }}} ?>
                </select>
                <select name="client_id" id="client" class="span2" onchange='this.form.submit()'>
                    <option value="">Search By Client</option>
                    <?php if(isset($_GET['client_id'])){ $client=$_GET['client_id']; if($client){ ?>
                        <option value="<?php echo $client; ?>" selected><?php $client_name=libclient::getclientByID($client); echo ucfirst($client_name->client_name); ?></option>
                    <?php }} ?>
                    <?php if(isset($cases)){ $name=array();foreach($cases as $case1){if($case1->lawyer_id==$id){ if(in_array($case1->client_id,$name)){continue;}$name[]=$case1->client_id;?>
                        <option value="<?php echo $case1->client_id; ?>"><?php foreach($cl as $client){ if($client->client_id==$case1->client_id){echo ucfirst($client->client_name);}} ?></option>
                    <?php }}} ?>

                </select>
                <select id="advocate" class="span2" name="updated_by" onchange='this.form.submit()'>
                    <option value="">Search By Lawyer</option>
                    <?php if(isset($_GET['updated_by'])){ $lawyer_id=$_GET['updated_by'];if($lawyer_id){ ?>
                        <option value="<?php echo $lawyer_id; ?>" selected><?php $lawyer_name=liblawyer::getUserByID($lawyer_id);echo ucfirst($lawyer_name->first_name); ?></option>
                    <?php }} ?>
                    <?php if(isset($cases)){ $uniq=array(); foreach( $cases as $case1){ if($case1->lawyer_id==Auth::user()->id){if(in_array($case1->updated_by,$uniq)){continue;}$uniq[]=$case1->updated_by;?>
                        <option value="<?php echo $case1->updated_by; ?>"><?php $name=get_value_from_multi_object_array($case1->updated_by,$user,'id','first_name'); echo ucfirst($name); ?></option>
                    <?php }} } ?>
                </select>
     &nbsp;&nbsp;&nbsp;<input type="text" class="span2" name="from_date" id="from_date" placeholder="From Date" <?php if(isset($_GET['from_date'])){$from_date=$_GET['from_date'];if($from_date){ ?>value="<?php echo $from_date; ?>" <?php }}?> ><strong>To</strong>
     <input type="text" class="span2"  name="to_date" id="to_date" placeholder="To Date" onchange="return datevalidate();" <?php if(isset($_GET['to_date'])){$to_date=$_GET['to_date'];if($to_date){ ?>value="<?php echo $to_date; ?>" <?php }}?>>
            </form>
<!--            --><?php //echo '<pre>'; print_r($cases);  ?>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Case Name</th>
                    <th>Case Number</th>
                    <th>Practice Area</th>
                    <th>Client Name</th>
                    <th>Lawyer</th>
                    <th>Date of filed</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($key_search)){ if(isset($cases_select)){ $la=liblawyer::getlawyer();$cl=libclient::getclientname(); foreach($cases_select as $case) {
                    if($case->$key_search == $search[$key_search]){
                    ?>
                    <tr>
                        <td><?php echo ucfirst($case->case_name); ?></td>
                        <td><a href="<?php echo URL::to_route('CaseDetail').'/'.$case->case_id;  ?>"><?php echo $case->case_no; ?></a></td>
                        <td><?php echo ucfirst($case->case_type); ?></td>
                        <td><a title="view-cases" href="<?php echo URL::to("admin/report/client?id=$case->client_id"); ?>"><?php foreach($cl as $clients_id){if($clients_id->client_id==$case->client_id){echo ucfirst($clients_id->client_name);}} ?></a></td>
                        <td><?php $associate_name=''; $asso=explode(',',$case->associate_lawyer);foreach($asso as $ass_lawyer){foreach($la as $assName){ if($assName->id==$ass_lawyer){ $associate_name.=', '.ucfirst($assName->first_name); } } } echo ltrim($associate_name,','); ?></td>
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
                                <ul class="dropdown-menu" role="menu">
                                    <li class="dropdown-submenu pull-left">
                                        <a tabindex="0" href="#">Change Status</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',0';?>">Pending</a></li>
                                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',1';?>">Processing</a></li>
                                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',2';?>">Completed</a></li>
                                        </ul>
                                    <li>
                                        <a  href="<?php echo URL::to_route('CasePermission').'/'.$case->case_id;  ?>">
                                            Assign permission
                                        </a></li>
                                    <li>
                                        <a href="<?php echo URL::to_route('CaseHistoryDetail').'/'.$case->case_id; ?>" title="History" >
                                            View History
                                        </a>
                                    </li>
                                    <li><a title="Delete"  onclick="return confirm('Are you want to delete!')" href="<?php echo URL::to_route('DeleteCases').'/'.$case->case_id;  ?>">
                                            Delete
                                        </a></li>
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
                <?php }} }} else {
                if(isset($cases_select)){$la=liblawyer::getlawyer();$cl=libclient::getclientname(); foreach($cases_select as $case) {
                if($case->lawyer_id==Auth::user()->id){
                ?>
    <tr>
        <td><?php echo ucfirst($case->case_name); ?></td>
        <td><a href="<?php echo URL::to_route('CaseDetail').'/'.$case->case_id;  ?>"><?php echo $case->case_no; ?></a></td>
        <td><?php echo ucfirst($case->case_type); ?></td>
        <td><a title="view-cases" href="<?php echo URL::to("admin/report/client?id=$case->client_id"); ?>"><?php foreach($cl as $clients_id){if($clients_id->client_id==$case->client_id){echo ucfirst($clients_id->client_name);}} ?></a></td>
        <td><?php $associate_name=''; $asso=explode(',',$case->associate_lawyer);foreach($asso as $ass_lawyer){foreach($la as $assName){ if($assName->id==$ass_lawyer){ $associate_name.=', '.ucfirst($assName->first_name); } } } echo ltrim($associate_name,','); ?></td>
        <td><?php $date=$case->date_of_filling; echo date('d-M-Y',strtotime($date)); ?></td>
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
                <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-submenu pull-left">
                        <a tabindex="0" href="#">Change Status</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',0';?>">Pending</a></li>
                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',1';?>">Processing</a></li>
                            <li><a href="<?php echo URL::to_route('CaseStatus').'/'.$case->case_id.',2';?>">Completed</a></li>
                        </ul>
                    <li>
                        <a  href="<?php echo URL::to_route('CasePermission').'/'.$case->case_id;  ?>">
                            Assign permission
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo URL::to_route('CaseHistoryDetail').'/'.$case->case_id; ?>" title="History" >
                            View History
                        </a>
                    </li>
                    <li><a title="Delete"  onclick="return confirm('Are you want to delete!')" href="<?php echo URL::to_route('DeleteCases').'/'.$case->case_id;  ?>">
                            Delete
                        </a>
                    </li>
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
    <?php }}}} ?>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('.btn').tooltip({ placement : 'left'});
            $('a').tooltip({ placement : 'bottom' });
            $('span').tooltip({ placement : 'bottom' });
            $('button').tooltip({ placement : 'bottom' });
        });
    </script>
    <script type="text/javascript">
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
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>