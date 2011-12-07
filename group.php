<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
		<div id="container">
			<div id="content" role="main">
            	<div id="content-top-widget-area">
					<?php if ( ! dynamic_sidebar( 'content-top-widget-area' ) ) : ?>
					<?php endif; ?>
	    		</div><!-- #content-top-widget-area -->
            	<div id="content-left-widget-area">
					<?php if ( ! dynamic_sidebar( 'content-left-widget-area' ) ) : ?>
					<?php endif; ?>
	    		</div><!-- #content-left-widget-area -->
            	<div id="content-right-widget-area">
					<?php if ( ! dynamic_sidebar( 'content-right-widget-area' ) ) : ?>
					<?php endif; ?>
	    		</div><!-- #content-right-widget-area -->
            	<div id="content-bottom-widget-area">
					<?php if ( ! dynamic_sidebar( 'content-bottom-widget-area' ) ) : ?>
					<?php endif; ?>
	    		</div><!-- #content-bottom-widget-area -->
    		</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
