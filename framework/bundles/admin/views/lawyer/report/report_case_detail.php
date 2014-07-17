<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:22 PM
 */ ?>
<style>
    @media print {

        .for-print {
            margin-left: -190px;
        }
        .widget-box {  page-break-inside:avoid; page-break-after:auto }
    }
</style>
<?php echo Section::start('contentWrapper');?>


  <div class="for-print">
        <div class="page-header">
            <span title="Back" style="cursor: pointer" onclick="history.go(-1);" id="back"><i class="icon-arrow-left"></i>Back</span>
            <div class="pull-right">
                <!--           <input type="hidden"  onClick="window.print()" id="print">-->
                <input id="printbtn" type="hidden" value="Print this page" onclick="printpage()"/>

                <i title="Print" class="icon-2x icon-print " id="print_icon" style="cursor: pointer"></i>
            </div>
            <?php  $lawyer=liblawyer::getlawyer();$reports=(array)$report;
            if($reports)
            {
            $case_id=$reports['case_id']; unset($reports['case_id']); ?>
            <div class="center">
                <h3><?php echo get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'first_name').'&nbsp;'.get_value_from_multi_object_array(Auth::user()->id, $lawyer, 'id', 'last_name'); ?></h3>
                <h4><?php $client=libclient::getclientByID($reports['client_id']); echo ucfirst(get_value_from_object_array($reports['client_id'],$client,'client_id','client_name')) ;?> Report</h4>
            </div>
        </div>

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

        <?php

        foreach($hearings as $hearing){ ?>
       <tr onclick="document.location.href='<?php echo URL::to_route('HearingDetail').'/'.$hearing->hearing_id;  ?>'" style="cursor: pointer">
            <?php $Hearing=(array)$hearing; unset($Hearing['hearing_id']); foreach ($Hearing as $key => $values) {   ?>

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
      <?php }
      else
      {
          echo "<br><p style='color:red'>There is no Hearings of this case</p></b>";
      }
      ?>
      </div>
<script>
    $('span').tooltip({
        placement : 'bottom'
    });
    $('i').tooltip({
        placement : 'left'
    });
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
