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
    <?php $res = translation_array(); ?>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-header">
        <tr>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody class="table table-bordered">
        <?php  $lawyer=liblawyer::getlawyer();
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
                        echo ucfirst(get_multi_value_from_object_array($value,$lawyer,'id','first_name'));
                        break;
                    case 'case_id':
                        $case=libcase::getcasedetailByID($value);
                        echo ucfirst(get_value_from_object_array($value,$case,'case_id','case_name'));
                        break;
                    case 'doc_no':
                        $doc=libdocument::getdocumentByID($value);
                        echo ucfirst(get_value_from_object_array($value,$doc,'doc_id','doc_name'));

                        break;
                    default:
                        echo ucfirst($value);
                        break;
                }
                 ?> </td>
        </tr>
        <?php } ?>

        </tbody>
</div>
<script>
    $(function(){
        $('a').tooltip({placement:'bottom'});
    });
</script>
<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>
