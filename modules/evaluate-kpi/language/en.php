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

$lang_translator['author'] = 'VINADES.,JSC (contact@vinades.vn)';
$lang_translator['createdate'] = '23/10/2024, 08:00';
$lang_translator['copyright'] = '@Copyright (C) 2024 VINADES.,JSC All rights reserved';
$lang_translator['info'] = '';
$lang_translator['langtype'] = 'lang_module';

$lang_module['main'] = 'KPI Dashboard';
$lang_module['tasks'] = 'Work Tasks';
$lang_module['self_eval'] = 'Self Evaluation';
$lang_module['manager_eval'] = 'Manager Approval';

$lang_module['add'] = 'Add New';
$lang_module['edit'] = 'Edit';
$lang_module['delete'] = 'Delete';
$lang_module['save'] = 'Save Data';
$lang_module['send_approve'] = 'Send for Approval';
$lang_module['cancel'] = 'Cancel';
$lang_module['action'] = 'Action';

// Main dashboard
$lang_module['welcome'] = 'Welcome';
$lang_module['your_department'] = 'Department';
$lang_module['your_manager'] = 'Your KPI Manager';
$lang_module['recent_periods'] = 'Recent Evaluation Periods';
$lang_module['period_title'] = 'Period';
$lang_module['status'] = 'Status';
$lang_module['status_draft'] = 'Draft';
$lang_module['status_pending'] = 'Pending Approval';
$lang_module['status_approved'] = 'Approved';
$lang_module['score_self'] = 'Self Score';
$lang_module['score_manager'] = 'Manager Score';

// Tasks
$lang_module['task_title'] = 'Task Name';
$lang_module['task_desc'] = 'Description';
$lang_module['task_type'] = 'Type';
$lang_module['task_type_1'] = 'Regular';
$lang_module['task_type_2'] = 'Ad-hoc';
$lang_module['task_freq'] = 'Frequency';
$lang_module['task_output'] = 'Expected Output';
$lang_module['task_deadline'] = 'Deadline';
$lang_module['task_status'] = 'Status';
$lang_module['task_status_0'] = 'Incomplete';
$lang_module['task_status_1'] = 'Completed';
$lang_module['task_evidence'] = 'Evidence URL';
$lang_module['task_empty'] = 'No tasks declared for this period.';
$lang_module['task_add_success'] = 'Task added successfully!';

// Self Eval
$lang_module['eval_criteria'] = 'General Criteria (30 points)';
$lang_module['eval_kpi'] = 'KPI Evaluation (70 points)';
$lang_module['eval_note'] = 'Note';
$lang_module['eval_max_score'] = 'Max Score';
$lang_module['eval_your_score'] = 'Your Score';
$lang_module['eval_kpi_a'] = 'a. Quantity (0-100%)';
$lang_module['eval_kpi_b'] = 'b. Quality (0-100%)';
$lang_module['eval_kpi_c'] = 'c. Schedule (0-100%)';
$lang_module['eval_kpi_d'] = 'd. Organization (0-100%)';
$lang_module['eval_kpi_d2'] = 'đ. Internal Solidarity (0-100%)';
$lang_module['eval_kpi_e'] = 'e. Innovation (0-100%)';
$lang_module['eval_error_b'] = 'Penalty count (Quality)';
$lang_module['eval_error_c'] = 'Penalty count (Schedule)';
$lang_module['eval_confirm_send'] = 'Are you sure you want to SEND? You cannot edit after sending!';

// Manager Eval
$lang_module['manager_list_emp'] = 'Employees Pending Approval';
$lang_module['manager_emp_name'] = 'Employee Name';
$lang_module['manager_note'] = 'Manager Note';
$lang_module['manager_approve'] = 'Approve & Rank';

$lang_module['locked_notice'] = 'This period is locked or you have already submitted your evaluation. No further edits allowed.';
$lang_module['total_score_general'] = 'Total general criteria score (Max 30)';
$lang_module['kpi_criteria'] = 'KPI Criteria';
$lang_module['kpi_percent'] = '% Completed';
$lang_module['kpi_note'] = 'Note / Penalty';
$lang_module['save_draft'] = 'Save Draft';
$lang_module['self_score'] = 'Self Score';
$lang_module['manager_score'] = 'Manager Score';
$lang_module['total_result'] = 'Total Result & Ranking';
$lang_module['total_point'] = 'TOTAL SCORE (100)';
$lang_module['rank_level'] = 'Rank Level';
$lang_module['manager_confirm_approve'] = 'Are you sure you want to approve this evaluation?';

$lang_module['error_no_period'] = 'No open evaluation period currently.';
$lang_module['error_locked'] = 'This period is locked. No actions allowed.';
$lang_module['error_not_found'] = 'Data not found.';
$lang_module['error_permission'] = 'You do not have permission for this action.';
$lang_module['error_token'] = 'Security error (Invalid token). Please refresh.';
