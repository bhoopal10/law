<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Asst Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Asst Lawyer
                </small>
            </h1>
        </div>
    </div>
<?php Section::stop();?>

<?php echo Section::start("contentWrapper"); ?>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert-success">
        <span><?php echo $status; ?></span>
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
                <form class="form-horizontal" action="<?php echo URL::to_route('AddUser'); ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php if(isset($user)){ echo $user->user_id;} ?>" />
                    <div class="control-group">
                        <label class="control-label" for="first_name">First Name:</label>
                        <div class="controls">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?php if(isset($user)){ echo $user->user_fname;} ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="last_name">Last Name:</label>
                        <div class="controls">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(isset($user)){ echo $user->user_lname;} ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lawyer_id">Lawyer ID:</label>
                        <div class="controls">
                            <input type="text" id="lawyer_id" name="lawyer_id" placeholder="" value=""/>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="mobile">Mobile:</label>
                        <div class="controls">
                            <input type="text" id="mobile" name="mobile" placeholder="" value=""/>
                        </div>

                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_email">Email-Id:</label>
                        <div class="controls">
                            <input type="text" id="user_email" name="user_email" placeholder="Email ID" value="<?php if(isset($user)){ echo $user->user_email;} ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_password">Password:</label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="Password"/>
                        </div>


                        <br>
                        <div class="controls">
                            <?php if(isset($user)){?>
                                <button class="btn btn-primary" type="submit" > Update User</button>
                            <?php }else{ ?>
                                <button class="btn btn-primary" type="submit" > Add Lawyer
                                </button>
                            <?php }?>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>


<?php Section::stop() ?>
<?php echo render('admin::template.main'); ?>