<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: /login.php?location=' . urlencode($_SERVER['REQUEST_URI']));
	exit;
}

$user = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$id = isset($_GET['id']) ? trim($_GET['id']) : NULL;
	check_id($id);

	$dbc = get_database_connection();

	begin_transaction($dbc);
	leave_tournament($dbc, $id, $user);
	$tournament = get_tournament($dbc, $id, $user);
	commit_transaction($dbc);

	close_database_connection($dbc);

	if (isset($_GET['format']) && $_GET['format'] === 'json') {
		include '../views/leave_tournament_view_json.php';
	} else {
		include '../views/leave_tournament_view.php';
	}
} else {
	throw new Exception('invalid request method');
}

