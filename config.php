<?php

define('PLUGIN_URL', plugins_url() . '/hackerrank-profile-widget/');

function hackerRankAddJavaScriptAndCss()
{
    wp_enqueue_style('main-style', PLUGIN_URL . 'css/style.css');

    wp_register_script('angular-core', PLUGIN_URL . 'js/angular.min.js', array(), null, false);
    wp_register_script('my-angular-app', PLUGIN_URL . 'js/app.js', array('angular-core'), null, false);
    wp_enqueue_script('angular-core');
    wp_enqueue_script('my-angular-app');
}

add_action('wp_print_scripts', 'hackerRankAddJavaScriptAndCss');

function htmlCompress($buffer)
{
    $buffer = preg_replace('/<!--([^\[|(<!)].*)/', '', $buffer);
    $buffer = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $buffer);

    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}
