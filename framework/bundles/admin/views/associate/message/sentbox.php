<?php echo Section::start('contentWrapper'); ?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-envelope"></i>
            Messages
            <small>
                <i class="icon-double-angle-right"></i>
                SentBox
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
<?php }?>
<div class="row-flow">
    <div class="row-fluid">

        <div class="span12">
            <?php   ?>
            <form action="<?php echo URL::to_route('MultiMessageDelete'); ?>" method="post">
            <span id="del" style="display: none">

                <button class="btn btn-mini btn-danger" type="submit" ><i class="icon-trash"></i>Delete</button>
            </span>
            <table id="table_bug_report" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox" >
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th style="width: 230px">Name</th>
                    <th>Message</th>
                    <th>date</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php if($inbox){ $uname=liblawyer::getlawyername(); foreach($inbox->results as $inboxs){if($inboxs->from_status==0){   ?>
                <tr class="">
                    <td class="left">
                        <label>
                            <input type="checkbox" name="sentbox_delete[]" value="<?php echo $inboxs->msg_id ?>">
                            <span class="lbl"></span>
                        </label>
                    </td>

                    <td><?php
                        foreach($uname as $name)
                        {
                            if($name->id==$inboxs->to_id)
                            {
                                echo $name->first_name;
                            }
                        }
                        ?></td>
                    <td><a id="msg"  href="<?php echo URL::to_route('MessageDetail').'/'.$inboxs->msg_id; ?>"><?php echo ucfirst(substr($inboxs->text,0,50)); ?></a></td>
                    <td><?php  $date=new DateTime($inboxs->date); echo date_format($date, 'd-M-Y H:i:s'); ?></td>
                    <td><a href="<?php echo URL::to_route('DeleteMessage').'/$'.$inboxs->msg_id ?>" class="btn btn-mini btn-danger"><i class="icon-trash"></i></a></td>
                <?php }} } ?>

                </tbody>

            </table>
                <?php echo $inbox->links(); ?>
                </form>
            <hr>
        </div><!--/span-->
    </div>

</div>
<script type="text/javascript">
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
<?php echo render('admin::associate/template.main'); ?>
