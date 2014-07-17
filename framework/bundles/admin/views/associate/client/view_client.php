<?php /**
 * Created by PhpStorm.
 * User: bhoo
 * Date: 2/6/14
 * Time: 10:24 AM
 */ ?>

<?php echo Section::start('contentWrapper');?>
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
                <a href="<?php echo URL::to_route('CreateClient'); ?>">
                    <button title="Add new client" class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new Client</button>

                </a>
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


        <table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
            <thead>
            <tr role="row">
                <th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 50px;" aria-label="">
                    Sno.
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
        </table>
        <?php echo $client->links(); ?>
    </div>
    <script type="text/javascript">
        $(function(){
            $('.btn').tooltip({placement: 'left'})
            $('span').tooltip({placement: 'bottom'})
        });
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::associate/template.main'); ?>