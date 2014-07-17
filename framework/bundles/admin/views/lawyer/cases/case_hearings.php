<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:22 PM
 */ ?>

<?php echo Section::start('contentWrapper');?>
<style type="text/css">

    table { page-break-after:avoid  }
    tr    { page-break-inside:avoid; page-break-after:auto }
    td    { page-break-inside:avoid; page-break-after:auto }
    thead { display:table-header-group }
    tfoot { display:table-footer-group }
    div.breakhere{ page-break-before: avoid}
    .page{page-break-after: always;page-break-inside: avoid}
    .center{text-align: center}
</style>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon icon-briefcase"></i>
            Case
            <small>
                <i class="icon-double-angle-right"></i>
                Case Hearings
                <i class="icon-double-angle-right"></i>
                <span style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php  $lawyer=liblawyer::getlawyer();$reports=(array)$report; $case_id=$reports['case_id']; unset($reports['case_id']); ?>
<div class="row-fluid">
    <?php $res = translation_array(); ?>
    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h4>Case</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main">

                <table>
                    <?php foreach($reports as $key=>$values){ ?>
                        <tr>
                            <td><span><?php echo $res[$key]; ?></span></td>
                            <td>:&nbsp;&nbsp;&nbsp;</td>
                            <td><span><?php
                                    switch($key)
                                    {
                                        case 'client_id':
                                            $client=libclient::getclientByID($values);
                                            echo '<b>'. ucfirst(get_value_from_object_array($values,$client,'client_id','client_name')).'</b>';
                                        default:
                                            echo '<b>'.ucfirst($values).'</b>';
                                            break;
                                    }
                                    ?></span>
                            </td>

                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
    <?php $hearings = libreport::getcaseHearingDetailsByCaseID($case_id); ?>
    <div class="widget-box breakhere">
        <div class="widget-header widget-header-flat">
            <h4>Hearings</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Hearing date</th>
                        <th>Next Hearing date</th>
                        <th>Lawyer</th>
                        <th>Associate</th>
                        <th>Hearing Description</th>
                        <th>Court Hall</th>
                        <th>Judge</th>
                        <th>Stage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($hearings as $hearing){ ?>
                        <tr>
                            <?php foreach ((array)$hearing as $key => $values) {?>
                                <td><?php
                                    switch($key)
                                    {
                                        case 'lawyer_id':
                                            echo '<b>'.ucfirst(get_multi_value_from_object_array($values,$lawyer,'id','first_name')).'</b>';
                                            break;
                                        case 'associate_lawyer':
                                            echo '<b>'.ucfirst(get_multi_value_from_object_array($values,$lawyer,'id','first_name')).'</b>';
                                            break;
                                        case 'status':
                                            if($values==0){echo "Pending";}elseif($values==1){echo "<b>Processing</b>";}elseif($values==2){echo "<b>Completed</b>";}
                                            break;
                                        case 'client_id':
                                            $client=libclient::getclientByID($values);
                                            echo '<b>'. ucfirst(get_value_from_object_array($values,$client,'client_id','client_name')).'</b>';
                                        case 'doc_no':
                                            $doc=libdocument::getdocumentByID($values);
                                            echo '<b>'.ucfirst(get_value_from_object_array($values,$doc,'doc_id','doc_name')).'</b>';
                                            break;
                                        case 'hearing_date':
                                            echo '<b>'. date('d-M-Y',strtotime($values)).'</b>';
                                            break;
                                        case 'next_hearing_date':
                                            echo '<b>'. date('d-M-Y',strtotime($values)).'</b>';
                                            break;

                                        default:
                                            echo '<b>'.ucfirst($values).'</b>';
                                            break;
                                    }
                                    ?></td>
                            <?php  } ?>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#print_icon').on('click',function(){
        $('#printbtn').click();
//       alert('dfsd');
    });

</script>
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("print_icon");
        var back = document.getElementById("back");
        //Set the print button visibility to 'hidden'
        printButton.style.visibility = 'hidden';
        back.style.visibility = 'hidden';
        //Print the page content
        window.print()
        //Set the print button to 'visible' again
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
        back.style.visibility = 'visible';
    }
</script>


<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
