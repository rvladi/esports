<?php
if (isset($error)) {
	$error = htmlspecialchars($error);
}

if (isset($games)) {
	foreach ($games as &$game) {
		$game['name'] = htmlspecialchars($game['name']);
		$game['image'] = urlencode($game['image']);
	}
	unset($game);
}

if (isset($platforms)) {
	foreach ($platforms as &$platform) {
		$platform['name'] = htmlspecialchars($platform['name']);
	}
	unset($platform);
}

if (isset($regions)) {
	foreach ($regions as &$region) {
		$region['name'] = htmlspecialchars($region['name']);
	}
	unset($region);
}

if (isset($tournaments)) {
	foreach ($tournaments as &$tournament) {
		$tournament['title'] = htmlspecialchars($tournament['title']);
		$tournament['image'] = urlencode($tournament['image']);
		$tournament['game'] = htmlspecialchars($tournament['game']);
		$tournament['platform'] = htmlspecialchars($tournament['platform']);
		$tournament['region'] = htmlspecialchars($tournament['region']);
		$tournament['date'] = htmlspecialchars($tournament['date']);
		$tournament['time'] = htmlspecialchars($tournament['time']);
	}
	unset($tournament);
}

if (isset($tournament)) {
	$tournament['title'] = htmlspecialchars($tournament['title']);
	$tournament['image'] = urlencode($tournament['image']);
	$tournament['game'] = htmlspecialchars($tournament['game']);
	$tournament['platform'] = htmlspecialchars($tournament['platform']);
	$tournament['region'] = htmlspecialchars($tournament['region']);
	$tournament['date'] = htmlspecialchars($tournament['date']);
	$tournament['time'] = htmlspecialchars($tournament['time']);
	$tournament['description'] = htmlspecialchars($tournament['description']);
}
