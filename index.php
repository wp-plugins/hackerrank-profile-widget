<?php
/**
 * Plugin Name: HackerRank Profile Widget
 * Description: This is a plugin that shows your HackerRank profile with a simple widget.
 * Version: 0.9.3
 * Author: Henrique Dias, Luís Soares
 * Author URI: http://henriquedias.com, http://luissoares.com
 * Network: true
 * License: GPL2 or later
 */

define('PLUGIN_URL', plugins_url() . '/hackerrank-profile-widget/');

require_once 'config.php';

add_action('widgets_init', create_function('', 'return register_widget("HackerRankProfile");'));
add_action('wp_print_scripts', 'addJavaScriptAndCss');

function addJavaScriptAndCss()
{
    wp_enqueue_style('main-style', PLUGIN_URL . 'css/style.css');

    wp_register_script('angular-core', PLUGIN_URL .'js/angular.min.js', array(), null, false);
    wp_register_script('my-angular-app', PLUGIN_URL . 'js/app.js', array('angular-core'), null, false);
    wp_enqueue_script('angular-core');
    wp_enqueue_script('my-angular-app');
}
