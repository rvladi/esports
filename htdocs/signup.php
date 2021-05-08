<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$error = isset($_GET['error']) ? $_GET['error'] : NULL;
	include '../views/signup_view.php';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = isset($_POST['username']) ? trim($_POST['username']) : NULL;
	$password = isset($_POST['password']) ? $_POST['password'] : NULL;

	if (!validate_username($username)) {
		$error = 'Username must be at least ' . MIN_UNAME_LEN . ' characters long.';
		header('Location: /signup.php?error=' . urlencode($error));
		exit;
	}
	if (!validate_password($password)) {
		$error = 'Password must be at least ' . MIN_PASSW_LEN . ' characters long.';
		header('Location: /signup.php?error=' . urlencode($error));
		exit;
	}

	$dbc = get_database_connection();
	$id = create_user($dbc, $username, $password);
	close_database_connection($dbc);

	$created = $id !== NULL; // $id is NULL if username is already taken
	if ($created) {
		$_SESSION['user_id'] = $id;
		$_SESSION['username'] = htmlspecialchars($username);
	} else {
		$error = "Error creating user '$username'. Please choose a different username.";
	}

	if (isset($_POST['format']) && $_POST['format'] === 'json') {
		if ($created) {
			$result = ['status' => 'success'];
		} else {
			$result = ['status' => 'failure', 'error' => $error];
		}
		include '../views/signup_view_result_json.php';
	} else {
		if ($created) {
			include '../views/signup_view_result.php';
		} else {
			header('Location: /signup.php?error=' . urlencode($error));
		}
	}
} else {
	throw new Exception('invalid request method');
}
