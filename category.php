<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div id="container">
	<div id="content" role="main">
		<div class="cont_tit_cat">
			<h1 class="page-title">
				<?php
					printf( __( 'Archivos: %s', 'twentyten' ), '' . single_cat_title( '', false ) . '' );
				?>
			</h1>
		</div>
		<?php 
			$cat = get_the_category(); 
		?>
		<?php
			if (function_exists('get_terms_meta')) {
				$metaValue = get_terms_meta($cat[0]->cat_ID, 'imagen');
			}
			$category_description = category_description();
			if ( ! empty( $category_description ) ) {
				echo '<div class="cont_desc_cat">';
				echo '<div class="archive-meta">';
				// se podria mejorar buscando una funcino que devuelva el id del post desde el guid
				$query = $wpdb->prepare("select wp_posts.ID from wp_posts where guid = %s", $metaValue[0]);
				$post = $wpdb->get_row($query,ARRAY_A);
				$image_attributes = wp_get_attachment_image_src( @$post["ID"], 'Pleno categoria', true );
				echo '<img title="' . single_cat_title( '', false ) . '" alt="" src="'.$image_attributes[0].'" class="alignleft">';
				//echo '<img title="' . single_cat_title( '', false ) . '" alt="" src="'.$metaValue[0].'" class="alignleft">';
				echo $category_description ;
				echo '</div>';
				echo '</div>';
			}

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>

			</div><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
