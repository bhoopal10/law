<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon icon-briefcase"></i>
            Case
            <small>
                <i class="icon-double-angle-right"></i>
                Case Detail
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewCases');?>">Back</a>
            </small>
        </h1>
    </div>
</div>
<div class="row-fluid">
    <?php $res=translation_array();
    $case=(array)$cases;
    $case_id=$case['case_id'];
    unset($case['case_id'],$case['created_on'],$case['case_color']);
    $lawyer=liblawyer::getlawyer();
    ?>
           <span><a title="View all hearings of this case" href="<?php echo URL::to("admin/report/cases?id=12"); ?>" class="btn btn-mini btn-info">View Hearings</a></span>
           <span><a title="history" href="<?php echo URL::to_route('CaseHistoryDetail').'/'.$case_id; ?>" class="btn btn-mini btn-info">View History</a></span>
        <table class="table table-bordered table-hover table-striped">
            <thead class="table-header">
            <tr>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody class="table table-bordered">
            <?php foreach($case as $key=>$value) { ?>
            <tr>
                <td><?php echo $res[$key]; ?>
                </td>
                <td><?php
                    switch($key)
                    {
                        case 'associate_lawyer':
                            echo ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name'));
                            break;
                        case 'lawyer_id':
                            echo ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name'));
                            break;
                        case 'status':
                            if($value==0){echo "Pending";}elseif($value==1){echo "Processing";}elseif($value==2){echo "Completed";}
                            break;
                        case 'updated_by':
                            echo ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name'));
                            break;
                        case 'client_id':
                            $client=libclient::getclientByID($value);
                            echo ucfirst(get_value_from_object_array($value,$client,'client_id','client_name'));
                            break;
                        case 'date_of_filling':
                            echo date('d/m/Y',strtotime($value));
                            break;
                        default:
                            echo ucfirst($value);
                            break;
                    }

                    ?>
                </td>
            </tr>
            <?php } ?>
            </tbody>
            
        </table>


</div>
    <script type="text/javascript">
        $(function() {
            $('.btn').tooltip({ placement : 'left'});
            $('a').tooltip({ placement : 'bottom' });
            $('span').tooltip({ placement : 'bottom' });
            $('button').tooltip({ placement : 'bottom' });
        });
    </script>
<?php Section::stop();  ?>
<?php echo render('admin::lawyer/template.main');  ?>