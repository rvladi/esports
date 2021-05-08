<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$error = isset($_GET['error']) ? $_GET['error'] : NULL;
	$location = isset($_GET['location']) ? trim($_GET['location']) : '/index.php';
	include '../views/login_view.php';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = isset($_POST['username']) ? trim($_POST['username']) : NULL;
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;
	$location = isset($_POST['location']) ? trim($_POST['location']) : '/index.php';

	if (empty($username) || empty($password)) {
		$error = 'Both a username and password must be provided.';
		header('Location: /login.php?error=' . urlencode($error) . '&location=' . urlencode($location));
		exit;
	}

	$dbc = get_database_connection();
	$user = get_user($dbc, $username);
	close_database_connection($dbc);

	$logged_in = $user ? password_verify($password, $user['password']) : FALSE;
	if ($logged_in) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = htmlspecialchars($username);
	} else {
		$error = 'Invalid credentials.';
	}

	if (isset($_POST['format']) && $_POST['format'] === 'json') {
		if ($logged_in) {
			$result = ['status' => 'success'];
		} else {
			$result = ['status' => 'failure', 'error' => $error];
		}
		include '../views/login_view_result_json.php';
	} else {
		if ($logged_in) {
			header("Location: $location");
		} else {
			header('Location: /login.php?error=' . urlencode($error) . '&location=' . urlencode($location));
		}
	}
} else {
	throw new Exception('invalid request method');
}
