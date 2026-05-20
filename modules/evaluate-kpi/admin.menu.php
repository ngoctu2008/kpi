<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_ADMIN')) {
    die('Stop!!!');
}

$submenu['main'] = $lang_module['main'];
$submenu['departments'] = $lang_module['departments'];
$submenu['period'] = $lang_module['period'];
$submenu['criteria'] = $lang_module['criteria'];
$submenu['reports'] = $lang_module['reports'];
$submenu['config'] = $lang_module['config'];

$allow_func = ['main', 'departments', 'period', 'criteria', 'reports', 'config'];
