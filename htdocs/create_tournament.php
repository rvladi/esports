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
	$dbc = get_database_connection();

	$games = get_games($dbc);
	$platforms = get_platforms($dbc);
	$regions = get_regions($dbc);

	close_database_connection($dbc);

	if (isset($_GET['format']) && $_GET['format'] === 'json') {
		include '../views/create_tournament_view_json.php';
	} else {
		include '../views/create_tournament_view.php';
	}
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = isset($_POST['title']) ? trim($_POST['title']) : NULL;
	check_non_empty($title);

	$game = isset($_POST['game']) ? trim($_POST['game']) : NULL;
	check_id($game);

	$platform = isset($_POST['platform']) ? trim($_POST['platform']) : NULL;
	check_id($platform);

	$region = isset($_POST['region']) ? trim($_POST['region']) : NULL;
	check_id($region);

	$date = isset($_POST['date']) ? trim($_POST['date']) : NULL;
	check_date($date);

	$time = isset($_POST['time']) ? trim($_POST['time']) : NULL;
	check_time($time);

	$description = isset($_POST['description']) ? trim($_POST['description']) : NULL;
	check_non_empty($description);

	$dbc = get_database_connection();

	begin_transaction($dbc);
	$id = create_tournament($dbc, $title, $game, $platform, $region, $date, $time, $description, $user);
	$tournament = get_tournament($dbc, $id, $user);
	commit_transaction($dbc);

	close_database_connection($dbc);

	if (isset($_POST['format']) && $_POST['format'] === 'json') {
		include '../views/create_tournament_view_result_json.php';
	} else {
		include '../views/create_tournament_view_result.php';
	}
} else {
	throw new Exception('invalid request method');
}
