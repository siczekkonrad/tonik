<?php
/**
 * Recruitment WP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Recruitment_WP
 */

if( ! function_exists('basic_setup')) :

	function basic_setup() {

		add_theme_support( 'post-thumbnails' ); 

		register_nav_menus(
			array(
			  'top' => __( 'Top Menu' )
			)
		);

	}
endif;

add_action( 'init', 'basic_setup' );
add_theme_support( 'custom-logo',array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
) );


if ( ! function_exists( 'recruitment_wp_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function recruitment_wp_setup() {
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );
	}
endif;
add_action( 'after_setup_theme', 'recruitment_wp_setup' );

function tonik_theme_styles(){

	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/public/css/theme.css', array());

}

add_action('wp_enqueue_scripts', 'tonik_theme_styles');
