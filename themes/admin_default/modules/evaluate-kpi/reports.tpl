<!-- BEGIN: main -->
<div class="panel panel-default">
    <div class="panel-heading">Lọc báo cáo thống kê (Mẫu 03, 04, 05)</div>
    <div class="panel-body">
        <form action="{NV_BASE_ADMINURL}index.php" method="get" class="form-inline">
            <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
            <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
            <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

            <div class="form-group">
                <label>Chọn kỳ đánh giá: </label>
                <select name="period_id" class="form-control">
                    <option value="0">--- Chọn ---</option>
                    <!-- BEGIN: period -->
                    <option value="{PERIOD.id}" {PERIOD.selected}>{PERIOD.title}</option>
                    <!-- END: period -->
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Xem báo cáo trực tuyến</button>
        </form>
    </div>
</div>

<!-- BEGIN: report -->
<div class="panel panel-info">
    <div class="panel-heading">
        <strong>Biểu tổng hợp kết quả (Mẫu 03)</strong>
        <div class="pull-right">
            <form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
                <input type="hidden" name="period_id" value="{PERIOD_ID}">
                <button type="submit" name="export_excel" value="1" class="btn btn-xs btn-success"><i class="fa fa-file-excel-o"></i> Xuất Excel</button>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center w50">STT</th>
                        <th rowspan="2" class="text-center">Đơn vị (Tổ/Phòng ban)</th>
                        <th rowspan="2" class="text-center w100">Tổng số LĐ</th>
                        <th colspan="2" class="text-center">Hoàn thành Xuất sắc</th>
                        <th colspan="2" class="text-center">Hoàn thành Tốt</th>
                        <th colspan="2" class="text-center">Hoàn thành</th>
                        <th colspan="2" class="text-center">Không hoàn thành</th>
                    </tr>
                    <tr>
                        <th class="text-center w50">SL</th>
                        <th class="text-center w50">%</th>
                        <th class="text-center w50">SL</th>
                        <th class="text-center w50">%</th>
                        <th class="text-center w50">SL</th>
                        <th class="text-center w50">%</th>
                        <th class="text-center w50">SL</th>
                        <th class="text-center w50">%</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- BEGIN: loop -->
                    <tr>
                        <td class="text-center">{ROW.stt}</td>
                        <td>{ROW.dep_title}</td>
                        <td class="text-center"><strong>{ROW.total_emp}</strong></td>
                        <td class="text-center text-primary">{ROW.rank_excellent}</td>
                        <td class="text-center text-primary">{ROW.percent_excellent}</td>
                        <td class="text-center text-success">{ROW.rank_good}</td>
                        <td class="text-center text-success">{ROW.percent_good}</td>
                        <td class="text-center text-warning">{ROW.rank_average}</td>
                        <td class="text-center text-warning">{ROW.percent_average}</td>
                        <td class="text-center text-danger">{ROW.rank_poor}</td>
                        <td class="text-center text-danger">{ROW.percent_poor}</td>
                    </tr>
                    <!-- END: loop -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END: report -->

<!-- END: main -->
