<?php echo Section::start('contentWrapper'); ?>
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
<?php //$group=libcontact::getcontactdetailByID(Auth::user()->id);
//print_r($group);exit;
// if($group!=null)
// {
//    $group_name=array();
//    $city_name=array();
//    foreach($group as $values)
//    {
//
//        $d=json_decode($values->contact_details);
//        print_r($d);exit;
//        foreach ($values as $val)
//        {
//print_r($val);exit;
//            array_push($group_name,$values->group);
//             array_push($city_name,$values->city);
//        }
//    }
//    $group_name2=array_filter($group_name);//filters empty values
//    $group_name1=array_unique($group_name2);//takes unique array values
//    $groupName=json_encode(array_values($group_name1));//prints json values
//    $city_name2=array_filter($city_name);
//    $city_name1=array_unique($city_name2);
//    $cityName=json_encode(array_values($city_name1));
// }
?>
                            <div id="contact-tab" class="tab-pane in active">

                                <form action="<?php echo URL::to_route('AddContacts');  ?>" class="form-horizontal" method="post">
                                    <input type="hidden" name="lawyer_id" value="<?php echo Auth::user()->id; ?>"/>
                                    <div class="control-group">
                                        <label for="first_name" class="control-label">First Name</label>
                                        <div class="controls">
                                            <input type="text" name="first_name" id="first_name"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="last_name" class="control-label">Last Name</label>
                                        <div class="controls">
                                            <input type="text" name="last_name" id="last_name"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="mobile" class="control-label">Mobile:</label>
                                        <div class="controls">
                                            <input type="text" name="mobile" id="mobile"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="phone" class="control-label">Phone:</label>
                                        <div class="controls">
                                            <input type="text" name="phone" id="phone"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                            <label for="email" class="control-label">Email-ID:</label>
                                            <div class="controls">
                                                <input type="text" name="email" id="email"/>
                                            </div>
                                    </div>

                                    <div class="control-group">
                                        <label for="group" class="control-label">Group:</label>
                                        <div class="controls">
                                            <input type="text" name="group" id="group"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="city" class="control-label">City:</label>
                                        <div class="controls">
                                            <input type="text" name="city" id="city"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="address" class="control-label">Address</label>
                                        <div class="controls">
                                            <textarea name="address" id="address"  rows="2"></textarea>
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