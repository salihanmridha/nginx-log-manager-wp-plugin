<?php
// Define the number of logs to display per page
$logs_per_page = 10;

// Get the current page number from the URL query parameter
$current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

// Calculate the total number of pages
$total_pages = ceil(count($log_entries) / $logs_per_page);

// Determine the starting and ending index for the logs on the current page
$start_index = ($current_page - 1) * $logs_per_page;
$end_index = min($start_index + $logs_per_page, count($log_entries));

// Get the logs for the current page
$current_page_logs = array_slice($log_entries, $start_index, $end_index - $start_index);

// Include the HTML template for displaying the logs
include 'log-content-html.php';

// Display pagination links
$pagination_args = array(
	'base' => add_query_arg('paged', '%#%'),
	'format' => '',
	'total' => $total_pages,
	'current' => $current_page,
	'show_all' => false,
	'end_size' => 1,
	'mid_size' => 2,
	'prev_next' => true,
	'prev_text' => __('&laquo; Previous'),
	'next_text' => __('Next &raquo;'),
);

// Include the pagination template
include 'log-paginate-html.php';
?>