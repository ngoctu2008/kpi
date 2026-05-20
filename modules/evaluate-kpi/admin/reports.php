<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['reports'];

$period_id = $nv_Request->get_int('period_id', 'get,post', 0);

if ($nv_Request->isset_request('export_excel', 'post')) {
    if ($period_id > 0) {
        // Prepare data query
        $db_slave->sqlreset()
            ->select('d.title as dep_title,
                COUNT(r.record_id) as total_emp,
                SUM(CASE WHEN r.final_rank = "EXCELLENT" THEN 1 ELSE 0 END) as rank_excellent,
                SUM(CASE WHEN r.final_rank = "GOOD" THEN 1 ELSE 0 END) as rank_good,
                SUM(CASE WHEN r.final_rank = "AVERAGE" THEN 1 ELSE 0 END) as rank_average,
                SUM(CASE WHEN r.final_rank = "POOR" THEN 1 ELSE 0 END) as rank_poor')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_departments d')
            ->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_records r ON d.id = r.department_id AND r.period_id = ' . $period_id . ' AND r.status = 2')
            ->group('d.id')
            ->order('d.id ASC');
        $result = $db_slave->query($db_slave->sql());

        // Check if PhpSpreadsheet is loaded
        $autoload_path = NV_ROOTDIR . '/vendor/autoload.php';
        if (file_exists($autoload_path)) {
            require_once $autoload_path;

            if (class_exists('\PhpOffice\PhpSpreadsheet\Spreadsheet')) {
                $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // Merge cells for header
                $sheet->mergeCells('A1:A2');
                $sheet->setCellValue('A1', 'STT');

                $sheet->mergeCells('B1:B2');
                $sheet->setCellValue('B1', 'Đơn vị (Tổ/Phòng ban)');

                $sheet->mergeCells('C1:C2');
                $sheet->setCellValue('C1', 'Tổng số LĐ');

                $sheet->mergeCells('D1:E1');
                $sheet->setCellValue('D1', 'Hoàn thành Xuất sắc');
                $sheet->setCellValue('D2', 'SL');
                $sheet->setCellValue('E2', '%');

                $sheet->mergeCells('F1:G1');
                $sheet->setCellValue('F1', 'Hoàn thành Tốt');
                $sheet->setCellValue('F2', 'SL');
                $sheet->setCellValue('G2', '%');

                $sheet->mergeCells('H1:I1');
                $sheet->setCellValue('H1', 'Hoàn thành');
                $sheet->setCellValue('H2', 'SL');
                $sheet->setCellValue('I2', '%');

                $sheet->mergeCells('J1:K1');
                $sheet->setCellValue('J1', 'Không hoàn thành');
                $sheet->setCellValue('J2', 'SL');
                $sheet->setCellValue('K2', '%');

                // Add data
                $rowNum = 3;
                $stt = 1;
                while ($row = $result->fetch()) {
                    $total = intval($row['total_emp']);
                    $percent_excellent = $total > 0 ? round(($row['rank_excellent'] / $total) * 100, 2) : 0;
                    $percent_good = $total > 0 ? round(($row['rank_good'] / $total) * 100, 2) : 0;
                    $percent_average = $total > 0 ? round(($row['rank_average'] / $total) * 100, 2) : 0;
                    $percent_poor = $total > 0 ? round(($row['rank_poor'] / $total) * 100, 2) : 0;

                    $sheet->setCellValue('A' . $rowNum, $stt++);
                    $sheet->setCellValue('B' . $rowNum, $row['dep_title']);
                    $sheet->setCellValue('C' . $rowNum, $total);
                    $sheet->setCellValue('D' . $rowNum, $row['rank_excellent']);
                    $sheet->setCellValue('E' . $rowNum, $percent_excellent . '%');
                    $sheet->setCellValue('F' . $rowNum, $row['rank_good']);
                    $sheet->setCellValue('G' . $rowNum, $percent_good . '%');
                    $sheet->setCellValue('H' . $rowNum, $row['rank_average']);
                    $sheet->setCellValue('I' . $rowNum, $percent_average . '%');
                    $sheet->setCellValue('J' . $rowNum, $row['rank_poor']);
                    $sheet->setCellValue('K' . $rowNum, $percent_poor . '%');

                    $rowNum++;
                }

                $filename = "Bao_cao_KPI_" . date('Ymd_His') . ".xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="' . $filename . '"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer->save('php://output');
                exit();
            }
        }

        // Fallback to CSV if library is missing
        $filename = "Bao_cao_KPI_" . date('Ymd_His') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF"); // UTF-8 BOM

        fputcsv($output, ['STT', 'Đơn vị (Tổ/Phòng ban)', 'Tổng số LĐ', 'Hoàn thành Xuất sắc (SL)', 'Hoàn thành Xuất sắc (%)', 'Hoàn thành Tốt (SL)', 'Hoàn thành Tốt (%)', 'Hoàn thành (SL)', 'Hoàn thành (%)', 'Không hoàn thành (SL)', 'Không hoàn thành (%)']);

        $stt = 1;
        while ($row = $result->fetch()) {
            $total = intval($row['total_emp']);
            $percent_excellent = $total > 0 ? round(($row['rank_excellent'] / $total) * 100, 2) . '%' : '0%';
            $percent_good = $total > 0 ? round(($row['rank_good'] / $total) * 100, 2) . '%' : '0%';
            $percent_average = $total > 0 ? round(($row['rank_average'] / $total) * 100, 2) . '%' : '0%';
            $percent_poor = $total > 0 ? round(($row['rank_poor'] / $total) * 100, 2) . '%' : '0%';

            fputcsv($output, [
                $stt++,
                $row['dep_title'],
                $row['total_emp'],
                $row['rank_excellent'],
                $percent_excellent,
                $row['rank_good'],
                $percent_good,
                $row['rank_average'],
                $percent_average,
                $row['rank_poor'],
                $percent_poor
            ]);
        }
        fclose($output);
        exit();
    }
}

$xtpl = new XTemplate('reports.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('PERIOD_ID', $period_id);

// Get periods
$sql_period = 'SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_period ORDER BY id DESC';
$result_period = $db->query($sql_period);
while ($row = $result_period->fetch()) {
    $row['selected'] = ($row['id'] == $period_id) ? 'selected="selected"' : '';
    $xtpl->assign('PERIOD', $row);
    $xtpl->parse('main.period');
}

if ($period_id > 0) {
    // Thống kê Mẫu 03 (Theo phòng ban và Xếp loại)
    // Hoàn thành xuất sắc: EXCELLENT
    // Hoàn thành tốt: GOOD
    // Hoàn thành: AVERAGE
    // Không hoàn thành: POOR

    $sql = 'SELECT d.title as dep_title,
            COUNT(r.record_id) as total_emp,
            SUM(CASE WHEN r.final_rank = "EXCELLENT" THEN 1 ELSE 0 END) as rank_excellent,
            SUM(CASE WHEN r.final_rank = "GOOD" THEN 1 ELSE 0 END) as rank_good,
            SUM(CASE WHEN r.final_rank = "AVERAGE" THEN 1 ELSE 0 END) as rank_average,
            SUM(CASE WHEN r.final_rank = "POOR" THEN 1 ELSE 0 END) as rank_poor
            FROM ' . NV_PREFIXLANG . '_' . $module_data . '_departments d
            LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_records r ON d.id = r.department_id AND r.period_id = ' . $period_id . ' AND r.status = 2
            GROUP BY d.id
            ORDER BY d.id ASC';

    $result = $db->query($sql);
    $stt = 1;
    while ($row = $result->fetch()) {
        $row['stt'] = $stt++;

        // Calculate percentages
        $total = intval($row['total_emp']);
        $row['percent_excellent'] = $total > 0 ? round(($row['rank_excellent'] / $total) * 100, 2) . '%' : '0%';
        $row['percent_good'] = $total > 0 ? round(($row['rank_good'] / $total) * 100, 2) . '%' : '0%';
        $row['percent_average'] = $total > 0 ? round(($row['rank_average'] / $total) * 100, 2) . '%' : '0%';
        $row['percent_poor'] = $total > 0 ? round(($row['rank_poor'] / $total) * 100, 2) . '%' : '0%';

        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.report.loop');
    }
    $xtpl->parse('main.report');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
