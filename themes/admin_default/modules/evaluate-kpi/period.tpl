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
                <th class="text-center">{LANG.period_start}</th>
                <th class="text-center">{LANG.period_end}</th>
                <th class="text-center">{LANG.period_lock}</th>
                <th>{LANG.status}</th>
                <th class="w150 text-center">{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.id}</td>
                <td>{DATA.title}</td>
                <td class="text-center">{DATA.start_time}</td>
                <td class="text-center">{DATA.end_time}</td>
                <td class="text-center text-danger"><strong>{DATA.lock_time}</strong></td>
                <td>{DATA.status_text}</td>
                <td class="text-center">
                    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;id={DATA.id}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> {LANG.edit}</a>
                    <a href="#" onclick="nv_del_period({DATA.id}, '{CHECKSS}'); return false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> {LANG.delete}</a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
    </table>
</div>
<!-- END: list -->

<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<div class="panel panel-default">
    <div class="panel-heading">{LANG.add} / {LANG.edit}</div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />
            <div class="form-group">
                <label><strong>{LANG.title}</strong></label>
                <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" placeholder="{LANG.period_ph}" />
            </div>

            <div class="row">
                <div class="col-xs-24 col-sm-8">
                    <div class="form-group">
                        <label><strong>{LANG.period_start}</strong></label>
                        <div class="input-group">
                            <input class="form-control datepicker" type="text" name="start_time" value="{ROW.start_time_fmt}" readonly="readonly" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-8">
                    <div class="form-group">
                        <label><strong>{LANG.period_end}</strong></label>
                        <div class="input-group">
                            <input class="form-control datepicker" type="text" name="end_time" value="{ROW.end_time_fmt}" readonly="readonly" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-24 col-sm-8">
                    <div class="form-group">
                        <label><strong>{LANG.period_lock}</strong></label>
                        <div class="input-group">
                            <input class="form-control datepicker" type="text" name="lock_time" value="{ROW.lock_time_fmt}" readonly="readonly" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
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
$(document).ready(function() {
    $(".datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : true,
        changeYear : true,
        showOtherMonths : true
    });
});

function nv_del_period(id, checkss) {
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
