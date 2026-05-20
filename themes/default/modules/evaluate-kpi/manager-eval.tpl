<!-- BEGIN: main -->
<div class="panel panel-primary">
    <div class="panel-heading"><strong>{LANG.manager_list_emp}</strong></div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="w50 text-center">ID</th>
                        <th>{LANG.manager_emp_name}</th>
                        <th>{LANG.period_title}</th>
                        <th class="w100 text-center">{LANG.score_self}</th>
                        <th class="w100 text-center">{LANG.score_manager}</th>
                        <th class="w150 text-center">{LANG.status}</th>
                        <th class="w150 text-center">{LANG.action}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: list -->
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">{ROW.record_id}</td>
                        <td><strong>{ROW.full_name}</strong></td>
                        <td>{ROW.period_title}</td>
                        <td class="text-center text-primary">{ROW.total_score_self}</td>
                        <td class="text-center text-success">{ROW.total_score_manager}</td>
                        <td class="text-center">{ROW.status_text}</td>
                        <td class="text-center">
                            <a href="{ROW.link_approve}" class="btn btn-xs btn-primary"><i class="fa fa-gavel"></i> {LANG.manager_approve}</a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                    <!-- END: list -->
                    <!-- BEGIN: empty -->
                    <tr>
                        <td colspan="7" class="text-center">{LANG.error_not_found}</td>
                    </tr>
                    <!-- END: empty -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: main -->

<!-- BEGIN: approve -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<div class="panel panel-success">
    <div class="panel-heading">Duyệt đánh giá: <strong>{RECORD.full_name}</strong> ({RECORD.period_title})</div>
    <div class="panel-body">
        <form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="record_id" value="{RECORD.record_id}" />
            <input type="hidden" name="checkss" value="{CHECKSS}" />

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{LANG.kpi_criteria}</th>
                            <th class="w150 text-center">{LANG.self_score}</th>
                            <th class="w150 text-center">{LANG.manager_score}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="info">
                            <td colspan="3"><strong>1. {LANG.eval_criteria}</strong></td>
                        </tr>
                        <tr>
                            <td>{LANG.total_score_general}</td>
                            <td class="text-center text-primary" style="font-size:16px;"><strong>{RECORD.score_general_self}</strong></td>
                            <td>
                                <input type="number" step="0.5" max="30" min="0" name="score_general_manager" value="{RECORD.score_general_manager}" class="form-control text-center text-success" style="font-weight:bold" />
                            </td>
                        </tr>
                        <tr class="info">
                            <td colspan="3"><strong>2. {LANG.eval_kpi}</strong></td>
                        </tr>
                        <tr>
                            <td>{LANG.eval_kpi_a}</td>
                            <td class="text-center text-primary">{RECORD.kpi_a_self}%</td>
                            <td><input type="number" name="kpi_a_manager" value="{RECORD.kpi_a_manager}" min="0" max="100" class="form-control text-center" /></td>
                        </tr>
                        <tr>
                            <td>
                                {LANG.eval_kpi_b}
                                <br><small class="text-danger">Số lần phạt: {RECORD.b_errors_self}</small>
                            </td>
                            <td class="text-center text-primary">{RECORD.kpi_b_self}%</td>
                            <td>
                                <input type="number" name="kpi_b_manager" value="{RECORD.kpi_b_manager}" min="0" max="100" class="form-control text-center" style="margin-bottom:5px" />
                                <input type="number" name="b_errors_manager" value="{RECORD.b_errors_manager}" min="0" class="form-control input-sm text-center text-danger" placeholder="{LANG.eval_error_b}" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {LANG.eval_kpi_c}
                                <br><small class="text-danger">Số lần phạt: {RECORD.c_errors_self}</small>
                            </td>
                            <td class="text-center text-primary">{RECORD.kpi_c_self}%</td>
                            <td>
                                <input type="number" name="kpi_c_manager" value="{RECORD.kpi_c_manager}" min="0" max="100" class="form-control text-center" style="margin-bottom:5px" />
                                <input type="number" name="c_errors_manager" value="{RECORD.c_errors_manager}" min="0" class="form-control input-sm text-center text-danger" placeholder="{LANG.eval_error_c}" />
                            </td>
                        </tr>

                        <!-- BEGIN: manager_fields -->
                        <tr>
                            <td>{LANG.eval_kpi_d}</td>
                            <td class="text-center text-primary">{RECORD.kpi_d_self}%</td>
                            <td><input type="number" name="kpi_d_manager" value="{RECORD.kpi_d_manager}" min="0" max="100" class="form-control text-center" /></td>
                        </tr>
                        <tr>
                            <td>{LANG.eval_kpi_d2}</td>
                            <td class="text-center text-primary">{RECORD.kpi_d2_self}%</td>
                            <td><input type="number" name="kpi_d2_manager" value="{RECORD.kpi_d2_manager}" min="0" max="100" class="form-control text-center" /></td>
                        </tr>
                        <tr>
                            <td>{LANG.eval_kpi_e}</td>
                            <td class="text-center text-primary">{RECORD.kpi_e_self}%</td>
                            <td><input type="number" name="kpi_e_manager" value="{RECORD.kpi_e_manager}" min="0" max="100" class="form-control text-center" /></td>
                        </tr>
                        <!-- END: manager_fields -->

                        <tr class="warning">
                            <td colspan="3"><strong>3. {LANG.total_result}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.total_point}</strong></td>
                            <td class="text-center text-primary" style="font-size:18px;"><strong>{RECORD.total_score_self}</strong></td>
                            <td class="text-center text-success" style="font-size:18px;"><strong>{RECORD.total_score_manager}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.rank_level}</strong></td>
                            <td class="text-center text-primary"><strong>{RECORD.rank_self}</strong></td>
                            <td class="text-center text-success"><strong>{RECORD.rank_manager}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <label><strong>{LANG.manager_note}</strong></label>
                <textarea class="form-control" name="manager_note" rows="3">{RECORD.manager_note}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" name="submit_approve" value="1" class="btn btn-success" onclick="return confirm('{LANG.manager_confirm_approve}');"><i class="fa fa-check"></i> {LANG.manager_approve}</button>
                <a href="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&{NV_OP_VARIABLE}={OP}" class="btn btn-default">{LANG.cancel}</a>
            </div>
        </form>
    </div>
</div>
<!-- END: approve -->
