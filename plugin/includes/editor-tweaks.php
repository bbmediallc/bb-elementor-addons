<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'elementor/editor/after_enqueue_styles', function () {
	wp_add_inline_style(
		'elementor-editor',
		'.elementor-control-url-more-options {
			display: block !important;
			visibility: visible !important;
			opacity: 1 !important;
			height: auto !important;
		}'
	);
} );

add_action( 'elementor/editor/after_enqueue_scripts', function () {
	wp_add_inline_script(
		'elementor-editor',
		'(function () {
			function place() {
				var basic = document.getElementById("elementor-panel-category-basic");
				var bb = document.getElementById("elementor-panel-category-bb-media");
				if (basic && bb && basic.nextElementSibling !== bb) {
					basic.parentNode.insertBefore(bb, basic.nextElementSibling);
				}
			}
			new MutationObserver(place).observe(document.documentElement, { childList: true, subtree: true });
		})();'
	);
} );

add_action( 'elementor/preview/enqueue_scripts', function () {
	if ( ! class_exists( 'GFAPI' ) || ! function_exists( 'gravity_form_enqueue_scripts' ) ) {
		return;
	}
	foreach ( \GFAPI::get_forms( true, false ) as $form ) {
		gravity_form_enqueue_scripts( $form['id'], true );
	}
} );

add_action( 'elementor/element/spacer/section_spacer/before_section_end', function ( $element, $args ) {
	$element->add_group_control(
		\Elementor\Group_Control_Background::get_type(),
		[
			'name'     => 'spacer_content_bg',
			'label'    => __( 'Background', 'elementor' ),
			'types'    => [ 'classic', 'gradient', 'video' ],
			'selector' => '{{WRAPPER}}',
		]
	);
}, 10, 2 );
