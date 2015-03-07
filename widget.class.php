<?php

class HackerRankProfile extends WP_Widget
{
    protected $options = array( // TODO: ativar "profiles" por omissão
        "profile",
        //"scores",
        "badges",
        "contests",
        "challenges",
        "discussions"
        //"ratings",
        //"submissions"
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
        if (isset($instance['user'])) {
            $user = $instance['user'];
        }
        // saca da BD
        foreach ($this->options as $option) {
            ${'show' . $option} = $instance['show' . $option];
        }
        require 'pieces/form.php';
    }

    public function update($newInstance, $oldInstance)
    {
        $instance = array();
        $instance['user'] = (!empty($newInstance['user'])) ? strip_tags($newInstance['user']) : '';
        foreach ($this->options as $option) {
            $instance['show' . $option] = $newInstance['show' . $option];
        }
        $instance['darkTheme'] = $newInstance['darkTheme'];
        return $instance;
    }

    public function widget($args, $instance)
    {
        $username = $instance['user'];
        $requestsUrl = PLUGIN_URL . 'requests.php';

        ob_start("htmlCompress");
        require 'pieces/widget.php';
        ob_end_flush();
    }
}

add_action('widgets_init', create_function('', 'return register_widget("HackerRankProfile");'));
