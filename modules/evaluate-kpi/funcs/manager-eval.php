<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_IS_MOD_EVALUATE_KPI')) {
    die('Stop!!!');
}

if (!defined('NV_IS_USER')) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users');
}

$page_title = $lang_module['manager_eval'];
$period_id = $nv_Request->get_int('period_id', 'get', 0);
$record_id = $nv_Request->get_int('record_id', 'get,post', 0);
$error = '';

// Check if user is a manager of any department
$db_slave->sqlreset()
    ->select('id, title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_departments')
    ->where('manager_id=' . $user_info['userid']);
$my_departments = $db_slave->query($db_slave->sql())->fetchAll();

if (empty($my_departments)) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_permission']);
}

$dep_ids = array_column($my_departments, 'id');
$dep_ids_str = implode(',', $dep_ids);

if ($record_id > 0) {
    // MANAGER IS APPROVING A SPECIFIC RECORD
    $db_slave->sqlreset()
        ->select('r.*, u.first_name, u.last_name, p.title as period_title')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_records r')
        ->join('JOIN ' . NV_USERS_GLOBALTABLE . ' u ON r.userid = u.userid')
        ->join('JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_period p ON r.period_id = p.id')
        ->where('r.record_id=' . $record_id . ' AND r.department_id IN (' . $dep_ids_str . ')');
    $record = $db_slave->query($db_slave->sql())->fetch();

    if (!$record || $record['status'] == 0) {
        nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_not_found']);
    }

    if ($nv_Request->isset_request('submit_approve', 'post')) {
        $checkss = $nv_Request->get_string('checkss', 'post', '');
        if ($checkss != NV_CHECK_SESSION) {
            die($lang_module['error_token']);
        }

        $score_general_manager = $nv_Request->get_float('score_general_manager', 'post', $record['score_general_self']);
        $kpi_a_manager = $nv_Request->get_float('kpi_a_manager', 'post', $record['kpi_a_self']);
        $kpi_b_manager = $nv_Request->get_float('kpi_b_manager', 'post', $record['kpi_b_self']);
        $kpi_c_manager = $nv_Request->get_float('kpi_c_manager', 'post', $record['kpi_c_self']);
        $b_errors_manager = $nv_Request->get_int('b_errors_manager', 'post', $record['b_errors_self']);
        $c_errors_manager = $nv_Request->get_int('c_errors_manager', 'post', $record['c_errors_self']);

        $kpi_d_manager = $record['kpi_d_self'];
        $kpi_d2_manager = $record['kpi_d2_self'];
        $kpi_e_manager = $record['kpi_e_self'];

        if ($record['group_type'] == 2) {
            $kpi_d_manager = $nv_Request->get_float('kpi_d_manager', 'post', $record['kpi_d_self']);
            $kpi_d2_manager = $nv_Request->get_float('kpi_d2_manager', 'post', $record['kpi_d2_self']);
            $kpi_e_manager = $nv_Request->get_float('kpi_e_manager', 'post', $record['kpi_e_self']);
        }

        $manager_note = $nv_Request->get_string('manager_note', 'post', '');

        // Recalculate manager scores
        $b_final = nv_evaluate_kpi_calc_penalty($kpi_b_manager, $b_errors_manager);
        $c_final = nv_evaluate_kpi_calc_penalty($kpi_c_manager, $c_errors_manager);

        if ($record['group_type'] == 2) {
            $score_kpi_manager = nv_evaluate_kpi_calc_manager($kpi_a_manager, $b_final, $c_final, $kpi_d_manager, $kpi_d2_manager, $kpi_e_manager);
        } else {
            $score_kpi_manager = nv_evaluate_kpi_calc_employee($kpi_a_manager, $b_final, $c_final);
        }

        $total_score_manager = $score_general_manager + $score_kpi_manager;
        $final_rank = nv_evaluate_kpi_ranking($total_score_manager, $kpi_a_manager, $c_errors_manager);

        // Update DB
        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_records SET
            manager_id = :manager_id,
            score_general_manager = :score_general_manager,
            kpi_a_manager = :kpi_a_manager,
            kpi_b_manager = :kpi_b_manager,
            kpi_c_manager = :kpi_c_manager,
            kpi_d_manager = :kpi_d_manager,
            kpi_d2_manager = :kpi_d2_manager,
            kpi_e_manager = :kpi_e_manager,
            b_errors_manager = :b_errors_manager,
            c_errors_manager = :c_errors_manager,
            score_kpi_manager = :score_kpi_manager,
            total_score_manager = :total_score_manager,
            rank_manager = :rank_manager,
            manager_note = :manager_note,
            final_rank = :final_rank,
            status = 2,
            edit_time = :edit_time
            WHERE record_id = :record_id');

        $sth->bindParam(':manager_id', $user_info['userid'], PDO::PARAM_INT);
        $sth->bindParam(':score_general_manager', $score_general_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_a_manager', $kpi_a_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_b_manager', $kpi_b_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_c_manager', $kpi_c_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_d_manager', $kpi_d_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_d2_manager', $kpi_d2_manager, PDO::PARAM_STR);
        $sth->bindParam(':kpi_e_manager', $kpi_e_manager, PDO::PARAM_STR);
        $sth->bindParam(':b_errors_manager', $b_errors_manager, PDO::PARAM_INT);
        $sth->bindParam(':c_errors_manager', $c_errors_manager, PDO::PARAM_INT);
        $sth->bindParam(':score_kpi_manager', $score_kpi_manager, PDO::PARAM_STR);
        $sth->bindParam(':total_score_manager', $total_score_manager, PDO::PARAM_STR);
        $sth->bindParam(':rank_manager', $final_rank, PDO::PARAM_STR);
        $sth->bindParam(':manager_note', $manager_note, PDO::PARAM_STR);
        $sth->bindParam(':final_rank', $final_rank, PDO::PARAM_STR);
        $sth->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);
        $sth->bindParam(':record_id', $record_id, PDO::PARAM_INT);

        if ($sth->execute()) {
            nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        } else {
            $error = $lang_module['error_save'];
        }
    }

    // Set initial manager values if not yet set (First time opening)
    if ($record['status'] == 1) {
        $record['score_general_manager'] = $record['score_general_self'];
        $record['kpi_a_manager'] = $record['kpi_a_self'];
        $record['kpi_b_manager'] = $record['kpi_b_self'];
        $record['kpi_c_manager'] = $record['kpi_c_self'];
        $record['kpi_d_manager'] = $record['kpi_d_self'];
        $record['kpi_d2_manager'] = $record['kpi_d2_self'];
        $record['kpi_e_manager'] = $record['kpi_e_self'];
        $record['b_errors_manager'] = $record['b_errors_self'];
        $record['c_errors_manager'] = $record['c_errors_self'];
    }

    $record['full_name'] = nv_htmlspecialchars($record['first_name'] . ' ' . $record['last_name']);
    $record['period_title'] = nv_htmlspecialchars($record['period_title']);
    $record['manager_note'] = nv_htmlspecialchars($record['manager_note']);

    $array_data = [
        'is_approve_mode' => true,
        'record' => $record,
        'checkss' => NV_CHECK_SESSION, // using core feature
        'error' => $error
    ];

    $contents = nv_theme_evaluate_kpi_manager_eval($array_data);

} else {
    // MANAGER DASHBOARD: LIST EMPLOYEES
    $db_slave->sqlreset()
        ->select('r.*, u.first_name, u.last_name, p.title as period_title')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_records r')
        ->join('JOIN ' . NV_USERS_GLOBALTABLE . ' u ON r.userid = u.userid')
        ->join('JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_period p ON r.period_id = p.id')
        ->where('r.status IN (1,2) AND r.department_id IN (' . $dep_ids_str . ')')
        ->order('r.status ASC, r.edit_time DESC');
    $result = $db_slave->query($db_slave->sql());

    $records = [];
    while ($row = $result->fetch()) {
        $row['full_name'] = nv_htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
        $row['period_title'] = nv_htmlspecialchars($row['period_title']);
        $row['status_text'] = $row['status'] == 2 ? '<span class="label label-success">' . $lang_module['status_approved'] . '</span>' : '<span class="label label-warning">' . $lang_module['status_pending'] . '</span>';
        $row['link_approve'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;record_id=' . $row['record_id'];

        $records[] = $row;
    }

    $array_data = [
        'is_approve_mode' => false,
        'records' => $records
    ];

    $contents = nv_theme_evaluate_kpi_manager_eval($array_data);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
