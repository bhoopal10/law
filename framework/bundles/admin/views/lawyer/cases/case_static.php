<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case
                <small>
                    <i class="icon-double-angle-right"></i>
                     <?php echo $stat.' Cases'; ?>
                     <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
                <a  href="<?php echo URL::to_route('Cases'); ?>">
                    <button title="add new case" class="btn btn-mini" style="float: right"><i class="icon-plus"></i>Add new case</button>
                </a>
                <a title="View all cases" href="<?php echo URL::to_route('ViewCases'); ?>" class="btn btn-mini" style="float: right">View All </a>
                <small class="pull-right">
                <span class="btn btn-mini btn-info">
                 <?php echo libcase::countStatusCase(Auth::user()->id,$stat_id).' Cases'; ?>
                 </span>
            </small>
            </h1>
        </div>
    </div>
<?php $id=Auth::user()->id;$cl=libclient::getclientname(); $user=liblawyer::getlawyer(); $selList=libautocomplete::selectList($id); ?>
<?php $status=Session::get('status'); if($status){  ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        </button>
        <span><?php echo $status;  ?></span>
    </div>
<?php }?>
<div class="row-fluid">
    <div class="span12">
    <form name="form2" action="" method="get">
        <select name="case_no" id="case" class="span2" onchange='this.form.submit()'>
            <option value="">Search By CaseNo</option>
            <?php if($selList['cases']){ foreach ($selList['cases'] as $value) { ?>
                    <option value="<?php echo $value->case_id; ?>" <?php echo (Input::old('case_no') == $value->case_id )?'selected':'';?>><?php echo $value->case_no; ?></option>
                <?php }} ?>
        </select>
        <select name="client_id" id="client" class="span2" onchange='this.form.submit()'>
            <option value="">Search By Client</option>
                <?php if($selList['client']){ foreach ($selList['client'] as $value) { ?>
                    <option value="<?php echo $value->client_id; ?>" <?php echo (Input::old('client_id') == $value->client_id )?'selected':'';?> ><?php echo $value->client_name; ?></option>
                <?php }} ?>
        </select>
        <select name="lawyer_id" id="lawyer" class="span2" onchange='this.form.submit()'>
            <option value="">Search By Lawyer</option>
            <?php if($selList['lawyer']){ foreach ($selList['lawyer'] as $value) { ?>
                    <option value="<?php echo $value->id; ?>" <?php echo (Input::old('lawyer_id') == $value->id )?'selected':'';?>><?php echo $value->first_name; ?></option>
                <?php }} ?>
        </select>
        <input type="text" class="span3" name="from_date" id='from' placeholder="From date" <?php echo (Input::old('from_date')?'value="'.Input::old('from_date').'"':''); ?> onchange="this.form.submit();">
          To
          <input type="text" class="span3" name="to_date" id="to" placeholder="to Date" <?php echo (Input::old('to_date')?'value="'.Input::old('to_date').'"':''); ?> onchange="this.form.submit()">
    </form>
        <table id="table_bug_report" class="table table-striped table-bordered table-hover cf">
                <thead class="cf">
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
                <?php  $la=liblawyer::getlawyer();$cl=libclient::getclientname(); 
                foreach($cases->results as $case) {
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
                <?php }?>
 
                </tbody>
            </table>
        </div>
    </div>

<?php echo $cases->links(); ?>

<script type="text/javascript">
    $(function(){

        $('#client').select2();
        $('#lawyer').select2();
        $('#case').select2();
        $( "#from" ).datepicker({
        dateFormat: "dd/mm/yy",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear:true,
        onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
        }
        });

        $( "#to" ).datepicker({
            dateFormat: "dd/mm/yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear:true,
            onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
</script>
            

<?php Section::stop(); ?>
 <?php echo render('admin::lawyer/template.main'); ?>