<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">{LANG.config_mapping_note}</div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
            <input type="hidden" name="checkss" value="{CHECKSS}" />
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <colgroup>
                        <col class="w250" />
                        <col />
                    </colgroup>
                    <tbody>
                        <tr>
                            <td><strong>{LANG.config_group_employee}</strong></td>
                            <td>
                                <!-- BEGIN: group_emp -->
                                <label class="show"><input type="checkbox" name="group_employee[]" value="{GROUP.id}" {GROUP.checked_emp}> {GROUP.title}</label>
                                <!-- END: group_emp -->
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{LANG.config_group_manager}</strong></td>
                            <td>
                                <!-- BEGIN: group_man -->
                                <label class="show"><input type="checkbox" name="group_manager[]" value="{GROUP.id}" {GROUP.checked_man}> {GROUP.title}</label>
                                <!-- END: group_man -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <input type="submit" name="savesetting" value="{LANG.save}" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>
<!-- END: main -->
