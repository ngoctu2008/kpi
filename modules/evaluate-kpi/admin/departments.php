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

$page_title = $lang_module['departments'];

$id = $nv_Request->get_int('id', 'get,post', 0);
$error = '';

if ($nv_Request->isset_request('submit', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if ($checkss != md5($global_config['sitekey'] . $nv_Request->session_id)) {
        die('Stop!!! CSRF Detected');
    }

    $row = [];
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['manager_id'] = $nv_Request->get_int('manager_id', 'post', 0);
    $row['description'] = $nv_Request->get_string('description', 'post', '');
    $row['status'] = $nv_Request->get_int('status', 'post', 1);

    if (empty($row['title'])) {
        $error = $lang_module['error_empty_title'];
    } else {
        if ($id > 0) {
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_departments SET title = :title, manager_id = :manager_id, description = :description, status = :status WHERE id = :id');
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
        } else {
            $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_departments (title, manager_id, description, status) VALUES (:title, :manager_id, :description, :status)');
        }

        $sth->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $sth->bindParam(':manager_id', $row['manager_id'], PDO::PARAM_INT);
        $sth->bindParam(':description', $row['description'], PDO::PARAM_STR);
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
            ->from(NV_PREFIXLANG . '_' . $module_data . '_departments')
            ->where('id=' . $id);
        $row = $db_slave->query($db_slave->sql())->fetch();
    } else {
        $row = ['id' => 0, 'title' => '', 'manager_id' => 0, 'description' => '', 'status' => 1];
    }
}

if ($nv_Request->isset_request('delete', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if ($checkss != md5($global_config['sitekey'] . $nv_Request->session_id)) {
        die('NO');
    }

    $del_id = $nv_Request->get_int('delete', 'post', 0);
    if ($del_id > 0) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_departments WHERE id=' . $del_id);
        die('OK');
    }
    die('NO');
}

$xtpl = new XTemplate('departments.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$row['title'] = nv_htmlspecialchars($row['title']);
$row['description'] = nv_htmlspecialchars($row['description']);
$xtpl->assign('ROW', $row);

$xtpl->assign('CHECKSS', md5($global_config['sitekey'] . $nv_Request->session_id));

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

// List
$db_slave->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_departments')
    ->order('id DESC');
$result = $db_slave->query($db_slave->sql());

while ($data = $result->fetch()) {
    $data['status_text'] = $data['status'] ? $lang_module['status_1'] : $lang_module['status_0'];
    $data['title'] = nv_htmlspecialchars($data['title']);
    $data['description'] = nv_htmlspecialchars($data['description']);
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
