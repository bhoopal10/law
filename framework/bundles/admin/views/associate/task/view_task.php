<?php echo Section::start('contentWrapper');?>
    <div class="clear-fix" id="page-content">
        <div class="page-header position-relative">
            <h1>
                Task
                <small>
                    <i class="icon-double-angle-right"></i>
                    View Task
                </small>
            </h1>
        </div>
    </div>
    <div class="row-fluid">
        <a href="<?php echo URL::to_route('Tasks'); ?>">
            <button class="btn btn-file" style="float: right"><i class="icon-plus"></i>Add new Task</button>
        </a>
        <table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
            <thead>
            <tr role="row">
                <th>Task Name</th>
                <th>Case Link</th>
                <th>Assigned TO</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th></th>
            </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            <tr class="odd">
               <td>Task1</td>
                <td>Case1</td>
                <td>Lawyer2</td>
                <td>High</td>
                <td>12/12/2013</td>
                <td class="td-actions ">
                    <div class="hidden-phone visible-desktop btn-group">

                        <button class="btn btn-mini btn-info">
                            <i class="icon-edit bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-danger">
                            <i class="icon-trash bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-warning">
                            <i class="icon-flag bigger-120"></i>
                        </button>
                    </div>

                </td>
            </tr>
            <tr class="odd">
                <td>Task3</td>
                <td>Case2</td>
                <td>Lawyer5</td>
                <td>Low</td>
                <td>12/12/2013</td>
                <td class="td-actions ">
                    <div class="hidden-phone visible-desktop btn-group">

                        <button class="btn btn-mini btn-info">
                            <i class="icon-edit bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-danger">
                            <i class="icon-trash bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-warning">
                            <i class="icon-flag bigger-120"></i>
                        </button>
                    </div>

                </td>
            </tr>
            <tr class="odd">
                <td>Task5</td>
                <td>Case2</td>
                <td>Lawyer8</td>
                <td>Medium</td>
                <td>12/12/2013</td>
                <td class="td-actions ">
                    <div class="hidden-phone visible-desktop btn-group">
                          <button class="btn btn-mini btn-info">
                            <i class="icon-edit bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-danger">
                            <i class="icon-trash bigger-120"></i>
                        </button>

                        <button class="btn btn-mini btn-warning">
                            <i class="icon-flag bigger-120"></i>
                        </button>
                    </div>

                </td>
            </tr>


            </tbody>
        </table>


    </div>
<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>