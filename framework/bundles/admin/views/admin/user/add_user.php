<?php echo Section::start('page-header');?>

    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
            <i class="icon icon-group"></i>
               Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                   Add Lawyer
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
                </small>

            </h1>
        </div>
    </div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper'); ?>
<?php $status=Session::get('status');
$error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php } if(isset($error)){ ?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <?php echo $error;  ?>
        <br/>
    </div>

<?php }?>
    <div class="span5">
        <form action="<?php echo URL::to_route('UserFile'); ?>" method="post" enctype="multipart/form-data" id="upload" style="display: none" >
             <input type="file" name="user" id="user" style="display: none" onselect=""/>
            <label for="" id="up" style="float: right">ClickHere To Add Bulk Lawyers</label>
        </form>
        <script>
            var fl = document.getElementById('user');
            fl.onchange = function(){

                var ext = this.value.match(/\.(.+)$/)[1];
                switch(ext)
                {
                    case 'csv':
                        $('#upload').submit();
                        break;

                    default:
                        alert('Upload only .csv file');
                        this.value='';
                }
            };
            $('#up').click(function(){
               $('#user').click();
            });


        </script>

        <div>
            <div>
                <form name="form1" onsubmit="return validation();" class="form-horizontal" action="<?php echo URL::to_route('AddUser'); ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo Crypter::encrypt(Auth::user()->id); ?>" />
                    <div class="control-group">
                        <label class="control-label" for="first_name">First Name:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" <?php echo (Input::old('first_name'))?'value="'.Input::old('first_name').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="last_name">Last Name:</label>
                        <div class="controls">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" <?php echo (Input::old('last_name'))?'value="'.Input::old('last_name').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lawyer_id">Lawyer ID:</label>
                        <div class="controls">
                            <input type="text" id="lawyer_id" name="lawyer_id" placeholder="Lawyer_id" value="" <?php echo (Input::old('lawyer_id'))?'value="'.Input::old('lawyer_id').'"':''; ?>/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="lawyer_subject">Lawyer Subject:</label>
                        <div class="controls">
                            <input type="text" id="lawyer_subject" name="lawyer_subject" placeholder="Lawyer Subject" <?php echo (Input::old('lawyer_subject'))?'value="'.Input::old('lawyer_subject').'"':''; ?>/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="mobile" name="mobile" placeholder="Mobile"  <?php echo (Input::old('mobile'))?'value="'.Input::old('mobile').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="phone">Phone:</label>
                        <div class="controls">
                            <input type="text" id="phone" name="phone" placeholder="Phone" <?php echo (Input::old('phone'))?'value="'.Input::old('phone').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="username">Username<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="username" name="username" placeholder="UserName" <?php echo (Input::old('username'))?'value="'.Input::old('username').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_email">Email-Id:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="user_email" name="user_email" placeholder="Email ID" <?php echo (Input::old('user_email'))?'value="'.Input::old('user_email').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="exp_date">Valid  Upto:</label>
                        <div class="controls">
                            <input type="text" id="exp_date" name="exp_date" placeholder="dd/mm/yyyy"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address">Address:</label>
                        <div class="controls">
                            <textarea name="address" id="address" style="width: 207px"><?php echo (Input::old('address'))? Input::old('address'):''; ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="city">City:</label>
                        <div class="controls">
                            <input type="text" id="city" name="city" placeholder="City" <?php echo (Input::old('city'))?'value="'.Input::old('city').'"':''; ?>/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="pincode">PinCode:<span style="color: red">*</span></label>
                        <div class="controls">
                            <input type="text" id="pincode" name="pincode" placeholder="Pin Code" <?php echo (Input::old('pincode'))?'value="'.Input::old('pincode').'"':''; ?>/>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        <button class="btn btn-primary" type="submit" > Add User</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

<script>
    function validation()
    {
        var first_name=document.form1.first_name.value;
        var last_name=document.form1.last_name.value;
        var mobile=document.form1.mobile.value;
        var username=document.form1.username.value;
        var email=document.form1.user_email.value;
        var pincode=document.form1.pincode.value;
        var password=document.form1.password.value;
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
        if(!username)
        {
            alert("Please enter UserName");
            document.form1.username.focus();
            return false;
        }
        if(username.length <= 4)
        {
            alert("UserName must be  greaterthan 4 charcaters");
            document.form1.username.focus();
            return false;
        }
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
        if(!pincode)
        {
            alert("Please Enter Pincode");
            document.form1.pincode.focus();
            return false;
        }
        if(isNaN(pincode))
        {
            alert("Enter the valid Pin Code(Like : 560057)");
            document.form1.pincode.focus();
            return false;
        }
        if(pincode.length != 6)
        {
            alert(" Your Pincode must be 1 to 6 Integers");
            document.form1.pincode.select();
            return false;
        }
        if(!password)
        {
            alert("please enter Password");
            document.form1.password.focus();
            return false;
        }

    }
</script>
<script>
    $('#exp_date').datepicker({
        minDate:0,
        dateFormat:"dd/mm/yy",
        changeMonth: true,
        changeYear: true
    });
    $(function() {
        $('.btn').tooltip({placement:'left'});
        $('span').tooltip({placement:'bottom'});
        $('a').tooltip({placement:'bottom'});
        $('#pincode').mask('999999');
        $('#mobile').mask('9999999999?,9999999999');
    });
</script>
<style type="text/css">
    label{
        color:green;
    }
</style>
<?php Section::stop() ?>
<?php echo render('admin::admin/template.main'); ?>