<?php
/**
 * Plugin Name: B&B Media Elementor Add-Ons
 * Plugin URI: https://bandbmedia.com/
 * Description: Custom Elementor widgets by B&B Media: Hover Reveal List, Testimonial Slider, Section Intro, Gallery Slider, Logo Carousel, Photo Carousel, Team Grid, Product & Service Grid and Gravity Form.
 * Version: 2.12.1
 * Author: B&B Media, LLC
 * Author URI: https://bandbmedia.com/
 * Requires at least: 6.5
 * Tested up to: 7.1
 * Requires PHP: 7.0
 * Requires Plugins: elementor
 * Update URI: https://github.com/bbmediallc/bb-elementor-addons
 * Text Domain: bb-elementor-addons
 */

// Never rename this file or the bb-elementor-addons folder: WordPress
// identifies the plugin as "bb-elementor-addons/bb-elementor-addons.php",
// and renaming either one would deactivate it on every site that updates.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Must match the Version header above. scripts/build.sh refuses to build
// if they differ.
define( 'BBEA_VERSION', '2.12.1' );
define( 'BBEA_FILE', __FILE__ );
define( 'BBEA_BASENAME', plugin_basename( __FILE__ ) );
define( 'BBEA_URL', plugin_dir_url( __FILE__ ) );
define( 'BBEA_PATH', plugin_dir_path( __FILE__ ) );

require_once BBEA_PATH . 'includes/editor-tweaks.php';
require_once BBEA_PATH . 'includes/admin-featured-image-column.php';
require_once BBEA_PATH . 'includes/updater.php';

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'font-awesome-7', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css', [], '7.0.0' );
} );

add_action( 'elementor/elements/categories_registered', function ( $elements_manager ) {
	$elements_manager->add_category( 'bb-media', [
		'title' => 'B&B Media',
		'icon'  => 'fa fa-plug',
	] );

	$categories = $elements_manager->get_categories();
	if ( ! isset( $categories['basic'], $categories['bb-media'] ) ) {
		return;
	}

	$bb = $categories['bb-media'];
	unset( $categories['bb-media'] );

	$ordered = [];
	foreach ( $categories as $key => $category ) {
		$ordered[ $key ] = $category;
		if ( 'basic' === $key ) {
			$ordered['bb-media'] = $bb;
		}
	}

	( function () use ( $ordered ) {
		$this->categories = $ordered;
	} )->call( $elements_manager );
} );

add_action( 'elementor/frontend/after_register_styles', function () {
	wp_register_style( 'bb-hover-reveal-list', BBEA_URL . 'assets/hover-reveal-list.css', [], BBEA_VERSION );
	wp_register_style( 'bb-testimonial-slider', BBEA_URL . 'assets/testimonial-slider.css', [], BBEA_VERSION );
	wp_register_style( 'bb-section-intro', BBEA_URL . 'assets/section-intro.css', [], BBEA_VERSION );
	wp_register_style( 'bb-gallery-slider', BBEA_URL . 'assets/gallery-slider.css', [], BBEA_VERSION );
	wp_register_style( 'bb-logo-carousel', BBEA_URL . 'assets/logo-carousel.css', [], BBEA_VERSION );
	wp_register_style( 'bb-team-grid', BBEA_URL . 'assets/team-grid.css', [], BBEA_VERSION );
	wp_register_style( 'bb-card-grid', BBEA_URL . 'assets/card-grid.css', [], BBEA_VERSION );
} );

add_action( 'elementor/frontend/after_register_scripts', function () {
	wp_register_script( 'bb-hover-reveal-list', BBEA_URL . 'assets/hover-reveal-list.js', [ 'elementor-frontend' ], BBEA_VERSION, true );
	wp_register_script( 'bb-testimonial-slider', BBEA_URL . 'assets/testimonial-slider.js', [ 'elementor-frontend' ], BBEA_VERSION, true );
	wp_register_script( 'bb-gallery-slider', BBEA_URL . 'assets/gallery-slider.js', [ 'elementor-frontend' ], BBEA_VERSION, true );
	wp_register_script( 'bb-logo-carousel', BBEA_URL . 'assets/logo-carousel.js', [ 'elementor-frontend' ], BBEA_VERSION, true );
} );

add_action( 'elementor/widgets/register', function ( $widgets_manager ) {
	require_once BBEA_PATH . 'widgets/class-hover-reveal-list.php';
	require_once BBEA_PATH . 'widgets/class-testimonial-slider.php';
	require_once BBEA_PATH . 'widgets/class-section-intro.php';
	require_once BBEA_PATH . 'widgets/class-gallery-slider.php';
	require_once BBEA_PATH . 'widgets/class-logo-carousel.php';
	require_once BBEA_PATH . 'widgets/class-photo-carousel.php';
	require_once BBEA_PATH . 'widgets/class-team-grid.php';
	require_once BBEA_PATH . 'widgets/class-card-grid.php';
	require_once BBEA_PATH . 'widgets/class-gravity-form.php';
	$widgets_manager->register( new \BBEA_Hover_Reveal_List_Widget() );
	$widgets_manager->register( new \BBEA_Testimonial_Slider_Widget() );
	$widgets_manager->register( new \BBEA_Section_Intro_Widget() );
	$widgets_manager->register( new \BBEA_Gallery_Slider_Widget() );
	$widgets_manager->register( new \BBEA_Logo_Carousel_Widget() );
	$widgets_manager->register( new \BBEA_Photo_Carousel_Widget() );
	$widgets_manager->register( new \BBEA_Team_Grid_Widget() );
	$widgets_manager->register( new \BBEA_Card_Grid_Widget() );
	$widgets_manager->register( new \BBEA_Gravity_Form_Widget() );
} );
