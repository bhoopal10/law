<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-bell"></i>
                Hearing
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Hearings
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>

                <a title="Add new hearing" href="<?php echo URL::to_route('Hearing'); ?>" style="float: right" class="btn btn-mini">
                    Add new hearing
                </a>
                <a title="view all hearings" href="<?php echo URL::to_route('ViewHearing'); ?>" class="btn btn-mini"  style="float: right">View all</a>&nbsp;&nbsp;&nbsp;
            </h1>

        </div>
    </div>
    <?php $cl=libclient::getclientname();
          $user=liblawyer::getlawyer();
//echo "<pre>"; print_r($hearing); echo "</pre>";
$search=Session::get('search');
if(isset($search))
{
  $key_search=key($search);
}
?>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class=" alert alert-info">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $status; ?></span>
    </div>
<?php } elseif(isset($error)){?>
    <div class=" alert alert-alert">
        <button type="button" class="close" data-dismiss="alert"><span><i class="icon-remove"></i></span></button>
        <span><?php echo $error; ?></span>
    </div>
<?php } ?>
    <div class="row-fluid">
        <div class="span12">
<div class="row-fluid">
    <form name="form2" action="<?php echo URL::to_route('SearchHearingView'); ?>" method="get" class="form-inline">

        <select id="case_number" class="span2" name="case_id" onchange='this.form.submit()'>
            <option value="0">Search By Case No</option>
            <?php if($case_id=Input::old('case_id')){
                echo "<option value='".$case_id."' selected>".libcase::getcasedetailByID($case_id)->case_no."</option>";
                } ?>
        </select>

        <select id="client" class="span2" name="client_id" onchange='this.form.submit()'>
            <option value="0">Search By Client</option>
            <?php if(isset($_GET['client_id'])){ $client=$_GET['client_id']; if($client){ ?>
                <option value="<?php echo $client; ?>" selected><?php  $client_name=libclient::getclientByID($client); echo ucfirst($client_name->client_name); ?></option>
            <?php }} ?>
            <?php if(isset($hearing_select)){ $client_name=array(); foreach( $hearing_select as $val){ if($val->lawyer_id==Auth::user()->id){ if(in_array($val->client_id,$client_name)){continue;}$client_name[]=$val->client_id;?>
                <option value="<?php echo $val->client_id; ?>"><?php  foreach($cl as $client){ if($client->client_id==$val->client_id){echo ucfirst($client->client_name);}} ?></option>
            <?php }} } ?>
        </select>
          <select id="court_hall" class="span2" name="court_hall" onchange='this.form.submit()'>
            <option value="0">Search By Court Hall</option>
              <?php if(isset($_GET['court_hall'])){ $court=$_GET['court_hall'];if($court){ ?>
                  <option value="<?php echo $court; ?>" selected><?php echo $court; ?></option>
              <?php }} ?>
            <?php if(isset($hearing_select)){ $court_hall=array(); foreach( $hearing_select as $val){ if($val->lawyer_id==Auth::user()->id){ if(in_array($val->court_hall,$court_hall)){continue;} $court_hall[]=$val->court_hall; ?>
                <option value="<?php echo $val->court_hall; ?>"><?php echo ucfirst($val->court_hall); ?></option>
            <?php }} } ?>
        </select>
        <select name='docket_no' class="span2" onchange='this.form.submit()' id='docket_no'>
            <option value="0">Search by DocketNo</option>
            <?php if($docket=Input::old('docket_no')){
                echo "<option value='".Input::old('docket_no')."' selected>".Input::old('docket_no')."</option>";
                } ?>
        </select>
         <select name='crime_no' class="span2" onchange='this.form.submit()' id='crime_no'>
            <option value="0">Search by CrimeNo</option>
            <?php if($docket=Input::old('crime_no')){
                echo "<option value='".Input::old('crime_no')."' selected>".Input::old('crime_no')."</option>";
                } ?>
        </select>
       &nbsp;&nbsp; <input type="text" class="datepicker span1" name="from_date" placeholder="From Date" <?php if(isset($_GET['from_date'])){$from_date=$_GET['from_date'];if($from_date){ ?>value="<?php echo $from_date; ?>" <?php }}?> ><strong>To</strong>
        <input type="text" class="datepicker span1" name="to_date" placeholder="To Date" onchange="return datevalidate();" <?php if(isset($_GET['to_date'])){$to_date=$_GET['to_date'];if($to_date){ ?>value="<?php echo $to_date; ?>" <?php }}?>>
    </form>
    &nbsp;&nbsp;&nbsp;
            </div>
            <form name="update_form" id="update_form"  action="<?php echo URL::to_route('MultiHearingUpdate'); ?>" method="post">
 <span id="del">

                <a class="btn btn-mini btn-danger" id="delete"><i class="icon-trash"></i>Delete</a>
                <input type="hidden" name="delete" value="" id="input_del">
                <a class="btn btn-mini btn-info" id="update"><i class="icon-upload"></i>Update Hearing</a>
                     <input type="hidden" name="update" value="" id="input_update">

            </span>
            <span class="pull-right"> 
            <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d') ?>" class="btn btn-mini btn-info ">Today Hearing</a>
            <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y'))); ?>" class="btn btn-mini btn-info ">Tomorrow Hearing</a>
            </span>

                <?php if(!isset($key_search)){ ?>
                <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="left" style="width: 20px">
                            <label>
                                <input type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Case Number</th>
                        <th>Client/opp.party name</th>
                        <th>Advocate</th>
                        <th>Stage</th>
                        <th>Docket/CrimeNO.</th>
                        <th>Hearing Date</th>
                        <th>Court Hall</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                <?php if(isset($hearing)){  $case=libcase::getcasedetail(); foreach($hearing->results as $hearings) {    ?>

                    <tr class="">
                        <td class="left">
                            <label>
                                <input type="checkbox" name="hearing_id[]" value="<?php echo $hearings->hearing_id; ?>">
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><a title="View all hearings of this case" href="<?php echo URL::to_route('ReportCase')."?id=$hearings->case_id"; ?>"><?php $case_no1=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_no'); echo $case_no1; ?></a></td>
                        <td><a title="view client cases" href="<?php echo URL::to("admin/report/client?id=$hearings->client_id"); ?>"><?php foreach($cl as $client){ if($client->client_id==$hearings->client_id){echo ucfirst($client->client_name).' / '.ucfirst($hearings->opp_party_name);}}  ?></td>
                        <td><?php $name=get_value_from_multi_object_array($hearings->updated_by,$user,'id','first_name'); echo ucfirst($name); ?></td>
                        <td><?php echo $hearings->stage; ?></td>
                        <!-- <td><?php if($hearings->hearing_date){ echo date('d/m/Y',strtotime($hearings->hearing_date));  }?></td> -->
                        <td><?php echo $hearings->docket_no.'/'.$hearings->crime_no; ?></td>
                        <td><?php if($hearings->next_hearing_date){ echo date('d/m/Y',strtotime($hearings->next_hearing_date));}?></td>
                        <td><?php echo $hearings->court_hall;  ?></td>

                        <td class="td-actions">
                            <div class="hidden-phone visible-desktop btn-group">
                                <a title="Edit hearing" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditHearing').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                <a title="Delete hearings" class="btn btn-mini btn-danger" onclick="return confirm('Do you want to delete!')" href="<?php echo URL::to_route('DeleteHearing').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                                <a title="View Hearing details" class="btn btn-mini btn-info"  href="<?php echo URL::to_route('HearingDetail').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-eye-open bigger-120"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php }} ?>
                </tbody>
                    </table>
                    <?php echo $hearing->links(); ?>
                <?php }else {  ?>


                <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="left" style="width: 20px">
                            <label>
                                <input type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>Case Number</th>
                        <th>Client/opp.party name</th>
                        <th>Advocate</th>
                        <th>Stage</th>
                        <th>Docket/CrimeNO.</th>
                        <th>Next Hearing Date</th>
                        <th>Court Hall</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($hearing)){  $case=libcase::getcasedetail(); foreach($hearing as $hearings) {  ?>
                        <tr class="">
                            <td class="left">
                                <label>
                                    <input type="checkbox" name="hearing_id[]" value="<?php echo $hearings->hearing_id; ?>">
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><a title="View all hearings of this case" href="<?php echo URL::to_route('ReportCase')."?id=$hearings->case_id"; ?>"><?php $case_no1=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_no'); echo $case_no1; ?></a></td>
                            <td><a title="view client cases" href="<?php echo URL::to("admin/report/client?id=$hearings->client_id"); ?>"><?php foreach($cl as $client){ if($client->client_id==$hearings->client_id){echo ucfirst($client->client_name).' / '.ucfirst($hearings->opp_party_name);}}  ?></a></td>
                            <td><?php $name=get_value_from_multi_object_array($hearings->updated_by,$user,'id','first_name'); echo ucfirst($name); ?></td>
                            <td><?php echo $hearings->stage; ?></td>
                            <!-- <td><?php if($hearings->hearing_date){ echo date('d/m/Y',strtotime($hearings->hearing_date));  }?></td> -->
                            <td><?php echo $hearings->docket_no.'/'.$hearings->crime_no; ?></td>
                            <td><?php if($hearings->next_hearing_date){ echo date('d/m/Y',strtotime($hearings->next_hearing_date));}?></td>
                            <td><?php echo $hearings->court_hall;  ?></td>
                            <td class="td-actions">
                                <div class="hidden-phone visible-desktop btn-group">
                                    <a title="Edit hearing" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditHearing').'/'.$hearings->hearing_id;  ?>">
                                        <i class="icon-edit bigger-120"></i>
                                    </a>
                                    <a title="delete hearing" class="btn btn-mini btn-danger" onclick="return confirm('Do you want to delete!')" href="<?php echo URL::to_route('DeleteHearing').'/'.$hearings->hearing_id;  ?>">
                                        <i class="icon-trash bigger-120"></i>
                                    </a>
                                    <a title="View hearing details" class="btn btn-mini btn-info"  href="<?php echo URL::to_route('HearingDetail').'/'.$hearings->hearing_id;  ?>">
                                        <i class="icon-eye-open bigger-120"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php }}} ?>

                </tbody>
            </table>
    </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
           $('a').tooltip({placement:'bottom'});
           $('.btn').tooltip({placement:'left'});
           $('span').tooltip({placement:'bottom'});
        });
        $(document).ready(function() {
            $("#case_name").select2();
            $("#case_number").select2();
            $("#client").select2();
            $("#advocate").select2();
            $("#date").select2();
            $("#court_hall").select2();
            $('#docket_no').select2();
            $('#crime_no').select2();

        });
        $('.datepicker').datepicker({dateFormat:"dd/mm/yy",
            changeMonth: true,
            changeYear: true});
        function datevalidate()
        {
            var from=document.form2.from_date.value;
            var to=document.form2.to_date.value;
            var from_date=from.split("/");
            var from1=Date.parse(from_date[2] + "-" + from_date[1] + "-" + from_date[0]);
            var to_date=to.split("/");
            var to1=Date.parse(to_date[2] + "-" + to_date[1] + "-" + to_date[0]);
            var stDate = new Date(from1);
            var enDate = new Date(to1);
            var compDate = enDate - stDate;
//            alert(compDate);
            if(!(compDate >= 0))
            {
                alert("Please Enter the correct date ");
                return false;
            }
            else
            {
                document.form2.submit();
            }
        }
        $('#delete').on('click',function(){
           document.update_form.delete.value="1";
            $('#update_form').submit();
        });
        $('#update').on('click',function(){
            document.update_form.update.value="1";
            $('#update_form').submit();
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

            var id=<?php echo Auth::user()->id; ?>;
            $.get("<?php echo URL::to_route('HearingsJson') ?>")
                .success(function(data){
                   var hearing  = $.parseJSON(data);
                   var dok=[];
                   $.each(hearing, function(key,value) {
                        $('#docket_no').append($('<option/>').attr("value",value.docket_no).text(value.docket_no));
                        $('#crime_no').append($('<option/>').attr("value",value.crime_no).text(value.crime_no));
                        $('#case_number').append($('<option/>').attr("value",value.case_id).text(value.case_no));
                   });
                  
                });


        });


       





    </script>

<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>