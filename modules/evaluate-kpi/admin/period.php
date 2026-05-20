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

$page_title = $lang_module['period'];

$id = $nv_Request->get_int('id', 'get,post', 0);
$error = '';

if ($nv_Request->isset_request('submit', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if (!nv_check_valid_token($checkss)) {
        die('Stop!!! CSRF Detected');
    }

    $row = [];
    $row['title'] = $nv_Request->get_title('title', 'post', '');

    // NukeViet stores dates natively as unix timestamps. Using preg_match to convert from DD/MM/YYYY
    $start_time = $nv_Request->get_string('start_time', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $start_time, $m)) {
        $row['start_time'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
    } else {
        $row['start_time'] = 0;
    }

    $end_time = $nv_Request->get_string('end_time', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $end_time, $m)) {
        $row['end_time'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
    } else {
        $row['end_time'] = 0;
    }

    $lock_time = $nv_Request->get_string('lock_time', 'post', '');
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $lock_time, $m)) {
        $row['lock_time'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
    } else {
        $row['lock_time'] = 0;
    }

    $row['status'] = $nv_Request->get_int('status', 'post', 1);

    if (empty($row['title'])) {
        $error = $lang_module['error_empty_title'];
    } else {
        if ($id > 0) {
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_period SET title = :title, start_time = :start_time, end_time = :end_time, lock_time = :lock_time, status = :status WHERE id = :id');
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_period (title, start_time, end_time, lock_time, status) VALUES (:title, :start_time, :end_time, :lock_time, :status)');
        }

        $sth->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $sth->bindParam(':start_time', $row['start_time'], PDO::PARAM_INT);
        $sth->bindParam(':end_time', $row['end_time'], PDO::PARAM_INT);
        $sth->bindParam(':lock_time', $row['lock_time'], PDO::PARAM_INT);
        $sth->bindParam(':status', $row['status'], PDO::PARAM_INT);

        if ($sth->execute()) {
            nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        } else {
            $error = $lang_module['error_save'];
        }
    }
} else {
    if ($id > 0) {
        $db_slave->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_period')
            ->where('id=' . $id);
        $row = $db_slave->query($db_slave->sql())->fetch();
    } else {
        $row = ['id' => 0, 'title' => '', 'start_time' => NV_CURRENTTIME, 'end_time' => NV_CURRENTTIME + 86400 * 30, 'lock_time' => NV_CURRENTTIME + 86400 * 35, 'status' => 1];
    }
}

if ($nv_Request->isset_request('delete', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if (!nv_check_valid_token($checkss)) {
        die('NO');
    }

    $del_id = $nv_Request->get_int('delete', 'post', 0);
    if ($del_id > 0) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_period WHERE id=' . $del_id);
        die('OK');
    }
    die('NO');
}

$xtpl = new XTemplate('period.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$row['title'] = nv_htmlspecialchars($row['title']);
$row['start_time_fmt'] = $row['start_time'] > 0 ? date('d/m/Y', $row['start_time']) : '';
$row['end_time_fmt'] = $row['end_time'] > 0 ? date('d/m/Y', $row['end_time']) : '';
$row['lock_time_fmt'] = $row['lock_time'] > 0 ? date('d/m/Y', $row['lock_time']) : '';
$xtpl->assign('ROW', $row);

$xtpl->assign('CHECKSS', NV_CHECK_SESSION);

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

// List
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_period')
    ->order('id DESC');
$result = $db_slave->query($db_slave->sql());

while ($data = $result->fetch()) {
    $data['status_text'] = $data['status'] ? $lang_module['status_1'] : $lang_module['status_0'];
    $data['title'] = nv_htmlspecialchars($data['title']);
    $data['start_time'] = $data['start_time'] > 0 ? date('d/m/Y', $data['start_time']) : '';
    $data['end_time'] = $data['end_time'] > 0 ? date('d/m/Y', $data['end_time']) : '';
    $data['lock_time'] = $data['lock_time'] > 0 ? date('d/m/Y', $data['lock_time']) : '';
    $xtpl->assign('DATA', $data);
    $xtpl->parse('main.list.loop');
}
if ($result->rowCount() > 0) {
    $xtpl->parse('main.list');
}

$xtpl->assign('CHECKED_STATUS_1', $row['status'] == 1 ? 'checked="checked"' : '');
$xtpl->assign('CHECKED_STATUS_0', $row['status'] == 0 ? 'checked="checked"' : '');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
