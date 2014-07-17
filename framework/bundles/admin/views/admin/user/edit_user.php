<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                    Edit Lawyer
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>

<?php echo Section::start("contentWrapper"); ?>
<?php $status=Session::get('status'); $error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <span><?php echo $status; ?></span>
    </div>
<?php }elseif(isset($error)){?>
<div class="alert alert-danger">
        <span><?php echo $error; ?></span>
    </div>
    <?php } ?>
<?php Session::put('User_detail',$user);  ?>
    <div>
        <div class="row-fluid">
            <form name="form1" onsubmit="return validation();" class="form-horizontal" action="<?php echo URL::to_route('UpdateUser'); ?>" method="post">
                <input type="hidden" name="user_id" value="<?php echo Crypter::encrypt(Auth::user()->id);  ?>" />
                <input type="hidden" name="id" value="<?php echo Crypter::encrypt($user->id);  ?>"/>
                <div class="control-group">
                    <label class="control-label" for="first_name">First Name:<span style="color: red">*</span></label>
                    <div class="controls">
                        <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $user->first_name ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="last_name">Last Name:</label>
                    <div class="controls">
                        <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $user->last_name;  ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="lawyer_id">Lawyer ID:<span style="color: red"></span></label>
                    <div class="controls">
                        <input type="text" id="lawyer_id" name="lawyer_id" value="<?php echo $user->lawyer_id;  ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="lawyer_id">Lawyer Subject:</label>
                    <div class="controls">
                        <input type="text" id="lawyer_subject" name="lawyer_subject" value="<?php echo $user->lawyer_subject;  ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="phone">Phone:</label>
                    <div class="controls">
                        <input type="text" id="phone" name="phone" value="<?php echo $user->phone;   ?>" />
                    </div>
                </div>

                    <div class="control-group">
                        <label class="control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="mobile" name="mobile" value="<?php echo $user->mobile;   ?>" />
                        </div>
                    </div>
                <div class="control-group">
                    <label class="control-label" for="user_email">Email-Id:<span style="color: red">*</span></label>
                    <div class="controls">
                        <input type="text" id="user_email" name="user_email" value="<?php echo $user->user_email;  ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="exp_date">Valid  Upto:</label>
                    <div class="controls">
                        <input type="text" id="exp_date" name="exp_date" placeholder="dd/mm/yyyy" value="<?php echo date('d/m/Y', strtotime($user->exp_date)); ?>"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="address">Address:</label>
                    <div class="controls">
                        <textarea name="address" id="address" style="width: 207px"><?php echo $user->address;  ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="city">City:</label>
                    <div class="controls">
                        <input type="text" id="city" name="city" placeholder="City" value="<?php echo $user->city;  ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="pincode">PinCode:</label>
                    <div class="controls">
                        <input type="text" id="pincode" name="pincode" placeholder="Pin Code" value="<?php echo $user->pincode;  ?>"/>
                    </div>

                    <br>
                    <div class="controls">
                        <button class="btn btn-primary" type="submit" >Update User</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
<script>
    function validation()
    {

        var first_name=document.form1.first_name.value;
//        var last_name=document.form1.last_name.value;
        var lawyer_id=document.form1.lawyer_id.value;
        var mobile=document.form1.mobile.value;
        var email=document.form1.user_email.value;
        var pincode=document.form1.pincode.value;
        var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
        var b=emailfilter.test(email);
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
            document.form1.user_email.focus();
            return false;
        }
        if(b==false)
        {
            alert("Please Enter a valid Mail ID");
            document.form1.user_email.focus();
            return false;
        }
        if(pincode.length != 6)
        {
            alert(" Your Pincode must be 1 to 6 Integers");
            document.form1.pincode.select();
            return false;
        }

    }
</script>
    <script type="text/javascript">
        <?php $sub=liblawyer::getlawyer();  ?>
        var s= <?php $subject=array(); foreach($sub as $sub1){ array_push($subject,$sub1->lawyer_subject); } echo json_encode($subject); ?>;
        $('#lawyer_subject').autocomplete({
            source:s,
            minLength:1

        });
    </script>
    <script>
        $('#exp_date').datepicker({
            dateFormat:"dd/mm/yy",
            changeMonth: true,
            changeYear: true
        })
        $(function(){
            $('span').tooltip({placement:'bottom'});
            $('#pincode').mask('999999');
            $('#mobile').mask('9999999999?,9999999999,9999999999,9999999999');
        });
    </script>
    <style type="text/css">
    label{
        color:green;
    }
</style>
<?php Section::stop() ?>
<?php echo render('admin::admin/template.main'); ?>