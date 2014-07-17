<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/8/14
 * Time: 3:35 PM
 */ ?>
<?php echo Section::start('contentWrapper'); ?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-user"></i>
                Client
                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Client
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>

        </div>
    </div>

<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class=" alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php } elseif(isset($error)){ ?>
    <div class=" alert alert-alert">
        <button type="button" class="close" data-dismiss="alert">
            <span><i class="icon-remove"></i></span>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php }?>
<?php Session::put('client', $client); if($client){ ?>
    <div id="contact-tab" class="tab-pane in active">
        <form name="form1" class="form-horizontal" action="<?php echo URL::to_route('ClientUpdate'); ?>" method="post" id="AddClientForm" onsubmit="return validation();">
            <div class="control-group">
<!--                <input type="hidden" name="update_by" value="--><?php //echo Auth::user()->id; ?><!--"/>-->
                <label class="control-label" for="client_name">Client name:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="client_name" id="client_name" value="<?php echo $client->client_name; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="mobile" id="mobile" value="<?php echo $client->mobile; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="phone">Phone:</label>
                <div class="controls">
                    <input type="text" name="phone" id="phone" value="<?php echo $client->phone; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">Email:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="<?php echo $client->email; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="address">Address:</label>
                <div class="controls">
                    <input type="text" name="address" id="address" value="<?php echo $client->address; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="city">City:</label>
                <div class="controls">
                    <input type="text" name="city" id="city" value="<?php echo $client->city; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="state">State:</label>
                <div class="controls">
                    <input type="text" name="state" id="state" value="<?php echo $client->state; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="pincode">Pincode:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="pincode" id="pincode" value="<?php echo $client->pincode; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" id="AddClient">Update</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>
            </div>

        </form>
    </div>
<?php } ?>
    <script>
        $(function(){
           $('span').tooltip({placement:'bottom'});
            $('#pincode').mask('999999');
            $('#mobile').mask('9999999999?,9999999999,9999999999,9999999999');
        });
        function validation()
        {
            var client_name=document.form1.client_name.value;
            var mobile=document.form1.mobile.value;
            var email=document.form1.email.value;
            var emails=email.split(',');
            var pincode=document.form1.pincode.value;
            var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
            var count=emails.length;
            for(var i=0;i<count;i++)
            {
                var b=emailfilter.test(emails[i]);
                if(b==false)
                {
                    alert('Please enter valid email');
                    return false;
                }
            }
            if(!client_name)
            {
                alert('Please enter Client name');
                document.form1.client_name.focus();
                return false;
            }
            if(!mobile)
            {
                alert('Please enter Mobile number');
                document.form1.mobile.focus();
                return false;
            }
            // if(isNaN(mobile))
            // {
            //     alert("Enter the valid Mobile Number(Like : 9566137117)");
            //     document.form1.mobile.focus();
            //     return false;
            // }
            // if(mobile.length != 10)
            // {
            //     alert(" Your Mobile Number must be 1 to 10 Integers");
            //     document.form1.mobile.select();
            //     return false;
            // }
            if(!email)
            {
                alert('please enter email ID');
                document.form1.email.focus();
                return false;
            }
            if(b==false)
            {
                alert("Please Enter a valid Mail ID");
                document.form1.email.focus();
                return false;
            }
            if(!pincode)
            {
                alert('Please Enter Pincode');
                document.form1.pincode.focus();
                return false;
            }
            if(isNaN(pincode))
            {
                alert("Enter the valid pincode Number(Like : 560057)");
                document.form1.mobile.focus();
                return false;
            }
            if(pincode.length != 6)
            {
                alert('Pincode length must 6 character');
                document.form1.pincode.focus();
                return false;
            }

        }
    </script>
    <style type="text/css">
    label{
        color:#F2D12E;
    }
</style>
<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>