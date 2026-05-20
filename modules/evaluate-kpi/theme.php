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

/**
 * Hiển thị trang chủ dashboard cá nhân
 */
function nv_theme_evaluate_kpi_main($array_data) {
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);

    $xtpl->assign('USER_INFO', $array_data['user_info']);
    $xtpl->assign('DEPARTMENT', $array_data['department']);

    if (!empty($array_data['periods'])) {
        foreach ($array_data['periods'] as $period) {
            $xtpl->assign('PERIOD', $period);
            $xtpl->parse('main.period.loop');
        }
        $xtpl->parse('main.period');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Hiển thị trang quản lý công việc (tasks)
 */
function nv_theme_evaluate_kpi_tasks($array_data) {
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate('tasks.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('ACTION_URL', $array_data['action_url']);
    $xtpl->assign('PERIOD_ID', $array_data['period_id']);

    $xtpl->assign('CHECKSS', $array_data['checkss']);
    $xtpl->assign('ROW', $array_data['row']);

    if (!empty($array_data['error'])) {
        $xtpl->assign('ERROR', $array_data['error']);
        $xtpl->parse('main.error');
    }

    if (!empty($array_data['tasks'])) {
        foreach ($array_data['tasks'] as $task) {
            $xtpl->assign('TASK', $task);
            $xtpl->parse('main.list.loop');
        }
        $xtpl->parse('main.list');
    } else {
        $xtpl->parse('main.empty');
    }

    // Set select options
    $xtpl->assign('SEL_TYPE_1', $array_data['row']['task_type'] == 1 ? 'selected="selected"' : '');
    $xtpl->assign('SEL_TYPE_2', $array_data['row']['task_type'] == 2 ? 'selected="selected"' : '');
    $xtpl->assign('SEL_STATUS_0', $array_data['row']['status'] == 0 ? 'selected="selected"' : '');
    $xtpl->assign('SEL_STATUS_1', $array_data['row']['status'] == 1 ? 'selected="selected"' : '');

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Hiển thị trang tự đánh giá
 */
function nv_theme_evaluate_kpi_self_eval($array_data) {
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate('self-eval.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);

    $xtpl->assign('CHECKSS', $array_data['checkss']);
    $xtpl->assign('PERIOD', $array_data['period']);
    $xtpl->assign('RECORD', $array_data['record']);

    if (!empty($array_data['error'])) {
        $xtpl->assign('ERROR', $array_data['error']);
        $xtpl->parse('main.error');
    }

    foreach ($array_data['criteria'] as $cri) {
        $xtpl->assign('CRI', $cri);
        $xtpl->parse('main.criteria.loop');
    }
    if (!empty($array_data['criteria'])) {
        $xtpl->parse('main.criteria');
    }

    if ($array_data['is_manager_group']) {
        $xtpl->parse('main.kpi.manager_fields');
    }

    $xtpl->parse('main.kpi');

    if ($array_data['record']['status'] == 0) {
        $xtpl->parse('main.submit_buttons');
    } else {
        $xtpl->parse('main.locked');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * Hiển thị trang quản lý duyệt
 */
function nv_theme_evaluate_kpi_manager_eval($array_data) {
    global $global_config, $module_name, $module_file, $lang_module, $module_info, $op;

    $xtpl = new XTemplate('manager-eval.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);

    if ($array_data['is_approve_mode']) {
        $xtpl->assign('RECORD', $array_data['record']);
        $xtpl->assign('CHECKSS', $array_data['checkss']);

        if (!empty($array_data['error'])) {
            $xtpl->assign('ERROR', $array_data['error']);
            $xtpl->parse('approve.error');
        }

        if ($array_data['record']['group_type'] == 2) {
            $xtpl->parse('approve.manager_fields');
        }

        $xtpl->parse('approve');
        return $xtpl->text('approve');
    } else {
        if (!empty($array_data['records'])) {
            foreach ($array_data['records'] as $row) {
                $xtpl->assign('ROW', $row);
                $xtpl->parse('main.list.loop');
            }
            $xtpl->parse('main.list');
        } else {
            $xtpl->parse('main.empty');
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}
