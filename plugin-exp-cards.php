<?php
/**
 * Plugin Name: Expanding Cards Plugin
 * Description: A custom Elementor widget for expanding cards.
 * Version: 1.0
 * Author: Mian Moiz
 * Author URI: https://github.com/moizxox
 * License: GPL2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register the widget
function ece_register_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/widget-exp-cards.php' );
    $widgets_manager->register( new \Expanding_Cards_Widget() );
}
add_action( 'elementor/widgets/register', 'ece_register_widget' );
