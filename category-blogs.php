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
            <div class="cont_tit_cat">
				<h1 class="page-title"><?php
					printf( __( 'Archivos: %s', 'twentyten' ), '' . single_cat_title( '', false ) . '' );
				?></h1></div>
            	<div id="rat-cont">
                <div id="rat-cont-item">
                <?php
					$id_category_blogs = get_category_by_slug( 'blogs' )->term_id;
					$args = array('child_of' => $id_category_blogs);
                	$categories = get_categories( $args );
					foreach ($categories as $cat) {
						echo '<div id="rat-item">';
						echo '<div id="rat-avatar-106">';
						echo '<a href="' . get_category_link($cat->cat_ID) .'">';
						if (function_exists('get_terms_meta')) {
							$src_imagen = get_terms_meta($cat->cat_ID, 'imagen');
						}
						$query = $wpdb->prepare("SELECT wp_posts.ID FROM wp_posts where wp_posts.guid = '".$src_imagen[0]."' ");
						$image_post = $wpdb->get_row($query,ARRAY_A);
						$image_attributes = wp_get_attachment_image_src( @$image_post["ID"], 'Miniatura servicios' );
						echo '<img title="' . $cat->name . '"  alt="" src="'.$image_attributes[0].'" class="aligncenter">';
						echo '</a>';
						echo '</div>';
        				echo '<div id="rat-cont-text" class="rat-cont-text-106">';
						echo '<div id="rat-item-titulo">';
						echo '<a href="' . get_category_link($cat->cat_ID) .'">';
						echo $cat->name;
						echo '</a>';
						echo '</div>';
						echo '<div id="rat-item-descripcion">';
						echo  $cat->description;
						echo '</div>';
         				echo '<div id="rat-item-pie"><img src="/wp-content/themes/rcd/images/ico_entr_18.png" width="18" height="18" align="absmiddle" />  ';
						echo $cat->count .' entrada';
						if ($cat->count != 1) {
							echo 's';
						}
						echo '</div>';
            			echo '</div><br class="clear"></div>';
					}
				?> 
                </div><!-- #rat-cont-item-->
	    		</div><!-- #rat-cont-->
    		</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
