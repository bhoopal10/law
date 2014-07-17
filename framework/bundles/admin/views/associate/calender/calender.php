<?php echo Section::start('contentWrapper'); ?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1>
                Full Calendar
                <small>
                    <i class="icon-double-angle-right"></i>
                    with editable events
                </small>
            </h1>
        </div><!--/.page-header-->

        <div class="row-fluid">
            <!--PAGE CONTENT BEGINS HERE-->

            <div class="row-fluid">
                <div class="span10">
<!--                 <div id="calendar">-->
<!--                 </div>-->
                    <?php $date=getdate();
                    print_r($date);
                    ?>
                    <table style="width: 100%" class="table table-bordered">
                        <thead>
                        <tr><th colspan="7" style="text-align: center"><b><?php echo $date['month']."   ".$date['year']; ?></b><a href="#" style="float: left"><i class="icon-arrow-left"></i></a><a href="#" style="float: right"><i class="icon-arrow-right"></i></a></th></tr>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $current=mktime(0,0,0,$date['mon'],1,$date['year']);
                        $days=1;
                        while($days <= date('t',$current)){
                        ?>
                        <tr>
                            <?php for($i=0;$i<=6;$i++){
                                $now=mktime(0,0,0,$date['mon'],$days,$date['year']);
                                $day=date('D',$now);
                              switch($day){case 'Sun': $begin=0;break;case 'Mon': $begin=1; break;case 'Tue':$begin=2; break;case 'Wed':$begin=3; break; case 'Thu':$begin=4;break; case 'Fri': $begin=5; break; case 'Sat': $begin=6;break;}
                                ?>

                            <td style="width: 30px;height: 100px;font-size: 20px;<?php  if($date['mday']==$days){ echo "background-color: darkolivegreen;color:white;";}if($days>date('t',$now) ||($i!=$begin) ){echo "background-color: #d3d3d3";} ?>"><?php if($i==$begin){if($days <= date('t',$now)){echo $days; $days++;} }?></td>
                            <?php }?>
                        </tr>
                            <?php }?>
                        </tbody>

                    </table>
                    <div class="span2">

                    </div>

    </div><!--/#page-content-->

</div><!--/#main-content-->
</div><!--/.fluid-container#main-container-->
<script>
    $(document).ready(function() {

        // page is now ready, initialize the calendar...

        $('#calendar').fullCalendar({

            dayClick:function(){ alert("ur clicked");}
        })

    });
</script>
<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>