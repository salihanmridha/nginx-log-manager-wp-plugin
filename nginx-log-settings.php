<?php
// Callback function to render the Nginx Log Settings page
function nginx_log_manager_render_settings_page() {
	// Check if the user has the required capability
	if (!current_user_can('manage_options')) {
		return;
	}

	// Save settings if the form is submitted
	if (isset($_POST['nginx_log_settings_submit'])) {
		// Verify nonce for security
		$nonce = isset($_POST['nginx_log_settings_nonce']) ? $_POST['nginx_log_settings_nonce'] : '';

		if (wp_verify_nonce($nonce, 'nginx_log_settings_action')) {
			$access_log_path = sanitize_text_field($_POST['access_log_path']);
			$error_log_path = sanitize_text_field($_POST['error_log_path']);

			global $wpdb;
			$table_name = $wpdb->prefix . 'nginx_log_manager_settings';

			$existing_settings = $wpdb->get_row("SELECT * FROM $table_name");

			if ($existing_settings) {
				// Update existing settings
				$data = array(
					'access_log_path' => $access_log_path,
					'error_log_path' => $error_log_path
				);

				$wpdb->update($table_name, $data, array('id' => $existing_settings->id));
			} else {
				// Insert new settings
				$data = array(
					'access_log_path' => $access_log_path,
					'error_log_path' => $error_log_path
				);

				$wpdb->insert($table_name, $data);
			}

			if ($wpdb->last_error) {
				// Display an error message or perform appropriate action
				echo '<div class="notice notice-error"><p>Error: ' . esc_html($wpdb->last_error) . '</p></div>';
			}

			// Display a success message
			echo '<div class="notice notice-success"><p>Settings saved successfully.</p></div>';
		} else {
			// Invalid nonce, display an error message or perform appropriate action
			echo '<div class="notice notice-error"><p>Error: Invalid security token. Settings not saved.</p></div>';
		}
	}

	// Retrieve the saved settings from the custom table or set default values
	global $wpdb;
	$table_name = $wpdb->prefix . 'nginx_log_manager_settings';

	$settings = $wpdb->get_row("SELECT * FROM $table_name");

	if ($settings) {
		$access_log_path = $settings->access_log_path;
		$error_log_path = $settings->error_log_path;
	} else {
		$access_log_path = '';
		$error_log_path = '';
	}

	?>
	<div class="wrap">
		<h1>Nginx Log Settings</h1>
		<form method="post" action="">
			<?php wp_nonce_field('nginx_log_settings_action', 'nginx_log_settings_nonce'); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="access_log_path">Access Log Path</label></th>
					<td><input type="text" id="access_log_path" name="access_log_path" value="<?php echo esc_attr($access_log_path); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th scope="row"><label for="error_log_path">Error Log Path</label></th>
					<td><input type="text" id="error_log_path" name="error_log_path" value="<?php echo esc_attr($error_log_path); ?>" class="regular-text"></td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="nginx_log_settings_submit" class="button button-primary" value="Save Settings">
			</p>
		</form>
	</div>
	<?php
}
?>
