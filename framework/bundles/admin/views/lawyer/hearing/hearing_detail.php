<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 12/31/13
 * Time: 11:09 AM
 */
?>
<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon icon-bell"></i>
            Hearing
            <small>
                <i class="icon-double-angle-right"></i>
                 Hearings Details
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewHearing'); ?>">Back</a>
            </small>
        </h1>

    </div>
</div>
<div class="row-fluid">

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
    <?php $res = translation_array(); if(isset($hearing)){?>

    <a class="btn btn-mini btn-info" id="Edit" href="<?php echo URL::to_route('EditHearingDetail').'/'.$hearing->hearing_id;  ?>"><i class="icon-pencil"></i>Edit Hearing</a>
    <?php } ?>
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-header">
        <tr>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody class="table table-bordered">
        <?php  $lawyer=liblawyer::getlawyer();
            $client=libclient::getclientname();
         if(isset($hearing)){
             unset($hearing->hearing_id,$hearing->created_date);
         }
        foreach ($hearing as $key=>$value){ ?>
        <tr>
            <td><?php echo $res[$key]; ?></td>
            <td><?php
                switch($key)
                {
                    case 'lawyer_id':
                        echo '<b>'.ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name')).'</b>';
                        break;
                    case 'client_id':
                        echo '<b>'.ucfirst(get_multi_value_from_object_array($value,$client,'client_id','client_name')).'</b>';
                        break;
                    case 'updated_by':
                        echo '<b>'.ucfirst(get_multi_value_from_object_array($value,$lawyer,'id',   'first_name')).'</b>';
                        break;
                    case 'case_id':
                        $case=libcase::getcasedetailByID($value);
                        echo '<b>'.ucfirst(get_value_from_object_array($value,$case,'case_id','case_no')).'</b>';
                        break;
                    case 'doc_no':
                        $doc=libdocument::getdocumentByID($value);
                        echo '<b>'.ucfirst(get_value_from_object_array($value,$doc,'doc_id','doc_name')).'</b>';
                        break;
                    case 'sms_deliver':
                        echo '<b>'.$value."&nbsp;&nbsp;Days before </b>";
                        break;
                    case 'hearing_date':
                        echo '<b>'.date('d-M-Y',strtotime($value))." </b>";
                        break;
                    case 'next_hearing_date':
                        echo '<b>'.date('d-M-Y',strtotime($value))." </b>";
                        break;
                    default:
                        echo '<b>'.ucfirst($value).'</b>';
                        break;
                }
                 ?> </td>
        </tr>
        <?php } ?>

        </tbody>
</div>
<script>
    $(function(){
        $('a').tooltip({placement:'bottom'})
    });
</script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
