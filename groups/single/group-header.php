<?php

do_action( 'bp_before_group_header' );

?>
<h3 class="widget-title"><a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>"><?php bp_group_name(); ?></a></h3>

<div id="item-header-avatar">
	<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

		<?php bp_group_avatar('width=150&height=150'); ?>

	</a>
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	
	<span class="highlight"><?php bp_group_type(); ?></span> <span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>

	<?php do_action( 'bp_before_group_header_meta' ); ?>

	<div id="item-meta">

		<?php bp_group_description(); ?>

		<div id="item-buttons">

			<?php do_action( 'bp_group_header_actions' ); ?>

		</div><!-- #item-buttons -->

		<?php do_action( 'bp_group_header_meta' ); ?>

	</div>
</div><!-- #item-header-content -->

<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>