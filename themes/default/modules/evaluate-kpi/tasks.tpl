<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<div class="panel panel-default">
    <div class="panel-heading"><strong>{LANG.tasks}</strong></div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="w50 text-center">ID</th>
                        <th>{LANG.task_title}</th>
                        <th class="w100">{LANG.task_type}</th>
                        <th class="w100">{LANG.task_freq}</th>
                        <th class="w150">{LANG.task_output}</th>
                        <th class="w100 text-center">{LANG.task_deadline}</th>
                        <th class="w100 text-center">{LANG.task_status}</th>
                        <th class="w100 text-center">{LANG.task_evidence}</th>
                        <th class="w150 text-center">{LANG.action}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: list -->
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">{TASK.id}</td>
                        <td><strong>{TASK.title}</strong></td>
                        <td>{TASK.type_text}</td>
                        <td>{TASK.frequency}</td>
                        <td>{TASK.output_expected}</td>
                        <td class="text-center text-danger">{TASK.deadline}</td>
                        <td class="text-center">{TASK.status_text}</td>
                        <td class="text-center">
                            <!-- IF TASK.evidence_url -->
                            <a href="{TASK.evidence_url}" target="_blank" class="btn btn-xs btn-info"><i class="fa fa-link"></i></a>
                            <!-- ENDIF TASK.evidence_url -->
                        </td>
                        <td class="text-center">
                            <a href="{TASK.link_edit}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> {LANG.edit}</a>
                            <a href="#" onclick="nv_del_task({TASK.id}, '{CHECKSS}', {PERIOD_ID}); return false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> {LANG.delete}</a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                    <!-- END: list -->

                    <!-- BEGIN: empty -->
                    <tr>
                        <td colspan="9" class="text-center">{LANG.task_empty}</td>
                    </tr>
                    <!-- END: empty -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<div class="panel panel-primary">
    <div class="panel-heading">{LANG.add} / {LANG.edit}</div>
    <div class="panel-body">
        <form action="{ACTION_URL}" method="post">
            <input type="hidden" name="period_id" value="{PERIOD_ID}" />
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>{LANG.task_title} <span class="text-danger">(*)</span></strong></label>
                        <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label><strong>{LANG.task_type}</strong></label>
                        <select name="task_type" class="form-control">
                            <option value="1" {SEL_TYPE_1}>{LANG.task_type_1}</option>
                            <option value="2" {SEL_TYPE_2}>{LANG.task_type_2}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label><strong>{LANG.task_desc}</strong></label>
                <textarea class="form-control" name="description" rows="2">{ROW.description}</textarea>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>{LANG.task_freq}</strong></label>
                        <input class="form-control" type="text" name="frequency" value="{ROW.frequency}" placeholder="VD: Hàng ngày, Hàng tuần..." />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>{LANG.task_output}</strong></label>
                        <input class="form-control" type="text" name="output_expected" value="{ROW.output_expected}" placeholder="VD: 5 bài viết, 1 báo cáo..." />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>{LANG.task_deadline}</strong></label>
                        <div class="input-group">
                            <input class="form-control datepicker" type="text" name="deadline" value="{ROW.deadline_fmt}" readonly="readonly" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>{LANG.task_status}</strong></label>
                        <select name="status" class="form-control">
                            <option value="0" {SEL_STATUS_0}>{LANG.task_status_0}</option>
                            <option value="1" {SEL_STATUS_1}>{LANG.task_status_1}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label><strong>{LANG.task_evidence}</strong></label>
                        <input class="form-control" type="url" name="evidence_url" value="{ROW.evidence_url}" placeholder="http://..." />
                    </div>
                </div>
            </div>

            <div class="text-center">
                <input type="submit" name="submit" value="{LANG.save}" class="btn btn-primary" />
                <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&{NV_OP_VARIABLE}=main" class="btn btn-default">{LANG.cancel}</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true
    });
});

function nv_del_task(id, checkss, period_id) {
    if (confirm('Are you sure you want to delete this task?')) {
        $.ajax({
            type: 'POST',
            url: '{ACTION_URL}',
            data: 'delete=' + id + '&checkss=' + checkss + '&period_id=' + period_id,
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
