<?php

function nginx_log_manager_create_tables() {
	global $wpdb;

	$access_log_table_name = $wpdb->prefix . 'access_log';
	$error_log_table_name = $wpdb->prefix . 'error_log';
	$nginx_log_manager_table_name = $wpdb->prefix . 'nginx_log_manager_settings';

	$charset_collate = $wpdb->get_charset_collate();

	// Create access log table
	$access_log_table_sql = "CREATE TABLE IF NOT EXISTS $access_log_table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        log_entry TEXT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
	$wpdb->query($wpdb->prepare($access_log_table_sql));

	// Create error log table
	$error_log_table_sql = "CREATE TABLE IF NOT EXISTS $error_log_table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        log_entry TEXT NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
	$wpdb->query($wpdb->prepare($error_log_table_sql));

	// Create nginx_log_manager table
	$nginx_log_manager_table_sql = "CREATE TABLE IF NOT EXISTS $nginx_log_manager_table_name (
        id INT(11) NOT NULL AUTO_INCREMENT,
        access_log_path VARCHAR(255) NOT NULL,
        error_log_path VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
	$wpdb->query($wpdb->prepare($nginx_log_manager_table_sql));
}


function nginx_log_manager_drop_tables() {
	global $wpdb;

	$access_log_table_name = $wpdb->prefix . 'access_log';
	$error_log_table_name = $wpdb->prefix . 'error_log';
	$nginx_log_manager_table_name = $wpdb->prefix . 'nginx_log_manager_settings';

	// Drop access log table
	$wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $access_log_table_name"));

	// Drop error log table
	$wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $error_log_table_name"));

	// Drop settings table
	$wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $nginx_log_manager_table_name"));
}
