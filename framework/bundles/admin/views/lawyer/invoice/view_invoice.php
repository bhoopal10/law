 <?php  /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/2/14
 * Time: 1:43 PM
 */  ?>

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

     <?php $client=libpayment::getClientByLawyerId(Auth::user()->id); ?>

     <form name="search" action="<?php echo URL::to_route('ViewInvoice'); ?>" method="get" onsubmit=" return searchValidation();">
         <select class="select2 span3" name="client_id" style="width:200px" onchange="this.form.submit();">
             <option value=''>SearchByClient</option>
             <?php if($client){foreach ($client as $value) { ?>
                <option value="<?php echo $value->client_id; ?>" <?php echo (Input::old('client_id') == $value->client_id )?'selected':'';?>>
                <?php echo $value->client_name; ?>
                </option>
           <?php  }} ?>
             
         </select>
         <input type="text" class="span3" name="from_date" id='from' placeholder="From date" <?php echo (Input::old('from_date')?'value="'.Input::old('from_date').'"':''); ?> onchange="this.form.submit();">
          To
          <input type="text" class="span3" name="to_date" id="to" placeholder="to Date" <?php echo (Input::old('to_date')?'value="'.Input::old('to_date').'"':''); ?> onchange="this.form.submit()">
     </form>
     <table class="table table-bordered table-striped">
         <thead>
         <tr>
         <th>S.No</th>
         <th>Client</th>
         <th>Case Number</th>
         <th>BillNo</th>
         <th>BillDate</th>
         <th>Due Amount</th>
         <th>Status</th>
         <th>Action</th>
         </tr>
         </thead>
         <tbody>
         <?php $client = libclient::getclientname();
         ?>
         <?php $i=1; if($invoice){foreach($invoice->results as $invoices){ $case=libcase::getcasedetailByID($invoices->case_id); ?>
         <tr >
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('HistoryInvoice').'?l='.$invoices->from_user.'&c='.$invoices->to_user; ?>';"><?php echo $i; $i++; ?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('HistoryInvoice').'?l='.$invoices->from_user.'&c='.$invoices->to_user; ?>';"><?php $client_id = $invoices->to_user; echo ucfirst(get_value_from_multi_object_array($client_id,$client,'client_id','client_name'));?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('HistoryInvoice').'?l='.$invoices->from_user.'&c='.$invoices->to_user; ?>';"><?php if($case){ echo $case->case_no; }?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('HistoryInvoice').'?l='.$invoices->from_user.'&c='.$invoices->to_user; ?>';"><?php echo  $invoices->bill_no; ?></td>
             <td style="cursor: pointer"  onclick="window.document.location='<?php echo URL::to_route('HistoryInvoice').'?='.$invoices->from_user.'&c='.$invoices->to_user; ?>';"><?php echo date('d/m/Y', strtotime($invoices->created_date)); ?></td>
             <td><?php echo "<i class='icon-inr'></i>".$invoices->due_amount; ?></td>
             <td><?php if($invoices->status!=0){$status="0";echo '<span class="label label-large label-success" style="padding:3px 8px 7px">&nbsp;&nbsp;&nbsp;Paid&nbsp;&nbsp;&nbsp;</span>';}else{ $status="1";echo '<span class="label label-large label-success" style="3px 8px 7px">UnPaid</span>';}  ?>
                 <div class="btn-group">
                     <button class="btn btn-mini btn-info dropdown-toggle" data-toggle="dropdown">
                         Action
                         <span class="caret"></span>
                     </button>
                     <ul class="dropdown-menu">
                         <li>
                           <a class="pay" data="<?php echo $invoices->payment_id; ?>" 
                           data-due="<?php echo $invoices->due_amount;  ?>"
                           data-paid="<?php echo $invoices->paid; ?>"
                           data-to_user="<?php echo $invoices->to_user; ?>"
                           data-description="<?php echo $invoices->description; ?>">Pay</a>
                         </li>
                     </ul>
                 </div>
             </td>
             <td>
<!--                 <a title="Edit" href="--><?php //echo URL::to_route('EditInvoice').'/'.$invoices->payment_id; ?><!--" class="btn btn-mini btn-info"><i class="icon-edit"></i></a>-->
                 <a title="Edit" href="<?php echo URL::to_route('EditInvoice').'/'.$invoices->payment_id; ?>" class="btn btn-mini btn-info"><i class="icon-edit"></i></a>
                 <a title="Delete" href="<?php echo URL::to_route('DeleteInvoice').'/'.$invoices->payment_id; ?>" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a>
<!--                 <a title="Delete" href="--><?php //echo URL::to_route('DeleteInvoice').'/'.$invoices->payment_id; ?><!--" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a>-->
             </td>
         </tr>
         <?php }} ?>
         </tbody>

     </table>
     <?php echo $invoice->links(); ?>
     </div>
     <div id="payment" style="display:none" >
         <form name="pay" method="post" action="<?php echo URL::to_route('UpdatePayment'); ?>" onsubmit="return validation();">
             <input type="text" name="pay">
             <input type="hidden" name="payment_id" id="payment_id">
             <input type="hidden" name="due" id="due">
             <input type="hidden" name="paid" id="paid">
             <input type="hidden" name='to_user' id="to_user">
             <button type="submit">Pay</button>
         </form>
     </div>
 <script>
 $(function(){
    $('.select2').select2();
       $('#from').datepicker({
                dateFormat:'dd/mm/yy',
                defaultDate: "+1w",
                changeMonth:true,
                changeYear:true,
                onClose:function(selectedDate){
                    $("#to").datepicker("option",'minDate',selectedDate);
                }
            });
            $('#to').datepicker({
                 dateFormat:'dd/mm/yy',
                defaultDate: "+1w",
                 changeMonth:true,
                changeYear:true,
                onClose:function(selectedDate){
                    $("#from").datepicker("option","maxDate",selectedDate);
                }
            });
 });
     $('.btn').tooltip({placement:"left"});
     $('span').tooltip({placement:"left"});
     $('.pay').on('click',function(){
        var id= $(this).attr('data');
        var due=$(this).attr('data-due');
        var paid=$(this).attr('data-paid');
        var to_user=$(this).attr('data-to_user');
         $('#payment_id').val(id);
        $('#due').val(due);
        $('#paid').val(paid);
        $('#to_user').val(to_user);
        $('#payment').dialog({
            title:'Pay',
             buttons: [
                {
                    text: "close",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
     });
     function validation()
     {
        var pay=document.pay.pay.value;
        if(!pay)
        {
            alert('Please enter amount');
            return false;
        }
        if(isNaN(pay))
        {
            alert('Amount must numeric');
            return false;
        }
     }
     function searchValidation()
     {
        var client_id=document.search.client_id.value;
        var from=document.search.from_date.value;
        var to= document.search.to_date.value;
        if(!client_id && !from && !to)
        {
            return false;
        }
     }
 </script>
 <?php Section::stop(); ?>
 <?php echo render('admin::lawyer/template.main'); ?>