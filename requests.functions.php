<?php
/**
 * Requests function
 *
 * Functions related with the requests made to the HackerRanks server.
 *
 * @package HackerRank Profile Widget
 * @author Henrique Dias <hacdias@gmail.com>
 * @author Luís Soares <lsoares@gmail.com>
 * @version 1.0.0
 */

function hackerRankGetUrlVariables()
{
    $pathInfo = '';

    if (isset($_SERVER['REDIRECT_URL'])) {
        $pathInfo = $_SERVER['REDIRECT_URL'];
    }

    if (isset($_SERVER['PATH_INFO'])) {
        $pathInfo = $_SERVER['PATH_INFO'];
    }

    return preg_split('|/|', $pathInfo, -1, PREG_SPLIT_NO_EMPTY);
}

function hackerRankGetHackerRankContent($user, $method = null, $query = null)
{
    $user .= '/';
    if (isset($method)) $method .= '?';
    $url = "https://www.hackerrank.com/rest/hackers/{$user}{$method}{$query}";
    return file_get_contents($url);
}