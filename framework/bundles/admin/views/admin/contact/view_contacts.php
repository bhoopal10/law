<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1>
            Contact
            <small>
                <i class="icon-double-angle-right"></i>
                Contacts list
            </small>
        </h1>

    </div>
</div>

<div class="row-fluid">
    <select name="group" id="group" style="float: left">
        <option value="">All groups</option>
    </select>

    <a href="<?php echo URL::to_route('Contacts'); ?>">
        <button class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new contact</button>

    </a>
        <table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
            <thead>
            <tr role="row">
                <th class="center sorting_disabled" role="columnheader" rowspan="1" colspan="1" style="width: 50px;" aria-label="">
                    <label>
                        <input type="checkbox">
                        <span class="lbl"></span>
                    </label>
                </th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Group</th>
                <th>City</th>
                <th></th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
           <?php $contact=libcontact::getcontactgroupByID(Auth::user()->id);
                 $arr=(array)$contact;//object to array
                 $contacts=array_filter($arr);//remove empty value element
           if($contacts!=null){
              $contacts=json_decode($contact->contact_details);
           ?>
            <?php  foreach($contacts as $key=>$con){ ?>
            <tr class="odd">
                <td class="center">
                    <label>
                        <input type="checkbox">
                        <span class="lbl"></span>
                    </label>
                </td>

                <td><?php echo $con->first_name;  ?></td>
                <td><?php echo $con->email;  ?></td>
                <td><?php echo $con->mobile;  ?></td>
                <td><?php echo $con->group;  ?></td>
                <td><?php echo $con->city;  ?></td>
                <td class="td-actions ">
                    <div class="hidden-phone visible-desktop btn-group">
                       <a title="Edit" class="btn btn-mini btn-info" href="<?php echo URL::to_route('EditContact').'/'.$key;  ?>">
                            <i class="icon-edit bigger-120"></i>
                        </a>
                        <a title="Delete" class="btn btn-mini btn-danger" href="#">
                            <i class="icon-trash bigger-120"></i>
                        </a>
                </div>
              </td>
            </tr>
            <?php } } ?>
            </tbody>
        </table>
</div>
    <script type="text/javascript">
        $(function(){
           $('.btn').tooltip({placement: 'left'})
        });
    </script>
<?php Section::stop(); ?>
<?php echo render('admin::admin/template.main'); ?>