<?php echo Section::start('contentWrapper');?>
<div class="clear-fix" id="page-content">
    <div class="page-header position-relative">
        <h1>
            Task
            <small>
                <i class="icon-double-angle-right"></i>
                Add Task
            </small>
        </h1>
    </div>
</div>
<div class="row-fluid">
    <form class="form-horizontal" action="#">
        <div class="control-group">
            <label class="control-label" for="task_name">Task Name:</label>
            <div class="controls">
                <input type="text" name="task_name" id="task_name"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="case_link">Case Link:</label>
            <div class="controls">
                <select name="case_link" id="case_link">
                    <option value="">select Case</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="assign_to">Assign To:</label>
            <div class="controls">
                <select name="assign_to" id="assign_to">
                    <option value="">select lawyer</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="check_list">Check List Item:</label>
            <div class="controls">
                <input type="text" name="check_list" id="check_list"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="due_date">Due Date:</label>
            <div class="controls">
                <input type="text" name="due_date" id="due_date"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="priority">Priority:</label>
            <div class="controls">
                <select name="priority" id="priority">
                    <option value="no priority">No Priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="description">Description:</label>
            <div class="controls">
                <textarea name="description" id="description" rows="2"></textarea>
            </div>
        </div>
        <div class="control-group">
             <div class="controls">
            <button class="btn btn-primary" type="submit">Add Task</button>
            <button class="btn btn-danger" type="reset">Reset</button>
            </div>
        </div>
    </form>
</div>
    <script type="text/javascript">

           $('#due_date').datepicker();

    </script>
<?php Section::stop(); ?>
<?php echo render('admin::template.main'); ?>