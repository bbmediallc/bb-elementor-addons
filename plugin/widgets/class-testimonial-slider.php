<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

class BBEA_Testimonial_Slider_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-testimonial-slider';
	}

	public function get_title() {
		return 'Testimonial Slider';
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'slider', 'carousel', 'review', 'quote' ];
	}

	public function get_style_depends() {
		return [ 'bb-testimonial-slider' ];
	}

	public function get_script_depends() {
		return [ 'bb-testimonial-slider' ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_items', [
			'label' => 'Testimonials',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'quote', [
			'label'   => 'Quote',
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 5,
			'default' => 'Fantastic experience. The team was professional, organized, and easy to work with.',
			'dynamic' => [ 'active' => true ],
		] );

		$repeater->add_control( 'name', [
			'label'       => 'Name',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Customer Name',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'meta', [
			'label'       => 'Company / Location',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Company, City, ST',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'image', [
			'label'   => 'Image',
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			'dynamic' => [ 'active' => true ],
		] );

		$this->add_control( 'items', [
			'label'       => 'Items',
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => [
				[ 'name' => 'Customer One' ],
				[ 'name' => 'Customer Two' ],
				[ 'name' => 'Customer Three' ],
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_settings', [
			'label' => 'Settings',
		] );

		$this->add_control( 'eyebrow', [
			'label'       => 'Eyebrow',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Testimonials',
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

		$this->add_control( 'quote_tag', [
			'label'   => 'Quote HTML Tag',
			'type'    => Controls_Manager::SELECT,
			'default' => 'blockquote',
			'options' => [
				'blockquote' => 'blockquote',
				'h2'         => 'H2',
				'h3'         => 'H3',
				'h4'         => 'H4',
				'p'          => 'p',
				'div'        => 'div',
			],
		] );

		$this->add_responsive_control( 'image_position', [
			'label'                => 'Image Position',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'right',
			'mobile_default'       => 'top',
			'toggle'               => false,
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-h-align-left' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
				'top'    => [ 'title' => 'Top', 'icon' => 'eicon-v-align-top' ],
				'bottom' => [ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
			],
			'selectors_dictionary' => [
				'right'  => '--bbts-dir: row; --bbts-nav-left: 0; --bbts-nav-right: auto; --bbts-card-minh: var(--bbts-h, 680px); --bbts-content-basis: var(--bbts-content-w, 42%); --bbts-content-gap: 64px; --bbts-author-pr: 140px; --bbts-nav-pos: absolute; --bbts-nav-w: var(--bbts-content-w, 42%); --bbts-nav-cap: var(--bbts-content-max, 500px); --bbts-nav-mt: 0; --bbts-nav-top-offset: 0px;',
				'left'   => '--bbts-dir: row-reverse; --bbts-nav-left: auto; --bbts-nav-right: 0; --bbts-card-minh: var(--bbts-h, 680px); --bbts-content-basis: var(--bbts-content-w, 42%); --bbts-content-gap: 64px; --bbts-author-pr: 140px; --bbts-nav-pos: absolute; --bbts-nav-w: var(--bbts-content-w, 42%); --bbts-nav-cap: var(--bbts-content-max, 500px); --bbts-nav-mt: 0; --bbts-nav-top-offset: 0px;',
				'top'    => '--bbts-dir: column-reverse; --bbts-card-minh: 0; --bbts-content-basis: auto; --bbts-content-gap: 32px; --bbts-author-pr: 0; --bbts-nav-pos: static; --bbts-nav-left: 0; --bbts-nav-right: auto; --bbts-nav-w: 100%; --bbts-nav-cap: none; --bbts-nav-mt: 32px; --bbts-nav-top-offset: calc(var(--bbts-h, 320px) + var(--bbts-gap, 32px));',
				'bottom' => '--bbts-dir: column; --bbts-card-minh: 0; --bbts-content-basis: auto; --bbts-content-gap: 32px; --bbts-author-pr: 0; --bbts-nav-pos: static; --bbts-nav-left: 0; --bbts-nav-right: auto; --bbts-nav-w: 100%; --bbts-nav-cap: none; --bbts-nav-mt: 32px; --bbts-nav-top-offset: 0px;',
			],
			'selectors'            => [ '{{WRAPPER}} .bbts' => '{{VALUE}}' ],
		] );

		$this->add_control( 'autoplay', [
			'label'        => 'Autoplay',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'return_value' => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'autoplay_delay', [
			'label'     => 'Autoplay Delay (ms)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 6000,
			'min'       => 1000,
			'step'      => 500,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => 'Pause on Hover',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'loop', [
			'label'        => 'Loop',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->add_control( 'speed', [
			'label'   => 'Transition Speed (ms)',
			'type'    => Controls_Manager::NUMBER,
			'default' => 500,
			'min'     => 100,
			'step'    => 50,
		] );

		$this->add_control( 'show_arrows', [
			'label'        => 'Show Arrows',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->add_control( 'show_counter', [
			'label'        => 'Show Counter',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'return_value' => 'yes',
		] );

		$this->add_responsive_control( 'nav_position', [
			'label'                => 'Arrows Placement',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'bottom',
			'tablet_default'       => 'top',
			'mobile_default'       => 'top',
			'toggle'               => false,
			'options'              => [
				'top'    => [ 'title' => 'Above Eyebrow', 'icon' => 'eicon-v-align-top' ],
				'bottom' => [ 'title' => 'Bottom', 'icon' => 'eicon-v-align-bottom' ],
			],
			'selectors_dictionary' => [
				'top'    => '--bbts-navx-pos: absolute; --bbts-navx-top: var(--bbts-nav-top-offset, 0px); --bbts-navx-bottom: auto; --bbts-navx-mt: 0px; --bbts-content-pt: calc(var(--bbts-arrow-size, 56px) + var(--bbts-nav-space, 24px));',
				'bottom' => '--bbts-navx-pos: initial; --bbts-navx-top: auto; --bbts-navx-bottom: 0px; --bbts-navx-mt: initial; --bbts-content-pt: 0px;',
			],
			'selectors'            => [ '{{WRAPPER}} .bbts' => '{{VALUE}}' ],
			'conditions'           => [
				'relation' => 'or',
				'terms'    => [
					[ 'name' => 'show_arrows', 'operator' => '===', 'value' => 'yes' ],
					[ 'name' => 'show_counter', 'operator' => '===', 'value' => 'yes' ],
				],
			],
		] );

		$this->add_responsive_control( 'nav_align', [
			'label'                => 'Arrows Alignment',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'end',
			'toggle'               => false,
			'options'              => [
				'start'   => [ 'title' => 'Start', 'icon' => 'eicon-h-align-left' ],
				'center'  => [ 'title' => 'Center', 'icon' => 'eicon-h-align-center' ],
				'end'     => [ 'title' => 'End', 'icon' => 'eicon-h-align-right' ],
				'between' => [ 'title' => 'Space Between', 'icon' => 'eicon-h-align-stretch' ],
			],
			'selectors_dictionary' => [
				'start'   => 'flex-start',
				'center'  => 'center',
				'end'     => 'flex-end',
				'between' => 'space-between',
			],
			'selectors'            => [ '{{WRAPPER}} .bbts-nav' => 'justify-content: {{VALUE}};' ],
			'conditions'           => [
				'relation' => 'or',
				'terms'    => [
					[ 'name' => 'show_arrows', 'operator' => '===', 'value' => 'yes' ],
					[ 'name' => 'show_counter', 'operator' => '===', 'value' => 'yes' ],
				],
			],
		] );

		$this->add_responsive_control( 'nav_space', [
			'label'      => 'Space Below Arrows',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .bbts' => '--bbts-nav-space: {{SIZE}}{{UNIT}};' ],
			'conditions' => [
				'relation' => 'or',
				'terms'    => [
					[ 'name' => 'show_arrows', 'operator' => '===', 'value' => 'yes' ],
					[ 'name' => 'show_counter', 'operator' => '===', 'value' => 'yes' ],
				],
			],
		] );

		$this->add_control( 'tile_reveal', [
			'label'        => 'Image Strip Reveal',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'tile_rows', [
			'label'     => 'Strips',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 5,
			'min'       => 1,
			'max'       => 20,
			'condition' => [ 'tile_reveal' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_layout', [
			'label' => 'Layout',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'content_width', [
			'label'      => 'Content Column Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 20, 'max' => 70 ] ],
			'description' => 'Applies when the image is left or right.',
			'default'    => [ 'unit' => '%', 'size' => 42 ],
			'selectors'  => [ '{{WRAPPER}} .bbts' => '--bbts-content-w: {{SIZE}}%;' ],
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'          => 'Gap',
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px' ],
			'range'          => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 80 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'      => [ '{{WRAPPER}} .bbts' => '--bbts-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'slide_height', [
			'label'          => 'Image Height',
			'type'           => Controls_Manager::SLIDER,
			'size_units'     => [ 'px', 'vh' ],
			'range'          => [ 'px' => [ 'min' => 160, 'max' => 1200 ], 'vh' => [ 'min' => 20, 'max' => 100 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 680 ],
			'mobile_default' => [ 'unit' => 'px', 'size' => 320 ],
			'selectors'      => [ '{{WRAPPER}} .bbts' => '--bbts-h: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_max', [
			'label'      => 'Content Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1000 ] ],
			'default'        => [ 'unit' => 'px', 'size' => 500 ],
			'mobile_default' => [ 'unit' => '%', 'size' => 100 ],
			'selectors'      => [ '{{WRAPPER}} .bbts' => '--bbts-content-max: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'image_radius', [
			'label'      => 'Image Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbts-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'tile_color', [
			'label'     => 'Strip Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#D2D2D2',
			'selectors' => [ '{{WRAPPER}} .bbts-tile' => 'background-color: {{VALUE}};' ],
			'condition' => [ 'tile_reveal' => 'yes' ],
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
			'selectors' => [ '{{WRAPPER}} .bbts-eyebrow' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'eyebrow_dot', [
			'label'     => 'Dot Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .bbts-eyebrow-dot' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_size', [
			'label'      => 'Dot Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-eyebrow-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_radius', [
			'label'      => 'Dot Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .bbts-eyebrow-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
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
			'selectors'            => [ '{{WRAPPER}} .bbts-eyebrow' => 'align-items: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_offset', [
			'label'      => 'Dot Vertical Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => -20, 'max' => 20, 'step' => 0.5 ], 'em' => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 0 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-eyebrow-dot' => 'transform: translateY({{SIZE}}{{UNIT}});' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_gap', [
			'label'      => 'Dot Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-eyebrow' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'eyebrow_typography',
			'selector' => '{{WRAPPER}} .bbts-eyebrow-text',
		] );

		$this->add_responsive_control( 'eyebrow_spacing', [
			'label'      => 'Spacing Below',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_text', [
			'label' => 'Text',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_quote', [
			'label' => 'Quote',
			'type'  => Controls_Manager::HEADING,
		] );

		$this->add_control( 'quote_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .bbts-quote' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'quote_typography',
			'selector' => '{{WRAPPER}} .bbts-quote',
		] );

		$this->add_control( 'heading_long', [
			'label'     => 'Long Quotes',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'long_threshold', [
			'label'       => 'Character Limit',
			'description' => 'Quotes longer than this get the reduced size. 0 turns it off.',
			'type'        => Controls_Manager::NUMBER,
			'default'     => 200,
			'min'         => 0,
			'step'        => 10,
		] );

		$this->add_responsive_control( 'long_scale', [
			'label'      => 'Reduced Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ '%' ],
			'range'      => [ '%' => [ 'min' => 40, 'max' => 100 ] ],
			'default'    => [ 'unit' => '%', 'size' => 65 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-quote--long .bbts-quote-text' => 'font-size: {{SIZE}}%;' ],
			'condition'  => [ 'long_threshold!' => 0 ],
		] );

		$this->add_responsive_control( 'long_line_height', [
			'label'       => 'Reduced Line Height Override',
			'description' => 'Leave empty to scale the line height with the text.',
			'type'        => Controls_Manager::SLIDER,
			'size_units'  => [ 'em' ],
			'range'       => [ 'em' => [ 'min' => 0.8, 'max' => 2, 'step' => 0.05 ] ],
			'selectors'   => [ '{{WRAPPER}} .bbts-quote--long .bbts-quote-text' => 'line-height: {{SIZE}}{{UNIT}};' ],
			'condition'   => [ 'long_threshold!' => 0 ],
		] );

		$this->add_control( 'heading_name', [
			'label'     => 'Name',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'name_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .bbts-name' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'selector' => '{{WRAPPER}} .bbts-name',
		] );

		$this->add_control( 'heading_meta', [
			'label'     => 'Company / Location',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'meta_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29A3',
			'selectors' => [ '{{WRAPPER}} .bbts-meta' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'meta_typography',
			'selector' => '{{WRAPPER}} .bbts-meta',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_arrows', [
			'label'     => 'Arrows',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_arrows' => 'yes' ],
		] );

		$this->add_responsive_control( 'arrow_box', [
			'label'      => 'Box Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 56 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .bbts' => '--bbts-arrow-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_icon', [
			'label'      => 'Arrow Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 20 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_gap', [
			'label'      => 'Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-arrows' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'arrow_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .bbts-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'arrow_border_width', [
			'label'      => 'Border Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 1 ],
			'selectors'  => [ '{{WRAPPER}} .bbts-arrow' => 'border-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'arrow_tabs' );

		$this->start_controls_tab( 'arrow_tab_normal', [ 'label' => 'Normal' ] );

		$this->add_control( 'arrow_color', [
			'label'     => 'Arrow Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_bg', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#FFFFFF00',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border', [
			'label'     => 'Border Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F2952',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow' => 'border-color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'arrow_tab_hover', [ 'label' => 'Hover' ] );

		$this->add_control( 'arrow_color_hover', [
			'label'     => 'Arrow Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#262F29',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow:hover, {{WRAPPER}} .bbts-arrow:focus-visible' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_bg_hover', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow:hover, {{WRAPPER}} .bbts-arrow:focus-visible' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_border_hover', [
			'label'     => 'Border Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .bbts-arrow:hover, {{WRAPPER}} .bbts-arrow:focus-visible' => 'border-color: {{VALUE}};' ],
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

		$count  = count( $items );
		$tag    = Utils::validate_html_tag( $s['quote_tag'] );
		$tiles  = 'yes' === $s['tile_reveal'] ? max( 1, min( 20, intval( $s['tile_rows'] ) ) ) : 0;
		$arrow  = '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M16 10L11 5M16 10L11 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/></svg>';

		$this->add_render_attribute( 'root', [
			'class'                => 'bbts' . ( $count > 1 && ( 'yes' === $s['show_arrows'] || 'yes' === $s['show_counter'] ) ? ' bbts--has-nav' : '' ),
			'role'                 => 'region',
			'aria-roledescription' => 'carousel',
			'aria-label'           => $s['eyebrow'] ? $s['eyebrow'] : 'Testimonials',
			'data-autoplay'        => 'yes' === $s['autoplay'] ? '1' : '0',
			'data-delay'           => max( 1000, intval( $s['autoplay_delay'] ) ),
			'data-pause'           => 'yes' === $s['pause_on_hover'] ? '1' : '0',
			'data-loop'            => 'yes' === $s['loop'] ? '1' : '0',
			'data-speed'           => max( 100, intval( $s['speed'] ) ),
			'data-long-lh'         => $this->has_long_line_height( $s ) ? '1' : '0',
		] );
		?>
		<div <?php $this->print_render_attribute_string( 'root' ); ?>>
			<div class="bbts-stage" aria-live="<?php echo 'yes' === $s['autoplay'] ? 'off' : 'polite'; ?>">
				<?php foreach ( $items as $i => $item ) : ?>
					<div class="bbts-slide<?php echo 0 === $i ? ' is-active' : ''; ?>" role="group" aria-roledescription="slide" aria-label="<?php echo esc_attr( ( $i + 1 ) . ' of ' . $count ); ?>"<?php echo 0 === $i ? '' : ' aria-hidden="true"'; ?>>
						<div class="bbts-card">
							<div class="bbts-content">
								<div class="bbts-headline">
									<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
										<div class="bbts-eyebrow"><span class="bbts-eyebrow-dot"></span><?php $etag = Utils::validate_html_tag( $s['eyebrow_tag'] ); ?><<?php echo $etag; ?> class="bbts-eyebrow-text"><?php echo esc_html( $s['eyebrow'] ); ?></<?php echo $etag; ?>></div>
									<?php endif; ?>
									<?php
									$limit   = intval( $s['long_threshold'] );
									$is_long = $limit > 0 && mb_strlen( trim( (string) $item['quote'] ) ) > $limit;
									?>
									<<?php echo $tag; ?> class="bbts-quote<?php echo $is_long ? ' bbts-quote--long' : ''; ?>"><span class="bbts-quote-text"><?php echo esc_html( $item['quote'] ); ?></span></<?php echo $tag; ?>>
								</div>
								<div class="bbts-author">
									<?php if ( ! empty( $item['name'] ) ) : ?>
										<div class="bbts-name"><?php echo esc_html( $item['name'] ); ?></div>
									<?php endif; ?>
									<?php if ( ! empty( $item['meta'] ) ) : ?>
										<div class="bbts-meta"><?php echo esc_html( $item['meta'] ); ?></div>
									<?php endif; ?>
								</div>
							</div>
							<div class="bbts-media">
								<?php echo $this->get_image_html( $item, 0 === $i ? 'eager' : 'lazy' ); ?>
								<?php if ( $tiles ) : ?>
									<div class="bbts-tiles" aria-hidden="true">
										<?php for ( $t = 0; $t < $tiles; $t++ ) : ?>
											<span class="bbts-tile" style="transition-delay:<?php echo esc_attr( $t * 70 ); ?>ms"></span>
										<?php endfor; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<?php if ( $count > 1 && ( 'yes' === $s['show_arrows'] || 'yes' === $s['show_counter'] ) ) : ?>
				<div class="bbts-nav">
					<?php if ( 'yes' === $s['show_counter'] ) : ?>
						<div class="bbts-counter"><span class="bbts-current">1</span> / <span class="bbts-total"><?php echo esc_html( $count ); ?></span></div>
					<?php endif; ?>
					<?php if ( 'yes' === $s['show_arrows'] ) : ?>
						<div class="bbts-arrows">
							<button type="button" class="bbts-arrow bbts-prev" aria-label="Previous testimonial"><?php echo $arrow; ?></button>
							<button type="button" class="bbts-arrow bbts-next" aria-label="Next testimonial"><?php echo $arrow; ?></button>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function has_long_line_height( $s ) {
		foreach ( [ 'long_line_height', 'long_line_height_tablet', 'long_line_height_mobile' ] as $key ) {
			if ( isset( $s[ $key ]['size'] ) && '' !== $s[ $key ]['size'] && null !== $s[ $key ]['size'] ) {
				return true;
			}
		}
		return false;
	}

	private function get_image_html( $item, $loading ) {
		$image = isset( $item['image'] ) ? $item['image'] : [];
		$alt   = ! empty( $item['name'] ) ? $item['name'] : '';

		if ( ! empty( $image['id'] ) ) {
			return wp_get_attachment_image( $image['id'], 'large', false, [ 'loading' => $loading, 'class' => 'bbts-img' ] );
		}

		if ( ! empty( $image['url'] ) ) {
			return sprintf( '<img class="bbts-img" src="%s" alt="%s" loading="%s">', esc_url( $image['url'] ), esc_attr( $alt ), esc_attr( $loading ) );
		}

		return '';
	}
}
