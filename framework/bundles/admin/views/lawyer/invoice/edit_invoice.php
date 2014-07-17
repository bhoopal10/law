<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/24/14
 * Time: 5:49 PM
 */ ?>
<?php echo Section::start('contentWrapper'); ?>

    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1><i class="icon icon-money"></i>
                Invoice
                <small>
                    <i class="icon-double-angle-right"></i>
                    Create
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>
        </div>
    </div>
    <div class="row-fluid">
        <?php $status=Session::get('status');
            if(isset($status)){ ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">
                        <span><i class="icon-remove"></i></span>
                    </button>
                    <span><?php echo $status; ?></span>
                </div>
            <?php } ?>
        <?php if($invoice){ ?>
        <form action="<?php echo URL::to_route('UpdateInvoice'); ?>" class="form-horizontal" method="post" name="form" onsubmit="return validation();">
            <input type="hidden" name="id" value="<?php echo $invoice->payment_id; ?>    ">
            <div class="control-group">
                <label class="control-label" for="client_name">Client:<span style="color: red">*</span></label>
                <div class="controls">
                        <?php $client = libclient::getclientByID($invoice->to_user);  ?>
                   <input type="text" value="<?php echo $client->client_name; ?>"  disabled>
                   <input type="hidden" value="<?php echo $invoice->to_user; ?>" name="client_id" >
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="case_id">Case:<span style="color: red">*</span></label>
                <div class="controls">
                    <?php $case = libcase::getcasedetailByID( $invoice->case_id ); ?>
                    <input type="text" value="<?php echo $case->case_no; ?>" disabled>
                    <input type="hidden" name="case_id" value="<?php echo $invoice->case_id; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="bill_no">Bill No:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="bill_no" id="bill_no" value="<?php echo $invoice->bill_no; ?>">
                </div>
            </div>
            <table id="mytable" style="margin-left: 108px">
                <?php $desc = json_decode( $invoice->description ); unset($desc->total); foreach($desc as $key=>$value){ ?>
                <tr>
                    <td>
                        Amount:<span style="color: red">*&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <input type="text" name="amount[]" id="amount" class="amount" value="<?php echo $value; ?>">
                        &nbsp; Description:<span style="color: red">*</span>
                        <input type="text" name="description[]" id="description" value="<?php echo $key; ?>">
                    </td>
                </tr>
        <?php } ?>
         </table>

            <div class="control-group">
                <label class="control-label" for="due">Due Amount:</label>
                <div class="controls">
                    <input type="text" name="due_amount" id="due_amount" value="<?php echo $invoice->old_due; ?>" readonly="readonly">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="discount">Discount:</label>
                <div class="controls">
                    <input type="text" name="discount" id="discount" value="<?php echo $invoice->discount; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="total">Total:</label>
                <div class="controls">
                    <input type="text" id="total" name="total" readonly="readonly" value="<?php echo $invoice->total; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="total">Paid:</label>
                <div class="controls">
                    <input type="text" id="paid" name="paid" value="<?php echo $invoice->paid; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="total">Balance:</label>
                <div class="controls">
                    <input type="text" id="bal" name="due" readonly="readonly" value="<?php echo $invoice->due_amount; ?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="total">Note:</label>
                <div class="controls">
                    <textarea name="note"><?php echo $invoice->note; ?></textarea>
                </div>
            </div>


           


            <div id="email">

            </div>
            <div class="control-group">
                <div class="controls">
                    <input type='submit' class="btn btn-small  btn-success" value="Save">
                    <input type="submit" class="btn btn-small btn-primary" value="save & send" id="send">
                    &nbsp;<a href="javascript:void(0);" class="add btn btn-mini btn-primary" id="add">[+]Add</a>
                </div>
            </div>
            <!--            <button class="btn btn-mini btn-danger" onclick="history.go(-1);">Back </button>-->
        </form>
        <?php } ?>
    </div>
    <script type="application/javascript">


        function validation()
        {
            var client=document.form.client_id.value;
            var case_id=document.form.case_id.value;
            var bill_no=document.form.bill_no.value;
            if(!client)
            {
                alert('Please select client');
                return false;
            }
            if(!case_id)
            {
                alert('Please select Case');
                return false;
            }
            if(!bill_no)
            {
                alert('Please enter bill number');
                return false;
            }
            var s= $('.amount').serializeArray();
            var count= s.length;
            for(var i=0; i< count;i++)
            {
                var amount=document.form.amount[i].value;
                var desc=document.form.description[i].value;
                if(amount)
                {
                    if(isNaN(amount))
                    {
                        alert("Amount must be numeric");
                        return false;
                    }
                }
                if(!amount)
                {
                    alert('Please enter amount');
                    return false;
                }
                if(!desc)
                {
                    alert('Please enter  Description');
                    return false;
                }
            }




        }
        $('#send').on('click',function(){
            $("#email").html("<input type='hidden' name='email' value='1' />");
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.add').on('click',function(){
                $('#mytable').append('<tr>' +
                    '<td>' +
                    'Amount:<span style="color: red">*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'+
                    '<input type="text" name="amount[]" id="amount" class="amount" >' +
                    '&nbsp; Description:<span style="color: red">*&nbsp;&nbsp;</span>'+
                    '<input type="text" name="description[]" id="description">&nbsp;' +
                    '<a href="javascript:void(0);" class="remove label label-warning">[-]Remove</a>'+
                    '</td>' +

                    '</tr>');

            });
            $('#mytable').on('click','.remove',function(){
                var min=$('#total').val()-$(this).parent().children('.amount').val();
                 $('#total').val(min);
                 var bal=$('#total').val()-$('#paid').val();
                 $('#bal').val(bal);
                $(this).parent().parent().remove();
            });

        });
        $(function(){
            $('span').tooltip({placement:'bottom'});
        });
        $(document).keyup(function(){
            var tot=0;
            $('.amount').each(function(){
                var am=parseInt($(this).val());
                tot =isNaN(am)? (tot):(tot+am);
            });
            var due=parseInt(document.form.due_amount.value);
            var paid=parseInt(document.form.paid.value);
            tot=isNaN(due)? (tot):(tot+due);
            var discount=parseInt(document.form.discount.value);
            tot=isNaN(discount)?(tot):(tot-discount);
            var bal=isNaN(paid)?(tot):(tot-paid);
            $('#total').val(tot);
            $('#bal').val(bal);
        });


    </script>
<style type="text/css">
    label{
        color:#5C94E9;
    }
</style>
    </div>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>