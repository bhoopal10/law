<?php echo Section::start('contentWrapper');  ?>
   <?php
    $data=$data;
    $lawyer=$data['lawyer'];
    $client=$data['client'];
    $date=implode( '/', array_reverse( explode( '-', $data['date'] ) ));
    $case=$data['case'];
    $mobiles=implode(',91',$data['mobile']);
    $username = urlencode("sirigroup");
    $password = urlencode("India123");
    $sender=urlencode("NETSMS");
    $message="CaseNO: $case
    Lawyer: $lawyer
    Client: $client
    HearingDate: $date
    ";

    $message=urlencode($message);
    $mobile=urlencode('91'.$mobiles);
    $data = "username=".$username."&password=".$password."&sendername=".$sender."&mobileno=".$mobile."&message=".$message;

?>
    <script>
        $(document).ready(function(){
            $.get('http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?<?php echo $data;  ?>').
                success(function(data,status){

            })
                .error(function(event){

                })
        });
    </script>
<?php Section::stop(); ?>

<?php echo render('template.main'); ?>