<?php
/**
 * Bootstrap file for unit tests.
 *
 * Sets up the testing environment, including error reporting and including necessary files.
 * Uses Brain\Monkey for mocking WordPress functions.
 *
 * @package WordPressSlideshowPlugin
 */

// Define WP_DEBUG and WP_DEBUG_DISPLAY constants for error reporting in testing environment.
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}
if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
	define( 'WP_DEBUG_DISPLAY', true );
}

// Autoload dependencies.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Set up Brain\Monkey for WordPress function mocking.
\Brain\Monkey\setUp();

// Uncomment and modify according to the specific functions you need to mock.
// For example, use \Brain\Monkey\Functions\stubs(['add_action', 'add_menu_page', ...]).

// Include plugin files that contain the functions to be tested.
require_once dirname( __DIR__ ) . '/admin/admin-settings.php';
