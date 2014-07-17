<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1>
        <i class="icon icon-dashboard"></i>
            Dashboard
            <small>
                <i class="icon-double-angle-right"></i>
                overview &amp; statistics

            </small>
        </h1>
    </div>
</div>
<?php Section::stop();?>
<?php echo Section::start('contentWrapper'); ?>
<div class="row-fluid">
 <?php 
 $status=Session::get('status');
 if(isset($status)){ ?>
    <div class="alert alert-alert">
        <button type="button" class="close" data-dismiss="alert" style="border-radius: 4px;margin-bottom: 2px;">
            <i class="icon-remove"></i>
        </button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>
    <div class="span2"></div>
      <div class="span7">
        <?php $case_statics=libcase::casestatics();
        if($case_statics){

        $total=$case_statics->total_case;// total cases
        if($total!=0){
                    $pending=($case_statics->pending_case * 100)/$total;//percentage calculation
                    $processing=($case_statics->processing_case * 100)/$total;//percentage calculation
                    $completed=($case_statics->completed_case * 100)/$total;//percentage calculation
                    $pending_case=round($pending,2);// round to 2 digit float value of percentage
                    $processing_case=round($processing,2);// round to 2 digit float value of percentage
                    $completed_case=round($completed,2);// round to 2 digit float value of percentage

        ?>
        <div class="widget-box">
            <div class="widget-header widget-header-flat widget-header-small">
                <h5>
                    <i class="icon-signal"></i>
                    Case Updates
                </h5>


            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div id="piechart-placeholder"></div>

                    <div class="hr hr8 hr-double"></div>

                    <div class="clearfix">
                        <div class="grid3">
													<span class="grey">
														<i class="icon-group icon-2x blue"></i>
                                                        &nbsp;<a href="<?php echo URL::to_route('ViewClient'); ?>"><b>Clients</b></a>
													</span>
                            <h4 class="bigger pull-right"><?php echo $total;  ?></h4>
                        </div>

                        <div class="grid3">
													<span class="grey">
														<i class="icon-legal icon-2x purple"></i>
														&nbsp;<a href="<?php echo URL::to_route('ViewUser'); ?>"><b>Associate Lawyers</b></a>
													</span>
                            <h4 class="bigger pull-right"><?php echo liblawyer::countlawyerIDs();  ?></h4>
                        </div>

                        <div class="grid3">
													<span class="grey">
														<i class="icon-briefcase icon-2x red"></i>
														&nbsp;<a href="<?php echo URL::to_route('ViewCases') ?>"><b>Total Cases</b></a>
													</span>
                            <h4 class="bigger pull-right"><?php echo $total;  ?></h4>
                        </div>
                    </div>







                </div><!--/widget-main-->
            </div><!--/widget-body-->
        </div><!--/widget-box-->
        <?php } } ?>
    </div>


</div>
<?php Section::stop(); ?>
<?php echo Section::start('javascript-footer');   Asset::container('footer')->bundle('admin');
Asset::container('footer')->add('pai-chart','js/jquery.easy-pie-chart.min.js');
Asset::container('footer')->add('sparkline','js/jquery.sparkline.min.js');
Asset::container('footer')->add('flot-min','js/jquery.flot.min.js');
Asset::container('footer')->add('flot-pie','js/jquery.flot.pie.min.js');
Asset::container('footer')->add('flot-resize','js/jquery.flot.resize.min.js');
Asset::container('footer')->add('touch','js/jquery.ui.touch-punch.min.js');
Asset::container('footer')->add('slimscroll','js/jquery.slimscroll.min.js');

?>

<script type="text/javascript">
    $(function() {

        $('.dialogs,.comments').slimScroll({
            height: '300px'
        });

        $('#tasks').sortable();
        $('#tasks').disableSelection();
        $('#tasks input:checkbox').removeAttr('checked').on('click', function(){
            if(this.checked) $(this).closest('li').addClass('selected');
            else $(this).closest('li').removeClass('selected');
        });

        var oldie = $.browser.msie && $.browser.version < 9;
        $('.easy-pie-chart.percentage').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
            var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
            var size = parseInt($(this).data('size')) || 50;
            $(this).easyPieChart({
                barColor: barColor,
                trackColor: trackColor,
                scaleColor: false,
                lineCap: 'butt',
                lineWidth: parseInt(size/10),
                animate: oldie ? false : 1000,
                size: size
            });
        })

        $('.sparkline').each(function(){
            var $box = $(this).closest('.infobox');
            var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
            $(this).sparkline('html', {tagValuesAttribute:'data-values', type: 'bar', barColor: barColor , chartRangeMin:$(this).data('min') || 0} );
        });




        var data = [
            { label: '<a href="<?php echo URL::to_route('PendingCase').'/0'; ?>">Pending Case</a>',  data: <?php if(isset($pending_case)) echo $pending_case;  ?>, color: "#DA5430"},
            { label: '<a href="<?php echo URL::to_route('ProcessingCase').'/1'; ?>">Processing Case</a>',  data: <?php if(isset($processing_case)) echo $processing_case;  ?>, color: "#2091CF"},
            { label: '<a href="<?php echo URL::to_route('CompletedCase').'/2'; ?>">Completed Cases</a>',  data: <?php if(isset($completed_case)) echo $completed_case;  ?>, color: "#68BC31"}

        ];

        var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
        $.plot(placeholder, data, {

            series: {
                pie: {
                    show: true,
                    tilt:0.8,
                    highlight: {
                        opacity: 0.25
                    },
                    stroke: {
                        color: '#fff',
                        width: 2
                    },
                    startAngle: 2

                }
            },
            legend: {
                show: true,
                position: "ne",
                labelBoxBorderColor: null,
                margin:[-30,15]
            }
            ,
            grid: {
                hoverable: true,
                clickable: true
            },
            tooltip: true, //activate tooltip
            tooltipOpts: {
                content: "%s : %y.1",
                shifts: {
                    x: -30,
                    y: -50
                }
            }

        });


        var $tooltip = $("<div class='tooltip top in' style='display:none;'><div class='tooltip-inner'></div></div>").appendTo('body');
        placeholder.data('tooltip', $tooltip);
        var previousPoint = null;

        placeholder.on('plothover', function (event, pos, item) {
            if(item) {
                if (previousPoint != item.seriesIndex) {
                    previousPoint = item.seriesIndex;
                    var tip = item.series['percent']+'%';
                    $(this).data('tooltip').show().children(0).text(tip);
                }
                $(this).data('tooltip').css({top:pos.pageY + 10, left:pos.pageX + 10});
            } else {
                $(this).data('tooltip').hide();
                previousPoint = null;
            }

        });






        var d1 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d1.push([i, Math.sin(i)]);
        }

        var d2 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.5) {
            d2.push([i, Math.cos(i)]);
        }

        var d3 = [];
        for (var i = 0; i < Math.PI * 2; i += 0.2) {
            d3.push([i, Math.tan(i)]);
        }


        var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
        $.plot("#sales-charts", [
            {  label: "Domains", data: d1 },
            {  label: "Hosting", data: d2 },
            { label: "Services", data: d3 }
        ], {
            hoverable: true,
            shadowSize: 0,
            series: {
                lines: { show: true },
                points: { show: true }
            },
            xaxis: {
                tickLength: 0
            },
            yaxis: {
                ticks: 10,
                min: -2,
                max: 2,
                tickDecimals: 3
            },
            grid: {
                backgroundColor: { colors: [ "#fff", "#fff" ] },
                borderWidth: 1,
                borderColor:'#555'
            }
        });


        $('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('.tab-content')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }
    })
</script>
<?php Section::stop(); ?>


<?php echo render('admin::lawyer/template.main') ?>
