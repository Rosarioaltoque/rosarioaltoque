<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
<div id="sidebar">
	<div id="sidebar-first-widget-area">
		<?php if ( ! dynamic_sidebar( 'sidebar-first-widget-area' ) ) : ?>
		<?php endif; // end sidebar first widget area ?>
	</div><!-- #sidebar first .widget-area -->
	<div id="sidebar-second-widget-area">
		<?php if ( ! dynamic_sidebar( 'sidebar-second-widget-area' ) ) : ?>
		<?php endif; // end sidebar second widget area ?>
	</div><!-- #sidebar second .widget-area -->
</div><!-- #sidebar widget-area -->
    

