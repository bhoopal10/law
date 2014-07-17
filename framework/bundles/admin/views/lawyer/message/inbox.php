<?php echo Section::start('contentWrapper'); ?>
<?php $profile=liblawyer::lawyerprofile(); if($profile->payment=='trail'){ ?>
    <div class="alert alert-info">
        <span>Trail</span>
    </div>
<?php }  ?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-envelope"></i>
            Messages
            <small>
                <i class="icon-double-angle-right"></i>
                Inbox
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">
                <span><i class="icon-remove"></i></span>
            </button>
        <span><?php echo $status; ?></span>
    </div>
<?php } ?>

<div class="row-flow">
    <div class="row-fluid">
        <div class="span12">
            <form action="<?php echo URL::to_route('MultiMessageDelete'); ?>" method="post">
                <span id="del" style="display: none">

                <button class="btn btn-mini btn-danger" type="submit" ><i class="icon-trash"></i>Delete</button>
            </span>
            <table id="table_bug_report" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th style="width: 230px">Name</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php if($inbox){ $uname=liblawyer::getlawyername(); foreach($inbox->results as $inboxs){if($inboxs->to_status==0){  ?>
                <tr class="">
                    <td class="left">
                        <label>
                            <input type="checkbox" name="inbox_delete[]" value="<?php echo $inboxs->msg_id; ?>">
                            <span class="lbl"></span>
                        </label>
                    </td>

                    <td><?php
                        foreach($uname as $name)
                        {
                            if($name->id==$inboxs->from_id)
                            {
                                echo $name->first_name;
                            }
                        }
                        ?></td>
                    <td> <a id="msg"  href="<?php echo URL::to_route('MessageDetail').'/'.$inboxs->msg_id; ?>"><?php echo ucfirst(substr($inboxs->text,0,50)); ?></a></td>
                    <td><?php  $date=new DateTime($inboxs->date); echo date_format($date, 'd-M-Y H:i:s'); ?></td>
                    <td><a href="<?php echo URL::to_route('DeleteMessage').'/@'.$inboxs->msg_id ?>" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a></td>
                <?php }} } ?>

                </tbody>

            </table>
                <?php echo $inbox->links(); ?>
                </form>
            <hr>
        </div><!--/span-->
    </div>

</div>
<script>
    $(function(){
        $('table th input:checkbox').on('click',function(){
            var that=this;

            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked=that.checked;
                    $(this).closest('tr').toggleClass('selected');
                })
        })


    });


    $(document).ready(function () {
        $('#del').hide();
        $('span').tootip();
        var count =function(){
            var n=$("input:checked").length;
            if(n >=2 )
            {
                $('#del').show();
            }
            else
            {
                $('#del').hide();
            }
        };
        count();
        $( "input[type=checkbox]" ).on( "click", count );
    });
</script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
