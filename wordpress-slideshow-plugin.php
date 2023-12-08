<?php
/**
 * Plugin Name: WordPress Slideshow Plugin
 * Description: A simple slideshow plugin for WordPress. To use the slideshow, upload your images through plugin setting page and then put [myslideshow] wherever you want to display the slideshow.
 * Version: 1.0
 * Author: Alireza Ebrahimi
 *
 * @package WordPressSlideshowPlugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Add filter to add custom action link.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wsp_add_action_links' );

/**
 * Adds custom action links to the plugin page.
 *
 * @param array $links An array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function wsp_add_action_links( $links ) {
	$mylinks = array(
		'<a href="' . admin_url( 'admin.php?page=wordpress_slideshow_plugin' ) . '">Settings</a>',
	);
	return array_merge( $links, $mylinks );
}

/**
 * Enqueues admin-specific styles and scripts.
 *
 * @param string $hook The current admin page.
 */
function wsp_enqueue_admin_scripts( $hook ) {
	if ( 'toplevel_page_wordpress_slideshow_plugin' !== $hook ) {
		return;
	}
	wp_enqueue_media(); // Enqueue the WordPress media uploader scripts.
	wp_enqueue_script( 'jquery-ui-sortable' ); // For sortable images.
	wp_enqueue_style( 'wsp-admin-style', plugin_dir_url( __FILE__ ) . 'admin/admin.css', array(), '1.0' );
}
add_action( 'admin_enqueue_scripts', 'wsp_enqueue_admin_scripts' );

/**
 * Enqueues frontend scripts and styles.
 */
function wsp_enqueue_frontend_scripts() {
	if ( ! is_admin() ) {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'slick-slider', plugin_dir_url( __FILE__ ) . 'libs/js/slick.min.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'slick-slider-style', plugin_dir_url( __FILE__ ) . 'libs/css/slick.css', array(), '1.0' );
		if ( file_exists( plugin_dir_path( __FILE__ ) . 'libs/css/slick-theme.css' ) ) {
			wp_enqueue_style( 'slick-slider-theme-style', plugin_dir_url( __FILE__ ) . 'libs/css/slick-theme.css', array(), '1.0' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'wsp_enqueue_frontend_scripts' );

// Include the admin settings page.
require_once plugin_dir_path( __FILE__ ) . 'admin/admin-settings.php';

// Include the frontend display functions.
require_once plugin_dir_path( __FILE__ ) . 'frontend/frontend-display.php';

/**
 * Registers plugin settings.
 */
function wsp_register_settings() {
	register_setting( 'wsp_settings_group', 'wsp_images', 'wsp_sanitize_images' );
	register_setting( 'wsp_settings_group', 'wsp_captions' );
	register_setting( 'wsp_settings_group', 'wsp_links' );
}
add_action( 'admin_init', 'wsp_register_settings' );

/**
 * Sanitizes image URLs.
 *
 * @param array $input The input array of image URLs.
 * @return array The sanitized array.
 */
function wsp_sanitize_images( $input ) {
	return array_map( 'esc_url_raw', $input );
}
