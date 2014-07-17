<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 11/28/13
 * Time: 1:47 AM
 * To change this template use File | Settings | File Templates.
 */
 echo Section::start('contentWrapper'); ?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-user"></i>
                Contact
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Contacts
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>

        </div>
    </div>

<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert-success">
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
    <!--       Getting all group names for auto complete            -->
<?php $id=$id;
//print_r($contact);exit;
?>
    <div id="contact-tab" class="tab-pane in active">

        <form name="form1" onsubmit="return validation();" action="<?php echo URL::to_route('UpdateContact');  ?>" class="form-horizontal" method="post">
            <input type="hidden" name="lawyer_id" value="<?php echo Auth::user()->id; ?>"/>
            <input type="hidden" name="key" value="<?php echo $id; ?>"/>
            <div class="control-group">
                <label for="first_name" class="control-label">First Name:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="first_name" id="first_name" value="<?php echo $contact[$id]->first_name;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="last_name" class="control-label">Last Name:</label>
                <div class="controls">
                    <input type="text" name="last_name" id="last_name" value="<?php echo $contact[$id]->last_name;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="mobile" class="control-label">Mobile:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="mobile" id="mobile" value="<?php echo $contact[$id]->mobile;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="phone" class="control-label">Phone:</label>
                <div class="controls">
                    <input type="text" name="phone" id="phone"value="<?php echo $contact[$id]->phone;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="email" class="control-label">Email-ID:<span style="color: red">*</span></label>
                <div class="controls">
                    <input type="text" name="email" id="email"value="<?php echo $contact[$id]->email;  ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label for="group" class="control-label">Group:</label>
                <div class="controls">
                    <input type="text" name="group" id="group" value="<?php echo $contact[$id]->group;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="city" class="control-label">City:</label>
                <div class="controls">
                    <input type="text" name="city" id="city" value="<?php echo $contact[$id]->city;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="address" class="control-label">Address</label>
                <div class="controls">
                    <textarea name="address" id="address"  rows="2"><?php echo $contact[$id]->address;  ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit">Add Contact</button>
                    <button class="btn btn-danger" type="reset">Reset</button>
                </div>
            </div>
        </form>
    </div>
<script>
    $(function(){
       $('span').tooltip({placement:'bottom'});
       $('#mobile').mask('9999999999?,9999999999,9999999999,9999999999');
    });
    function validation()
    {

        var first_name=document.form1.first_name.value;
        var mobile=document.form1.mobile.value;
        var email=document.form1.email.value;
        var emails=email.split(',');
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
        if(!first_name)
        {
            alert('Please enter first name');
            document.form1.first_name.focus();
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

    }
</script>
    <script type="text/javascript">

        $(function(){
            var group=<?php if(isset($groupName)){echo $groupName;}  ?>;
            var city=<?php if(isset($cityName)){ echo $cityName;}  ?>;
            $('#group').autocomplete({
                source:group,
                minLength:1
            })
            $('#city').autocomplete({
                source:city,
                minLength:1
            })
        });

    </script>


<style type="text/css">
    label{
        color:#4DD9E1;
    }
</style>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>