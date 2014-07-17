<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/31/13
 * Time: 6:42 PM
 */
?>
<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1>
            Lawyers
            <small>
                <i class="icon-double-angle-right"></i>
                Lawyers Detail
                <i class="icon-double-angle-right"></i>
                <a href="<?php echo URL::to_route('ViewUser'); ?>">Back</a>
            </small>
        </h1>

    </div>
</div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-info">
        <span><?php echo $status; ?></span>
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
    </div>
<?php }?>
<div class="row-fluid">
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-header">
        <tr>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody class="table table-bordered">
        <?php if(isset($user)){
            $res=translation_array();
            $users=array_unset($user,'id,password,case_case_id,updated_by,user_log');
//            print_r($users);exit;
            foreach ($users as $key=>$value){ ?>
                <tr>
                    <td><?php echo $res[$key]; ?></td>
                    <td>
                        <?php
                        switch($key)
                        {
                            case 'user_role':
                                if($key==1){echo "ADMIN";}elseif($key==2){echo "LAWYER";}elseif($key==3){echo "ASSOCIATE";}elseif($key==0){echo "NOT ASSIGNED";}
                                break;
                            case 'reg_date':
                                $date=date('d-M-Y',strtotime($value));
                                echo $date;
                                break;
                            default:
                                echo ucfirst($value);
                                break;
                        }
                        ?>
                    </td>
                </tr>
            <?php } }?>

        </tbody>
</div>
<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>

