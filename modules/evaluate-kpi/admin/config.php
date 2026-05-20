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

$page_title = $lang_module['config'];

// Get system user groups
$groups_list = nv_groups_list();

if ($nv_Request->isset_request('savesetting', 'post')) {
    $checkss = $nv_Request->get_string('checkss', 'post', '');
    if ($checkss != md5($global_config['sitekey'] . $nv_Request->session_id)) {
        die('Stop!!! CSRF Detected');
    }

    $group_employee = $nv_Request->get_array('group_employee', 'post', []);
    $group_manager = $nv_Request->get_array('group_manager', 'post', []);

    $config_employee = implode(',', array_map('intval', $group_employee));
    $config_manager = implode(',', array_map('intval', $group_manager));

    $sth = $db->prepare('REPLACE INTO ' . NV_PREFIXLANG . '_' . $module_data . '_config (config_name, config_value) VALUES (:config_name, :config_value)');

    $sth->bindValue(':config_name', 'group_employee');
    $sth->bindValue(':config_value', $config_employee);
    $sth->execute();

    $sth->bindValue(':config_name', 'group_manager');
    $sth->bindValue(':config_value', $config_manager);
    $sth->execute();

    $nv_Cache->delMod($module_name);
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
}

$xtpl = new XTemplate('config.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->assign('CHECKSS', md5($global_config['sitekey'] . $nv_Request->session_id));

// Get current config
$db_slave->sqlreset()
    ->select('config_name, config_value')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_config');
$result = $db_slave->query($db_slave->sql());

$array_config = [];
while ($row = $result->fetch()) {
    $array_config[$row['config_name']] = $row['config_value'];
}

$curr_group_employee = isset($array_config['group_employee']) ? explode(',', $array_config['group_employee']) : [];
$curr_group_manager = isset($array_config['group_manager']) ? explode(',', $array_config['group_manager']) : [];

foreach ($groups_list as $group_id => $group_title) {
    $xtpl->assign('GROUP', [
        'id' => $group_id,
        'title' => nv_htmlspecialchars($group_title),
        'checked_emp' => in_array($group_id, $curr_group_employee) ? ' checked="checked"' : '',
        'checked_man' => in_array($group_id, $curr_group_manager) ? ' checked="checked"' : '',
    ]);
    $xtpl->parse('main.group_emp');
    $xtpl->parse('main.group_man');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
