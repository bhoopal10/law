<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1><i class="icon icon-user"></i>
            Contact
            <small>
                <i class="icon-double-angle-right"></i>
                Contacts list
                <i class="icon-double-angle-right"></i>
                <span title="Back" style="cursor: pointer" onclick="history.go(-1);">Back</span>
            </small>
            <a href="<?php echo URL::to_route('Contacts'); ?>">
                <button title="Add new contact" class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new contact</button>
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
                S.no
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Group</th>
                <th>City</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
           <?php
           //print_r($contact);exit;
           if(isset($contact))
           {
                if(isset($_GET['page']))
                {
                  $perpage=$contact->per_page;
                    $currentpage=$contact->page;
                    $initial=$currentpage-1;
                    $total_rows=$contact->total;
//                    echo $total_rows;exit;
                    $total=$perpage*$currentpage;
                    $Initial=$total-1;
                    $count1=$perpage+$Initial;
                    $count= ($count1>$total_rows) ? $total_rows:$count1;
                }
                else
                {
                     $Initial=0;
                    $total_rows=$contact->total;
                    $perpage=$contact->per_page;
                    $count=($perpage>$total_rows)? $total_rows:$perpage;

                }
//           $count=count($contact->results);
           ?>
            <?php  for($Initial;$Initial < $count; $Initial++){   ?>
            <tr class="odd">
                <td class="center">
                    <?php  echo $Initial+1; ?>
                </td>
                <td><?php echo $contact->results[$Initial]->first_name;  ?></td>
                <td><?php echo $contact->results[$Initial]->email;  ?></td>
                <td><?php echo $contact->results[$Initial]->mobile;  ?></td>
                <td><?php echo $contact->results[$Initial]->group;  ?></td>
                <td><?php echo $contact->results[$Initial]->city;  ?></td>
                <td class="td-actions ">
                    <div class="hidden-phone visible-desktop btn-group">
                       <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditContact').'/'.Crypter::encrypt($Initial);  ?>">
                            <i class="icon-edit bigger-120"></i>
                        </a>
                        <a title="Delete" class="btn btn-mini btn-danger" onclick="return confirm('Really want to delete this contact')" href="<?php echo URL::to_route('DeleteContact').'/'.Crypter::encrypt($Initial);  ?>">
                            <i class="icon-trash bigger-120"></i>
                        </a>
                </div>
              </td>
            </tr>
            <?php } } ?>
            </tbody>
        </table>
    <?php if(isset($contact)){ echo $contact->links();} ?>
</div>
    <script type="text/javascript">
        $(function(){
           $('.btn').tooltip({placement: 'left'})
           $('span').tooltip({placement: 'bottom'})
        });
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>