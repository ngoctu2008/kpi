<!-- BEGIN: main -->
<div class="panel panel-primary">
    <div class="panel-heading">{LANG.welcome}, <strong>{USER_INFO.full_name}</strong>!</div>
    <div class="panel-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>{LANG.your_department}:</strong> {DEPARTMENT.title}</li>
            <li class="list-group-item"><strong>{LANG.your_manager}:</strong> {DEPARTMENT.manager_name}</li>
        </ul>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>{LANG.recent_periods}</strong></div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center w50">ID</th>
                        <th>{LANG.period_title}</th>
                        <th class="text-center w150">{LANG.status}</th>
                        <th class="text-center w100">{LANG.score_self}</th>
                        <th class="text-center w100">{LANG.score_manager}</th>
                        <th class="text-center w200">{LANG.action}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: period -->
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">{PERIOD.id}</td>
                        <td><strong>{PERIOD.title}</strong></td>
                        <td class="text-center">{PERIOD.status_text}</td>
                        <td class="text-center text-primary">{PERIOD.score_self}</td>
                        <td class="text-center text-success">{PERIOD.score_manager}</td>
                        <td class="text-center">
                            <a href="{PERIOD.link_tasks}" class="btn btn-xs btn-info"><i class="fa fa-list"></i> {LANG.tasks}</a>
                            <a href="{PERIOD.link_eval}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {LANG.self_eval}</a>
                        </td>
                    </tr>
                    <!-- END: loop -->
                    <!-- END: period -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: main -->
