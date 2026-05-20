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

$page_title = $lang_module['main'];

// Lấy thông tin user
$user_info_arr = [
    'userid' => $user_info['userid'],
    'full_name' => $user_info['first_name'] . ' ' . $user_info['last_name'],
];

// Lấy phòng ban của user. Dựa vào bảng users_departments
$db_slave->sqlreset()
    ->select('d.*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_users u')
    ->join('JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_departments d ON u.department_id = d.id')
    ->where('u.userid = ' . $user_info['userid']);
$department = $db_slave->query($db_slave->sql())->fetch();

if ($department) {
    // Tên sếp
    $manager_name = '';
    if ($department['manager_id'] > 0) {
        $db_slave->sqlreset()
            ->select('first_name, last_name')
            ->from(NV_USERS_GLOBALTABLE)
            ->where('userid=' . $department['manager_id']);
        $mgr = $db_slave->query($db_slave->sql())->fetch();
        if ($mgr) {
            $manager_name = trim($mgr['first_name'] . ' ' . $mgr['last_name']);
        }
    }

    $department_arr = [
        'title' => nv_htmlspecialchars($department['title']),
        'manager_name' => nv_htmlspecialchars($manager_name),
    ];
} else {
    $department_arr = [
        'title' => 'N/A',
        'manager_name' => 'N/A',
    ];
}

// Lấy danh sách các kỳ đánh giá gần đây
$periods = [];
$db_slave->sqlreset()
    ->select('p.*, r.status as record_status, r.total_score_self, r.total_score_manager')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_period p')
    ->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_records r ON p.id = r.period_id AND r.userid = ' . $user_info['userid'])
    ->order('p.id DESC')
    ->limit(10);
$result = $db_slave->query($db_slave->sql());

while ($row = $result->fetch()) {
    $status_text = '';
    if ($row['record_status'] === '0' || $row['record_status'] === null) {
        $status_text = '<span class="label label-default">' . $lang_module['status_draft'] . '</span>';
    } elseif ($row['record_status'] == '1') {
        $status_text = '<span class="label label-warning">' . $lang_module['status_pending'] . '</span>';
    } elseif ($row['record_status'] == '2') {
        $status_text = '<span class="label label-success">' . $lang_module['status_approved'] . '</span>';
    }

    $periods[] = [
        'id' => $row['id'],
        'title' => nv_htmlspecialchars($row['title']),
        'status_text' => $status_text,
        'score_self' => $row['total_score_self'] ?: '0',
        'score_manager' => $row['total_score_manager'] ?: '---',
        'link_tasks' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tasks&amp;period_id=' . $row['id'],
        'link_eval' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=self-eval&amp;period_id=' . $row['id'],
    ];
}

$array_data = [
    'user_info' => $user_info_arr,
    'department' => $department_arr,
    'periods' => $periods,
];

$contents = nv_theme_evaluate_kpi_main($array_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
