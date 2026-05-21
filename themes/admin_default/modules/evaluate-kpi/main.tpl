<!-- BEGIN: main -->
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">{LANG.dash_overview}</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">{NUM_DEPARTMENTS}</span>
                        {LANG.dash_departments}
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{NUM_PERIODS}</span>
                        {LANG.dash_periods}
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{NUM_TASKS}</span>
                        {LANG.dash_tasks}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-16">
        <div class="panel panel-success">
            <div class="panel-heading">{LANG.dash_status_title}</div>
            <div class="panel-body text-center">
                <div class="row">
                    <div class="col-sm-8">
                        <h2 class="text-muted">{NUM_RECORDS_DRAFT}</h2>
                        <p>{LANG.dash_draft}</p>
                    </div>
                    <div class="col-sm-8">
                        <h2 class="text-warning">{NUM_RECORDS_PENDING}</h2>
                        <p>{LANG.dash_pending}</p>
                    </div>
                    <div class="col-sm-8">
                        <h2 class="text-success">{NUM_RECORDS_APPROVED}</h2>
                        <p>{LANG.dash_approved}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    {LANG.dash_instruction_1}
    <br>1. <strong>{LANG.dash_instruction_2}</strong>
    <br>2. <strong>{LANG.dash_instruction_3}</strong>
    <br>3. <strong>{LANG.dash_instruction_4}</strong>
</div>
<!-- END: main -->
