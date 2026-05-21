<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<div class="alert alert-info">
    <i class="fa fa-info-circle"></i> {LANG.cri_notice}
</div>

<!-- BEGIN: list -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th class="w50 text-center">{LANG.cri_stt}</th>
                <th>{LANG.title}</th>
                <th class="text-center w150">{LANG.cri_max_score}</th>
                <th class="w100 text-center">{LANG.status}</th>
                <th class="w150 text-center">{LANG.action}</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: loop -->
            <tr>
                <td class="text-center">{DATA.weight}</td>
                <td><strong>{DATA.title}</strong><br><em>{DATA.description}</em></td>
                <td class="text-center text-danger"><strong>{DATA.max_score}</strong></td>
                <td class="text-center">{DATA.status_text}</td>
                <td class="text-center">
                    <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;id={DATA.id}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>
                    <a href="#" onclick="nv_del_criteria({DATA.id}, '{CHECKSS}'); return false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <!-- END: loop -->
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right"><strong>{LANG.cri_total}</strong></td>
                <td class="text-center text-danger"><strong>{TOTAL_MAX_SCORE} / 30</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>
<!-- END: list -->

<div class="panel panel-default">
    <div class="panel-heading">{LANG.add} / {LANG.edit}</div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="id" value="{ROW.id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />
            <div class="form-group">
                <label><strong>{LANG.title}</strong></label>
                <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" placeholder="" />
            </div>

            <div class="form-group">
                <label><strong>{LANG.cri_desc}</strong></label>
                <textarea class="form-control" name="description" rows="3" placeholder="{LANG.cri_desc_ph}">{ROW.description}</textarea>
            </div>

            <div class="form-group">
                <label><strong>{LANG.cri_max_score}</strong></label>
                <input class="form-control w250" type="number" step="0.5" name="max_score" value="{ROW.max_score}" required="required" />
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
function nv_del_criteria(id, checkss) {
    if (confirm('Are you sure you want to delete this criteria?')) {
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
