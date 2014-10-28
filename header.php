<?php
/**
 * The Header for Reach
 *
 * Displays all of the <head> section and everything up till main content
 *
 * @package Reach
 * @since Reach 1.0
 */
?>
<!doctype html>
<html class="no-js" <?php language_attributes() ?>>
	<?php do_action( 'dc_html_head' ) ?>
	<body <?php body_class( 'main-wrapper' ) ?> >
		<div class="main-container">
			<?php do_action( 'rh_main_header' ) ?>