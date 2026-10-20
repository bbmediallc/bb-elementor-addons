<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'manage_page_posts_columns', function ( $columns ) {
	$new = [];
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'cb' === $key ) {
			$new['bbea_thumb'] = '<span class="screen-reader-text">Featured Image</span>';
		}
	}
	if ( ! isset( $new['bbea_thumb'] ) ) {
		$new = [ 'bbea_thumb' => '<span class="screen-reader-text">Featured Image</span>' ] + $new;
	}
	return $new;
} );

add_action( 'manage_page_posts_custom_column', function ( $column, $post_id ) {
	if ( 'bbea_thumb' !== $column ) {
		return;
	}
	$thumb_id = get_post_thumbnail_id( $post_id );
	if ( $thumb_id ) {
		echo wp_get_attachment_image( $thumb_id, [ 80, 80 ], false, [ 'class' => 'bbea-thumb', 'alt' => '', 'loading' => 'lazy' ] );
		return;
	}
	echo '<span class="bbea-thumb bbea-thumb--empty" title="No featured image"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5zM8 9.5A1.5 1.5 0 1 1 8 6.5a1.5 1.5 0 0 1 0 3z"/></svg><span class="screen-reader-text">No featured image</span></span>';
}, 10, 2 );

add_action( 'admin_head-edit.php', function () {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}
	echo '<style>
		.wp-list-table .column-bbea_thumb { width: 52px; }
		.wp-list-table .bbea-thumb { display: block; width: 40px; height: 40px; object-fit: cover; border-radius: 3px; }
		.wp-list-table .bbea-thumb--empty { display: flex; align-items: center; justify-content: center; background: #f0f0f1; border: 1px solid #dcdcde; box-sizing: border-box; }
		.wp-list-table .bbea-thumb--empty svg { width: 20px; height: 20px; fill: #a7aaad; }
	</style>';
} );
