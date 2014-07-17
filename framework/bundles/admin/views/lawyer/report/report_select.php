<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/28/14
 * Time: 12:58 PM
 */ ?>
<?php echo Section::start('page-header');?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-file-alt"></i>
            Report
            <small>
                <i class="icon-double-angle-right"></i>
                Select Report
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php Section::stop(); ?>
<?php echo Section::start('contentWrapper'); ?>

<div class="row-fluid">
    <span>
<form action="<?php echo URL::to_route('ReportClient'); ?>" method="get" class="form-horizontal">
    <div class="control-group">
        <label for="client" class="control-label">By Client vise</label>
        <div class="controls">
    <select class="select span3"  onchange="this.form.submit();" name="id" id="client">
        <option value="0">Select Client</option>
        <?php if (isset($client)) { foreach ($client as $clients) { ?>
            <option value="<?php echo $clients->client_id ?>"><?php echo $clients->client_name; ?></option>
        <?php }} ?>
    </select>
            </div>
        </div>
</form>
    <form action="<?php echo URL::to_route('ReportCase'); ?>" method="get" class="form-horizontal">
        <div class="control-group">
            <label for="client" class="control-label">By Case vise</label>
            <div class="controls">
    <select class="select span3" onchange=" this.form.submit();" name="id">
        <option value="0">Select Case</option>
        <?php if ($case!=0) {  foreach ($case as $cases) { ?>
            <option value="<?php echo $cases->case_id ?>"><?php echo $cases->case_no; ?></option>
        <?php }} ?>
    </select>
         </div>
   </div>
</form>
</span>

</div>
<script>
    $(function(){
       $('span').tooltip({placement:'bottom'});
    });
    $(document).ready(function(){
        $('.select').select2();
    });
    function getitems()
    {
        var array = new Array();
        $( ".dropdown-menu li a.hc" ).each(function( index ) {
            array.push( $(this).text() );
        });
        return array;


    }

    $('.dropdown-menu input').click(function(){return false;}); //prevent menu hide

    $('.typeahead').typeahead(
        {
            source: getitems,
            //update: function(item){return item}
            updater: function(item){
                if($('a.hc').filter(function(index) { return $(this).text() === item; }))
                {
                    alert('redirect to: ' + $('a.hc').filter(function(index) { return $(this).text() === item; }).attr('href'));
                    window.location = $('a.hc').filter(function(index) { return $(this).text() === item; }).attr('href');
                }
                return item;}
        }
    );

</script>
<style type="text/css">
    label{
        color:#F2A03D;
    }
</style>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>