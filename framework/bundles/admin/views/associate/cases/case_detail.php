<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-briefcase"></i>
                Case
                <small>
                    <i class="icon-double-angle-right"></i>
                    Case Detail
                    <i class="icon-double-angle-right"></i>
                    <a href="<?php echo URL::to_route('ViewCases');?>">Back</a>
                </small>
            </h1>
        </div>
    </div>
    <div class="row-fluid">
        <?php $res=translation_array();
        $case=(array)$cases;
        unset($case['case_id'],$case['case_color'],$case['created_on']);
        $lawyer=liblawyer::getlawyer();
        ?>

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
<?php Section::stop();  ?>
<?php echo render('admin::associate/template.main');  ?>