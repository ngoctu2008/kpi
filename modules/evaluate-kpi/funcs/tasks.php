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

$page_title = $lang_module['tasks'];

$period_id = $nv_Request->get_int('period_id', 'get,post', 0);
$id = $nv_Request->get_int('id', 'get,post', 0);
$error = '';

if ($period_id == 0) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_not_found']);
}

// Kiểm tra kỳ đánh giá còn mở không
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_period')
    ->where('id=' . $period_id);
$period = $db_slave->query($db_slave->sql())->fetch();

if (!$period || $period['status'] == 0 || $period['lock_time'] < NV_CURRENTTIME) {
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_module['error_locked']);
}

if ($nv_Request->isset_request('submit', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if (!nv_check_valid_token($checkss)) {
        die($lang_module['error_token']);
    }

    $row = [];
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['description'] = $nv_Request->get_string('description', 'post', '');
    $row['task_type'] = $nv_Request->get_int('task_type', 'post', 1);
    $row['frequency'] = $nv_Request->get_title('frequency', 'post', '');
    $row['output_expected'] = $nv_Request->get_string('output_expected', 'post', '');

    // Deadline
    $deadline = $nv_Request->get_string('deadline', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $deadline, $m)) {
        $row['deadline'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
    } else {
        $row['deadline'] = 0;
    }

    $row['status'] = $nv_Request->get_int('status', 'post', 0);
    $row['evidence_url'] = $nv_Request->get_string('evidence_url', 'post', '');

    if (empty($row['title'])) {
        $error = $lang_module['error_empty_title'] ?? 'Title is empty';
    } else {
        if ($id > 0) {
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tasks SET title = :title, description = :description, task_type = :task_type, frequency = :frequency, output_expected = :output_expected, deadline = :deadline, status = :status, evidence_url = :evidence_url WHERE id = :id AND userid = :userid');
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
        } else {
            $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tasks (userid, period_id, title, description, task_type, frequency, output_expected, deadline, status, evidence_url, add_time) VALUES (:userid, :period_id, :title, :description, :task_type, :frequency, :output_expected, :deadline, :status, :evidence_url, :add_time)');
            $sth->bindParam(':userid', $user_info['userid'], PDO::PARAM_INT);
            $sth->bindParam(':period_id', $period_id, PDO::PARAM_INT);
            $add_time = NV_CURRENTTIME;
            $sth->bindParam(':add_time', $add_time, PDO::PARAM_INT);
        }

        $sth->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $sth->bindParam(':description', $row['description'], PDO::PARAM_STR);
        $sth->bindParam(':task_type', $row['task_type'], PDO::PARAM_INT);
        $sth->bindParam(':frequency', $row['frequency'], PDO::PARAM_STR);
        $sth->bindParam(':output_expected', $row['output_expected'], PDO::PARAM_STR);
        $sth->bindParam(':deadline', $row['deadline'], PDO::PARAM_INT);
        $sth->bindParam(':status', $row['status'], PDO::PARAM_INT);
        $sth->bindParam(':evidence_url', $row['evidence_url'], PDO::PARAM_STR);

        if ($sth->execute()) {
            nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&period_id=' . $period_id);
        } else {
            $error = $lang_module['error_save'] ?? 'Error saving data';
        }
    }
} else {
    if ($id > 0) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_tasks')
            ->where('id=' . $id . ' AND userid=' . $user_info['userid']);
        $row = $db_slave->query($db_slave->sql())->fetch();
    } else {
        $row = ['id' => 0, 'title' => '', 'description' => '', 'task_type' => 1, 'frequency' => '', 'output_expected' => '', 'deadline' => NV_CURRENTTIME, 'status' => 0, 'evidence_url' => ''];
    }
}

if ($nv_Request->isset_request('delete', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if (!nv_check_valid_token($checkss)) {
        die('NO');
    }

    $del_id = $nv_Request->get_int('delete', 'post', 0);
    if ($del_id > 0) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tasks WHERE id=' . $del_id . ' AND userid=' . $user_info['userid']);
        die('OK');
    }
    die('NO');
}

// Prepare row for display
$row['title'] = nv_htmlspecialchars($row['title']);
$row['description'] = nv_htmlspecialchars($row['description']);
$row['frequency'] = nv_htmlspecialchars($row['frequency']);
$row['output_expected'] = nv_htmlspecialchars($row['output_expected']);
$row['evidence_url'] = nv_htmlspecialchars($row['evidence_url']);
$row['deadline_fmt'] = $row['deadline'] > 0 ? date('d/m/Y', $row['deadline']) : '';

// Get tasks list
$tasks = [];
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_tasks')
    ->where('userid=' . $user_info['userid'] . ' AND period_id=' . $period_id)
    ->order('id ASC');
$result = $db_slave->query($db_slave->sql());

while ($data = $result->fetch()) {
    $tasks[] = [
        'id' => $data['id'],
        'title' => nv_htmlspecialchars($data['title']),
        'type_text' => $data['task_type'] == 1 ? $lang_module['task_type_1'] : $lang_module['task_type_2'],
        'frequency' => nv_htmlspecialchars($data['frequency']),
        'output_expected' => nv_htmlspecialchars($data['output_expected']),
        'deadline' => $data['deadline'] > 0 ? date('d/m/Y', $data['deadline']) : '',
        'status_text' => $data['status'] == 1 ? '<span class="text-success">' . $lang_module['task_status_1'] . '</span>' : '<span class="text-danger">' . $lang_module['task_status_0'] . '</span>',
        'evidence_url' => nv_htmlspecialchars($data['evidence_url']),
        'link_edit' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;period_id=' . $period_id . '&amp;id=' . $data['id']
    ];
}

$array_data = [
    'action_url' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op,
    'period_id' => $period_id,
    'checkss' => NV_CHECK_SESSION,
    'row' => $row,
    'error' => $error,
    'tasks' => $tasks
];

$contents = nv_theme_evaluate_kpi_tasks($array_data);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
