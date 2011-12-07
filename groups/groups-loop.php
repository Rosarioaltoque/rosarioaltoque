<?php

/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_dtheme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>
<?php do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php do_action( 'bp_before_directory_groups_list' ); ?>

	<div id="rat-cont-item">
	<?php while ( bp_groups() ) : bp_the_group(); ?>
		<div id="rat-item">
    		<div id="rat-avatar-80">
			<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
			</div>
            	<div id="rat-cont-text" class="rat-cont-text-80">
            		<div id="rat-item-titulo"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
                    <div id="rat-item-descripcion"><?php bp_group_description_excerpt(); ?></div>
                    <?php do_action( 'bp_directory_groups_item' ); ?>
                    <div id="rat-item-pie">
				<?php do_action( 'bp_directory_groups_actions' ); ?>
                    <img src="/wp-content/themes/rcd/images/ico_act_18.png" width="18" height="18" align="absmiddle" /> <?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?>  | 
					<img src="/wp-content/themes/rcd/images/ico_comun_18.png" width="18" height="18" align="absmiddle" /> <?php bp_group_type(); ?>  | 
                    <img src="/wp-content/themes/rcd/images/ico_user_18.png" width="9" height="18" align="absmiddle" /> <?php bp_group_member_count(); ?>
			</div>
                </div><!--rat-cont-text-->
            <br class="clear">
        </div><!--rat-item-->
	<?php endwhile; ?>
	</div><!--rat-cont-item-->

	<?php do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php do_action( 'bp_after_groups_loop' ); ?>
