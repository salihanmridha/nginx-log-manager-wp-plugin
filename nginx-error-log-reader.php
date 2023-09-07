<?php
// Include WordPress environment
if (file_exists(dirname(__FILE__) . '/../../../wp-load.php')) {
	require_once(dirname(__FILE__) . '/../../../wp-load.php');
}

require_once (plugin_dir_path(__FILE__) . 'read-write-nginx-log.php');

function display_error_log_entries() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'error_log';

	$log_entries = read_nginx_log('error_log_path');

	if (!empty($log_entries)) {
		insert_log_entries($log_entries, $table_name);
	}

	// Retrieve the access log entries from the database
	$log_entries = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

	if (!$log_entries) {
		echo 'No error log entries found.';
		return;
	}

	include ("nginx-log-paginate.php");


}

