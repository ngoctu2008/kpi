<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC (contact@vinades.vn)';
$lang_translator['createdate'] = '23/10/2024, 08:00';
$lang_translator['copyright'] = '@Copyright (C) 2024 VINADES.,JSC All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main'] = 'Trang chính';
$lang_module['config'] = 'Cấu hình module';
$lang_module['departments'] = 'Quản lý Phòng/Ban (Tổ)';
$lang_module['period'] = 'Quản lý Kỳ đánh giá';
$lang_module['criteria'] = 'Tiêu chí đánh giá chung';
$lang_module['reports'] = 'Báo cáo thống kê';

$lang_module['save'] = 'Lưu thay đổi';
$lang_module['add'] = 'Thêm mới';
$lang_module['edit'] = 'Sửa';
$lang_module['delete'] = 'Xóa';
$lang_module['action'] = 'Thao tác';
$lang_module['title'] = 'Tiêu đề';
$lang_module['status'] = 'Trạng thái';
$lang_module['status_1'] = 'Hoạt động';
$lang_module['status_0'] = 'Đình chỉ';

$lang_module['department_add'] = 'Thêm phòng ban';
$lang_module['department_manager'] = 'Người quản lý (Duyệt KPI)';
$lang_module['department_manager_note'] = 'Nhập tài khoản hoặc ID của quản lý';
$lang_module['department_description'] = 'Mô tả';
$lang_module['department_users'] = 'Danh sách UserID nhân viên';
$lang_module['department_users_note'] = 'Nhập các User ID cách nhau bởi dấu phẩy (,). VD: 15,22,35';

$lang_module['config_group_employee'] = 'Nhóm Nhân viên (Nhóm 1, 2, 3)';
$lang_module['config_group_manager'] = 'Nhóm Quản lý (Nhóm 4)';
$lang_module['config_mapping_note'] = 'Chọn các nhóm người dùng trên hệ thống để ánh xạ vào công thức tính KPI';

$lang_module['error_empty_title'] = 'Lỗi: Chưa nhập tiêu đề!';
$lang_module['error_save'] = 'Lỗi: Hệ thống không thể lưu dữ liệu!';
$lang_module['save_success'] = 'Thực hiện thành công!';

$lang_module['report_filter'] = 'Lọc báo cáo thống kê (Mẫu 03, 04, 05)';
$lang_module['report_choose_period'] = 'Chọn kỳ đánh giá:';
$lang_module['report_view_online'] = 'Xem báo cáo trực tuyến';
$lang_module['report_export_excel'] = 'Xuất Excel';
$lang_module['report_choose'] = '--- Chọn ---';
$lang_module['report_title_03'] = 'Biểu tổng hợp kết quả (Mẫu 03)';
$lang_module['report_col_stt'] = 'STT';
$lang_module['report_col_dep'] = 'Đơn vị (Tổ/Phòng ban)';
$lang_module['report_col_total'] = 'Tổng số LĐ';
$lang_module['report_col_excellent'] = 'Hoàn thành Xuất sắc';
$lang_module['report_col_good'] = 'Hoàn thành Tốt';
$lang_module['report_col_average'] = 'Hoàn thành';
$lang_module['report_col_poor'] = 'Không hoàn thành';
$lang_module['report_col_sl'] = 'SL';

$lang_module['dash_overview'] = 'Tổng quan hệ thống';
$lang_module['dash_departments'] = 'Phòng ban (Tổ chuyên môn)';
$lang_module['dash_periods'] = 'Kỳ đánh giá đã khởi tạo';
$lang_module['dash_tasks'] = 'Sản phẩm công việc được ghi nhận';
$lang_module['dash_status_title'] = 'Trạng thái Phiếu Đánh giá KPI';
$lang_module['dash_draft'] = 'Bản nháp (Đang tự đánh giá)';
$lang_module['dash_pending'] = 'Chờ Quản lý duyệt';
$lang_module['dash_approved'] = 'Đã duyệt & Chốt điểm';
$lang_module['dash_instruction_1'] = 'Để bắt đầu sử dụng, hãy chắc chắn bạn đã:';
$lang_module['dash_instruction_2'] = 'Cấu hình module: Mapping đúng Nhóm người dùng (Nhân viên, Quản lý).';
$lang_module['dash_instruction_3'] = 'Tạo phòng ban: Gắn đúng User ID của người Quản lý.';
$lang_module['dash_instruction_4'] = 'Mở kỳ đánh giá: Để nhân viên bắt đầu nộp báo cáo.';

$lang_module['period_start'] = 'Bắt đầu';
$lang_module['period_end'] = 'Kết thúc';
$lang_module['period_lock'] = 'Hạn chót (Lock form)';
$lang_module['period_ph'] = 'VD: Đánh giá KPI Tháng 01/2024';

$lang_module['cri_max_score'] = 'Điểm tối đa';
$lang_module['cri_stt'] = 'STT';
$lang_module['cri_total'] = 'TỔNG CỘNG:';
$lang_module['cri_notice'] = 'Vui lòng thiết lập các tiêu chí sao cho tổng điểm tối đa bằng 30.';
$lang_module['cri_desc'] = 'Mô tả chi tiết';
$lang_module['cri_desc_ph'] = 'Ghi chú thêm về tiêu chí để người dùng dễ đánh giá';
