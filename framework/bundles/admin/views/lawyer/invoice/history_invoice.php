<?php echo Section::start('contentWrapper'); ?>

 <div id="page-content" class="clearfix">
     <div class="page-header position-relative">
         <h1><i class="icon icon-money"></i>
             Invoice
             <small>
                 <i class="icon-double-angle-right"></i>
                View
                 <i class="icon-double-angle-right"></i>
                 <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
             </small>
         </h1>
     </div>
 </div>
<div class="row-fluid">
     <?php $status=Session::get('status');
            $error=Session::get('error');
     if(isset($status)){ ?>
     <div class="alert alert-success">
         <button type="button" class="close" data-dismiss="alert">
             <span><i class="icon-remove"></i></span>
         </button>
         <span><?php echo $status; ?></span>
     </div>
     <?php } elseif(isset($error)){ ?>
     <div class="alert alert-alert">
         <button type="button" class="close" data-dismiss="alert">
             <span><i class="icon-remove"></i></span>
         </button>
         <span><?php echo $error; ?></span>
     </div>
     <?php } ?>


   <table class="table table-bordered table-striped">
         <thead>
         <tr>
         <th>S.No</th>
         <th>Client</th>
         <th>Case Number</th>
         <th>BillNo</th>
         <th>BillDate</th>
         <th>Due Amount</th>
         <th>UpdatedOn</th>
         <th>Action</th>
         </tr>
         </thead>
         <tbody>
         <?php $client = libclient::getclientname();
         ?>
         <?php $i=1; if($invoice){foreach($invoice as $invoices){ $case=libcase::getcasedetailByID($invoices->case_id); ?>
         <tr >
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id; ?>';"><?php echo $i; $i++; ?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id; ?>';"><?php $client_id = $invoices->to_user; echo ucfirst(get_value_from_multi_object_array($client_id,$client,'client_id','client_name'));?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id; ?>';"><?php if($case){ echo $case->case_no; }?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id; ?>';"><?php echo  $invoices->bill_no; ?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id ?>';"><?php echo date('d/m/Y', strtotime($invoices->created_date)); ?></td>
             <td><?php echo "<i class='icon-inr'></i>".$invoices->due_amount; ?></td>
             <td onclick="window.document.location='<?php echo URL::to_route('InvoiceDetail').'/'.$invoices->payment_id ?>';" > <?php echo date('d/m/Y', strtotime($invoices->modified_date)); ?></td>
             <td>
<!--                 <a title="Edit" href="--><?php //echo URL::to_route('EditInvoice').'/'.$invoices->payment_id; ?><!--" class="btn btn-mini btn-info"><i class="icon-edit"></i></a>-->
                 <!-- <a title="Edit" href="<?php echo URL::to_route('EditInvoice').'/'.$invoices->payment_id; ?>" class="btn btn-mini btn-info"><i class="icon-edit"></i></a> -->
                 <a title="Delete" href="<?php echo URL::to_route('DeleteInvoice').'/'.$invoices->payment_id; ?>" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a>
<!--                 <a title="Delete" href="--><?php //echo URL::to_route('DeleteInvoice').'/'.$invoices->payment_id; ?><!--" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a>-->
             </td>
         </tr>
         <?php }} ?>
         </tbody>

     </table>
     </div>
<?php Section::stop(); ?>
 <?php echo render('admin::lawyer/template.main'); ?>