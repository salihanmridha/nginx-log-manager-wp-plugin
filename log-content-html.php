<style>
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border: 1px solid #eaeaea; /* Add border */
    }

    th, td {
        padding: 20px;
        text-align: left;
        border: 1px solid #eaeaea; /* Add border */
    }

    th {

    }

    .log-entry {
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .id-column {
        width: 10%; /* Adjust the width as needed */
    }

    .log-entry-column {
        width: 80%; /* Adjust the width as needed */
    }

    .timestamp-column {
        width: 20%; /* Adjust the width as needed */
        text-align: center;
    }
</style>

<table>
	<tr><th class="log-entry-column">Log Entry</th><th class="timestamp-column">Timestamp</th></tr>

	<?php foreach ($current_page_logs as $log_entry): ?>
		<tr>
			<td class="log-entry-column"><div class="log-entry"><?php echo esc_html($log_entry->log_entry); ?></div></td>
			<td class="timestamp-column"><?php echo esc_html($log_entry->timestamp); ?></td>
		</tr>
	<?php endforeach; ?>

</table>
