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

                <a href="<?php echo URL::to_route('Hearing'); ?>">
                    <button title="Add new hearing" class="btn btn-mini btn-file" style="float: right"><i class="icon-plus"></i>Add new hearing</button>
                </a>
                <a href="<?php echo URL::to_route('ViewHearing'); ?>">
                    <button title="View all hearings" class="btn btn-mini btn-info" style="float: right">View all</button>
                </a>
            </h1>

        </div>
    </div>
    <?php
    $cl=libclient::getclientname();
    $user=liblawyer::getlawyer();
    $search=Session::get('search');
    if(isset($search))
    {
        $key_search=key($search);
    }
    ?>
    <div class="row-fluid">
        <div class="span12">
            <form name="form2" action="<?php echo URL::to_route('SearchHearingView'); ?>" method="get" class="form-inline">
                <select id="case_number" class="span2" name="case_id" onchange='this.form.submit()'>
                    <option value="0">Search By Case No</option>
                    <?php if(isset($_GET['case_id'])){ $case_no=$_GET['case_id'];if($case_no){ ?>
                        <option value="<?php echo $case_no; ?>" selected><?php $cas=libcase::getcasedetailByID($case_no); echo $cas->case_no; ?></option>
                    <?php }} ?>
                    <?php if(isset($hearing_select) && is_object($hearing_select)){ foreach( $hearing_select as $val){ ?>
                        <option value="<?php echo $val->case_id; ?>"><?php $cas=libcase::getcasedetailByID($val->case_id); echo ucfirst($cas->case_no); ?></option>
                    <?php }}  ?>
                </select>

                <select id="client" class="span2" name="client_id" onchange='this.form.submit()'>
                    <option value="0">Search By Client</option>
                    <?php if(isset($_GET['client_id'])){ $client=$_GET['client_id']; if($client){ ?>
                        <option value="<?php echo $client; ?>" selected><?php $client_name=libclient::getclientByID($client); echo ucfirst($client_name->client_name); ?></option>
                    <?php }} ?>
                    <?php if(isset($hearing_select)  && is_object($hearing_select)){ $client_name=array(); foreach( $hearing_select as $val){ if(in_array($val->client_id,$client_name)){continue;}$client_name[]=$val->client_id;?>
                        <option value="<?php echo $val->client_id; ?>"><?php  foreach($cl as $client){ if($client->client_id==$val->client_id){echo ucfirst($client->client_name);}} ?></option>
                    <?php } } ?>
                </select>
                <select id="court_hall" class="span2" name="court_hall" onchange='this.form.submit()'>
                    <option value="0">Search By Court Hall</option>
                    <?php if(isset($_GET['court_hall'])){ $court=$_GET['court_hall'];if($court){ ?>
                        <option value="<?php echo $court; ?>" selected><?php echo $court; ?></option>
                    <?php }} ?>
                    <?php if(isset($hearing_select)  && is_object($hearing_select)){ $court_hall=array(); foreach( $hearing_select as $val) if(in_array($val->court_hall,$court_hall)){continue;} $court_hall[]=$val->court_hall; ?>
                        <option value="<?php echo $val->court_hall; ?>"><?php echo ucfirst($val->court_hall); ?></option>
                    <?php }  ?>
                </select>
                <input type="hidden" name="updated_by" value="0">
                &nbsp;&nbsp;<input type="text" class="datepicker span2" name="from_date" placeholder="From Date" <?php if(isset($_GET['from_date'])){$from_date=$_GET['from_date'];if($from_date){ ?>value="<?php echo $from_date; ?>" <?php }}?> ><strong>To</strong>
                <input type="text" class="datepicker span2" name="to_date" placeholder="To Date" onchange="return datevalidate();" <?php if(isset($_GET['to_date'])){$to_date=$_GET['to_date'];if($to_date){ ?>value="<?php echo $to_date; ?>" <?php }}?> >
            </form>


                <!--                --><?php //print_r($hearing);exit;  ?>
            <form name="update_form" id="update_form"  action="<?php echo URL::to_route('MultiHearingUpdate'); ?>" method="post">
 <span id="del" >

                <a title="Delete" class="btn btn-mini btn-danger" id="delete"><i class="icon-trash"></i>Delete</a>
                <input type="hidden" name="delete" value="" id="input_del">
                <a title="update hearings" class="btn btn-mini btn-info" id="update"><i class="icon-upload"></i>Update Hearing</a>
                     <input type="hidden" name="update" value="" id="input_update">

            </span>
            <span class="pull-right"> 
            <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d') ?>" class="btn btn-mini btn-info ">Today Hearing</a>
            <a href="<?php echo URL::to_route('FutureHeaing').'/'.date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y'))); ?>" class="btn btn-mini btn-info ">Tomorrow Hearing</a>
            </span>
                <?php if(!isset($key_search)){ if(isset($hearing)){ $cl=libclient::getclientname(); ?>
                    <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Case Name</th>
                    <th>Case Number</th>
                    <th>Client/opp.party name</th>
                    <th>Stage</th>
                    <th>Hearing Date</th>
                    <th>Next Hearing Date</th>
                    <th>Court Hall</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                    <?php $case=libcase::getcasedetail(); foreach($hearing->results as $hearings) {  ?>
                    <tr class="">
                        <td class="left">
                            <label>
                                <input type="checkbox" name="hearing_id[]" value="<?php echo $hearings->hearing_id; ?>">
                                <span class="lbl"></span>
                            </label>
                        <td><?php $case_name=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_name'); echo $case_name ?></td>
                        <td><?php $case_no=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_no'); echo $case_no; ?></td>
                        <td><?php foreach($cl as $client){ if($client->client_id==$hearings->client_id){echo ucfirst($client->client_name).' / '.ucfirst($hearings->opp_party_name);}}  ?></td>
                        <td><?php echo $hearings->stage; ?></td>
                        <td><?php if($hearings->hearing_date){ echo date('d/m/Y',strtotime($hearings->hearing_date));  }?></td>
                        <td><?php if($hearings->next_hearing_date){ echo date('d/m/Y',strtotime($hearings->next_hearing_date));}?></td>
                        <td><?php echo $hearings->court_hall;  ?></td>
                        <td class="td-actions">
                            <div class="hidden-phone visible-desktop btn-group">

                                <a title="Edit hearings" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditHearing').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                <a title="Delete hearings" class="btn btn-mini btn-danger" onclick="return confirm('Do you want to delete!')" href="<?php echo URL::to_route('DeleteHearing').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                                <a title="View hearing details" class="btn btn-mini btn-info"  href="<?php echo URL::to_route('HearingDetail').'/'.$hearings->hearing_id;  ?>">
                                    <i class="icon-eye-open bigger-120"></i>
                                </a>
                           </div>
                        </td>
                    </tr>
                <?php } ?>
                    </tbody>
                        </table>
                    <?php echo $hearing->links(); ?>
                    <?php } } elseif(isset($key_search)){ ?>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>Case Name</th>
                    <th>Case Number</th>
                    <th>Client/opp.party name</th>
                    <th>Stage</th>
                    <th>Hearing Date</th>
                    <th>Next Hearing Date</th>
                    <th>Court Hall</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                   <?php if(isset($hearing)){ $cl=libclient::getclientname();
                    $case=libcase::getcasedetail(); foreach($hearing as $hearings) {   ?>

                            <tr class="">
                                <td class="left">
                                    <label>
                                        <input type="checkbox" name="hearing_id[]" value="<?php echo $hearings->hearing_id; ?>">
                                        <span class="lbl"></span>
                                    </label>
                                <td><?php $case_name=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_name'); echo $case_name ?></td>
                                <td><?php $case_no=get_value_from_multi_object_array($hearings->case_id,$case,'case_id','case_no'); echo $case_no; ?></td>
                                <td><?php foreach($cl as $client){ if($client->client_id==$hearings->client_id){echo ucfirst($client->client_name).' / '.ucfirst($hearings->opp_party_name);}}  ?></td>
                                <td><?php echo $hearings->stage; ?></td>
                                <td><?php if($hearings->hearing_date){ echo date('d/m/Y',strtotime($hearings->hearing_date));  }?></td>
                                <td><?php if($hearings->next_hearing_date){ echo date('d/m/Y',strtotime($hearings->next_hearing_date));}?></td>
                                <td><?php echo $hearings->court_hall;  ?></td>
                                <td class="td-actions">
                                    <div class="hidden-phone visible-desktop btn-group">

                                        <a title="Edit hearing" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditHearing').'/'.$hearings->hearing_id;  ?>">
                                            <i class="icon-edit bigger-120"></i>
                                        </a>
                                        <a title="Delete hearing" class="btn btn-mini btn-danger" onclick="return confirm('Do you want to delete!')" href="<?php echo URL::to_route('DeleteHearing').'/'.$hearings->hearing_id;  ?>">
                                            <i class="icon-trash bigger-120"></i>
                                        </a>
                                        <a title="View hearing" class="btn btn-mini btn-info"  href="<?php echo URL::to_route('HearingDetail').'/'.$hearings->hearing_id;  ?>">
                                            <i class="icon-eye-open bigger-120"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                <?php } ?>
                           </tbody>
                </table>
                       <?php }} ?>


                </tbody>
            </table>
</form>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
           $('span').tooltip({placement:'bottom'});
           $('a').tooltip({placement:'bottom'});
           $('.btn').tooltip({placement:'left'});
        });
        $(document).ready(function() {
            $("#case_name").select2();
            $("#case_number").select2();
            $("#client").select2();
            $("#advocate").select2();
            $("#date").select2();
            $("#court_hall").select2();

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
                alert("Please Enter the to date greaterthan from date ");
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
                    $('#del').show();
                }
            };
            count();
            $( "input[type=checkbox]" ).on( "click", count );
        });
        $('#delete').on('click',function(){
            document.update_form.delete.value="1";
            $('#update_form').submit();
        })
        $('#update').on('click',function(){
            document.update_form.update.value="1";
            $('#update_form').submit();
        })
    </script>

<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>