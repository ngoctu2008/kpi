<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<!-- BEGIN: list -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w50 text-center">ID</th>
                <th>{LANG.title}</th>
                <th>{LANG.department_manager} (ID)</th>
                <th>{LANG.status}</th>
                <th class="w150 text-center">{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.id}</td>
                <td>{DATA.title}</td>
                <td>{DATA.manager_id}</td>
                <td>{DATA.status_text}</td>
                <td class="text-center">
                    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;id={DATA.id}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> {LANG.edit}</a>
                    <a href="#" onclick="nv_del_department({DATA.id}, '{CHECKSS}'); return false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> {LANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- END: list -->

<div class="panel panel-default">
    <div class="panel-heading">{LANG.department_add}</div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />
            <div class="form-group">
                <label><strong>{LANG.title}</strong></label>
                <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" />
            </div>
            <div class="form-group">
                <label><strong>{LANG.department_manager}</strong></label>
                <input class="form-control" type="number" name="manager_id" value="{ROW.manager_id}" placeholder="{LANG.department_manager_note}" />
            </div>
            <div class="form-group">
                <label><strong>{LANG.department_description}</strong></label>
                <textarea class="form-control" name="description">{ROW.description}</textarea>
            </div>
            <div class="form-group">
                <label><strong>{LANG.status}</strong></label>
                <div>
                    <label class="radio-inline"><input type="radio" name="status" value="1" {CHECKED_STATUS_1} /> {LANG.status_1}</label>
                    <label class="radio-inline"><input type="radio" name="status" value="0" {CHECKED_STATUS_0} /> {LANG.status_0}</label>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" name="submit" value="{LANG.save}" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
function nv_del_department(id, checkss) {
    if (confirm('Are you sure you want to delete this?')) {
        $.ajax({
            type: 'POST',
            url: '{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&{NV_OP_VARIABLE}={OP}',
            data: 'delete=' + id + '&checkss=' + checkss,
            success: function(res) {
                if (res == 'OK') {
                    window.location.reload();
                } else {
                    alert('Error deleting');
                }
            }
        });
    }
}
</script>
<!-- END: main -->
