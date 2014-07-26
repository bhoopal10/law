<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Welcome-Lawyerzz</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php echo Asset::container('header')->styles(); ?>
  <?php echo Asset::container('header')->scripts(); ?>

<script type="text/javascript">
jQuery(document).ready(function () {
    if (navigator.appVersion.search(/MSIE (6|5|4)/gi) == -1) {
        jQuery('#parallax').jparallax({
            xparallax: true,
            yparallax: false
        }, {
            width: 1600,
            height: 1200
        }, {
            width: 1800,
            height: 1400
        }, {
            width: 2000,
            height: 1800
        });
    }
});
</script>
<script type="text/javascript">
$(document).ready(function () {
    var s = jQuery.noConflict();
    s('#slider_area').coinslider({
        width: 636,
        height: 271,
        navigation: false,
        delay: 5000,
        titleSpeed: 4000,
        navigation: true
    });

});
</script>

</head>
<body>
<div id="parallax">
  <div id="layer1"></div>
  <div id="layer2"></div>
  <div id="layer3"></div>
</div>
<div id="header"> <?php echo HTML::image('css/newtheme/img/logo.png'); ?>
  <div class="navigation_area">
    <ul>
      <li><a href="#"><?php echo HTML::image('css/newtheme/img/home_img.png'); ?></a></li>
      <li><a href="#"><?php echo HTML::image('css/newtheme/img/about_img.png'); ?></a></li>
      <li><a href="#"><?php echo HTML::image('css/newtheme/img/services_img.png'); ?></a></li>
      <li><a href="#"><?php echo HTML::image('css/newtheme/img/client_img.png'); ?></a></li>
    </ul>
  </div>
  <div class="banner">
    <div class="slide lefts">
      <div class="img_news_slider"></div>
      <div id="slider_area"> <a href="#"> <img src="img/img_slide.png" /> <span> Description for picture </span> </a> <a href="#"> <img src="img/img_slide2.png" /> <span> Description for picture </span> </a> <a href="#"> <img src="img/img_slide3.png" /> <span> Description for picture </span> </a> </div>
    </div>
    <div class="rights" id="">
   
      <form action="#" class="">
        <input type="hidden" name="user_id" value="<?php echo Crypter::encrypt('1'); ?>" />
                    <div class="">
                        <label class="col-sm-5 " for="first_name">First Name: <span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" id="first_name" class="" name="first_name" placeholder="First Name"/>
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="last_name">Last Name:</label>
                        <div class="col-sm-7">
                            <input type="text" id="last_name" class="" name="last_name" placeholder="Last Name"/>
                        </div>
                    </div>

                    
                            <input type="hidden" id="lawyer_subject" class="" name="lawyer_subject" placeholder="Lawyer Subject" />
                       

                    <div class="">
                        <label class="col-sm-5 " for="mobile">Mobile:<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" id="mobile" class="" name="mobile" placeholder="Mobile" />
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="mobile">Phone:</label>
                        <div class="col-sm-7">
                            <input type="text" id="phone" class="" name="phone" placeholder="Phone" />
                        </div>
                    </div>
                    <div class="">
                        <label class="error col-sm-5 " for="username">Username<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" id="username" name="username" placeholder="UserName"  class=""/>
                        </div>
                    </div>
                    <div class="">
                        <label class="error col-sm-5  " for="user_email">Email-Id:<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="text" id="user_email" class="" name="user_email" placeholder="Email ID" />
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="address">Address:</label>
                        <div class="col-sm-7">
                            <input type="text" id="address" class="" name="address" placeholder="Address"/>
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="city">City:</label>
                        <div class="col-sm-7">
                            <input type="text" id="city" class="" name="city" placeholder="City"/>
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="user_password">Password:<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="password" id="password" class="" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="">
                        <label class="col-sm-5 " for="confirm_password">Confirm Password:<span style="color: red">*</span></label>
                        <div class="col-sm-7">
                            <input type="password" id="confirm_password" class="" name="confirm_password" placeholder="Confirm Password"/>
                        </div>
                    </div>
        <div class="clear"></div>
        <div class="col-sm-12">
          <span>Already registered? <a href="<?php echo URL::to('/test') ?>">Login</a></span>
        </div>
       <div><button class="btn btn-primary">Register</button></div>
      </form>
    </div>
    
  </div>
</div>

<div id="content">
  <div class="box_right">
    <div class="box_right_top"></div>
    <div class="box_right_middle">
      <div class="contain_news lefts">
        <h2>good business ideas</h2>
        <span>Phasellus bibendum magna non enim porta. </span>
        <p>Aenean tincidunt commodo orci, non varius ante tempor eu. Nunc viverra dapibus leo sed ullamcorper. Vestibulum pharetra magna vitae ante porta ac auctor risus venenatis. Donec non dolor sed nibh elementum tincidunt. Nullam lacinia pulvinar euismod. </p>
        <img alt="" src="img/line_img.png" class="line_separe"/>
        <input value="" type="button" class="read_more"/>
      </div>
      <img src="img/img_1.png" class="img_news rights" alt="" /> </div>
    <div class="box_right_bottom"></div>
    <div class="content_latest">
      <h2>About Our Company</h2>
      <img src="img/img_3.png" alt="" />
      <p>Cras nec posuere arcu.Sed gravida commodo lacus sed faucibus. Donec et nibh mauris. In lobortis massa quis nibh varius at euismod risus eleifend. aecenas id mi ante. Morbi adipiscing molestie convallis. Morbi est metus, porttitor quis fermentum laoreet, aliquam ut arcu. <a href="#">Read More»</a></p>
    </div>
    <div class="content_latest">
      <h2>Our Latest Work</h2>
      <img src="img/img_4.png" alt="" />
      <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eleifend est eu diam gravida aliquam. Cras nec posuere arcu. Sed gravida commodo lacus sed faucibus. Donec et nibh mauris. In lobortis massa quis nibh varius at euismod risus eleifend. <a href="#">Read More»</a></p>
    </div>
  </div>
  <div class="siderbar">
    <h2>Stay in touch</h2>
    <img alt="" src="img/contact2_img.png"/>
    <table>
      <tr>
        <td>Address: </td>
        <td>0000 Av. of Success - NY - USA</td>
      </tr>
      <tr>
        <td>Telephone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td >+000-0000-0000</td>
      </tr>
      <tr>
        <td>FAX:</td>
        <td>+000-0000-0000</td>
      </tr>
      <tr>
        <td>Others:</td>
        <td>+000-0000-0000 (ext. 00)</td>
      </tr>
      <tr>
        <td>E-mail:</td>
        <td>mail@company.com</td>
      </tr>
    </table>
    <br />
    <br />
    <h2>From the blog</h2>
    <img alt="" src="img/blog_img.png" />
    <p><small>00 Oct 2010 | 00 comments</small><br />
      <strong>Duis nec porttitor lorem</strong><br />
      Mauris et nisi urna nonfaucibus magna. Integer lacus ante then ullamcorper ut vulputate..</p>
    <p> <small>00 Oct 2010 | 00 comments</small><br />
      <strong>Aenean interdum</strong> Vestibulum ante ipsum primis in faucibus orci luctus ultrices ante posuere.</p>
    <p> <small>00 Oct 2010 | 00 comments</small><br />
      <strong>Integer vitae nisl</strong> Duis volutpat ligula laoreet orci lectus placerat Curabitur lectus malesuada pulvinar. </p>
  </div>
</div>
<div class="bottom_content">
  <div class="bottom_content_area">
    <div class="bottom_content_left lefts"> <span>This is Popular</span>
      <ul>
        <li><a href="#">Our Work | 00</a></li>
        <li><a href="#">About us (11)</a></li>
        <li><a href="#">Iconshock (33)</a></li>
        <li><a href="#">Templates (21)</a></li>
      </ul>
      <ul>
        <li><a href="#">Our Work | 00</a></li>
        <li><a href="#">About us (11)</a></li>
        <li><a href="#">Iconshock (33)</a></li>
        <li><a href="#">Templates (21)</a></li>
      </ul>
    </div>
    <div class="bottom_content_right lefts"> <span>A Brief History</span>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tristique varius tortor. Ut nec dui in nisi volutpat rutrum. Morbi ullamcorper orci nec augue. Duis consequat blandit lacus. Morbi eu orci eu arcu congue tincidunt. Donec vitae justo condimentum pede aliquet consequat. Mauris vel mi. Nunc pede tortor, vestibulum at, bibendum condimentum, ultricies sed, mi. Suspendisse potenti. Phasellus eget metus in diam ornare porta. Curabitur aliquet elit in metus. </p>
    </div>
  </div>
</div>
<div id="footer">
  <div class="footer_area">
    <div class="footer_navigation lefts margin">
      <ul>
        <li><a href="#">HOME</a></li>
        <li><a href="#">ABOUT US</a></li>
        <li><a href="#">SERVICES</a></li>
        <li><a href="#">CLIENTS</a></li>
        <li><a href="#">CONTACT</a></li>
      </ul>
      <small>Copyright &copy; <a href="#">Domain Name</a>, All rights reserved | Design by <a target="_blank" href="http://www.wordpressthemeshock.com/">ThemeShock</a></small> </div>
    <div class="footer_navigation lefts">
      <ul>
        <li><a href="#"><img alt="" src="img/delicious.png"/></a></li>
        <li><a href="#"><img alt="" src="img/facebook.png"/></a></li>
        <li><a href="#"><img alt="" src="img/linked_in.png"/></a></li>
        <li><a href="#"><img alt="" src="img/my_space.png"/></a></li>
        <li><a href="#"><img alt="" src="img/technoratic.png"/></a></li>
        <li><a href="#"><img alt="" src="img/rss.png"/></a></li>
      </ul>
    </div>
    <a href="#"><img alt="" src="img/logo_footer.png" /></a> </div>
</div>
<script type="text/javascript">

  
</script>
</body>
</html>
