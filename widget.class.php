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
        "title",
        "username",
        "hideBuiltInHeader",
        "showProfile",
        "showBadges",
        "showContests",
        "showChallenges",
        "showDiscussions"
    );

    public function __construct()
    {
        parent::__construct(
            'HackerrankWidget', 'HackerRank :: Profile',
            array('description' => 'A widget to show a small version of your HackerRank profile.')
        );
    }

    public function form($config)
    {
        $config = !empty($config) ? unserialize($config) : array();
        foreach ($this->options as $option) {
            ${$option} = isset($config[$option]) ? $config[$option] : null;
        }
        ob_start("htmlCompress");
        require 'pieces/form.php';
        ob_end_flush();
    }

    public function update($newInstance, $oldInstance)
    {
        $instance = serialize($newInstance);
        return $instance;
    }

    public function widget($args, $config)
    {
        extract($args, EXTR_SKIP);
        $config = !empty($config) ? unserialize($config) : array();

        ob_start("htmlCompress");
        require 'pieces/widget.php';
        ob_end_flush();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("HackerRankProfile");'));
