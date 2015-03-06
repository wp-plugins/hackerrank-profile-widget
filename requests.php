<?php

require_once 'functions.php';

$url = hackerrank_getUrlVariables();

if (count($url) < 1) {
    exit('Few arguments.');
}

$user = $url[0];
$method = isset($url[1]) ? $url[1] : null;
$queryString = isset($_GET) ? http_build_query($_GET) : null;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo hackerrank_getHackerRankContent($user, $method, $queryString);
