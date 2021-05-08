<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$game_ids = isset($_GET['game']) ? param_to_array($_GET['game']) : [];
	check_games($game_ids);

	$platform_ids = isset($_GET['platform']) ? param_to_array($_GET['platform']) : [];
	check_platforms($platform_ids);

	$region_ids = isset($_GET['region']) ? param_to_array($_GET['region']) : [];
	check_regions($region_ids);

	$start_date = isset($_GET['start_date']) ? trim($_GET['start_date']) : NULL;
	if (!empty($start_date)) {
		check_date($start_date);
	}

	$end_date = isset($_GET['end_date']) ? trim($_GET['end_date']) : NULL;
	if (!empty($end_date)) {
		check_date($end_date);
	}

	$dbc = get_database_connection();

	$tournaments = get_tournaments($dbc, $game_ids, $platform_ids, $region_ids, $start_date, $end_date);
	$games = get_games($dbc);
	$platforms = get_platforms($dbc);
	$regions = get_regions($dbc);

	close_database_connection($dbc);

	// games
	foreach ($games as &$game) {
		$game['selected'] = in_array($game['id'], $game_ids);
	}
	unset($game);

	// platforms
	foreach ($platforms as &$platform) {
		$platform['selected'] = in_array($platform['id'], $platform_ids);
	}
	unset($platform);

	// regions
	foreach ($regions as &$region) {
		$region['selected'] = in_array($region['id'], $region_ids);
	}
	unset($region);

	if (isset($_GET['format']) && $_GET['format'] === 'json') {
		include '../views/browse_tournaments_view_json.php';
	} else {
		include '../views/browse_tournaments_view.php';
	}
} else {
	throw new Exception('invalid request method');
}
