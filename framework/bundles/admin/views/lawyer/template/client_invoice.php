<!DOCTYPE html>
<html>
<head>
</head>
<body>

<div class="header">
<table style="width:100%">
    <tr>
        <td style="width:50%">
            <?php $image=liblawyer::getimage();?>
             <img alt="150x50" src="<?php if($image){ if($image->letter_header){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->letter_header;}else{ echo '';} }?>" width='150' height="50"/>
         </td>
        <td style="width:50%">
             <h3><?php echo ucfirst( $lawyer->first_name ) . '&nbsp;' . ucfirst( $lawyer->last_name ); ?></h3>
        </td>
    </tr>
</table>
   
</div>
<div>
    <div style="float:right;" >


        <p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BillingDate: <b><?php $date=date('d M Y',strtotime($payment['date']));echo $date; ?></b></p>
        <p class="pull-right">Bill Generated on: <b><?php $Gdate=date("d M  Y",strtotime($payment['modified']));echo $Gdate;  ?></b></p>
    </div>
    <p>Bill Number: <b><?php echo $payment['bill_no']; ?></b></p>

</div>
<div>
    <p>Customer Name: <b><?php echo ucfirst($client->client_name); ?></b></p>
    <p>Case Number: <b><?php echo $case->case_no; ?></b></p>
</div>
<hr>
<div>
    <table  style="width:100%;"  frame="box" rules="all">
        <thead>
        <tr>
            <th style="width:10%" >Sl.No</th>
            <th style="width:60%">description</th>
            <th style="width:30%">Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach ($payment['description'] as $key=>$values){ ?>
        <tr>
            <td><?php echo $i;$i++; ?></td>
            <td><?php echo ucfirst($key); ?></td>
            <td><?php echo $values.' ('.no_to_words($values).' only)'; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="2" align="right">Total due</td>
            <td><?php echo "<i class='icon-inr'></i>".$payment['total'].' ('.no_to_words($payment['total']).' only)'; ?></td>
        </tr>
         <tr>
            <td colspan="2" align="right">Previous due amount:</td>
            <td><?php echo "<i class='icon-inr'></i>".$payment['due'].' ('.no_to_words($payment['due']).' only)'; ?></td>
        </tr>
         <tr>
            <td colspan="2" align="right">Discount:</td>
            <td><?php echo "<i class='icon-inr'></i>".$payment['discount'].' ('.no_to_words($payment['discount']).' only)'; ?></td>
        </tr>
         <tr>
            <td colspan="2" align="right">Total:</td>
            <td><?php echo "<i class='icon-inr'></i>".$payment['netTotal'].' ('.no_to_words($payment['netTotal']).' only)'; ?></td>
        </tr>
         <tr>
            <td colspan="2" align="right">Paid:</td>
            <td><?php echo "<i class='icon-inr'></i>".$payment['paid'].' ('.no_to_words($payment['paid']).' only)'; ?></td>
        </tr>
         <tr>
            <td colspan="2" align="right">Balance:</td>
            <td><?php echo "RS.".$payment['bal']; echo ' ('.no_to_words($payment['bal']).' only)'; ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right">
                 <img alt="150x50" src="<?php if($image){ if($image->sign){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->sign;}else{ echo '';} }?>" width="150"height="30"/>
            </td>
        </tr>
        </tbody>

    </table>
</div>


</body>
</html>
