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
            <h1>
                Contact
                <small>
                    <i class="icon-double-angle-right"></i>
                    Add Contacts
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
?>
    <div id="contact-tab" class="tab-pane in active">

        <form action="<?php echo URL::to_route('UpdateContact');  ?>" class="form-horizontal" method="post">
            <input type="hidden" name="lawyer_id" value="<?php echo Auth::user()->id; ?>"/>
            <input type="hidden" name="key" value="<?php echo $id; ?>"/>
            <div class="control-group">
                <label for="first_name" class="control-label">First Name</label>
                <div class="controls">
                    <input type="text" name="first_name" id="first_name" value="<?php echo $contact[$id]->first_name;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="last_name" class="control-label">Last Name</label>
                <div class="controls">
                    <input type="text" name="last_name" id="last_name" value="<?php echo $contact[$id]->last_name;  ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label for="mobile" class="control-label">Mobile:</label>
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
                <label for="email" class="control-label">Email-ID:</label>
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


<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>