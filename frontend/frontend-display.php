<?php
/**
 * Frontend display for WordPress Slideshow Plugin.
 *
 * This file contains the shortcode implementation for displaying the slideshow on the frontend.
 *
 * @package WordPressSlideshowPlugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Shortcode for displaying the slideshow.
 *
 * This function generates the HTML for the slideshow based on saved images,
 * captions, and links. It also includes JavaScript for slideshow functionality.
 *
 * @return string The HTML and JavaScript for the slideshow.
 */
function wsp_slideshow_shortcode() {
	$images   = get_option( 'wsp_images' );
	$captions = get_option( 'wsp_captions' );
	$links    = get_option( 'wsp_links' );

	if ( ! $images ) {
		return ''; // Return empty string if there are no images.
	}

	$html = '<div id="wsp-slideshow" class="wsp-slideshow">';
	foreach ( $images as $index => $image ) {
		$caption = isset( $captions[ $index ] ) ? $captions[ $index ] : '';
		$link    = isset( $links[ $index ] ) && ! empty( $links[ $index ] ) ? $links[ $index ] : '';

		$html .= '<div class="wsp-slide">';
		if ( ! empty( $link ) ) {
			$html .= '<a href="' . esc_url( $link ) . '">';
		}

		$html .= '<img src="' . esc_url( $image ) . '" />';

		if ( ! empty( $caption ) ) {
			$html .= '<p class="wsp-caption">' . esc_html( $caption ) . '</p>';
		}

		if ( ! empty( $link ) ) {
			$html .= '</a>';
		}
		$html .= '</div>';
	}
	$html .= '</div>';

	$html .= '<script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#wsp-slideshow").slick({
                dots: true,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: "linear",
                autoplay: true,
                autoplaySpeed: 2000,
            });
        });
    </script>';

	return $html;
}
add_shortcode( 'myslideshow', 'wsp_slideshow_shortcode' );
