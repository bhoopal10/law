<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:22 PM
 */ ?>
<?php echo Section::start('contentWrapper');?>
<style type="text/css">
        @media print {

            .for-print {
                margin-left: -190px;

            }
            .widget-box {  page-break-inside:avoid; page-break-after:auto }

        }
</style>


<?php  $lawyer=liblawyer::getlawyer();$reports=(array)$report; ?>
<?php $page=1;?>
<div class="for-print">
   <div class="page-header">
       <span title="Back" style="cursor: pointer" onclick="history.go(-1);" id="back"><i class="icon-arrow-left"></i>Back</span>
       <div class="pull-right">
<!--           <input type="hidden"  onClick="window.print()" id="print">-->
           <input id="printbtn" type="hidden" value="Print this page" onclick="printpage()"/>

           <i title="Print" class="icon-2x icon-print " id="print_icon" style="cursor: pointer"></i>
       </div>

       <div class="center">
          <h3><?php echo get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'first_name').'&nbsp;'.get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'last_name'); ?></h3>
          <h4><?php echo ucfirst($report->client_name); ?> Report</h4>
      </div>
   </div>

<?php $res = translation_array(); ?>



<div class="widget-box">
    <div class="widget-header widget-header-flat">
        <h4>Client</h4>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <table>
            <?php foreach((array)$report as $key=>$value){ ?>
                <tr>
                    <td><span><?php echo $res[$key]; ?></span></td>
                    <td>  :&nbsp;&nbsp;&nbsp;  </td>
                    <td><span><?php echo '<b>' . ucwords($value) . '</b>'; ?></span><br/></td>
                </tr>
            <?php } ?>

                </table>
        </div>
    </div>
</div>

<div class="widget-box breakhere">
    <div class="widget-header widget-header-flat">
        <h4>Cases</h4>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Case Name</th>
                    <th>Case Number</th>
                    <th>Case Description</th>
                    <th>Case Type</th>
                    <th>Case Subject</th>
                </tr>
                </thead>
                <tbody>
                <?php $case=libreport::getcasehearingByclientID($client_id); foreach($case as $cases){ ?>
                <tr>
                    <td><?php echo '<b>'.ucfirst($cases->case_name).'</b>'; ?></td>
                    <td><?php echo '<b>'.ucfirst($cases->case_no).'</b>'; ?></td>
                    <td><?php echo '<b>'.ucfirst($cases->case_description).'</b>'; ?></td>
                    <td><?php echo '<b>'.ucfirst($cases->case_type).'</b>'; ?></td>
                    <td><?php echo '<b>'.ucfirst($cases->case_subject).'</b>'; ?></td>
                </tr>
                <?php } ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<div class="footer">

</div>

<?php foreach($case as $cases){ $hearings = libreport::getcaseHearingDetailsByCaseID($cases->case_id); if($hearings!=NULL){ ?>
<div class="widget-box breakhere">
    <div class="widget-header widget-header-flat">
        <h4>Hearings - <?php echo $cases->case_name.'('.$cases->case_no.')'; ?></h4>
    </div>

    <div class="widget-body" style="page-break-inside: avoid">
        <div class="widget-main">
       <table class="table table-bordered" style="page-break-inside: avoid">
           <thead>
           <tr>
               <th>S. No.</th>
               <th>Hearing Date</th>
               <th>Next Hearing date</th>
               <th>Associate</th>
               <th>Description</th>
               <th>Court Hall</th>
               <th>Judge</th>
               <th>Stage</th>
           </tr>
           </thead>
           <tbody>
           <?php $i=1;foreach($hearings as $hearing){ ?>
               <tr onclick="document.location.href='<?php echo URL::to_route('HearingDetail').'/'.$hearing->hearing_id;  ?>'" style="cursor: pointer">
               <td><?php echo $i;$i++; ?></td>
               <td><?php echo date('d-M-Y',strtotime($hearing->hearing_date)); ?></td>
               <td><?php echo date('d-M-Y',strtotime($hearing->next_hearing_date)); ?></td>
               <td><?php echo '<b>'.ucfirst(get_multi_value_from_object_array($hearing->associate_lawyer,$lawyer,'id','first_name')).'</b>'; ?></td>
               <td><?php echo '<b>'.ucfirst($hearing->description).'</b>'; ?></td>
               <td><?php echo '<b>'.ucfirst($hearing->court_hall).'</b>'; ?></td>
               <td><?php echo '<b>'.ucfirst($hearing->judge).'</b>'; ?></td>
               <td><?php echo '<b>'.ucfirst($hearing->stage).'</b>'; ?></td>
           </tr>
           <?php } ?>
           </tbody>
       </table>
        </div>
        </div>
</div>
<?php } } ?>
    </div>

<script>
    $('#print_icon').on('click',function(){
        $('#printbtn').click();
//       alert('dfsd');
    });
    $('span').tooltip({
        placement : 'bottom'
    });
    $('i').tooltip({
        placement : 'left'
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
