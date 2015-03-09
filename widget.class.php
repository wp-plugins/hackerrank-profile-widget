<?php

/**
 * Widget Class
 *
 * @package HackerRank Profile Widget
 * @author Henrique Dias <hacdias@gmail.com>, Luís Soares <lsoares@gmail.com>
 * @version 1.0.0
 */
class HackerRankProfile extends WP_Widget
{
    /**
     * Options
     *
     * The names of the options the plugin can handle.
     *
     * @todo "profile" option by default
     * @todo add options : scores, ratings and submissions
     * @var $options array
     */
    protected $options = array(
        "text" => array(
            'title',
            'username'
        ),
        "checkboxes" => array(
            'Hide_Built_In_Header',
        ),
        "showOptions" => array(
            "profile",
            "badges",
            "contests",
            "challenges",
            "discussions"
        )
    );

    public function __construct()
    {
        parent::__construct(
            'HackerrankWidget', 'HackerRank :: Profile',
            array('description' => 'A widget to show a small version of your HackerRank profile.')
        );
    }

    public function form($instance)
    {
        foreach ($this->options['text'] as $option) {
            ${$option} = isset($instance[$option]) ? $instance[$option] : null;
        }
        foreach ($this->options['checkboxes'] as $option) {
            ${$option} = $instance[$option];
        }
        foreach ($this->options['showOptions'] as $option) {
            ${'show' . $option} = $instance['show' . $option];
        }
        ob_start("htmlCompress");
        require 'pieces/form.php';
        ob_end_flush();
    }

    public function update($newInstance, $oldInstance)
    {
        $instance = array();
        foreach ($this->options['text'] as $option) {
            $instance[$option] = (!empty($newInstance[$option])) ? strip_tags($newInstance[$option]) : '';
        }
        foreach ($this->options['checkboxes'] as $option) {
            $instance[$option] = $newInstance[$option];
        }
        foreach ($this->options['showOptions'] as $option) {
            $instance['show' . $option] = $newInstance['show' . $option];
        }
        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $requestsUrl = HACKERRANK_PLUGIN_URL . 'requests.php';

        ob_start("htmlCompress");
        require 'pieces/widget.php';
        ob_end_flush();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("HackerRankProfile");'));
