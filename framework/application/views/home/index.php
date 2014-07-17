<?php echo Section::start('contentWrapper');  ?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color: black">
    <div class="navbar-container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">Lawyerzz.in</a>

        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <?php if (Auth::check()){ ?>
                <a href="<?php echo URL::to('admin/logout') ?>">Logout</a>
                <?php }else{ ?>
                <a href="<?php echo URL::to('admin/') ?>">Login</a>
            </li>
            <li><a data-toggle="modal"  href="#signup">SignUp</a></li>
                <?php } ?>

        </ul>
        <div id="nav-collapse" class="collapse navbar-collapse navbar-ex1-collapse">

            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a title="Home page" class="scroll brand-1" href="#home">Home</a></li>
                <li class=""><a title="Home page"  href="<?php echo URL::to('admin/') ?>">Dashboard</a></li>
                <li class=""><a title="Check out our awesome services" href="#features" class=" scroll brand-4">Features</a></li>
                <li class=""><a title="Who we are" href="#about" class="scroll fadeto brand-1"> About us</a></li>
                <li class=""><a title="Get in touch!" href="#contact" class="scroll brand-4">Contact</a></li>
                <li><a title="Try It Free" data-toggle="modal" class="scroll brand-5 btn btn-danger" href="#trailuser">Try It Free</a></li>

            </ul>

        </div>
    </div><!-- /.navbar-container -->
</nav>

<!-- Home Page -->
<div id="home" class="page color-1">
    <?php $status=Session::get('status');$error=Session::get('error'); if($status){  ?>
        <div class=" alert alert-info">
            <button type="button" class="close" data-dismiss="alert"><i class="glyphicon-chevron-left"></i></button>
            <span><?php echo $status;  ?></span>
        </div>
    <?php } if($error){ ?>
        <div class=" alert alert-danger">
            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
            <span><?php echo $error;  ?></span>
        </div>
    <?php }  ?>
    <div class="inner-page">
        <h2 class="page-headline large">Stay organized. Get more done every day.</h2>
    </div>
    <div class="row inner-page">
        <div class="col-md-8 col-md-push-4">
            <img style="display: block;" class="figurette lazy" src="<?php echo Config::get('application.url').'img/images/dashboard.png'; ?>" data-original="" alt="image">
        </div>
        <div class="col-md-4 col-md-pull-8" style="padding-top: 80px">
           <span style="font-size: 24px; color: #000000">
             Web-based legal practice management software built for the modern law firm.

           </span>
            <br>
        </div>
    </div>
</div> <!-- /#home -->

<!-- Feature page-->
<div id="features" class="page color-4">
    <div class="inner-page">
        <h2 class="page-headline">Why Do Law Firms Love <b>Lawyerzz.in</b>?</h2>
    </div>

    <div class="inner-page row">
       <div class="col-mod-12">
           <h4 style="font-weight: bold">1. Organize Your Law Firm – Spend Less Time Pushing Paper And More Time Practicing Law . </h4>
           </div>
           <div class="col-md-6">
               <ul class="list-wide">
                   <li><i class="glyphicon glyphicon-ok"></i> Easy Legal Document Management and Assembly</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Contact Management</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Organize Cases and Matters</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Appointments and Fixes</li>
               </ul>
           </div>
           <div class="col-md-6">
               <ul class="list-wide">
                   <li><i class="glyphicon glyphicon-ok"></i> Create Professional Invoices</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Schedule Payment Plans</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Simple Time and Legal Billing Features</li>
                   <li><i class="glyphicon glyphicon-ok"></i> Accept Online Payments</li>
               </ul>
           </div>

        <div class="col-mod-12">
            <h4 style="font-weight: bold">2. Keep Your Clients Happy. </h4>
            <p style="padding-left: 25px">Provide 24/7 access to case files and communication and give your clients the attention they want and deserve, without putting extra strain on your staff.</p>
        </div>
            <div class="col-md-6">
                <ul class="list-wide">
                    <li><i class="glyphicon glyphicon-ok"></i> Simple and intuitive client portal lets you share selected information.  </li>
                    <li><i class="glyphicon glyphicon-ok"></i> Post comments and send messages to your clients (and staff). </li>

                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-wide">
                    <li><i class="glyphicon glyphicon-ok"></i> Facebook style notifications and alerts of case developments.  </li>
                    <li><i class="glyphicon glyphicon-ok"></i> Clients can easily view and pay their invoices online.  </li>
                    <li></li>
                    <li></li>
                    <li></li>

                </ul>
            </div>
        <div class="col-mod-12">
            <h4>&nbsp;</h4>
         </div>
        <div class="col-mod-12">
        <h4 style="font-weight: bold">3. Increased Mobility – Work From Anywhere</h4>
        <p style="padding-left: 25px">One of the greatest benefits of legal practice management
            software in the cloud is the flexibility you have to access your case and client information. Securely login from any computer or use the Lawyerzz iPhone App to take advantage of the time you spend commuting, waiting in court, or traveling. Get more done every single day.</p>
         </div>
    </div>

</div> <!-- /#features -->


<!-- About page -->
<div id="about" class="page color-4">
    <div class="inner-page">
        <h2 class="page-headline">Who are we and how it all got started. Our story.</h2>
    </div>
    <div class="row inner-page">
      <div class="col-md-12">
          <h4 style="font-weight: bold">Lawyerzz, web-based practice management software for lawyers, was built to address the number one complaint across all State Bar Associations... insufficient attorney/client communication.</h4>
          <p >Successful legal professionals all over the world rely on Lawyerzz every day to stay incredibly organized, easily communicate and collaborate with their clients while simultaneously managing and growing their practice.  Because Lawyerzz offers legal practice management in the cloud, lawyers can work from anywhere at anytime significantly increasing productivity.  </p>
          <p>Lawyerzz was founded in 2010 by attorney Matt Spiegel, Alex Dikowski, and Chris Schulte.  In October 2012 Lawyerzz was acquired by AppFolio,  the leading provider of web-based software for vertical markets. AppFolio's cloud based software is used by thousands of small and mid-sized businesses to improve their workflow so they save time and make more money. The Lawyerzz founding team remains in place and runs the day to day operations of Lawyerzz.</p>
      </div>
    </div>

    <hr>


</div> <!-- /#about -->

<!-- Contact page -->
<div id="contact" class="page color-2">
    <div class="inner-page">
        <h2 class="page-headline">Get in touch and stay updated</h2>
    </div>
    <div class="row inner-page contact">
        <div class="col-md-6">
            <h3>What's on your mind?</h3>
            <?php $contact_sent = Session::get( 'contact_sent' );
                $contact_fail = Session::get('contact_fail');?>
            <?php if (isset($contact_sent))
            { ?>
                <small>
                    <p class="bg-success" style="background-color: darkgreen"><?php echo $contact_sent; ?></p>
                </small>
            <?php }elseif(isset($contact_fail)){?>

                <small>
                    <p class="bg-danger" style="background-color: darkorange"><?php echo $contact_fail; ?></p>
                </small>
            <?php }?>
            <form name="contact" id="contact-form" action="<?php echo URL::to_route( 'contactUs' ); ?>" method="post" onsubmit="return contactValidation();">
                <textarea rows="6" class="form-control" placeholder="Your Thoughts " name="content"></textarea>
                <input class="form-control" placeholder="your@e-mail.com" type="text" name="email">
                <input class="form-control" placeholder="Name" type="text" name="uname">
                <button class="btn btn-primary btn-centered">Contact us</button>
            </form>
        </div>
        <div class="col-md-6">
            <h4>Location</h4>
            <div class="btn-container centered lazy-container text-center loaded">
                <img style="display: block;" src="<?php echo Config::get('application.url').'img/images/map.png'; ?>" class="lazy figurette" alt="Open the map" data-original="<?php echo Config::get('application.url').'img/images/map.png'; ?>">
                <a class="lightbox iframe  btn-map" target="blank" title="Open google maps" href="https://maps.google.co.in/maps?q=SIRI+Groups,+Indira+Nagar+II+Stage,+Indira+Nagar,+Bangalore,+Karnataka&hl=en&ll=12.979551,77.637141&spn=0.006304,0.010568&sll=12.9701,77.640896&sspn=0.025218,0.058622&oq=indra+nagar,siri&hq=SIRI+Groups,&hnear=Indira+Nagar+II+Stage,+Stage+2,+Hoysala+Nagar,+Indira+Nagar,+Bangalore,+Bangalore+Urban,+Karnataka&t=m&z=17"><i class="fa fa-map-marker"></i><div>Sri Groups,<br>Bangalore,<br> Karnataka</div></a>
            </div>
        </div>
    </div>
</div> <!-- /#contact -->


<!-- The footer, social media icons, and copyright -->
<footer class="page color-5">
    <div class="inner-page row">
        <div class="col-md-6 social">
            <a href="#home">home|</a>
            <a href="#features"> features|</a>
            <a href="#assets"> assets|</a>
            <a href="#about"> about</a>
        </div>
        <div class="col-md-6 text-right copyright">
            © 2014 <a href="http://www.sirigroups.com/" title="">Sirigroups.com</a> | all rights reserved | <a href="#top" title="Got to top" class="scroll">To top <i class="fa fa-caret-up"></i></a>
        </div>
    </div>
</footer>
<div id="trailuser" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">15 Days free trial</h3>
            </div>
            <div class="modal-body">
                <form name="form2" onsubmit="return validation2();" class="form-horizontal" action="<?php echo URL::to_route('AddTrailUser');  ?>" method="post">
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="first_name">First Name: <span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="last_name">Last Name:</label>
                        <div class="col-lg-7">
                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="lawyer_id">Lawyer ID:</label>
                        <div class="col-lg-7">
                            <input type="text" id="lawyer_id" class="form-control" name="lawyer_id" placeholder="Lawyer ID"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="lawyer_id">Lawyer Subject:</label>
                        <div class="col-lg-7">
                            <input type="text" id="lawyer_subject" class="form-control" name="lawyer_subject" placeholder="Lawyer Subject" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="mobile" class="form-control" name="mobile" placeholder="Mobile" />
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="error col-lg-4 control-label" for="username">Username<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="username" name="username" placeholder="UserName"  class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="error col-lg-4 control-label " for="user_email">Email-Id:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="user_email" class="form-control" name="user_email" placeholder="Email ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="user_password">Password:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="confirm_password">Confirm Password:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password"/>
                        </div>
                    </div>


            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" type="submit">Register</button>
            </div>
            </form>
                </div>
        </div>
    </div>
</div>
<div id="signup" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4>New User Register</h4>
            </div>
            <div class="modal-body">
                <form name="form1" onsubmit="return validation();" class="form-horizontal" action="<?php echo URL::to_route('AddUser');  ?>" method="post">
                    <input type="hidden" name="user_id" value="<?php echo Crypter::encrypt('1'); ?>" />
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="first_name">First Name: <span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="last_name">Last Name:</label>
                        <div class="col-lg-7">
                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="lawyer_id">Lawyer Subject:</label>
                        <div class="col-lg-7">
                            <input type="text" id="lawyer_subject" class="form-control" name="lawyer_subject" placeholder="Lawyer Subject" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="mobile">Mobile:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="mobile" class="form-control" name="mobile" placeholder="Mobile" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="mobile">Phone:</label>
                        <div class="col-lg-7">
                            <input type="text" id="phone" class="form-control" name="phone" placeholder="Phone" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="error col-lg-4 control-label" for="username">Username<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="username" name="username" placeholder="UserName"  class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="error col-lg-4 control-label " for="user_email">Email-Id:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="text" id="user_email" class="form-control" name="user_email" placeholder="Email ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="address">Address:</label>
                        <div class="col-lg-7">
                            <input type="text" id="address" class="form-control" name="address" placeholder="Address"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="city">City:</label>
                        <div class="col-lg-7">
                            <input type="text" id="city" class="form-control" name="city" placeholder="City"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="user_password">Password:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="confirm_password">Confirm Password:<span style="color: red">*</span></label>
                        <div class="col-lg-7">
                            <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password"/>
                        </div>
                    </div>


            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary" type="submit">Sign Up</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    if (typeof jQuery == 'undefined') {
        document.write(unescape("%3Cscript src='js/jquery-1.9.1.min.js' type='text/javascript'%3E%3C/script%3E"));
 }

</script>

<script type="text/javascript">
    function contactValidation()
    {
        var email=document.contact.email.value;
        var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
        var b=emailfilter.test(email);
        if(!email)
        {
            alert("Please Enter email address");
            document.contact.email.focus();
            return false;
        }
        if(b==false)
        {
            alert("Please Enter a valid Mail ID");
            document.contact.email.focus();
            return false;
        }


    }
    function validation()
    {

        var first_name=document.form1.first_name.value;

        var mobile=document.form1.mobile.value;
        var email=document.form1.user_email.value;
        var username=document.form1.username.value;
        var password=document.form1.password.value;
        var confirm_password=document.form1.confirm_password.value;
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
        if(isNaN(mobile))
        {
            alert("Enter the valid Mobile Number(Like : 9566137117)");
            document.form1.mobile.focus();
            return false;
        }
        if(mobile.length != 10)
        {
            alert(" Enter a valid mobile no");
            document.form1.mobile.select();
            return false;
        }
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


        if(!password)
        {
            alert("please enter Password");
            document.form1.password.focus();
            return false;
        }
        if(!confirm_password)
        {
            alert("please enter confirm Password");
            document.form1.confirm_password.focus();
            return false;
        }
        if(password != confirm_password)
        {
            alert("Password missmatch");
            document.form1.confirm_password.focus();
            return false;
        }
    }
    function validation2()
    {

        var first_name=document.form2.first_name.value;
        var username=document.form2.username.value;
        var mobile=document.form2.mobile.value;
        var email=document.form2.user_email.value;

        var password=document.form2.password.value;
        var confirm_password=document.form2.confirm_password.value;
        var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
        var b=emailfilter.test(email);

        if(!first_name)
        {
            alert('Please enter first name');
            document.form2.first_name.focus();
            return false;
        }

        if(!mobile)
        {
            alert('Please enter Mobile number');
            document.form2.mobile.focus();
            return false;
        }
        if(isNaN(mobile))
        {
            alert("Enter the valid Mobile Number(Like : 9566137117)");
            document.form2.mobile.focus();
            return false;
        }
        if(mobile.length != 10)
        {
            alert(" Your Mobile Number must be 1 to 10 Integers");
            document.form2.mobile.select();
            return false;
        }
        if(!username)
        {
            alert("Please enter UserName");
            document.form2.username.focus();
            return false;
        }
        if(username.length <= 4)
        {
            alert("UserName must be  greaterthan 4 charcaters");
            document.form2.username.focus();
            return false;
        }
        if(!email)
        {
            alert('please enter email ID');
            document.form2.user_email.focus();
            return false;
        }
        if(b==false)
        {
            alert("Please Enter a valid Mail ID");
            document.form2.user_email.focus();
            return false;
        }


        if(!password)
        {
            alert("please enter Password");
            document.form2.password.focus();
            return false;
        }
        if(!confirm_password)
        {
            alert("please enter confirm Password");
            document.form2.confirm_password.focus();
            return false;
        }
        if(password != confirm_password)
        {
            alert("Password missmatch");
            document.form2.confirm_password.focus();
            return false;
        }
    }
</script>
<?php Section::stop();  ?>
<?php echo render('template.main'); ?>