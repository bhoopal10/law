<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/4/14
 * Time: 8:24 PM
 */ ?>
    <style>
        @media print{
            .for-print {
                margin-left: -190px;
            }

        }

    </style>

<?php echo Section::start('contentWrapper'); ?>

<div class="for-print">
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php } ?>
<a title="Back" style="cursor: pointer" href="<?php echo URL::to_route('ViewInvoice'); ?>" class="btn btn-mini" id="back">Back</a>
    <a title="Print" href="javascript:void(0);" style="float: right;color:black" id="print"><i class="icon-2x icon-print"></i></a>&nbsp;&nbsp;
    <a title="sendMail" href="javascript:void(0);" style="float: right;color: #a0acff" id="email"><i class="icon-2x icon-envelope"></i>&nbsp;&nbsp;</a>&nbsp;&nbsp;
    <div class="header">
       <table style="width:100%">
    <tr>
        <td style="width:50%">
             <?php $image=liblawyer::getimage();?>
                            <img alt="150x150" src="<?php if($image){ if($image->letter_header){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->letter_header;}else{ echo '';} }?>" style="width: 150px;height: 50px"/>
        </td>
        <td style="width:50%">
             <h3 ><?php echo ucfirst( $lawyer->first_name ) . '&nbsp;' . ucfirst( $lawyer->last_name ); ?></h3>
        </td>
    </tr>
</table>
    </div>
    <div>
        <div style="float:right;" >


            <p >  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BillingDate: <b><?php $date=date("d M  Y",strtotime($invoice->created_date));echo $date; ?></b></p>
            <p class="pull-right">Bill Generated on: <b><?php $Gdate=date("d M  Y",strtotime($invoice->modified_date));echo $Gdate;  ?></b></p>
        </div>
        <p>Bill Number: <b><?php echo $invoice->bill_no; ?></b></p>

    </div>
    <div>
        <p>Customer Name: <b><?php echo $client->client_name; ?></b></p>
        <p>Case Number: <b><?php echo $case->case_no; ?></b></p>
    </div>
    <div>
        <table  class="table table-bordered table-striped" rules="all">
            <thead>
            <tr>
                <th style="width:10%" >Sl.No</th>
                <th style="width:60%">description</th>
                <th style="width:30%">Amount</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach ($description as $key=>$values){ ?>
                <tr>
                    <td><?php echo $i;$i++; ?></td>
                    <td><?php echo ucfirst($key); ?></td>
                    <td><?php echo $values.' ('.no_to_words($values).' only)'; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">SubTotal:</td>
                <td><?php echo "<i class='icon-inr'></i>".$total.' ('.no_to_words($total).' only)'; ?></td>
            </tr>
              <tr>
              <td>&nbsp;</td>
            <td style="text-align: right">Previous due amount:</td>
            <td><?php echo "<i class='icon-inr'></i>".$invoice->old_due.' ('.no_to_words($invoice->old_due).' only)'; ?></td>
        </tr>
         <tr>
         <td>&nbsp;</td>
            <td style="text-align: right">Discount:</td>
            <td><?php echo "<i class='icon-inr'></i>".$invoice->discount.' ('.no_to_words($invoice->discount).' only)'; ?></td>
        </tr>
         <tr>
         <td>&nbsp;</td>
            <td style="text-align: right">TotalDue:</td>
            <td><?php echo "<i class='icon-inr'></i>".$invoice->total.' ('.no_to_words($invoice->total).' only)'; ?></td>
        </tr>
         <tr>
         <td>&nbsp;</td>
            <td style="text-align: right">Paid:</td>
            <td><?php echo "<i class='icon-inr'></i>".$invoice->paid.' ('.no_to_words($invoice->paid).' only)'; ?></td>
        </tr>
         <tr>
         <td>&nbsp;</td>
            <td style="text-align: right">Balance:</td>
            <td><?php echo "<i class='icon-inr'></i>".$invoice->due_amount; echo ' ('.no_to_words($invoice->due_amount).' only)'; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right">
                 <img alt="150x150" src="<?php if($image){ if($image->sign){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->sign;}else{ echo '';} }?>" style="width: 150px;height: 50px"/>
            </td>
        </tr>
            </tbody>

        </table>
    </div>
<script>
    $(function(){
       $('a').tooltip({placement:'left'});
       $('.btn').tooltip({placement:'right'});
        $('#print').on('click',function(){
            var printButton = document.getElementById("print");
            var email=document.getElementById("email");
             var back=document.getElementById("back");
            printButton.style.visibility = 'hidden';
            email.style.visibility='hidden';
            back.style.visibility='hidden';
            window.print()
            printButton.style.visibility = 'visible';
            email.style.visibility='visible';
            back.style.visibility='visible';
        });
        $('#email').on('click',function(){
           var id="<?php echo $invoice->payment_id; ?>";
            var url="<?php echo URL::to_route('SendInvoice'); ?>";
            $.post(url,{payment_id:id})
                .success(function(data){
                   alert(data);
                });
        });
    });
</script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>