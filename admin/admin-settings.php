<?php
/**
 * Admin settings for WordPress Slideshow Plugin.
 *
 * This file contains the admin settings page for the slideshow plugin, allowing users
 * to manage images, captions, and links for their slideshows.
 *
 * @package WordPressSlideshowPlugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds an admin menu for the slideshow plugin.
 *
 * @return void
 */
function wsp_add_admin_menu() {
	add_menu_page( 'Slideshow Plugin', 'Slideshow Plugin', 'manage_options', 'wordpress_slideshow_plugin', 'wsp_settings_page' );
}
add_action( 'admin_menu', 'wsp_add_admin_menu' );

/**
 * Settings page layout for the slideshow plugin.
 */
function wsp_settings_page() {
	$images   = get_option( 'wsp_images' ) ? get_option( 'wsp_images' ) : array(); // Replaced short ternary with full ternary.
	$captions = get_option( 'wsp_captions' ) ? get_option( 'wsp_captions' ) : array(); // Replaced short ternary with full ternary.
	$links    = get_option( 'wsp_links' ) ? get_option( 'wsp_links' ) : array(); // Replaced short ternary with full ternary.
	?>
	<div class="wrap">
		<h1>WordPress Slideshow Plugin</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'wsp_settings_group' ); ?>
			<?php do_settings_sections( 'wsp_settings_group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Images</th>
					<td>
						<ul id="wsp-image-list" style="list-style-type: none; padding: 0;">
							<?php
							foreach ( $images as $index => $image ) :
								$caption = $captions[ $index ] ?? '';
								$link    = $links[ $index ] ?? '';
								?>
								<li class="wsp-image-item">
									<div class="wsp-image-preview">
										<img src="<?php echo esc_url( $image ); ?>" height="100px" width="100px">
										<span class="wsp-remove-image-x">X</span>
									</div>
									<div class="wsp-image-details">
										<input type="hidden" name="wsp_images[]" value="<?php echo esc_url( $image ); ?>">
										<input type="text" name="wsp_captions[]" placeholder="Enter caption" value="<?php echo esc_attr( $caption ); ?>">
										<input type="text" name="wsp_links[]" placeholder="Enter URL" value="<?php echo esc_url( $link ); ?>">
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
						<button type="button" id="wsp-add-image-btn" class="button">Add Image</button>
						<p style="margin-top: 10px;"><strong>Ideal image size:</strong> 800 x 300 pixels for optimal display. You can sort the slides by drag  & drop them</p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#wsp-add-image-btn').click(function(e) {
				e.preventDefault();
				var imageUploader = wp.media({
					'title': 'Add Image to Slideshow',
					'button': {
						'text': 'Add Image'
					},
					'multiple': true
				}).on('select', function() {
					var selection = imageUploader.state().get('selection');
					selection.map(function(attachment) {
						attachment = attachment.toJSON();
						$('#wsp-image-list').append(
							'<li class="wsp-image-item">' +
							'<div class="wsp-image-preview">' +
							'<span class="wsp-remove-image-x">X</span>' +
							'<img src="' + attachment.url + '" height="100px" width="100px">' +
							'</div>' +
							'<div class="wsp-image-details">' +
							'<input type="hidden" name="wsp_images[]" value="' + attachment.url + '">' +
							'<input type="text" name="wsp_captions[]" placeholder="Enter caption">' +
							'<input type="text" name="wsp_links[]" placeholder="Enter URL">' + // Add this line
							'</div>' +
							'</li>'
						);
					});
				}).open();
			});
	
			// Remove image event
			$('#wsp-image-list').on('click', '.wsp-remove-image-x', function() {
				$(this).closest('.wsp-image-item').remove();
			});
	
			// Initialize sortable
			$('#wsp-image-list').sortable({
				opacity: 0.7
				// Add any additional sortable options here
			});
		});
	</script>
	<?php
}
?>
