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

$sql_drop_module = [];
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_period";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_criteria";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_users";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tasks";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_records";

$sql_create_module = $sql_drop_module;

// Bảng cấu hình module
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_config (
  config_name varchar(30) NOT NULL,
  config_value varchar(255) NOT NULL,
  UNIQUE KEY config_name (config_name)
) ENGINE=MyISAM";

// Bảng quản lý các kỳ đánh giá
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_period (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  start_time int(11) unsigned NOT NULL DEFAULT '0',
  end_time int(11) unsigned NOT NULL DEFAULT '0',
  lock_time int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

// Bảng danh mục 30 điểm tiêu chí chung
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_criteria (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description text NOT NULL,
  max_score float NOT NULL DEFAULT '0',
  weight int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

// Bảng quản lý phòng ban và gắn sếp trực tiếp (manager_id)
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  manager_id int(11) unsigned NOT NULL DEFAULT '0',
  description text NOT NULL,
  weight int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

// Bảng lưu mapping user thuộc phòng ban nào
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_users (
  userid int(11) unsigned NOT NULL,
  department_id int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (userid),
  KEY department_id (department_id)
) ENGINE=MyISAM";

// Bảng thống kê sản phẩm công việc
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_tasks (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  userid int(11) unsigned NOT NULL DEFAULT '0',
  period_id int(11) unsigned NOT NULL DEFAULT '0',
  title varchar(255) NOT NULL,
  description text NOT NULL,
  task_type tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1: Thuong xuyen, 2: Dot xuat',
  frequency varchar(255) NOT NULL,
  output_expected varchar(255) NOT NULL,
  deadline int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Chua hoan thanh, 1: Hoan thanh',
  evidence_url varchar(255) NOT NULL,
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY userid (userid),
  KEY period_id (period_id)
) ENGINE=MyISAM";

// Bảng dữ liệu chính lưu điểm tự chấm và điểm duyệt của quản lý
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_records (
  record_id int(11) unsigned NOT NULL AUTO_INCREMENT,
  userid int(11) unsigned NOT NULL DEFAULT '0',
  period_id int(11) unsigned NOT NULL DEFAULT '0',
  department_id int(11) unsigned NOT NULL DEFAULT '0',
  group_type tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1: Nhan vien, 2: Quan ly',

  score_general_self float NOT NULL DEFAULT '0',
  kpi_a_self float NOT NULL DEFAULT '0',
  kpi_b_self float NOT NULL DEFAULT '0',
  kpi_c_self float NOT NULL DEFAULT '0',
  kpi_d_self float NOT NULL DEFAULT '0',
  kpi_d2_self float NOT NULL DEFAULT '0',
  kpi_e_self float NOT NULL DEFAULT '0',
  b_errors_self int(11) unsigned NOT NULL DEFAULT '0',
  c_errors_self int(11) unsigned NOT NULL DEFAULT '0',
  score_kpi_self float NOT NULL DEFAULT '0',
  total_score_self float NOT NULL DEFAULT '0',
  rank_self varchar(20) NOT NULL,

  manager_id int(11) unsigned NOT NULL DEFAULT '0',
  score_general_manager float NOT NULL DEFAULT '0',
  kpi_a_manager float NOT NULL DEFAULT '0',
  kpi_b_manager float NOT NULL DEFAULT '0',
  kpi_c_manager float NOT NULL DEFAULT '0',
  kpi_d_manager float NOT NULL DEFAULT '0',
  kpi_d2_manager float NOT NULL DEFAULT '0',
  kpi_e_manager float NOT NULL DEFAULT '0',
  b_errors_manager int(11) unsigned NOT NULL DEFAULT '0',
  c_errors_manager int(11) unsigned NOT NULL DEFAULT '0',
  score_kpi_manager float NOT NULL DEFAULT '0',
  total_score_manager float NOT NULL DEFAULT '0',
  rank_manager varchar(20) NOT NULL,
  manager_note text NOT NULL,

  final_rank varchar(20) NOT NULL,
  status tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0: Nhap, 1: Cho duyet, 2: Da duyet',
  add_time int(11) unsigned NOT NULL DEFAULT '0',
  edit_time int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (record_id),
  KEY userid (userid),
  KEY period_id (period_id),
  KEY department_id (department_id),
  KEY manager_id (manager_id)
) ENGINE=MyISAM";
