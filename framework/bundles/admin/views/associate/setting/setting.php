<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bhoo
 * Date: 12/8/13
 * Time: 7:40 PM
 * To change this template use File | Settings | File Templates.
 */
echo Section::start('page-header');
?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-cog"></i>
            Settings
            <small>
                <i class="icon-double-angle-right"></i>
                Profile

            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper');  ?>
<?php $status=Session::get('status');
        $error=Session::get('error');
if(isset($status)){ ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }
    if(isset($error)){ ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $error; ?></span>
    </div>
<?php }?>
<!-- Profile -->
<div class="widget-box widget-color-blue">
    <div class ="widget-header">
        <h2>Profile</h2>
    </div>
    <div class="widget-body">
   
        <div class="widget-main no-padding">
            <div id="user-profile-1" class="user-profile row-fluid">
                <div class="span2">
                    <div class="row-fluid">
                        <form class="form-horizontal" action="<?php echo URL::to_route('UploadImage');  ?>" method="post" enctype="multipart/form-data" id="upload">
                            <div class="control-group">
                                <label for="image" class="control-label">
                                    <ul class="ace-thumbnails">
                                        <li>
                                            <a id="thumbnails" data-rel="colorbox">
                                                <?php $image=liblawyer::getimage();?>
                                                <img alt="150x150" style="width:160px;height:130px" src="<?php if($image->image){ echo Config::get('application.url').Config::get('admin::admin_config.image_path').'images/'.$image->image;}else{ echo Config::get('application.url').'img/index.jpg';} ?>" />
                                            </a>
                                            <div class="tools tools-bottom">
                                               <span style="color: white">Change Picture</span>

                                            </div>
                                        </li>
                                    </ul>
                                </label>
                                <div class="controls">
                                    <input type="file" id="image" name="image"  style="display: none"/>
                                </div>
                            </div>
                        </form>
                </div>
                <div class="hr dotted"></div>
                <div class="row-fluid">
                    <a data-toggle="modal" href="#editProfile" class="btn btn-block btn-info">Edit Profile</a>
                </div>
                <div class="hr dotted"></div>
                    <div class="row-fluid">
                        <a data-toggle="modal" href="#myModal" class="btn btn-block btn-info">Change Password</a>
                    </div>
                    <div class="hr dotted"></div>
                </div>
                <?php $profile=liblawyer::lawyerprofile();  ?>
    <div class="span5">
                    <div class="row-fluid">
                          <div class="span4">
                              <h5>FirstName</h5>
                          </div>
                        <div class="span8">
                            <h5><b>: <?php echo ucfirst($profile->first_name);  ?></b></h5>
                        </div>
                    </div>
                        <div class="hr dashed"></div>
                        <div class="row-fluid">
                        <div class="span4">
                              <h5>UserName</h5>
                          </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->username;  ?></b></h5>
                        </div>
                        </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Mobile</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->mobile; ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>City</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo ucfirst($profile->city); ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Address</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo ucfirst($profile->address); ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>           
                </div>
                <!-- Rightside -->
                <div class="span5">
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Last Name</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo ucfirst($profile->last_name);  ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Primary Email</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->user_email; ?></b>&nbsp;&nbsp;<a data-toggle='modal' title="Add more email" href="#add-email" ><i class="icon icon-plus-sign"></i></a></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Phone</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->phone; ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                    <div class="row-fluid">
                        <div class="span4">
                            <h5>Pincode</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->pincode; ?></b></h5>
                        </div>
                    </div>
                     <div class="hr dashed"></div>
                     <div class="row-fluid">
                        <div class="span4">
                            <h5>Additional Emails</h5>
                        </div>
                        <div class="span8">
                            <h5><b>: <?php echo $profile->email; ?></b></h5>
                        </div>
                    </div>
                    <div class="hr dashed"></div>
                </div>
                <!-- Right Ends -->
            </div>
        </div>
    </div>
</div>
    


<!--            Edit Profile                        -->

    <div id="editProfile" class="modal hide fade" style="display: none;" >
         <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Edit Profile</h3>
        </div>
            <div class="modal-body">
                <form action="<?php echo URL::to_route('ProfileUpdate');  ?>" class="form-horizontal" method="post">
                    <div class="control-group">
                        <label for="first_name" class="control-label">First Name:</label>
                        <div class="controls">
                            <input type="text" name="first_name" id="first_name" value="<?php echo $profile->first_name;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="last_name" class="control-label">Last Name:</label>
                        <div class="controls">
                            <input type="text" name="last_name" id="last_name"value="<?php echo $profile->last_name;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="lawyer_id" class="control-label">Lawyer ID:</label>
                        <div class="controls">
                            <input type="text" name="lawyer_id" id="lawyer_id" value="<?php echo $profile->lawyer_id;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="lawyer_subject" class="control-label">Lawyer Subject:</label>
                        <div class="controls">
                            <input type="text" name="lawyer_subject" id="lawyer_subject" value="<?php echo $profile->lawyer_subject;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="mobile" class="control-label">Mobile:</label>
                        <div class="controls">
                            <input type="text" name="mobile" id="mobile" value="<?php echo $profile->mobile;  ?>"/>
                        </div>
                    </div>
                     <div class="control-group">
                        <label for="phone" class="control-label">Phone:</label>
                        <div class="controls">
                            <input type="text" name="phone" id="phone" value="<?php echo $profile->phone;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="city" class="control-label">City:</label>
                        <div class="controls">
                            <input type="text" name="city" id="city" value="<?php echo $profile->city;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="pincode" class="control-label">Pincode:</label>
                        <div class="controls">
                            <input type="text" name="pincode" id="pincode" value="<?php echo $profile->pincode;  ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="address" class="control-label">Address:</label>
                        <div class="controls">
                            <textarea type="text" name="address" id="address"><?php echo $profile->address;  ?></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
    </div>

<!--              Change Password                  -->

    <div id="myModal" class="modal hide fade" style="display: none; ">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Change Password</h3>
        </div>
        <div class="modal-body">
        <form action="<?php echo URL::to_route('ChangePassword');  ?>" class="form-horizontal" method="post">
            <div class="control-group">
                <label for="current_password" class="control-label">Current Password</label>
                <div class="controls">
                    <input type="password" name="current_password" id="current_password"/>
                </div>
            </div>
            <div class="control-group">
                <label for="new_password" class="control-label">New Password</label>
                <div class="controls">
                    <input type="password" name="new_password" id="new_password"/>
                </div>
            </div>
            <div class="control-group">
                <label for="confirm_password" class="control-label">Confirm Password</label>
                <div class="controls">
                    <input type="password" name="confirm_password" id="confirm_password"/>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button class="btn btn-primary" type="submit">Change</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Add- Email -->
<div id="add-email" class="modal hide fade" style="display: none; ">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>Add Email</h3>
    </div>
    <div class="modal-body">
    <form class="form-horizontal" action="<?php echo URL::to_route('AddEmail') ?>" method="post" onsubmit="return emailValidate()">
        <div class="control-group">
            <label class="control-label" for="addEmail">
                Email(s)
            </label>
            <div class="controls">
                <input type="text" id="addEmail" placeholder="comma(,) seperate for more email" name='email' class="form-control" value="<?php echo $profile->email; ?>" >
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-info">Add</button>
            </div>
        </div>
    </form>
    </div>
</div>
<script type="text/javascript">
    $('#tumbnails').on('click',function(){
        $('#image').click();
    });
    
</script>

<?php Section::stop();  ?>
<?php echo Section::start('javascript-footer'); ?>
<script>
$(function(){
   $('#mobile').mask('9999999999?,9999999999') ;
   $('#pincode').mask('999999');
});
    var fl = document.getElementById('image');
    
    fl.onchange = function(){

        var ext = this.value.match(/\.(.+)$/)[1];
        switch(ext)
        {
             case 'jpg':
                $('#upload').submit();
                break;
            case 'JPG':
                $('#upload').submit();
                break;
            case 'jpeg':
                $('#upload').submit();
                break;
            case 'JPEG':
                $('#upload').submit();
                break;
            case 'png':
                $('#upload').submit();
                break;
            case 'PNG':
                $('#upload').submit();
                break;

            default:
                alert('Upload only .jpg, .png file');
                this.value='';
        }
    };
     function emailValidate()
    {
        var email=$('#addEmail').val();
        var emails=email.split(',');
        var count=emails.length;
        var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
        
        for(var i=0;i<count;i++)
        {
            var b=emailfilter.test(emails[i]);
            if( b == false)
            {
                alert('Enter valid Email address');
                return false;
            }

        }
    }
    </script>
    <?php Section::stop();  ?>
<?php echo render('admin::associate/template.main');  ?>
