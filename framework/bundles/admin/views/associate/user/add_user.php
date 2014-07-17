
<?php echo Section::start('page-header');?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
               Lawyer
                <small>
                    <i class="icon-double-angle-right"></i>
                   Add Lawyer
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
        <div>
            <div class="row-fluid">
                <form class="form-horizontal" action="<?php echo URL::to_route('AddUser'); ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo Crypter::encrypt(Auth::user()->id);  ?>" />
                    <div class="control-group">
                        <label class="control-label" for="first_name">First Name:</label>
                        <div class="controls">
                            <input type="text" id="first_name" name="first_name" placeholder="First Name"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="last_name">Last Name:</label>
                        <div class="controls">
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lawyer_id">Lawyer ID:</label>
                        <div class="controls">
                            <input type="text" id="lawyer_id" name="lawyer_id" placeholder=""/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lawyer_id">Lawyer Subject:</label>
                        <div class="controls">
                            <input type="text" id="lawyer_subject" name="lawyer_subject" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="mobile">Mobile:</label>
                        <div class="controls">
                            <input type="text" id="mobile" name="mobile" placeholder="" />
                        </div>

                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_email">Email-Id:</label>
                        <div class="controls">
                            <input type="text" id="user_email" name="user_email" placeholder="Email ID" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_password">Password:</label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="Password"/>
                        </div>
                        <br>
                        <div class="controls">
                                <button class="btn btn-primary" type="submit" >Add User</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    <script type="text/javascript">
        <?php $sub=liblawyer::getlawyer();  ?>
        var s= <?php $subject=array(); foreach($sub as $sub1){ array_push($subject,$sub1->lawyer_subject); } echo json_encode($subject); ?>;
        $('#lawyer_subject').autocomplete({
          source:s,
            minLength:1

       });
    </script>
    <?php Section::stop() ?>
<?php echo render('admin::template.main'); ?>