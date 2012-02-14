<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'rcd' ),
	) );
	register_nav_menus( array(
		'secondary' => __( 'Secondary Navigation', 'rcd' ),
	) );

}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Ver m&aacute;s <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since Twenty Ten 1.2
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Deprecated way to remove inline styles printed when the gallery shortcode is used.
 *
 * This function is no longer needed or used. Use the use_default_gallery_style
 * filter instead, as seen above.
 *
 * @since Twenty Ten 1.0
 * @deprecated Deprecated in Twenty Ten 1.2 for WordPress 3.1
 *
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">escribió:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Su comentario fue enviado para ser validado.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?> - <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/*registro de srcipts utilizados por el sitio entero*/

wp_register_script('OpenLayers', get_template_directory_uri().'/js/OpenLayers.js');

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function rcd_widgets_init() {
	// Group Area 1, located at the first of the group sidebar.
	register_sidebar( array(
		'name' => __( 'Group Sidebar First Widget Area', 'rcd' ),
		'id' => 'group-sidebar-first-widget-area',
		'description' => __( 'The group sidebar first widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 1, located at the first of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar First Widget Area', 'rcd' ),
		'id' => 'sidebar-first-widget-area',
		'description' => __( 'The sidebar first widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 1, located at the second of the sidebar.
	register_sidebar( array(
		'name' => __( 'Sidebar Second Widget Area', 'rcd' ),
		'id' => 'sidebar-second-widget-area',
		'description' => __( 'The sidebar second widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

// Area derecha de content.
	register_sidebar( array(
		'name' => __( 'Content Right Widget Area', 'rcd' ),
		'id' => 'content-right-widget-area',
		'description' => __( 'The content right widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

// Area inferior de content.
	register_sidebar( array(
		'name' => __( 'Content Bottom Widget Area', 'rcd' ),
		'id' => 'content-bottom-widget-area',
		'description' => __( 'The content bottom widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

// Area izquierda de content.
	register_sidebar( array(
		'name' => __( 'Content Left Widget Area', 'rcd' ),
		'id' => 'content-left-widget-area',
		'description' => __( 'The content left widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

// Area superior de content.
	register_sidebar( array(
		'name' => __( 'Content Top Widget Area', 'rcd' ),
		'id' => 'content-top-widget-area',
		'description' => __( 'The content top widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area located in left of the footer. 
	register_sidebar( array(
		'name' => __( 'Footer Left Widget Area', 'rcd' ),
		'id' => 'footer-left-widget-area',
		'description' => __( 'The footer left widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area located in middle of the footer. 
	register_sidebar( array(
		'name' => __( 'Footer Middle Widget Area', 'rcd' ),
		'id' => 'footer-middle-widget-area',
		'description' => __( 'The footer middle widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area located in right of the footer. 
	register_sidebar( array(
		'name' => __( 'Footer Right Widget Area', 'rcd' ),
		'id' => 'footer-right-widget-area',
		'description' => __( 'The footer right widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	// Area located in the header. 
	register_sidebar( array(
		'name' => __( 'Header Widget Area', 'rcd' ),
		'id' => 'header-widget-area',
		'description' => __( 'The header widget area', 'rcd' ),
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );


	/* registro de widgets*/
	add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Twitter_Hash_Tag1");'));


}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'rcd_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * This function uses a filter (show_recent_comments_widget_style) new in WordPress 3.1
 * to remove the default style. Using Twenty Ten 1.2 in WordPress 3.0 will show the styles,
 * but they won't have any effect on the widget in default Twenty Ten styling.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Publicado el</span> %2$s <span class="meta-sep">por</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'Esta entrada fue publicada en %1$s y etiquetada %2$s. Agendar el <a href="%3$s" title="Permalink to %4$s" rel="bookmark">enlace permanente</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'Esta entrada fue publicada en %1$s. Agendar el <a href="%3$s" title="Permalink to %4$s" rel="bookmark">enlace permanente</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/**
* Programacion de capas de mapa
*/

function getDivCapasMapa($idDivCapas){
	$divCapaMapa = new divCapaMapa($idDivCapas);
	return $divCapaMapa->getHTML();
}

class capaMapa {
	function __construct($args = array()) {
		$this->nombre = $args['nombre'];
		$this->tipo = $args['tipo'];
		if ($args['padre']) {
			$this->padre = $args['padre'];
		}
		if ($this->tipo->nombre == 'Entradas') {
			$this->URLFeed = '/category/'.$args['slug'].'/feed';
		}
		if ($this->tipo->nombre == 'Comunidades') {
			$this->URLFeed = '/groups/'.$args['slug'].'/feed';
		}
		if ($this->tipo->nombre == 'Servicios') {
			$this->URLFeed = get_template_directory_uri().'/feed-servicios.php?category_id='.$args['category_id'];
		}
		if ($this->tipo->nombre == 'Agrupador') {
			$this->slug .= $this->padre->slug.$args['slug'].'_';
		} else {
			$this->slug = $this->tipo->slug.'-'.$args['slug'];
		}
		$this->slugHijos = array();
		if ($this->padre) {
			$this->padre->insertarSlugHijo($this->slug);
		}
	}
	function insertarSlugHijo($slug) {
		$this->slugHijos[] = $slug;
	}
}

class tipoDeCapaMapa {
	function __construct($args = array()) {
		$this->nombre = $args['nombre'];
		$this->slug = $args['slug'];
	}
}

class divCapaMapa {
	function __construct($idDivCapas) {
		$this->idDivCapas = $idDivCapas;
		$this->capas = getArregloCapaMapa();
	}
	function getCapaBySlug($slug) {
		foreach ($this->capas as $capa) {
			if ($capa->slug == $slug) {
				return $capa;
			}
		}
		return null;
	}
	function getHTML() {
		$html .= '<script>var arregloCapaMapa = eval(unescape(\'('.urlencode(json_encode($this->capas)).')\'))	</script>';
		$html .= '<div id="'.$this->idDivCapas.'">';
		$html .= '<form id="formCapas" name="formCapas">';
		$html .= $this->getDivCapa($this->getCapaBySlug('_'));
		$html .= '</form>';
		$html .= '</div>';
		return $html;
	}
	function getDivCapa($capa) {
		if ($capa->padre) {
			$divCapa .= '<div id=grupoFamiliarCapaMapa>';
			$divCapa .= '<div id=individuoCapaMapa>';
			$divCapa .= '<div id=nodoCapaMapa>';
			$divCapa .= '</div>'; // nodoCapaMapa
			if (count($capa->slugHijos) > 0) {
				$divCapa .= '<div id=nodoCapaMapa>';
				$divCapa .= '<a href="javascript:mostrarNodo(\''.$capa->slug.'\')"><img id="img'.$capa->slug.'" class="nodo-capa-mapa" src="'.get_template_directory_uri().'/images/nodo-capa-mapa-contraido.png"></a>';
				$divCapa .= '</div>'; // nodoCapaMapa
			}
			if ($capa->tipo->nombre == 'Agrupador') {
			}
			$divCapa .= '<div id=checkboxCapaMapa>';
			$divCapa .= '<input type=checkbox id="cb_'.$capa->slug.'" name="cb_'.$capa->slug.'" onClick=javascript:mostrarCapa(\''.$capa->slug.'\') checked>';
			$divCapa .= '</div>'; // checkboxCapaMapa
			$divCapa .= '<div id=nombreCapaMapa>'.$capa->nombre.'</div>';
			$divCapa .= '</div>'; // individuoCapaMapa
			$divCapa .= '<div id=familiaresCapaMapa style="position:absolute;visibility:hidden">';
			$divCapa .= '<div id=nivelCapaMapa></div>';
			$divCapa .= '<div id=hijosCapaMapa>';
		}
		foreach ( $capa->slugHijos as $slug ) {
			$capaHijo = $this->getCapaBySlug($slug);
			$divCapa .= $this->getDivCapa($capaHijo);
		}
		if ($capa->padre) {
			$divCapa .= '</div>'; // hijosCapaMapa
			$divCapa .= '</div>'; // familiaresCapaMapa
			$divCapa .= '</div>'; // grupoFamiliarCapaMapa
		}
		return $divCapa;
	}
}

function getArregloCapaMapa() {
	$arregloCapaMapa = array();
	$tipoAgrupador = new tipoDeCapaMapa(array('nombre' => 'Agrupador', 'slug' => 'agrupador'));
	$tipoEntradas = new tipoDeCapaMapa(array('nombre' => 'Entradas', 'slug' => 'category'));
	$tipoComunidades = new tipoDeCapaMapa(array('nombre' => 'Comunidades', 'slug' => 'group'));
	$tipoServicios = new tipoDeCapaMapa(array('nombre' => 'Servicios', 'slug' => 'servicio'));

	$capaRaiz = new capaMapa(array('nombre' => 'Raiz', 'tipo' => $tipoAgrupador, 'slug' => ''));
	$arregloCapaMapa[] = $capaRaiz;

	$capaAlertas = new capaMapa(array('nombre' => 'Alertas', 'tipo' => $tipoAgrupador, 'padre' => $capaRaiz, 'slug' => 'alertas'));
	$arregloCapaMapa[] = $capaAlertas;
	$id_category_alertas = get_category_by_slug( 'alertas' )->term_id;
	$args = array('child_of' => $id_category_alertas);
	$categories = get_categories( $args );
	foreach ($categories as $cat) {
		$capaCategoria = new capaMapa(array('nombre' => $cat->cat_name, 'tipo' => $tipoEntradas, 'padre' => $capaAlertas, 'slug' => $cat->category_nicename));
		$arregloCapaMapa[] = $capaCategoria;
	}
	$capaComunidades = new capaMapa(array('nombre' => 'Comunidades', 'tipo' => $tipoAgrupador, 'padre' => $capaRaiz, 'slug' => 'comunidades'));
	$arregloCapaMapa[] = $capaComunidades;
	if ( bp_has_groups() ) :
		while ( bp_groups() ) : bp_the_group();
			$capaComunidad = new capaMapa(array('nombre' => bp_get_group_name(), 'tipo' => $tipoComunidades, 'padre' => $capaComunidades, 'slug' => bp_get_group_slug()));
			$arregloCapaMapa[] = $capaComunidad;
		endwhile;
	endif;

	$capaServicios = new capaMapa(array('nombre' => 'Servicios', 'tipo' => $tipoAgrupador, 'padre' => $capaRaiz, 'slug' => 'servicios'));
	$arregloCapaMapa[] = $capaServicios;
	global $wpdb;
	$categories = $wpdb->get_results("SELECT * FROM wp_sd_categories WHERE hide !=1 ORDER BY category ASC",ARRAY_A);
	foreach($categories as $category) {
		$slug = strtolower(@$category["category"]);
		$slug = str_replace(" ", "-", $slug);
		$capaCategoria = new capaMapa(array('nombre' => @$category["category"], 'tipo' => $tipoServicios, 'padre' => $capaServicios, 'slug' => $slug, 'category_id' => @$category["category_id"]));
		$arregloCapaMapa[] = $capaCategoria;
	}

//	$arregloCapaMapa = array ($capaAlertas, $arregloCapasAlertas, $capaComunidades, $arregloCapasComunidades, $capaServicios);

	return $arregloCapaMapa;
}

if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
define( 'BP_AVATAR_FULL_WIDTH', 220 ); //change this with your desired full size,weel I changed it to 260 <img src="http://buddydev.com/wp-includes/images/smilies/icon_smile.gif" alt=":)" class="wp-smiley">
if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
define( 'BP_AVATAR_FULL_HEIGHT', 220 ); //change this to default height for full avatar

function custom_login_logo() {
	echo '<style type="text/css">
	h1 a { height: 120px;background-image: url('.get_bloginfo('template_directory').'/images/custom-login-logo.png) !important; }
	</style>';
}
if ( !is_admin() ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button' );

		// Activity button
		if ( bp_is_active( 'activity' ) )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button' );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button' );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button' );
			add_action( 'bp_group_header_actions',     'bp_group_new_topic_button' );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}
add_action('login_head', 'custom_login_logo');
function change_wp_login_url() {
    echo bloginfo('url');
    }
    function change_wp_login_title() {
    echo get_option('blogname');
    }
    add_filter('login_headerurl', 'change_wp_login_url');
    add_filter('login_headertitle', 'change_wp_login_title');