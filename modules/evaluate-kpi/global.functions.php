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

/**
 * Tính điểm KPI cho viên chức không giữ chức vụ quản lý (Nhóm 1, 2, 3)
 * Công thức: ((a + b + c) / 3) * 70% (a, b, c là thang điểm 100)
 *
 * @param float $a Số lượng
 * @param float $b Chất lượng
 * @param float $c Tiến độ
 * @return float
 */
function nv_evaluate_kpi_calc_employee($a, $b, $c) {
    return round((($a + $b + $c) / 3) * 0.70, 2);
}

/**
 * Tính điểm KPI cho viên chức giữ chức vụ quản lý (Nhóm 4)
 * Công thức: ((a + b + c + d + d2 + e) / 6) * 70%
 *
 * @param float $a Số lượng
 * @param float $b Chất lượng
 * @param float $c Tiến độ
 * @param float $d Tổ chức điều hành
 * @param float $d2 Đoàn kết nội bộ (đ)
 * @param float $e Đổi mới sáng tạo
 * @return float
 */
function nv_evaluate_kpi_calc_manager($a, $b, $c, $d, $d2, $e) {
    return round((($a + $b + $c + $d + $d2 + $e) / 6) * 0.70, 2);
}

/**
 * Tính điểm KPI bị phạt
 * Nếu có lỗi b giảm 25% cho mỗi lỗi. Nếu chậm tiến độ c giảm 25% cho mỗi lỗi.
 *
 * @param float $score Điểm gốc (b hoặc c)
 * @param int $errors Số lượng lỗi
 * @return float Điểm sau khi phạt
 */
function nv_evaluate_kpi_calc_penalty($score, $errors) {
    if ($errors > 0) {
        $penalty = $score * (0.25 * $errors);
        $score -= $penalty;
        if ($score < 0) {
            $score = 0;
        }
    }
    return $score;
}

/**
 * Xếp loại chất lượng dựa trên tổng điểm và điều kiện
 *
 * @param float $total_score Tổng điểm cuối cùng (Tiêu chí chung + KPI)
 * @param float $kpi_a Điểm tiêu chí $a
 * @param int $c_errors Số lỗi trễ hạn
 * @return string Xếp loại (1: Hoàn thành xuất sắc, 2: Hoàn thành tốt, 3: Hoàn thành, 4: Không hoàn thành)
 */
function nv_evaluate_kpi_ranking($total_score, $kpi_a, $c_errors) {
    if ($total_score >= 90 && $kpi_a == 100 && $c_errors == 0) {
        return 'EXCELLENT'; // Hoàn thành xuất sắc nhiệm vụ
    } elseif ($total_score >= 70) {
        return 'GOOD'; // Hoàn thành tốt nhiệm vụ
    } elseif ($total_score >= 50) {
        return 'AVERAGE'; // Hoàn thành nhiệm vụ
    } else {
        return 'POOR'; // Không hoàn thành nhiệm vụ
    }
}
