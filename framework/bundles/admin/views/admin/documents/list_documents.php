<?php
/**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/8/14
 * Time: 1:31 PM
 */
//require path('public').'framework/google_api/functions/GDrive_1.php';

?>
<?php echo Section::start('contentWrapper');?>
<?php  $old=Input::old('lawyer_id'); ?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
            <i class="icon icon-file-alt"></i>
                Documents
                <small>
                    <i class="icon-double-angle-right"></i>
                    GDrive Documents
                </small>
                 <span class='pull-right'>Total : <?php $lawyer_id=($old)?$old:false; echo roundsize(libdocument::docSize($lawyer_id)); ?></span>
            </h1>

        </div>
    </div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
    <div class="row-fluid">
        <div class="span12">
        <form action='' method="get">
            <select name='lawyer_id' class="select2" style="width:200px" onchange="this.form.submit()">
                <option value=''>Search By Lawyer</option>
                <?php $lawyer=liblawyer::superLawyer(); 
                   
                    if($lawyer)
                    {
                        foreach ($lawyer as $value) {?>

                                 <option value='<?php echo $value->id ?>' <?php echo ($old == $value->id)?'selected':'' ?>><?php echo $value->first_name.$value->last_name ?></option>";
<?php
                        }
                    }

                 ?>;

            </select>
        </form>

            <table id="table_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Document Name</th>
                    <th>Lawyer</th>
                    <th>Created on</th>
                    <th>DocumentId</th>
                    <th>MemorySize</th>
                </tr>
                </thead>

                <tbody>
                <?php $id='';
            
                foreach($list as $value){
                    $id.=$value[1]->rev.',';
                }
                if(isset($list)){ if (isset($document)) { $case=libcase::getcasedetail(); $user=liblawyer::getlawyer();
                    foreach ($document->results as $documents) {

                foreach($list as $values){  if($values[1]->rev == $documents->gdrive_fileid){
                ?>

                        <tr class="">
                            <td><?php echo $documents->doc_name;  ?></td>
                            <td><?php echo get_value_from_multi_object_array($documents->lawyer_id,$user,'id','first_name');  ?></td>
                            <td><?php echo $documents->create_date;?></td>
                            <td><?php echo $values[1]->rev ?></td>
                            <td>
                                <?php echo $values[1]->size; ?>
                            </td>
                        </tr>
                    <?php } }  } } }?>


                </tbody>
            </table>
            <?php echo $document->links(); ?>
<!--            --><?php // $res=file_get_contents($obj->downloadFile('0B4t6RvVF7erSNHRUdjFiS0FQa28'));
//            print_r('https://doc-10-ac-docs.googleusercontent.com/docs/securesc/v7f7imkku0fqqadrn135as6047qonu9u/1heft056hbpv69mm8passbapnd1a0157/1389196800000/09718063997967389817/09718063997967389817/0B4t6RvVF7erSNHRUdjFiS0FQa28?h=16653014193614665626&e=download&gd=true ');
           
//            $obj->deleteFile('0B4t6RvVF7erSUnhIZmk2TjBmYmM');
//            print_r($obj->retrieveAllFiles());
//            $ids=rtrim($id,',');
//            $obj->deleteFile($ids);
//            $res=$obj->downloadFile('0B4t6RvVF7erSM0poWGFZTWY0ZGs');
//            print_r($res);
//            echo '</pre>';
//            $res=$obj->insertPermission('0B4t6RvVF7erSWktkU0REMVRzTm8','176783101860-uofim5iilrlqdhlm62m886g88qkbtpkg@developer.gserviceaccount.com','reader','anyone');
//            print_r($res);
//                        print_r($obj->retrieveAllFiles());

            ?>
        </div>
    </div>
<?php Section::stop(); ?>
<?php echo Section::start('javascript-footer'); ?>
    <script type="text/javascript">
        $(function() {
            $('.select2').select2();

            var oTable1 = $('#table_report').dataTable( {
                "aoColumns": [
                    { "bSortable": false },
                    null, null,null, null, null,
                    { "bSortable": false }
                ] } );
            $('.btn').tooltip({ placement : 'left'})

        });
    </script>

<?php Section::stop(); ?>

<?php echo render('admin::admin/template.main'); ?>