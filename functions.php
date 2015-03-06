<?php

function hackerrank_getHackerRankContent($user, $method = null, $query = null)
{
    $user .= '/';
    if (isset($method)) $method .= '?';
    $url = "https://www.hackerrank.com/rest/hackers/{$user}{$method}{$query}";
    return file_get_contents($url);
}

function hackerrank_getUrlVariables()
{
    do {
        $pathInfo = '';

        if (isset($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
            break;
        }

        if (isset($_SERVER['REDIRECT_URL'])) {
            $pathInfo = $_SERVER['REDIRECT_URL'];
        }
    } while (false); // -_-

    return preg_split('|/|', $pathInfo, -1, PREG_SPLIT_NO_EMPTY); // params -> não compreendo o problem
}
