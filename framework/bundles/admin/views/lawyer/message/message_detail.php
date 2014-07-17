<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 1/24/14
 * Time: 5:03 PM
 */ ?>
<?php echo Section::start('contentWrapper'); ?>
    <div id="page-content" class="clearfix">
        <div class="page-header position-relative">
            <h1><i class="icon icon-envelope"></i>
                Messages
                <small>
                    <i class="icon-double-angle-right"></i>
                    MessageDetails
                    <i class="icon-double-angle-right"></i>
                       <a title="View All" href="<?php echo URL::to_route('Inbox'); ?>">ViewAll</a>
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
<div class="row-fluid">
    <span>
        From :<b> <?php $from=liblawyer::getUserByID($message->from_id); echo ucfirst($from->first_name).'&nbsp'.ucfirst($from->last_name); ?></b><br/>
        Time :<b> <?php echo date('d-M-Y H:i:s', strtotime($message->date)); ?></b><br/>
        To&nbsp;&nbsp;&nbsp;&nbsp;   :<b> <?php $to=liblawyer::getUserByID($message->to_id);  echo ucfirst($to->first_name).'&nbsp'.ucfirst($to->last_name); ?></b><br/>
        Message: <br/>
    </span>
    <div class="well">
        <span>
            <?php echo $message->text; ?>
        </span>
    </div>

</div>
<script type="text/javascript">
    $('a').tootip();
</script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>