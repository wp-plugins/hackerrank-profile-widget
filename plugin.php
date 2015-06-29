<?php

/**
 * Plugin Name: HackerRank Profile Widget
 * Description: This is a plugin that shows your HackerRank profile with a simple widget.
 * Version: 1.3.0
 * Author: Henrique Dias and Luís Soares (Refactors)
 * Author URI: https://github.com/refactors
 * Network: true
 * License: GPL2 or later
 *
 * HackerRank Profile Widget for WordPress
 *
 *     Copyright (C) 2015 Henrique Dias     <hacdias@gmail.com>
 *     Copyright (C) 2015 Luís Soares       <lsoares@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once 'lib/htmlcompressor.php';

define( 'HACKERRANK_REQUESTS', plugins_url( 'requests.php', __FILE__ ) );

class HackerRank_Profile extends WP_Widget {

	protected $widget_slug = 'hackerrank-profile-widget';

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
		"theme",
		"hideBuiltInHeader",
		"showProfile",
		"showBadges",
		"showContests",
		"showChallenges",
		"showDiscussions"
	);

	public function __construct() {
		parent::__construct(
			'HackerrankWidget', 'HackerRank Profile',
			array( 'description' => 'A widget to show a small version of your HackerRank profile.' )
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_scripts' ) );
	}

	public function form( $config ) {
		$config = ! empty( $config ) ? unserialize( $config ) : array();
		foreach ( $this->options as $option ) {
			${$option} = isset( $config[ $option ] ) ? $config[ $option ] : null;
		}
		ob_start( "refactors_HTMLCompressor" );
		require 'views/form.php';
		ob_end_flush();
	}

	public function update( $newInstance, $oldInstance ) {
		$instance = serialize( $newInstance );

		return $instance;
	}

	public function widget( $args, $config ) {
		extract( $args, EXTR_SKIP );
		$config = ! empty( $config ) ? unserialize( $config ) : array();

		$config['theme'] = isset( $config['theme'] ) ? $config['theme'] : null;

		switch ( $config['theme'] ) {
			case 'dark':
				wp_enqueue_style( 'dark-style', plugins_url( 'css/dark.css', __FILE__ ) );
				break;
			case 'balanced':
				wp_enqueue_style( 'balanced-style', plugins_url( 'css/balanced.css', __FILE__ ) );
				break;
			case 'light':
			default:
			wp_enqueue_style( 'light-style', plugins_url( 'css/light.css', __FILE__ ) );
		}

		ob_start( "refactors_HTMLCompressor" );
		require 'views/widget.php';
		ob_end_flush();
	}

	public function register_widget_styles() {;
		wp_enqueue_style( $this->get_widget_slug() . '-widget-styles', plugins_url( 'css/general.css', __FILE__ ) );
	}

	public function get_widget_slug() {
		return $this->widget_slug;
	}

	public function register_widget_scripts() {
		wp_register_script( $this->get_widget_slug() . 'angular-core', plugins_url( 'vendor/angular/angular.min.js', __FILE__ ), array(), null, true );
		wp_register_script( $this->get_widget_slug() . 'my-angular-app', plugins_url( 'js/app.js', __FILE__ ), array( $this->get_widget_slug() . 'angular-core' ), null, true );
		wp_enqueue_script( $this->get_widget_slug() . 'angular-core');
		wp_enqueue_script( $this->get_widget_slug() . 'my-angular-app' );
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget("HackerRank_Profile");' ) );
