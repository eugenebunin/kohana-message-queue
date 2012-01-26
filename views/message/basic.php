<?php
/**
 * Render message alerts
 */
if (count($messages)) {
	foreach( $messages as $message ) {
		$type = isset($message['type']) ? $message['type'] : '';
		echo "<div class='alert-message ".$type."'><a class='close' href='#' onClick='return $(" .'".alert-message"' .").detach();'>×</a><strong></strong> ".$message['text']."</div>";
	}
}