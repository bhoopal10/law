<!DOCTYPE html>
<html>
<head>
</head>
<body style="background-color: #E4E4E4;padding: 20px; margin: 0; min-width: 640px;">
<table border="1" cellspacing="0" width="530" style="color:#262626;background-color:#fff;
		padding:27px 30px 20px 30px;margin:auto; border:1px solid #e1e1e1;">
    <tbody>
    <!-- header -->
    <tr style="background:#9bcaff">
        <td style="padding-left:20px">
            <a target="_blank" style="text-decoration:none;color:inherit;font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:normal;">
                <h1 style="color:#fff">Lawyerzz Appointment</h1>
            </a>
        </td>
    </tr>
    </tbody>
<tr>
    <td>
                
        <span style="float: left;font-weight: bold;width:30%">Appointment Date</span>
        <span style="text-align: center;font-weight: bold">
        <?php echo ':'.$data['from_date'][0].' '.$data['from_date'][1].' TO '.$data['to_date'][0].' '.$data['to_date'][1];  ?>
        </span>
        <br>
        <span style="float: left;font-weight: bold;width:30%">Event Name</span>
        <span style="text-align: center;font-weight: bold">
        <?php echo ':'.$data['event_name'];  ?>
        </span>
        <br>
        <span style="float: left;font-weight: bold;width:30%">Case No</span>
        
        <span style="text-align: center;font-weight: bold">
            <?php $case=libcase::getcasedetailByID($data['case_link']); echo ($case)?':'.$case->case_no:':' ?>
        </span>
        <br>
        <span style="float: left;font-weight: bold;width:30%">Contact person</span>
        <span style="text-align: center;font-weight: bold">
        <?php echo ':'.$data['contact_person']; ?>
        </span>
        <br>
        <span style="float: left;font-weight: bold;width:30%">Location</span>
        <span style="text-align: center;font-weight: bold">
        <?php echo ':'.$data['location']; ?>
        </span>

    </td>

    </tr>
    <tbody>
    <tr style="background:#9bcaff">
        <td align="right" style="padding:25px 0  0 0;">
            <table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:9px;" align="right">
                <tbody>
                <tr style="border-bottom:1px solid #499799;background:#9bcaff">
                    <td>visit: <a href="www.lawyerzz.in">lawyerzz.in</a></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
    </table>
</body>
</html>
