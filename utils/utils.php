<?php
$config = include 'config.php';

// request validation utils

define('MIN_UNAME_LEN', 6);
define('MIN_PASSW_LEN', 6);

function param_to_array($param) {
	return is_array($param) ? $param : [$param];
}

function check_games($games) {
	check_ids($games);
}

function check_platforms($platforms) {
	check_ids($platforms);
}

function check_regions($regions) {
	check_ids($regions);
}

function check_ids($array) {
	foreach ($array as $element) {
		check_id($element);
	}
}

function check_id($id) {
	if (!ctype_digit($id)) {
		throw new Exception('id must be a non-negative integer');
	}
}

function check_non_empty($string) {
	if (empty($string)) {
		throw new Exception('string must be non-empty');
	}
}

function check_date($date) {
	$dt = date_create_from_format('Y-m-d', $date);
	if ($dt === FALSE) {
		throw new Exception('invalid date');
	}
}

function check_time($time) {
	$dt = date_create_from_format('H:i', $time);
	if ($dt !== FALSE) {
		return;
	}

	$dt = date_create_from_format('H:i:s', $time);
	if ($dt !== FALSE) {
		return;
	}

	throw new Exception('invalid time');
}

function validate_username($username) {
	return strlen($username) >= MIN_UNAME_LEN;
}

function validate_password($password) {
	return strlen($password) >= MIN_PASSW_LEN;
}

// database utils

define('ER_DUP_ENTRY', 1062);

function get_database_connection() {
	global $config;

	$dbc = @mysqli_connect($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);
	if (!$dbc) {
		throw new Exception(mysqli_connect_error());
	}

	$charset_set = mysqli_set_charset($dbc, 'utf8');
	if (!$charset_set) {
		$err_msg = mysqli_error($dbc);
		@mysqli_close($dbc);
		throw new Exception($err_msg);
	}

	return $dbc;
}

function close_database_connection($dbc) {
	@mysqli_close($dbc);
}

function begin_transaction($dbc) {
	$success = mysqli_begin_transaction($dbc);
	if (!$success) {
		throw new Exception(mysqli_error($dbc));
	}
}

function commit_transaction($dbc) {
	$success = mysqli_commit($dbc);
	if (!$success) {
		throw new Exception(mysqli_error($dbc));
	}
}

function rollback_transaction($dbc) {
	$success = mysqli_rollback($dbc);
	if (!$success) {
		throw new Exception(mysqli_error($dbc));
	}
}

function get_games($dbc) {
	$games = [];

	$sql = 'SELECT id, name, image FROM games';

	if ($result = mysqli_query($dbc, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$games[] = [
				'id' => (int) $row['id'],
				'name' => $row['name'],
				'image' => $row['image'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $games;
}

function get_platforms($dbc) {
	$platforms = [];

	$sql = 'SELECT id, name FROM platforms';

	if ($result = mysqli_query($dbc, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$platforms[] = [
				'id' => (int) $row['id'],
				'name' => $row['name'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $platforms;
}

function get_regions($dbc) {
	$regions = [];

	$sql = 'SELECT id, name FROM regions';

	if ($result = mysqli_query($dbc, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$regions[] = [
				'id' => (int) $row['id'],
				'name' => $row['name'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $regions;
}

function get_tournaments($dbc, $games, $platforms, $regions, $start_date, $end_date) {
	$tournaments = [];

	$start_date = mysqli_real_escape_string($dbc, $start_date);
	$end_date = mysqli_real_escape_string($dbc, $end_date);

	$clauses = [];
	if ($games && !in_array('0', $games)) {
		$clauses[] = 'game IN (' . implode(',', $games) . ')';
	}
	if ($platforms && !in_array('0', $platforms)) {
		$clauses[] = 'platform IN (' . implode(',', $platforms) . ')';
	}
	if ($regions && !in_array('0', $regions)) {
		$clauses[] = 'region IN (' . implode(',', $regions) . ')';
	}
	if ($start_date) {
		$clauses[] = "date >= '$start_date'";
	}
	if ($end_date) {
		$clauses[] = "date <= '$end_date'";
	}
	$where_clause = $clauses ? 'WHERE ' . implode(' AND ', $clauses) : '';

	$sql = 'SELECT t.id, t.title, g.image, g.name AS game, p.name AS platform, r.name AS region, t.date, t.time FROM'
		. " (SELECT id, title, game, platform, region, date, time FROM tournaments $where_clause) AS t"
		. ' INNER JOIN (SELECT id, name, image FROM games) AS g ON t.game = g.id'
		. ' INNER JOIN (SELECT id, name FROM platforms) AS p ON t.platform = p.id'
		. ' INNER JOIN (SELECT id, name FROM regions) AS r ON t.region = r.id'
		. ' ORDER BY date, time';

	if ($result = mysqli_query($dbc, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$tournaments[] = [
				'id' => (int) $row['id'],
				'title' => $row['title'],
				'image' => $row['image'],
				'game' => $row['game'],
				'platform' => $row['platform'],
				'region' => $row['region'],
				'date' => $row['date'],
				'time' => $row['time'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $tournaments;
}

function get_tournament($dbc, $id, $user) {
	if ($user === NULL) {
		return get_tournament_no_user($dbc, $id);
	}

	$tournament = NULL;

	$sql = 'SELECT t.id, t.title, g.image, g.id AS game_id, g.name AS game_name, p.id AS platform_id, p.name AS platform_name,'
		. ' r.id AS region_id, r.name AS region_name, t.date, t.time, t.description, t.creator, ut.tournament,'
		. " (SELECT COUNT(*) FROM user_tournaments WHERE tournament = $id) AS participants FROM"
		. " (SELECT id, title, game, platform, region, date, time, description, creator FROM tournaments WHERE id = $id) AS t"
		. ' INNER JOIN (SELECT id, name, image FROM games) AS g ON t.game = g.id'
		. ' INNER JOIN (SELECT id, name FROM platforms) AS p ON t.platform = p.id'
		. ' INNER JOIN (SELECT id, name FROM regions) AS r ON t.region = r.id'
		. " LEFT JOIN (SELECT user, tournament FROM user_tournaments WHERE user = $user) AS ut ON t.id = ut.tournament";

	if ($result = mysqli_query($dbc, $sql)) {
		if ($row = mysqli_fetch_assoc($result)) {
			$tournament = [
				'id' => (int) $row['id'],
				'title' => $row['title'],
				'image' => $row['image'],
				'game' => $row['game_name'],
				'game_id' => (int) $row['game_id'],
				'platform' => $row['platform_name'],
				'platform_id' => (int) $row['platform_id'],
				'region' => $row['region_name'],
				'region_id' => (int) $row['region_id'],
				'date' => $row['date'],
				'time' => $row['time'],
				'description' => $row['description'],
				'participants' => (int) $row['participants'],
				'created' => (int) $row['creator'] === $user,
				'joined' => $row['tournament'] !== NULL,
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $tournament;
}

function get_tournament_no_user($dbc, $id) {
	$tournament = NULL;

	$sql = 'SELECT t.id, t.title, g.image, g.id AS game_id, g.name AS game_name, p.id AS platform_id, p.name AS platform_name,'
		. ' r.id AS region_id, r.name AS region_name, t.date, t.time, t.description,'
		. " (SELECT COUNT(*) FROM user_tournaments WHERE tournament = $id) AS participants FROM"
		. " (SELECT id, title, game, platform, region, date, time, description FROM tournaments WHERE id = $id) AS t"
		. ' INNER JOIN (SELECT id, name, image FROM games) AS g ON t.game = g.id'
		. ' INNER JOIN (SELECT id, name FROM platforms) AS p ON t.platform = p.id'
		. ' INNER JOIN (SELECT id, name FROM regions) AS r ON t.region = r.id';

	if ($result = mysqli_query($dbc, $sql)) {
		if ($row = mysqli_fetch_assoc($result)) {
			$tournament = [
				'id' => (int) $row['id'],
				'title' => $row['title'],
				'image' => $row['image'],
				'game' => $row['game_name'],
				'game_id' => (int) $row['game_id'],
				'platform' => $row['platform_name'],
				'platform_id' => (int) $row['platform_id'],
				'region' => $row['region_name'],
				'region_id' => (int) $row['region_id'],
				'date' => $row['date'],
				'time' => $row['time'],
				'description' => $row['description'],
				'participants' => (int) $row['participants'],
				'created' => FALSE,
				'joined' => FALSE,
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $tournament;
}

function create_tournament($dbc, $title, $game, $platform, $region, $date, $time, $description, $creator) {
	$title = mysqli_real_escape_string($dbc, $title);
	$date = mysqli_real_escape_string($dbc, $date);
	$time = mysqli_real_escape_string($dbc, $time);
	$description = mysqli_real_escape_string($dbc, $description);

	$sql = 'INSERT INTO tournaments(title, game, platform, region, date, time, description, creator)'
		. " VALUES ('$title', $game, $platform, $region, '$date', '$time', '$description', $creator)";

	if (!mysqli_query($dbc, $sql)) {
		throw new Exception(mysqli_error($dbc));
	}

	return mysqli_insert_id($dbc);
}

function edit_tournament($dbc, $id, $title, $game, $platform, $region, $date, $time, $description, $user) {
	$title = mysqli_real_escape_string($dbc, $title);
	$date = mysqli_real_escape_string($dbc, $date);
	$time = mysqli_real_escape_string($dbc, $time);
	$description = mysqli_real_escape_string($dbc, $description);

	$sql = "UPDATE tournaments SET title = '$title', game = $game, platform = $platform, region = $region"
		. ", date = '$date', time = '$time', description = '$description' WHERE id = $id AND creator = $user";

	if (!mysqli_query($dbc, $sql)) {
		throw new Exception(mysqli_error($dbc));
	}
}

function delete_tournament($dbc, $id, $user) {
	$sql = "DELETE FROM tournaments WHERE id = $id AND creator = $user";

	if (!mysqli_query($dbc, $sql)) {
		throw new Exception(mysqli_error($dbc));
	}
}

function join_tournament($dbc, $id, $user) {
	$sql = "INSERT INTO user_tournaments(user, tournament) VALUES ($user, $id)";

	if (!mysqli_query($dbc, $sql)) {
		$errno = mysqli_errno($dbc);
		if ($errno !== ER_DUP_ENTRY) {
			throw new Exception(mysqli_error($dbc));
		}
	}
}

function leave_tournament($dbc, $id, $user) {
	$sql = "DELETE FROM user_tournaments WHERE user = $user AND tournament = $id";

	if (!mysqli_query($dbc, $sql)) {
		throw new Exception(mysqli_error($dbc));
	}
}

function get_user_tournaments($dbc, $user) {
	$tournaments = [];

	$sql = 'SELECT t.id, t.title, g.image, g.name AS game, p.name AS platform, r.name AS region, t.date, t.time FROM'
		. ' (SELECT id, title, game, platform, region, date, time FROM tournaments) AS t'
		. ' INNER JOIN (SELECT id, name, image FROM games) AS g ON t.game = g.id'
		. ' INNER JOIN (SELECT id, name FROM platforms) AS p ON t.platform = p.id'
		. ' INNER JOIN (SELECT id, name FROM regions) AS r ON t.region = r.id'
		. " INNER JOIN (SELECT user, tournament FROM user_tournaments WHERE user = $user) AS ut ON t.id = ut.tournament"
		. ' ORDER BY date, time';

	if ($result = mysqli_query($dbc, $sql)) {
		while ($row = mysqli_fetch_assoc($result)) {
			$tournaments[] = [
				'id' => (int) $row['id'],
				'title' => $row['title'],
				'image' => $row['image'],
				'game' => $row['game'],
				'platform' => $row['platform'],
				'region' => $row['region'],
				'date' => $row['date'],
				'time' => $row['time'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $tournaments;
}

function get_user($dbc, $username) {
	$user = NULL;

	$username = mysqli_real_escape_string($dbc, $username);

	$sql = "SELECT id, username, password FROM users WHERE username = '$username'";

	if ($result = mysqli_query($dbc, $sql)) {
		if ($row = mysqli_fetch_assoc($result)) {
			$user = [
				'id' => (int) $row['id'],
				'username' => $row['username'],
				'password' => $row['password'],
			];
		}
		mysqli_free_result($result);
	} else {
		throw new Exception(mysqli_error($dbc));
	}

	return $user;
}

function create_user($dbc, $username, $password) {
	$username = mysqli_real_escape_string($dbc, $username);
	$password = password_hash($password, PASSWORD_DEFAULT);

	$sql = "INSERT INTO users(username, password) VALUES ('$username', '$password')";

	if (!mysqli_query($dbc, $sql)) {
		$errno = mysqli_errno($dbc);
		if ($errno === ER_DUP_ENTRY) {
			return NULL;
		}
		throw new Exception(mysqli_error($dbc));
	}

	return mysqli_insert_id($dbc);
}
