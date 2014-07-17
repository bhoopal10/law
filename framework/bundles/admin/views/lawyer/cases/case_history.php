<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon icon-briefcase"></i>
            Case
            <small>
                <i class="icon-double-angle-right"></i>
                History
                <i class="icon-double-angle-right"></i>
                <a title="Back" href="<?php echo URL::to_route('ViewCases');?>">Back</a>
            </small>
        </h1>
    </div>
</div>
<div class="row-fluid">
  
        <div class="span12">
            <span>Case No:<strong>&nbsp;&nbsp;<?php if(isset($history)){$case=libcase::getcasedetailByID($history->case_id);echo ucfirst($case->case_no);$histories=$history->history;$hist_value=json_decode($histories); $user=liblawyer::getlawyer(); }  ?></strong></span>
            <table id="table_bug_report" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Modification</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <tbody>
                    <?php if(isset($history)){ foreach ($hist_value as $hist){ ?>
                    <tr>
                        <td><?php $name=  get_value_from_multi_object_array($hist->uid, $user, 'id', 'first_name');echo ucfirst($name); ?></td>
                        <td><?php if(!is_object($hist->modify)){echo ucfirst($hist->modify);}if(is_object($hist->modify)){
                            $results='';
                            foreach ($hist->modify as $key=>$value)
                            {
                                if($key == 'associate_lawyer')
                                {
                                    
                                    $name=get_array_by_idString_from_object_array($user, $value, 'id');
                                    foreach($name as $val)
                                    {
                                        $results.=ucfirst($key).'&nbsp;:&nbsp;"<b>'.ucfirst($val['first_name']).'</b>"&nbsp;&nbsp;,';
                                    }
                                            
                                }
                                else{
                                $results.=ucfirst($key).':"<b>'.ucfirst($value).'</b>"&nbsp;&nbsp;,';
                                }
                            }
                            echo rtrim($results,',');
                            }?></td>
                        <td><?php echo date("d-M-Y",strtotime($hist->time)); ?></td>
                        <td><?php echo date("h:i:s A",strtotime($hist->time)); ?></td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
</div>
<script type="text/javascript">
    $('a').tooltip();
</script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
            
            
                  



