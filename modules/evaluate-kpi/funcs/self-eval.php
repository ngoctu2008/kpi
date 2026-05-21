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

$page_title = $lang_module['self_eval'];

$period_id = $nv_Request->get_int('period_id', 'get,post', 0);
$error = '';

if ($period_id == 0) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_not_found']);
}

// 1. Get Period info
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_period')
    ->where('id=' . $period_id);
$period = $db_slave->query($db_slave->sql())->fetch();

if (!$period || $period['status'] == 0 || $period['lock_time'] < NV_CURRENTTIME) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_locked']);
}

// 2. Determine User Group Mapping (Employee vs Manager)
$db_slave->sqlreset()->select('*')->from(NV_PREFIXLANG . '_' . $module_data . '_config');
$res_config = $db_slave->query($db_slave->sql());
$array_config = [];
while ($row = $res_config->fetch()) {
    $array_config[$row['config_name']] = $row['config_value'];
}
$group_employee = isset($array_config['group_employee']) ? explode(',', $array_config['group_employee']) : [];
$group_manager = isset($array_config['group_manager']) ? explode(',', $array_config['group_manager']) : [];

$is_manager_group = false;
foreach ($user_info['in_groups'] as $g) {
    if (in_array($g, $group_manager)) {
        $is_manager_group = true;
        break;
    }
}
$group_type = $is_manager_group ? 2 : 1;

// 3. Get User Department
$department_id = 0;
$db_slave->sqlreset()
    ->select('department_id')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_users')
    ->where('userid = ' . $user_info['userid']);
$dep = $db_slave->query($db_slave->sql())->fetch();
if ($dep) {
    $department_id = $dep['department_id'];
}

// 4. Get Existing Record
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_records')
    ->where('userid=' . $user_info['userid'] . ' AND period_id=' . $period_id);
$record = $db_slave->query($db_slave->sql())->fetch();

if (!$record) {
    $record = [
        'record_id' => 0, 'status' => 0,
        'score_general_self' => 0,
        'kpi_a_self' => 100, 'kpi_b_self' => 100, 'kpi_c_self' => 100,
        'kpi_d_self' => 100, 'kpi_d2_self' => 100, 'kpi_e_self' => 100,
        'b_errors_self' => 0, 'c_errors_self' => 0,
        'score_kpi_self' => 0, 'total_score_self' => 0, 'rank_self' => ''
    ];
}

// Block submission if already sent
if ($record['status'] > 0 && $nv_Request->isset_request('submit', 'post')) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_permission']);
}

// 5. Handle Form Submit
if ($nv_Request->isset_request('submit', 'post') && $record['status'] == 0) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if ($checkss != NV_CHECK_SESSION) {
        die($lang_module['error_token']);
    }

    $score_general_self = $nv_Request->get_float('score_general_self', 'post', 0);
    $kpi_a_self = $nv_Request->get_float('kpi_a_self', 'post', 100);
    $kpi_b_self = $nv_Request->get_float('kpi_b_self', 'post', 100);
    $kpi_c_self = $nv_Request->get_float('kpi_c_self', 'post', 100);
    $b_errors_self = $nv_Request->get_int('b_errors_self', 'post', 0);
    $c_errors_self = $nv_Request->get_int('c_errors_self', 'post', 0);

    $kpi_d_self = 0; $kpi_d2_self = 0; $kpi_e_self = 0;
    if ($is_manager_group) {
        $kpi_d_self = $nv_Request->get_float('kpi_d_self', 'post', 100);
        $kpi_d2_self = $nv_Request->get_float('kpi_d2_self', 'post', 100);
        $kpi_e_self = $nv_Request->get_float('kpi_e_self', 'post', 100);
    }

    // Calculate penalties
    $b_final = nv_evaluate_kpi_calc_penalty($kpi_b_self, $b_errors_self);
    $c_final = nv_evaluate_kpi_calc_penalty($kpi_c_self, $c_errors_self);

    // Calculate KPI Score
    if ($is_manager_group) {
        $score_kpi_self = nv_evaluate_kpi_calc_manager($kpi_a_self, $b_final, $c_final, $kpi_d_self, $kpi_d2_self, $kpi_e_self);
    } else {
        $score_kpi_self = nv_evaluate_kpi_calc_employee($kpi_a_self, $b_final, $c_final);
    }

    $total_score_self = $score_general_self + $score_kpi_self;
    $rank_self = nv_evaluate_kpi_ranking($total_score_self, $kpi_a_self, $c_errors_self);

    // Is it Save Draft or Send?
    $status = $nv_Request->get_int('status_action', 'post', 0);

    if ($record['record_id'] > 0) {
        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_records SET group_type = :group_type, score_general_self = :score_general_self, kpi_a_self = :kpi_a_self, kpi_b_self = :kpi_b_self, kpi_c_self = :kpi_c_self, kpi_d_self = :kpi_d_self, kpi_d2_self = :kpi_d2_self, kpi_e_self = :kpi_e_self, b_errors_self = :b_errors_self, c_errors_self = :c_errors_self, score_kpi_self = :score_kpi_self, total_score_self = :total_score_self, rank_self = :rank_self, status = :status, edit_time = :edit_time WHERE record_id = :record_id AND userid = :userid');
        $sth->bindParam(':record_id', $record['record_id'], PDO::PARAM_INT);
        $sth->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
    } else {
        $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_records (userid, period_id, department_id, group_type, score_general_self, kpi_a_self, kpi_b_self, kpi_c_self, kpi_d_self, kpi_d2_self, kpi_e_self, b_errors_self, c_errors_self, score_kpi_self, total_score_self, rank_self, status, add_time, edit_time) VALUES (:userid, :period_id, :department_id, :group_type, :score_general_self, :kpi_a_self, :kpi_b_self, :kpi_c_self, :kpi_d_self, :kpi_d2_self, :kpi_e_self, :b_errors_self, :c_errors_self, :score_kpi_self, :total_score_self, :rank_self, :status, :add_time, :edit_time)');
        $sth->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
        $sth->bindParam(':period_id', $period_id, PDO::PARAM_INT);
        $sth->bindParam(':department_id', $department_id, PDO::PARAM_INT);
        $sth->bindValue(':add_time', NV_CURRENTTIME, PDO::PARAM_INT);
    }

    $sth->bindParam(':group_type', $group_type, PDO::PARAM_INT);
    $sth->bindParam(':score_general_self', $score_general_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_a_self', $kpi_a_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_b_self', $kpi_b_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_c_self', $kpi_c_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_d_self', $kpi_d_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_d2_self', $kpi_d2_self, PDO::PARAM_STR);
    $sth->bindParam(':kpi_e_self', $kpi_e_self, PDO::PARAM_STR);
    $sth->bindParam(':b_errors_self', $b_errors_self, PDO::PARAM_INT);
    $sth->bindParam(':c_errors_self', $c_errors_self, PDO::PARAM_INT);
    $sth->bindParam(':score_kpi_self', $score_kpi_self, PDO::PARAM_STR);
    $sth->bindParam(':total_score_self', $total_score_self, PDO::PARAM_STR);
    $sth->bindParam(':rank_self', $rank_self, PDO::PARAM_STR);
    $sth->bindParam(':status', $status, PDO::PARAM_INT);
    $sth->bindValue(':edit_time', NV_CURRENTTIME, PDO::PARAM_INT);

    if ($sth->execute()) {
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    } else {
        $error = $lang_module['error_save'];
    }
}

// 6. Output Data
$db_slave->sqlreset()->select('*')->from(NV_PREFIXLANG . '_' . $module_data . '_criteria')->order('weight ASC');
$result_cri = $db_slave->query($db_slave->sql());
$criteria_list = [];
while ($cri = $result_cri->fetch()) {
    $criteria_list[] = [
        'id' => $cri['id'],
        'title' => nv_htmlspecialchars($cri['title']),
        'description' => nv_htmlspecialchars($cri['description']),
        'max_score' => $cri['max_score']
    ];
}

$array_data = [
    'checkss' => NV_CHECK_SESSION,
    'period' => $period,
    'record' => $record,
    'criteria' => $criteria_list,
    'is_manager_group' => $is_manager_group,
    'error' => $error
];

$contents = nv_theme_evaluate_kpi_self_eval($array_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
