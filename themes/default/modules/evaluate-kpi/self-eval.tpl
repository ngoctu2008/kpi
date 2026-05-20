<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<!-- BEGIN: locked -->
<div class="alert alert-warning">
    <i class="fa fa-lock"></i> {LANG.locked_notice}
</div>
<!-- END: locked -->

<div class="panel panel-primary">
    <div class="panel-heading"><strong>{PERIOD.title}</strong> - {LANG.self_eval}</div>
    <div class="panel-body">
        <form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" id="frmSelfEval">
            <input type="hidden" name="period_id" value="{PERIOD.id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />
            <input type="hidden" name="status_action" id="status_action" value="0" />

            <h3 class="text-info">{LANG.eval_criteria}</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{LANG.eval_note}</th>
                            <th class="w100 text-center">{LANG.eval_max_score}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: criteria -->
                        <!-- BEGIN: loop -->
                        <tr>
                            <td>
                                <strong>{CRI.title}</strong><br>
                                <em class="text-muted">{CRI.description}</em>
                            </td>
                            <td class="text-center text-danger"><strong>{CRI.max_score}</strong></td>
                        </tr>
                        <!-- END: loop -->
                        <!-- END: criteria -->
                        <tr>
                            <td class="text-right"><strong>{LANG.total_score_general}</strong></td>
                            <td>
                                <input type="number" step="0.5" max="30" min="0" name="score_general_self" value="{RECORD.score_general_self}" class="form-control text-center text-primary" style="font-weight:bold" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3 class="text-info">{LANG.eval_kpi}</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{LANG.kpi_criteria}</th>
                            <th class="w150 text-center">{LANG.kpi_percent}</th>
                            <th class="w150 text-center">{LANG.kpi_note}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- BEGIN: kpi -->
                        <tr>
                            <td><strong>{LANG.eval_kpi_a}</strong></td>
                            <td><input type="number" name="kpi_a_self" value="{RECORD.kpi_a_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.eval_kpi_b}</strong></td>
                            <td><input type="number" name="kpi_b_self" value="{RECORD.kpi_b_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td>
                                <label class="small">{LANG.eval_error_b}</label>
                                <input type="number" name="b_errors_self" value="{RECORD.b_errors_self}" min="0" class="form-control input-sm text-center text-danger" />
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.eval_kpi_c}</strong></td>
                            <td><input type="number" name="kpi_c_self" value="{RECORD.kpi_c_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td>
                                <label class="small">{LANG.eval_error_c}</label>
                                <input type="number" name="c_errors_self" value="{RECORD.c_errors_self}" min="0" class="form-control input-sm text-center text-danger" />
                            </td>
                        </tr>
                        <!-- BEGIN: manager_fields -->
                        <tr>
                            <td><strong>{LANG.eval_kpi_d}</strong></td>
                            <td><input type="number" name="kpi_d_self" value="{RECORD.kpi_d_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.eval_kpi_d2}</strong></td>
                            <td><input type="number" name="kpi_d2_self" value="{RECORD.kpi_d2_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.eval_kpi_e}</strong></td>
                            <td><input type="number" name="kpi_e_self" value="{RECORD.kpi_e_self}" min="0" max="100" class="form-control text-center" /></td>
                            <td></td>
                        </tr>
                        <!-- END: manager_fields -->
                        <!-- END: kpi -->
                    </tbody>
                </table>
            </div>

            <!-- BEGIN: submit_buttons -->
            <div class="text-center" style="margin-top: 20px;">
                <button type="button" class="btn btn-default" onclick="submitEval(0)"><i class="fa fa-save"></i> {LANG.save_draft}</button>
                <button type="button" class="btn btn-primary" onclick="submitEval(1)"><i class="fa fa-paper-plane"></i> {LANG.send_approve}</button>
            </div>
            <!-- END: submit_buttons -->
        </form>
    </div>
</div>

<script type="text/javascript">
function submitEval(status) {
    if (status === 1) {
        if (!confirm('{LANG.eval_confirm_send}')) {
            return false;
        }
    }
    $('#status_action').val(status);
    $('#frmSelfEval').submit();
}
</script>
<!-- END: main -->
