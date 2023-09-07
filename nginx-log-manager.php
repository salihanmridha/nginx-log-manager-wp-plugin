<?php
/*
Plugin Name: Nginx Log Manager
Plugin URI: https://salihanmridha.com/
Description: Manage Nginx server access and error logs.
Version: 1.0.0
Author: Salihan Mridha
Author URI: https://salihanmridha.com/
*/

// Include activator.php file
require_once plugin_dir_path(__FILE__) . 'activator.php';
require_once plugin_dir_path(__FILE__) . 'nginx-log-settings.php';
require_once plugin_dir_path(__FILE__) . 'nginx-access-log-reader.php';
require_once plugin_dir_path(__FILE__) . 'nginx-error-log-reader.php';

// Register activation hook
register_activation_hook(__FILE__, 'nginx_log_manager_activate');

// Register deactivation hook
register_deactivation_hook(__FILE__, 'nginx_log_manager_deactivate');

// Register uninstall hook
register_uninstall_hook(__FILE__, 'nginx_log_manager_uninstall');

// Activation hook callback
function nginx_log_manager_activate() {
	// Create necessary database tables
	nginx_log_manager_create_tables();
}

// Deactivation hook callback
function nginx_log_manager_deactivate() {
	// Code to run on plugin deactivation
}

//Uninstall hook callback
function nginx_log_manager_uninstall() {
	nginx_log_manager_drop_tables();
}

// Add menu page for Nginx Log Settings
add_action('admin_menu', 'nginx_log_manager_add_menu');
function nginx_log_manager_add_menu() {
	add_menu_page(
		'Nginx Log Manager',
		'Nginx Log Manager',
		'manage_options',
		'nginx-log-manager',
		'nginx_log_manager_render_settings_page',
		'dashicons-admin-generic',
		30
	);

	// Submenu - Access Log Viewer
	add_submenu_page(
		'nginx-log-manager',
		'Access Log Viewer',
		'Access Log Viewer',
		'manage_options',
		'nginx-access-log-viewer',
		'display_access_log_entries'
	);

	// Submenu - Error Log Viewer
	add_submenu_page(
		'nginx-log-manager',
		'Error Log Viewer',
		'Error Log Viewer',
		'manage_options',
		'nginx-error-log-viewer',
		'display_error_log_entries'
	);
}
