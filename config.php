<?php

require 'functions.php';

class HackerRankProfile extends WP_Widget
{
    protected $options = array( // TODO: ativar "profiles" por omissão
        "profile",
        "scores",
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
        // guarda na BD
        foreach ($this->options as $option) {
            $instance['show' . $option] = $newInstance['show' . $option];
        }
        return $instance;
    }

    public function widget($args, $instance)
    {
        $username = $instance['user'];
        $requestsUrl = PLUGIN_URL . 'requests.php';
        require 'pieces/widget.php';
    }
}
