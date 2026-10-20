<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

class BBEA_Hover_Reveal_List_Widget extends Widget_Base {

	public function get_name() {
		return 'hover-reveal-list';
	}

	public function get_title() {
		return 'Hover Reveal List';
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'services', 'hover', 'image', 'list', 'accordion', 'reveal' ];
	}

	public function get_style_depends() {
		return [ 'bb-hover-reveal-list' ];
	}

	public function get_script_depends() {
		return [ 'bb-hover-reveal-list' ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_items', [
			'label' => 'Services',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'title', [
			'label'       => 'Title',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Service',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'description', [
			'label'   => 'Description',
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => 'Short description of this service.',
			'dynamic' => [ 'active' => true ],
		] );

		$repeater->add_control( 'image', [
			'label'   => 'Image',
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			'dynamic' => [ 'active' => true ],
		] );

		$repeater->add_control( 'link', [
			'label'       => 'Link',
			'type'        => Controls_Manager::URL,
			'placeholder' => '/services/electrical',
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'items', [
			'label'       => 'Items',
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[ 'title' => 'Electrical', 'description' => 'Full-service electrical repair, maintenance, and installation.' ],
				[ 'title' => 'Installation', 'description' => 'Equipment installation built to manufacturer standards.' ],
				[ 'title' => 'Construction', 'description' => 'Licensed general contracting for industrial facilities.' ],
				[ 'title' => 'Equipment Sales', 'description' => 'Industrial equipment sourced, delivered, and installed.' ],
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_settings', [
			'label' => 'Settings',
		] );

		$this->add_control( 'static_image', [
			'label'       => 'Static Image',
			'description' => 'Shows before any service is hovered.',
			'type'        => Controls_Manager::MEDIA,
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'reset_on_leave', [
			'label'        => 'Return to Static Image on Mouse Leave',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'static_image[url]!' => '' ],
		] );

		$this->add_control( 'eyebrow', [
			'label'       => 'Eyebrow',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Our Services',
			'label_block' => true,
		] );

		$this->add_control( 'eyebrow_tag', [
			'label'     => 'Eyebrow HTML Tag',
			'type'      => Controls_Manager::SELECT,
			'default'   => 'div',
			'options'   => [
				'h1'   => 'H1',
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'div'  => 'div',
				'p'    => 'p',
				'span' => 'span',
			],
			'condition' => [ 'eyebrow!' => '' ],
		] );

		$this->add_control( 'title_tag', [
			'label'   => 'Title HTML Tag',
			'type'    => Controls_Manager::SELECT,
			'default' => 'h3',
			'options' => [
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'div'  => 'div',
			],
		] );

		$this->add_control( 'default_active', [
			'label'       => 'Open by Default',
			'description' => '0 keeps all closed.',
			'type'        => Controls_Manager::NUMBER,
			'min'         => 0,
			'default'     => 0,
		] );

		$this->add_responsive_control( 'image_position', [
			'label'                => 'Image Position',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'left',
			'mobile_default'       => 'top',
			'toggle'               => false,
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-h-align-left' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
				'top'    => [ 'title' => 'Top', 'icon' => 'eicon-v-align-top' ],
				'bottom' => [ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
			],
			'selectors_dictionary' => [
				'left'   => '--rhs-dir: row; --rhs-media-basis: var(--rhs-media-w, 50%); --rhs-media-maxw: var(--rhs-media-w, 50%); --rhs-media-pos: sticky;',
				'right'  => '--rhs-dir: row-reverse; --rhs-media-basis: var(--rhs-media-w, 50%); --rhs-media-maxw: var(--rhs-media-w, 50%); --rhs-media-pos: sticky;',
				'top'    => '--rhs-dir: column; --rhs-media-basis: auto; --rhs-media-maxw: 100%; --rhs-media-pos: relative;',
				'bottom' => '--rhs-dir: column-reverse; --rhs-media-basis: auto; --rhs-media-maxw: 100%; --rhs-media-pos: relative;',
			],
			'selectors'            => [ '{{WRAPPER}} .rhs' => '{{VALUE}}' ],
		] );

		$this->add_responsive_control( 'image_mode', [
			'label'                => 'Image Display',
			'type'                 => Controls_Manager::SELECT,
			'default'              => 'separate',
			'mobile_default'       => 'inline',
			'options'              => [
				'separate' => 'Separate Image Column',
				'inline'   => 'Inside Each Item',
			],
			'selectors_dictionary' => [
				'separate' => '--rhs-media-display: block; --rhs-inline-display: none;',
				'inline'   => '--rhs-media-display: none; --rhs-inline-display: block;',
			],
			'selectors'            => [ '{{WRAPPER}} .rhs' => '{{VALUE}}' ],
		] );

		$this->add_control( 'show_icon', [
			'label'        => 'Show Arrow Icon',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_layout', [
			'label' => 'Layout',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'      => 'Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 64 ],
			'selectors'  => [ '{{WRAPPER}} .rhs' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'image_width', [
			'label'       => 'Image Column Width',
			'description' => 'Applies when the image is left or right.',
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ '%' ],
			'range'       => [ '%' => [ 'min' => 20, 'max' => 80 ] ],
			'default'     => [ 'unit' => '%', 'size' => 50 ],
			'selectors'   => [ '{{WRAPPER}} .rhs' => '--rhs-media-w: {{SIZE}}%;' ],
		] );

		$this->add_responsive_control( 'image_height', [
			'label'      => 'Image Height',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1200 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 640 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 320 ],
			'selectors'      => [ '{{WRAPPER}} .rhs-media' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'image_radius', [
			'label'      => 'Image Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .rhs-media, {{WRAPPER}} .rhs-mobile-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'image_transition', [
			'label'     => 'Image Fade (ms)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 500,
			'selectors' => [ '{{WRAPPER}} .rhs-img' => 'transition-duration: {{VALUE}}ms;' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_eyebrow', [
			'label'     => 'Eyebrow',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'eyebrow!' => '' ],
		] );

		$this->add_control( 'eyebrow_color', [
			'label'     => 'Text Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .rhs-eyebrow' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'eyebrow_dot', [
			'label'     => 'Dot Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .rhs-eyebrow-dot' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_size', [
			'label'      => 'Dot Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-eyebrow-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_radius', [
			'label'      => 'Dot Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .rhs-eyebrow-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_align', [
			'label'                => 'Dot Vertical Alignment',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'center',
			'toggle'               => false,
			'options'              => [
				'top'      => [ 'title' => 'Top', 'icon' => 'eicon-v-align-top' ],
				'center'   => [ 'title' => 'Middle', 'icon' => 'eicon-v-align-middle' ],
				'bottom'   => [ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
				'baseline' => [ 'title' => 'Baseline', 'icon' => 'eicon-text-align-justify' ],
			],
			'selectors_dictionary' => [
				'top'      => 'flex-start',
				'center'   => 'center',
				'bottom'   => 'flex-end',
				'baseline' => 'baseline',
			],
			'selectors'            => [ '{{WRAPPER}} .rhs-eyebrow' => 'align-items: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_offset', [
			'label'      => 'Dot Vertical Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => -20, 'max' => 20, 'step' => 0.5 ], 'em' => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 0 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-eyebrow-dot' => 'transform: translateY({{SIZE}}{{UNIT}});' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_gap', [
			'label'      => 'Dot Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-eyebrow' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'eyebrow_typography',
			'selector' => '{{WRAPPER}} .rhs-eyebrow-text',
		] );

		$this->add_responsive_control( 'eyebrow_spacing', [
			'label'      => 'Spacing Below',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_items', [
			'label' => 'Items',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'divider_color', [
			'label'     => 'Divider Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F2952',
			'selectors' => [ '{{WRAPPER}} .rhs-item' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'item_padding', [
			'label'      => 'Item Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'default'    => [ 'top' => 24, 'right' => 0, 'bottom' => 24, 'left' => 0, 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [ '{{WRAPPER}} .rhs-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'heading_title', [
			'label'     => 'Title',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .rhs-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'title_inactive_opacity', [
			'label'     => 'Inactive Opacity',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ] ],
			'default'   => [ 'size' => 0.48 ],
			'selectors' => [ '{{WRAPPER}} .rhs-item:not(.is-active) .rhs-title' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .rhs-title',
		] );

		$this->add_control( 'heading_desc', [
			'label'     => 'Description',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'desc_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29E0',
			'selectors' => [ '{{WRAPPER}} .rhs-desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'desc_typography',
			'selector' => '{{WRAPPER}} .rhs-desc',
		] );

		$this->add_responsive_control( 'desc_spacing', [
			'label'      => 'Spacing Above',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-bottom-inner' => 'padding-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'desc_max_width', [
			'label'      => 'Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 900 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 448 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-desc' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'expand_speed', [
			'label'     => 'Expand Speed (ms)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 450,
			'selectors' => [ '{{WRAPPER}} .rhs-bottom, {{WRAPPER}} .rhs-title, {{WRAPPER}} .rhs-icon' => 'transition-duration: {{VALUE}}ms;' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_icon', [
			'label'     => 'Arrow Icon',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_icon' => 'yes' ],
		] );

		$this->add_responsive_control( 'icon_box', [
			'label'      => 'Box Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 48 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => 'Arrow Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .rhs-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'icon_border_width', [
			'label'      => 'Border Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ '{{WRAPPER}} .rhs-icon' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'icon_tabs' );

		$this->start_controls_tab( 'icon_tab_normal', [ 'label' => 'Normal' ] );

		$this->add_control( 'icon_color', [
			'label'     => 'Arrow Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .rhs-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_bg', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#F4F3F052',
			'selectors' => [ '{{WRAPPER}} .rhs-icon' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_border', [
			'label'     => 'Border Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#00000052',
			'selectors' => [ '{{WRAPPER}} .rhs-icon' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'icon_tab_active', [ 'label' => 'Active' ] );

		$this->add_control( 'icon_color_active', [
			'label'     => 'Arrow Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .rhs-item.is-active .rhs-icon' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_bg_active', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .rhs-item.is-active .rhs-icon' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_border_active', [
			'label'     => 'Border Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .rhs-item.is-active .rhs-icon' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'icon_rotate', [
			'label'     => 'Rotate (deg)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 45,
			'selectors' => [ '{{WRAPPER}} .rhs-item.is-active .rhs-icon svg' => 'transform: rotate({{VALUE}}deg);' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) ? $s['items'] : [];

		if ( ! $items ) {
			return;
		}

		$count      = count( $items );
		$has_static = ! empty( $s['static_image']['url'] );
		$active     = intval( $s['default_active'] ) - 1;
		$active     = $active < 0 ? ( $has_static ? -1 : 0 ) : min( $count - 1, $active );
		$reset      = $has_static && 'yes' === $s['reset_on_leave'];
		$tag    = Utils::validate_html_tag( $s['title_tag'] );
		$uid    = 'rhs-' . $this->get_id();
		$arrow  = '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 15L15 5M15 5H7M15 5V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/></svg>';
		?>
		<div class="rhs" data-active="<?php echo esc_attr( $active ); ?>" data-reset="<?php echo $reset ? '1' : '0'; ?>">
			<div class="rhs-media" aria-hidden="true">
				<?php if ( $has_static ) : ?>
					<div class="rhs-img rhs-img-static<?php echo -1 === $active ? ' is-active' : ''; ?>" data-index="-1">
						<?php echo $this->get_image_html( [ 'image' => $s['static_image'], 'title' => '' ], 'large', 'eager' ); ?>
					</div>
				<?php endif; ?>
				<?php foreach ( $items as $i => $item ) : ?>
					<div class="rhs-img<?php echo $i === $active ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>">
						<?php echo $this->get_image_html( $item, 'large', $i === 0 ? 'eager' : 'lazy' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="rhs-content">
				<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
					<div class="rhs-eyebrow"><span class="rhs-eyebrow-dot"></span><?php $etag = Utils::validate_html_tag( $s['eyebrow_tag'] ); ?><<?php echo $etag; ?> class="rhs-eyebrow-text"><?php echo esc_html( $s['eyebrow'] ); ?></<?php echo $etag; ?>></div>
				<?php endif; ?>
				<div class="rhs-list">
					<?php
					foreach ( $items as $i => $item ) :
						$key      = 'item_' . $i;
						$has_link = ! empty( $item['link']['url'] );
						$el       = $has_link ? 'a' : 'div';
						$this->add_render_attribute( $key, [
							'class'      => 'rhs-item' . ( $i === $active ? ' is-active' : '' ),
							'data-index' => $i,
						] );
						if ( $has_link ) {
							$this->add_link_attributes( $key, $item['link'] );
						} else {
							$this->add_render_attribute( $key, 'tabindex', '0' );
						}
						$this->add_render_attribute( $key, 'aria-describedby', $uid . '-d' . $i );
						?>
						<<?php echo $el; ?> <?php $this->print_render_attribute_string( $key ); ?>>
							<div class="rhs-top">
								<<?php echo $tag; ?> class="rhs-title"><?php echo esc_html( $item['title'] ); ?></<?php echo $tag; ?>>
								<?php if ( 'yes' === $s['show_icon'] ) : ?>
									<span class="rhs-icon"><?php echo $arrow; ?></span>
								<?php endif; ?>
							</div>
							<div class="rhs-bottom">
								<div class="rhs-bottom-inner">
									<?php if ( ! empty( $item['description'] ) ) : ?>
										<p class="rhs-desc" id="<?php echo esc_attr( $uid . '-d' . $i ); ?>"><?php echo esc_html( $item['description'] ); ?></p>
									<?php endif; ?>
									<div class="rhs-mobile-img"><?php echo $this->get_image_html( $item, 'medium_large', 'lazy' ); ?></div>
								</div>
							</div>
						</<?php echo $el; ?>>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}

	private function get_image_html( $item, $size, $loading ) {
		$image = isset( $item['image'] ) ? $item['image'] : [];
		$alt   = isset( $item['title'] ) ? $item['title'] : '';

		if ( ! empty( $image['id'] ) ) {
			return wp_get_attachment_image( $image['id'], $size, false, [ 'loading' => $loading ] );
		}

		if ( ! empty( $image['url'] ) ) {
			return sprintf( '<img src="%s" alt="%s" loading="%s">', esc_url( $image['url'] ), esc_attr( $alt ), esc_attr( $loading ) );
		}

		return '';
	}
}
