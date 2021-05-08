<?php
function exception_handler($e) {
	// TODO $error = 'Unexpected server error. Please try again later.';
	$error = $e->getMessage();
	if ((isset($_GET['format']) && $_GET['format'] === 'json')
			|| (isset($_POST['format']) && $_POST['format'] === 'json')) {
		include '../views/error_json.php';
	} else {
		include '../views/error.php';
	}
}

set_exception_handler('exception_handler');
