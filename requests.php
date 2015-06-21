<?php
/**
 * Requests Handler
 *
 * @package HackerRank Profile Widget
 * @author Henrique Dias <hacdias@gmail.com>
 * @author Luís Soares <lsoares@gmail.com>
 * @version 1.0.3
 */

function hackerrank_get_url_variables() {
	$pathInfo = '';

	if ( isset( $_SERVER['REDIRECT_URL'] ) ) {
		$pathInfo = $_SERVER['REDIRECT_URL'];
	}

	if ( isset( $_SERVER['PATH_INFO'] ) ) {
		$pathInfo = $_SERVER['PATH_INFO'];
	}

	return preg_split( '|/|', $pathInfo, - 1, PREG_SPLIT_NO_EMPTY );
}

function hackerrank_get_content( $user, $method = null, $query = null ) {
	$user .= '/';
	if ( isset( $method ) ) {
		$method .= '?';
	}
	$url = "https://www.hackerrank.com/rest/hackers/{$user}{$method}{$query}";

	return file_get_contents( $url );
}

$url = hackerrank_get_url_variables();

if ( count( $url ) < 1 ) {
	exit( 'Few arguments.' );
}

$user        = $url[0];
$method      = isset( $url[1] ) ? $url[1] : null;
$queryString = isset( $_GET ) ? http_build_query( $_GET ) : null;

header( 'Access-Control-Allow-Origin: *' );
header( 'Content-Type: application/json' );

echo hackerrank_get_content( $user, $method, $queryString );
