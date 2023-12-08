<?php
/**
 * Unit tests for WordPress Slideshow Plugin.
 *
 * This file contains PHPUnit tests for testing the WordPress Slideshow Plugin functionalities.
 *
 * @package WordPressSlideshowPlugin
 */

use Brain\Monkey;
use PHPUnit\Framework\TestCase;
use function Brain\Monkey\Functions\expect;

/**
 * SampleTest class for testing WordPress Slideshow Plugin functions.
 */
class SampleTest extends TestCase {

	/**
	 * Set up the test environment before each test.
	 */
	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	/**
	 * Tear down the test environment after each test.
	 */
	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

	/**
	 * Test the wsp_add_admin_menu function.
	 */
	public function testWspAddAdminMenu() {
		expect( 'add_menu_page' )->once()->with( 'Slideshow Plugin', 'Slideshow Plugin', 'manage_options', 'wordpress_slideshow_plugin', 'wsp_settings_page' );

		// Run the wsp_add_admin_menu function to see if it behaves as expected.
		wsp_add_admin_menu();
	}
}
