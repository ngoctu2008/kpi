<!-- BEGIN: main -->
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Tổng quan hệ thống</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">{NUM_DEPARTMENTS}</span>
                        Phòng ban (Tổ chuyên môn)
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{NUM_PERIODS}</span>
                        Kỳ đánh giá đã khởi tạo
                    </li>
                    <li class="list-group-item">
                        <span class="badge">{NUM_TASKS}</span>
                        Sản phẩm công việc được ghi nhận
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading">Trạng thái Phiếu Đánh giá KPI</div>
            <div class="panel-body text-center">
                <div class="row">
                    <div class="col-sm-4">
                        <h2 class="text-muted">{NUM_RECORDS_DRAFT}</h2>
                        <p>Bản nháp (Đang tự đánh giá)</p>
                    </div>
                    <div class="col-sm-4">
                        <h2 class="text-warning">{NUM_RECORDS_PENDING}</h2>
                        <p>Chờ Quản lý duyệt</p>
                    </div>
                    <div class="col-sm-4">
                        <h2 class="text-success">{NUM_RECORDS_APPROVED}</h2>
                        <p>Đã duyệt & Chốt điểm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info">
    Để bắt đầu sử dụng, hãy chắc chắn bạn đã:
    <br>1. <strong>Cấu hình module</strong>: Mapping đúng Nhóm người dùng (Nhân viên, Quản lý).
    <br>2. <strong>Tạo phòng ban</strong>: Gắn đúng User ID của người Quản lý.
    <br>3. <strong>Mở kỳ đánh giá</strong>: Để nhân viên bắt đầu nộp báo cáo.
</div>
<!-- END: main -->
