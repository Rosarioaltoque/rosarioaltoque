<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->
	<link href="style.css" rel="stylesheet" type="text/css" />
	
	<div id="footer">
		<div id="footer-left-widget-area">
			<?php if ( ! dynamic_sidebar( 'footer-left-widget-area' ) ) : ?>
			<?php endif; // end footer left widget area ?>
		</div><!-- #footer-left-widget-area -->
		<div id="footer-middle-widget-area">
			<?php if ( ! dynamic_sidebar( 'footer-middle-widget-area' ) ) : ?>
			<?php endif; // end footer middle widget area ?>
		</div><!-- #footer-middle-widget-area -->
		<div id="footer-right-widget-area">
			<?php if ( ! dynamic_sidebar( 'footer-right-widget-area' ) ) : ?>
			<?php endif; // end footer right widget area ?>
		</div><!-- #footer-right-widget-area -->
        <br class="clear">
		<div class="logos-footer"> <a href="http://www.rosario.gov.ar" target="_blank"><img src="/wp-content/themes/rcd/images/logo_muni.gif" width="291" height="72" border="0" /></a><a href="http://www.polotecnologico.net/" target="_blank"><img src="/wp-content/themes/rcd/images/logo_polo.gif" width="291" height="49" border="0" /></a><a href="/rosario-ciudad-digital/"><img src="/wp-content/themes/rcd/images/logo_ciudaddigital.gif" width="291" height="58" border="0" /></a></div><!-- #logos-footer -->
	</div><!-- #footer -->
</div><!-- #wrapper -->
</body>
</html>
