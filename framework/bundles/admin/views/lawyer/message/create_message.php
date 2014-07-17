<?php echo Section::start('contentWrapper'); ?>
<div id="page-content" class="clearfix">
    <div class="page-header position-relative">
        <h1><i class="icon icon-envelope"></i>
            Messages
            <small>
                <i class="icon-double-angle-right"></i>
                Create Message
                <i class="icon-double-angle-right"></i>
                <span title="back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
        </h1>
    </div>
</div>
<?php $status=Session::get('status');
if(isset($status)){ ?>
    <div class="alert alert-success">
        <button class="close" type="button" data-dismiss="alert"><i class="icon-remove"></i></button>
        <span><?php echo $status; ?></span>
    </div>
<?php }?>

<div class="row-flow">
      <div class="span12">
          <form class="form-horizontal" action="<?php echo URL::to_route('SendMessage')  ?>" method="post">
              <input type="hidden" name="from" value="<?php echo Auth::user()->id;  ?>"/>
              <div class="control-group">

                  <label class="control-label" for="to">
                      TO:
                  </label>
                  <div class="controls">
                      <input type="text" name="to" id="to" />

                  </div>
                 </div>
              <div class="control-group">
                  <label class="control-label" for="message">Message:</label>
                  <div class="controls">
                      <textarea name="message" id="message" cols="30" rows="5" style="width: 387px; height: 140px;"></textarea>
                  </div>
              </div>
              <div class="control-group">
                  <div class="controls">
                      <button class="btn btn-primary" type="submit">Send</button>
                      <button class="btn btn-primary" type="reset">Cancel</button>

                  </div>
              </div>
          </form>
      </div>
</div>
<?php $foo=liblawyer::getlawyer();

$source=array();

foreach($foo as $lawyer)
{
    if($lawyer->updated_by==Auth::user()->id)
    {
        $lawyer_id=$lawyer->id;
        $val=$lawyer->first_name.'('.$lawyer->user_email.')';
        $data=array(
            'name'=>$val,
            'id'=>$lawyer_id
            );
        array_push($source,$data);
    }
}
$lawyer_names=json_encode($source);
?>
    <script type="text/javascript">
        $(document).ready(function(){
          $('span').tooltip();
        $('#to').tokenInput(<?php echo $lawyer_names;?>,{
            theme:"facebook",
            preventDuplicates:false
        });
        });


    </script>
    <style type="text/css">
      label{
        color:#55A82E;
      }
    </style>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>