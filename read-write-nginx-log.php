<?php

function read_nginx_log($pathColumn) {

	// Retrieve the path from the database
	$path = get_path($pathColumn);

	// Check if the access log path is empty
	if (empty($path)) {
		return array(); // Return an empty array if the path is not defined
	}

	$log_entries = array();

	if (file_exists($path)) {
		$file_handle = fopen($path, 'r');

		while (!feof($file_handle)) {
			$line = fgets($file_handle);
			$log_entries[] = $line;
		}

		fclose($file_handle);
	} else {
		echo "The $pathColumn file path doesn't exist. Please check access log path correctly and save it to plugin settings page.";
	}

	return $log_entries;
}

function insert_log_entries($log_entries, $table_name) {
	global $wpdb;

	foreach ($log_entries as $log_entry) {
		// Check if the log entry already exists in the database
		$existing_entry = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE log_entry = %s", $log_entry));

		if (!$existing_entry) {
			// Insert the log entry into the database
			$wpdb->insert($table_name, array('log_entry' => $log_entry));
		}
	}
}

function get_path($pathColumn){
	global $wpdb;
	$table_name = $wpdb->prefix . 'nginx_log_manager_settings';

	// Retrieve the access log path from the database
	$settings = $wpdb->get_row("SELECT * FROM $table_name");
	return $settings->$pathColumn;
}