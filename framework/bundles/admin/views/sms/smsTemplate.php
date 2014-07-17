<script src="<?php echo Asset::container( 'header' )->add( 'jquery-9', 'js/jquery-1.9.1.js' ); ?>">

</script>
<?php
    $username = urlencode("sirigroup");
    $password = urlencode("India123");
    $sender=urlencode("NETSMS");
    $number=urlencode("9742623867");
    $message=urlencode("hello haaaaa");
    $mobile=urlencode("91$number");
    $data = "username=".$username."&password=".$password."&sendername=".$sender."&mobileno=".$mobile."&message=".$message;
?>
<script>
    $(document).ready(function(){
        $.get('http://bulksms.mysmsmantra.com:8080/WebSMS/SMSAPI.jsp?<?php echo $data;  ?>').
            success(function(data,status){
                alert(data);
            })
    });
</script>