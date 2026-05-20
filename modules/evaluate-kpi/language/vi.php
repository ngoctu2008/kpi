<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC (contact@vinades.vn)';
$lang_translator['createdate'] = '23/10/2024, 08:00';
$lang_translator['copyright'] = '@Copyright (C) 2024 VINADES.,JSC All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main'] = 'Trang chủ KPI';
$lang_module['tasks'] = 'Sản phẩm công việc';
$lang_module['self_eval'] = 'Tự đánh giá';
$lang_module['manager_eval'] = 'Duyệt đánh giá';

$lang_module['add'] = 'Thêm mới';
$lang_module['edit'] = 'Sửa';
$lang_module['delete'] = 'Xóa';
$lang_module['save'] = 'Lưu dữ liệu';
$lang_module['send_approve'] = 'Gửi duyệt';
$lang_module['cancel'] = 'Hủy bỏ';
$lang_module['action'] = 'Thao tác';

// Main dashboard
$lang_module['welcome'] = 'Xin chào';
$lang_module['your_department'] = 'Phòng ban / Tổ';
$lang_module['your_manager'] = 'Người duyệt KPI của bạn';
$lang_module['recent_periods'] = 'Các kỳ đánh giá gần đây';
$lang_module['period_title'] = 'Kỳ đánh giá';
$lang_module['status'] = 'Trạng thái';
$lang_module['status_draft'] = 'Đang nháp';
$lang_module['status_pending'] = 'Chờ duyệt';
$lang_module['status_approved'] = 'Đã chốt';
$lang_module['score_self'] = 'Điểm tự chấm';
$lang_module['score_manager'] = 'Điểm quản lý chấm';

// Tasks
$lang_module['task_title'] = 'Tên sản phẩm / Công việc';
$lang_module['task_desc'] = 'Mô tả nội dung';
$lang_module['task_type'] = 'Loại công việc';
$lang_module['task_type_1'] = 'Thường xuyên';
$lang_module['task_type_2'] = 'Đột xuất';
$lang_module['task_freq'] = 'Tần suất';
$lang_module['task_output'] = 'Đầu ra mong đợi';
$lang_module['task_deadline'] = 'Hạn chót';
$lang_module['task_status'] = 'Trạng thái HT';
$lang_module['task_status_0'] = 'Chưa hoàn thành';
$lang_module['task_status_1'] = 'Hoàn thành';
$lang_module['task_evidence'] = 'Link minh chứng';
$lang_module['task_empty'] = 'Bạn chưa khai báo công việc nào trong kỳ này.';
$lang_module['task_add_success'] = 'Thêm công việc thành công!';

// Self Eval
$lang_module['eval_criteria'] = 'Tiêu chí chung (30 điểm)';
$lang_module['eval_kpi'] = 'Đánh giá KPI (70 điểm)';
$lang_module['eval_note'] = 'Lưu ý';
$lang_module['eval_max_score'] = 'Điểm tối đa';
$lang_module['eval_your_score'] = 'Điểm của bạn';
$lang_module['eval_kpi_a'] = 'a. Khối lượng / Số lượng (0-100%)';
$lang_module['eval_kpi_b'] = 'b. Chất lượng công việc (0-100%)';
$lang_module['eval_kpi_c'] = 'c. Tiến độ (0-100%)';
$lang_module['eval_kpi_d'] = 'd. Tổ chức điều hành (0-100%)';
$lang_module['eval_kpi_d2'] = 'đ. Xây dựng đoàn kết nội bộ (0-100%)';
$lang_module['eval_kpi_e'] = 'e. Đổi mới sáng tạo (0-100%)';
$lang_module['eval_error_b'] = 'Số lần bị phạt (Chất lượng)';
$lang_module['eval_error_c'] = 'Số lần bị phạt (Tiến độ)';
$lang_module['eval_confirm_send'] = 'Bạn có chắc chắn muốn GỬI DUYỆT? Sau khi gửi sẽ không thể sửa đổi!';

// Manager Eval
$lang_module['manager_list_emp'] = 'Danh sách nhân viên chờ duyệt';
$lang_module['manager_emp_name'] = 'Tên nhân viên';
$lang_module['manager_note'] = 'Ý kiến của Quản lý';
$lang_module['manager_approve'] = 'Chốt điểm & Phân loại';

$lang_module['locked_notice'] = 'Kỳ đánh giá này đã được khóa hoặc bạn đã gửi phiếu đánh giá cho Quản lý. Không thể chỉnh sửa thêm.';
$lang_module['total_score_general'] = 'Tổng điểm tiêu chí chung (Max 30)';
$lang_module['kpi_criteria'] = 'Tiêu chí KPI';
$lang_module['kpi_percent'] = '% Hoàn thành';
$lang_module['kpi_note'] = 'Ghi chú / Phạt';
$lang_module['save_draft'] = 'Lưu bản nháp';
$lang_module['self_score'] = 'NV Tự chấm';
$lang_module['manager_score'] = 'Quản lý duyệt';
$lang_module['total_result'] = 'Tổng hợp kết quả & Xếp loại';
$lang_module['total_point'] = 'TỔNG ĐIỂM (100)';
$lang_module['rank_level'] = 'Mức xếp loại';
$lang_module['manager_confirm_approve'] = 'Bạn có chắc chắn chốt điểm đánh giá này?';

$lang_module['error_no_period'] = 'Hiện tại không có kỳ đánh giá nào đang mở.';
$lang_module['error_locked'] = 'Kỳ đánh giá này đã khóa, bạn không thể thao tác.';
$lang_module['error_not_found'] = 'Không tìm thấy dữ liệu.';
$lang_module['error_permission'] = 'Bạn không có quyền thực hiện thao tác này.';
$lang_module['error_token'] = 'Lỗi bảo mật (Token không hợp lệ). Vui lòng tải lại trang.';
