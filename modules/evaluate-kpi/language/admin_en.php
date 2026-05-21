<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2024 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvpage/
 * @Createdate Wed, 23 Oct 2024 08:00:00 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

$lang_translator['author'] = 'VINADES.,JSC (contact@vinades.vn)';
$lang_translator['createdate'] = '23/10/2024, 08:00';
$lang_translator['copyright'] = '@Copyright (C) 2024 VINADES.,JSC All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main'] = 'Main';
$lang_module['config'] = 'Configuration';
$lang_module['departments'] = 'Departments';
$lang_module['period'] = 'Evaluation Periods';
$lang_module['criteria'] = 'General Criteria';
$lang_module['reports'] = 'Reports';

$lang_module['save'] = 'Save';
$lang_module['add'] = 'Add new';
$lang_module['edit'] = 'Edit';
$lang_module['delete'] = 'Delete';
$lang_module['action'] = 'Action';
$lang_module['title'] = 'Title';
$lang_module['status'] = 'Status';
$lang_module['status_1'] = 'Active';
$lang_module['status_0'] = 'Suspended';

$lang_module['department_add'] = 'Add Department';
$lang_module['department_manager'] = 'Manager (KPI Approver)';
$lang_module['department_manager_note'] = 'Enter manager username or ID';
$lang_module['department_description'] = 'Description';
$lang_module['department_users'] = 'Employee UserIDs';
$lang_module['department_users_note'] = 'Comma separated User IDs. E.g: 15,22,35';

$lang_module['config_group_employee'] = 'Employee Group (Groups 1, 2, 3)';
$lang_module['config_group_manager'] = 'Manager Group (Group 4)';
$lang_module['config_mapping_note'] = 'Select user groups to map to KPI formulas';

$lang_module['error_empty_title'] = 'Error: Title cannot be empty!';
$lang_module['error_save'] = 'Error: Could not save data!';
$lang_module['save_success'] = 'Action successful!';

$lang_module['report_filter'] = 'Report Filter (Form 03, 04, 05)';
$lang_module['report_choose_period'] = 'Choose Period:';
$lang_module['report_view_online'] = 'View Online Report';
$lang_module['report_export_excel'] = 'Export Excel';
$lang_module['report_choose'] = '--- Select ---';
$lang_module['report_title_03'] = 'Summary Report (Form 03)';
$lang_module['report_col_stt'] = 'No.';
$lang_module['report_col_dep'] = 'Department';
$lang_module['report_col_total'] = 'Total Emp.';
$lang_module['report_col_excellent'] = 'Excellent';
$lang_module['report_col_good'] = 'Good';
$lang_module['report_col_average'] = 'Average';
$lang_module['report_col_poor'] = 'Poor';
$lang_module['report_col_sl'] = 'Qty';

$lang_module['dash_overview'] = 'System Overview';
$lang_module['dash_departments'] = 'Departments';
$lang_module['dash_periods'] = 'Initialized Periods';
$lang_module['dash_tasks'] = 'Recorded Tasks';
$lang_module['dash_status_title'] = 'KPI Evaluation Status';
$lang_module['dash_draft'] = 'Drafts (Self-evaluating)';
$lang_module['dash_pending'] = 'Pending Manager Approval';
$lang_module['dash_approved'] = 'Approved & Ranked';
$lang_module['dash_instruction_1'] = 'To get started, please make sure you have:';
$lang_module['dash_instruction_2'] = 'Configured module: Correctly mapped Employee/Manager groups.';
$lang_module['dash_instruction_3'] = 'Created departments: Assigned the correct Manager User ID.';
$lang_module['dash_instruction_4'] = 'Opened periods: So employees can submit reports.';

$lang_module['period_start'] = 'Start Date';
$lang_module['period_end'] = 'End Date';
$lang_module['period_lock'] = 'Deadline (Lock form)';
$lang_module['period_ph'] = 'Eg: KPI Evaluation Jan 2024';

$lang_module['cri_max_score'] = 'Max Score';
$lang_module['cri_stt'] = 'No.';
$lang_module['cri_total'] = 'TOTAL:';
$lang_module['cri_notice'] = 'Please set criteria so that the total max score is exactly 30.';
$lang_module['cri_desc'] = 'Detailed Description';
$lang_module['cri_desc_ph'] = 'Additional notes to help users evaluate';
