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

$module_version = [
    'name' => 'Evaluate KPI',
    'modfuncs' => 'main, tasks, self-eval, manager-eval',
    'change_alias' => 'main, tasks, self-eval, manager-eval',
    'submenu' => 'main, tasks, self-eval, manager-eval',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.5.08',
    'date' => 'Wed, 23 Oct 2024 08:00:00 GMT',
    'author' => 'VINADES.,JSC',
    'uploads_dir' => [$module_name],
    'note' => 'Module đánh giá KPI dành cho viên chức, giáo viên',
];
