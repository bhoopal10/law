<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/6/14
 * Time: 10:24 AM
 */ ?>

<?php echo Section::start('contentWrapper');?>
<script src="<?php echo Config::get('application.url').Config::get('admin::admin_config.ckeditor').'ckeditor.js';  ?>"></script>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1><i class="icon icon-user"></i>
                Client
                <small>
                    <i class="icon-double-angle-right"></i>
                    Client List
                    <i class="icon-double-angle-right"></i>
                    <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>

                </small>
               <!--  <a href="<?php echo URL::to_route('CreateClient'); ?>">
                    <button title="Add new client" class="btn btn-mini btn-file" style="float: right"><i class="icon-plus"></i>Add new Client</button>
                </a> -->
            </h1>
        </div>
    </div>

    <div class="row-fluid">
        <!--    <select name="group" id="group" style="float: left">-->
        <!--        <option value="">All groups</option>-->
        <!--    </select>-->
        <?php $status=Session::get('status');
        if(isset($status)){ ?>
            <div class=" alert alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <span><i class="icon-remove"></i></span>
                </button>
                <span><?php echo $status; ?></span>
            </div>
        <?php }?>
        <div class="span12">
            <a href="<?php echo URL::to_route('CreateClient'); ?>">
                <button title="Add new Client" class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new Client</button>
            </a>
             <span style="float: right">&nbsp;</span>
            <a title="Send Email" href="javascript:void(0);" id="send_mail" class="btn btn-file" style="float: right">Send Email</a>
        <form name="form2" action="<?php echo URL::to_route('SearchClient'); ?>" method="get" class="form-inline">
            <?php $client_name = libclient::getclientByLawyerID(Auth::user()->id); ?>
        <select id="client_id" class="span3" name="client_id" onchange='this.form.submit()'>
            <option value="0">Search By Client Name</option>
            <?php if(isset($_GET['client_id'])){ $client_id=$_GET['client_id'];if($client_id){ ?>
                <option value="<?php echo $client_id; ?>" selected><?php $cas=get_value_from_multi_object_array($client_id,$client_name,'client_id','client_name'); echo $cas->client_name; ?></option>
            <?php }} ?>
            <?php if(isset($client_name)){ foreach( $client_name as $val){ ?>
                <option value="<?php echo $val->client_id; ?>"><?php echo ucfirst($val->client_name); ?></option>
            <?php }}  ?>
        </select>
       </form>

        <table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
        <form action="#" method="post" id="send_email" >
            <thead>
            <tr role="row">
                <th class="left" style="width: 20px">
                        <label>
                            <input type="checkbox">
                            <span class="lbl"></span>
                        </label>
                </th>
                <th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 50px;" aria-label="">
                    S.No
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Pincode</th>
                <th></th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <?php
            if($client!=null){
            ?>
                <?php $i=1; foreach($client->results as $clients){ ?>
                    <tr class="odd">
                        <td class="left">
                                <label>
                                    <input type="checkbox" name="email[]" value="<?php echo $clients->email; ?>">
                                    <span class="lbl"></span>
                                </label>
                        </td>
                        <td><?php $page=$client->page-1;$total=$client->per_page*$page; echo $i+$total;$i++; ?></td>
                        <td><?php echo $clients->client_name;  ?></td>
                        <td><?php echo $clients->email;  ?></td>
                        <td><?php echo $clients->mobile;  ?></td>
                        <td><?php echo $clients->city;  ?></td>
                        <td><?php echo $clients->pincode;  ?></td>
                        <td class="td-actions ">
                            <div class="hidden-phone visible-desktop btn-group">
                                <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditClient').'/'.$clients->client_id;  ?>">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really want to delete this contact')" href="<?php echo URL::to_route('DeleteClient').'/'.$clients->client_id;  ?>">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } } ?>
            </tbody>
            </form>
        </table>
        <?php echo $client->links(); ?>
    </div>
    </div>
    <div id="message_div" style="display:none">
        <form id="send_message"  onsubmit="return sendMessage();">
            <textarea name='editor1' id='editor1' class="editor1">
               
            </textarea>
        </form>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
           $('#client_id').select2();
        });
        $(function(){
            $('.btn').tooltip({placement: 'left'});
            $('span').tooltip({placement: 'bottom'});
            $('a').tooltip({placement: 'bottom'});


             $('table th input:checkbox').on('click',function(){
                var that=this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                     .each(function(){
                     this.checked=that.checked;
                     $(this).closest('tr').toggleClass('selected');
                });
            });
        });






         $('#send_mail').on('click',function(){
        var n=$("input:checked").length;
        if(n <= 0)
        {
            alert('Select atleast one user');
            return false;
        }
        else{
            $('#message_div').dialog({ 
                        minWidth: 700,
                        modal:true,
                         buttons: {
                            Close: function() {
                            $( this ).dialog( "close" );
                            },
                            Send: function(){
                                $('#send_message').submit();
                                 $( this ).dialog( "close" );
                             
                                }
                            }
                         }).fadeIn(300);
            setTimeout(function(){CKEDITOR.replace('editor1')},350);
      
        }
    });

 function sendMessage()
 {
  
     var email  = $('#send_email').serializeArray();
     var data1  = CKEDITOR.instances.editor1.getData();
         data1  = escape(data1);
     var arr    = encodeURIComponent(data1);
     $.post("<?php echo URL::to_route('SendMail'); ?>",{da:arr,email:email})
        .success(function(data){
           alert(data) ;
        })
        .error(function(xhr, textStatus, error){
            alert(xhr.statusText);
            alert(textStatus);
           alert(error) ;
        });
        return false;
 }
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>