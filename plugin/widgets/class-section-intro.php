<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;

class BBEA_Section_Intro_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-section-intro';
	}

	public function get_title() {
		return 'Section Intro';
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'intro', 'heading', 'eyebrow', 'hero', 'title', 'buttons', 'cta' ];
	}

	public function get_style_depends() {
		return [ 'bb-section-intro' ];
	}

	private function tag_options() {
		return [
			'h1'   => 'H1',
			'h2'   => 'H2',
			'h3'   => 'H3',
			'h4'   => 'H4',
			'h5'   => 'H5',
			'h6'   => 'H6',
			'div'  => 'div',
			'p'    => 'p',
			'span' => 'span',
		];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_content', [
			'label' => 'Content',
		] );

		$this->add_control( 'eyebrow', [
			'label'       => 'Eyebrow',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Electrical',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'eyebrow_tag', [
			'label'     => 'Eyebrow HTML Tag',
			'type'      => Controls_Manager::SELECT,
			'default'   => 'div',
			'options'   => $this->tag_options(),
			'condition' => [ 'eyebrow!' => '' ],
		] );

		$this->add_control( 'show_dot', [
			'label'        => 'Show Eyebrow Dot',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'eyebrow!' => '' ],
		] );

		$this->add_control( 'heading', [
			'label'     => 'Heading',
			'type'      => Controls_Manager::TEXTAREA,
			'rows'      => 2,
			'default'   => 'Electrical Services',
			'dynamic'   => [ 'active' => true ],
			'separator' => 'before',
		] );

		$this->add_control( 'heading_tag', [
			'label'   => 'Heading HTML Tag',
			'type'    => Controls_Manager::SELECT,
			'default' => 'h1',
			'options' => $this->tag_options(),
		] );

		$this->add_control( 'text', [
			'label'     => 'Intro Text',
			'type'      => Controls_Manager::WYSIWYG,
			'default'   => '<p>Short introduction for this page or section.</p>',
			'dynamic'   => [ 'active' => true ],
			'separator' => 'before',
		] );

		$this->end_controls_section();

		foreach ( [ 1, 2 ] as $n ) {
			$this->start_controls_section( "section_button_{$n}", [
				'label' => "Button {$n}",
			] );

			$this->add_control( "btn{$n}_show", [
				'label'        => "Show Button {$n}",
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			] );

			$this->add_control( "btn{$n}_text", [
				'label'       => 'Text',
				'type'        => Controls_Manager::TEXT,
				'default'     => 1 === $n ? 'Request a Quote' : 'Learn more',
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ "btn{$n}_show" => 'yes' ],
			] );

			$this->add_control( "btn{$n}_link", [
				'label'       => 'Link',
				'type'        => Controls_Manager::URL,
				'placeholder' => '/contact',
				'default'     => [ 'url' => '#' ],
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ "btn{$n}_show" => 'yes' ],
			] );

			$this->add_control( "btn{$n}_icon", [
				'label'       => 'Icon',
				'type'        => Controls_Manager::ICONS,
				'default'     => 1 === $n ? [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ] : [ 'value' => '', 'library' => '' ],
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => [ "btn{$n}_show" => 'yes' ],
			] );

			$this->add_control( "btn{$n}_icon_position", [
				'label'     => 'Icon Position',
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'after',
				'toggle'    => false,
				'options'   => [
					'before' => [ 'title' => 'Before', 'icon' => 'eicon-h-align-left' ],
					'after'  => [ 'title' => 'After', 'icon' => 'eicon-h-align-right' ],
				],
				'condition' => [ "btn{$n}_show" => 'yes', "btn{$n}_icon[value]!" => '' ],
			] );

			$this->end_controls_section();
		}

		$this->start_controls_section( 'section_style_layout', [
			'label' => 'Layout',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'align', [
			'label'                => 'Alignment',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'left',
			'toggle'               => false,
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'selectors_dictionary' => [
				'left'   => 'text-align: left; align-items: flex-start; justify-content: flex-start;',
				'center' => 'text-align: center; align-items: center; justify-content: center;',
				'right'  => 'text-align: right; align-items: flex-end; justify-content: flex-end;',
			],
			'selectors'            => [
				'{{WRAPPER}} .bbsi'         => '{{VALUE}}',
				'{{WRAPPER}} .bbsi-buttons' => '{{VALUE}}',
			],
		] );

		$this->add_responsive_control( 'eyebrow_spacing', [
			'label'      => 'Space Below Eyebrow',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'heading_spacing', [
			'label'      => 'Space Below Heading',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 48 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'text_spacing', [
			'label'      => 'Space Below Text',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 32 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-text' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'heading_max', [
			'label'      => 'Heading Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'ch' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1600 ], 'ch' => [ 'min' => 10, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-heading' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'text_max', [
			'label'      => 'Text Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'ch' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 1600 ], 'ch' => [ 'min' => 20, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 720 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-text' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'buttons_direction', [
			'label'                => 'Buttons Direction',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'row',
			'toggle'               => false,
			'separator'            => 'before',
			'options'              => [
				'row'    => [ 'title' => 'Side by Side', 'icon' => 'eicon-arrow-right' ],
				'column' => [ 'title' => 'Stacked', 'icon' => 'eicon-arrow-down' ],
			],
			'selectors_dictionary' => [
				'row'    => 'flex-direction: row;',
				'column' => 'flex-direction: column;',
			],
			'selectors'            => [ '{{WRAPPER}} .bbsi-buttons' => '{{VALUE}}' ],
		] );

		$this->add_responsive_control( 'buttons_width', [
			'label'                => 'Buttons Width',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'auto',
			'toggle'               => false,
			'options'              => [
				'auto' => [ 'title' => 'Auto', 'icon' => 'eicon-shrink' ],
				'full' => [ 'title' => 'Full Width', 'icon' => 'eicon-h-align-stretch' ],
			],
			'selectors_dictionary' => [
				'auto' => 'align-self: auto; flex: 0 0 auto;',
				'full' => 'align-self: stretch; flex: 1 1 0;',
			],
			'selectors'            => [
				'{{WRAPPER}} .bbsi-buttons' => '{{VALUE}}',
				'{{WRAPPER}} .bbsi-btn'     => '{{VALUE}}',
			],
		] );

		$this->add_responsive_control( 'buttons_gap', [
			'label'      => 'Buttons Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 16 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-buttons' => 'gap: {{SIZE}}{{UNIT}};' ],
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
			'selectors' => [ '{{WRAPPER}} .bbsi-eyebrow' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'eyebrow_typography',
			'selector' => '{{WRAPPER}} .bbsi-eyebrow-text',
		] );

		// Border around the eyebrow text (it shrinks to fit, see section-intro.css).
		// ".bbsi" in the selectors outranks the stylesheet's padding: 0.
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'      => 'eyebrow_border',
			'selector'  => '{{WRAPPER}} .bbsi .bbsi-eyebrow-text',
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'eyebrow_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbsi .bbsi-eyebrow-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'eyebrow_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .bbsi .bbsi-eyebrow-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'eyebrow_dot', [
			'label'     => 'Dot Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#93BF3E',
			'selectors' => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'background-color: {{VALUE}};' ],
			'condition' => [ 'show_dot' => 'yes' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_size', [
			'label'      => 'Dot Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 40 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 8 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'show_dot' => 'yes' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_radius', [
			'label'      => 'Dot Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => true ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'condition'  => [ 'show_dot' => 'yes' ],
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
				'top'      => 'top',
				'center'   => 'middle',
				'bottom'   => 'bottom',
				'baseline' => 'baseline',
			],
			'selectors'            => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'vertical-align: {{VALUE}};' ],
			'condition'            => [ 'show_dot' => 'yes' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_offset', [
			'label'      => 'Dot Vertical Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => -20, 'max' => 20, 'step' => 0.5 ], 'em' => [ 'min' => -1, 'max' => 1, 'step' => 0.05 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 0 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'transform: translateY({{SIZE}}{{UNIT}});' ],
			'condition'  => [ 'show_dot' => 'yes' ],
		] );

		$this->add_responsive_control( 'eyebrow_dot_gap', [
			'label'      => 'Dot Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 24 ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-eyebrow-dot' => 'margin-right: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'show_dot' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_heading', [
			'label' => 'Heading',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbsi-heading' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'heading_typography',
			'selector' => '{{WRAPPER}} .bbsi-heading',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_text', [
			'label' => 'Intro Text',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'text_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbsi-text' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'text_typography',
			'selector' => '{{WRAPPER}} .bbsi-text, {{WRAPPER}} .bbsi-text p',
		] );

		$this->add_responsive_control( 'paragraph_spacing', [
			'label'      => 'Paragraph Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbsi-text p:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		foreach ( [ 1, 2 ] as $n ) {
			$sel   = "{{WRAPPER}} .bbsi-btn--{$n}";

			$this->start_controls_section( "section_style_btn{$n}", [
				'label'     => "Button {$n}",
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ "btn{$n}_show" => 'yes' ],
			] );

			$this->add_group_control( Group_Control_Typography::get_type(), [
				'name'     => "btn{$n}_typography",
				'selector' => $sel,
			] );

			$this->add_responsive_control( "btn{$n}_padding", [
				'label'      => 'Padding',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors'  => [ $sel => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			] );

			$this->add_responsive_control( "btn{$n}_radius", [
				'label'      => 'Border Radius',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ $sel => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			] );

			$this->add_control( "btn{$n}_border_width", [
				'label'      => 'Border Width',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'selectors'  => [ $sel => 'border-style: solid; border-width: {{SIZE}}{{UNIT}};' ],
			] );

			$this->add_responsive_control( "btn{$n}_icon_size", [
				'label'      => 'Icon Size',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 6, 'max' => 60 ], 'em' => [ 'min' => 0.3, 'max' => 3, 'step' => 0.05 ] ],
				'selectors'  => [ "{$sel} .elementor-button-icon" => 'font-size: {{SIZE}}{{UNIT}};' ],
				'condition'  => [ "btn{$n}_icon[value]!" => '' ],
			] );

			$this->add_responsive_control( "btn{$n}_icon_gap", [
				'label'      => 'Icon Spacing',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'selectors'  => [ "{$sel} .elementor-button-content-wrapper" => 'gap: {{SIZE}}{{UNIT}};' ],
				'condition'  => [ "btn{$n}_icon[value]!" => '' ],
			] );

			$this->start_controls_tabs( "btn{$n}_tabs" );

			$this->start_controls_tab( "btn{$n}_tab_normal", [ 'label' => 'Normal' ] );

			$this->add_control( "btn{$n}_color", [
				'label'     => 'Text Color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'color: {{VALUE}}; fill: {{VALUE}};' ],
			] );

			$this->add_control( "btn{$n}_bg", [
				'label'     => 'Background',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'background-color: {{VALUE}}; background-image: none;' ],
			] );

			$this->add_control( "btn{$n}_border", [
				'label'     => 'Border Color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ $sel => 'border-color: {{VALUE}};' ],
			] );

			$this->end_controls_tab();

			$this->start_controls_tab( "btn{$n}_tab_hover", [ 'label' => 'Hover' ] );

			$this->add_control( "btn{$n}_color_hover", [
				'label'     => 'Text Color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ "{$sel}:hover, {$sel}:focus-visible" => 'color: {{VALUE}}; fill: {{VALUE}};' ],
			] );

			$this->add_control( "btn{$n}_bg_hover", [
				'label'     => 'Background',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ "{$sel}:hover, {$sel}:focus-visible" => 'background-color: {{VALUE}}; background-image: none;' ],
			] );

			$this->add_control( "btn{$n}_border_hover", [
				'label'     => 'Border Color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ "{$sel}:hover, {$sel}:focus-visible" => 'border-color: {{VALUE}};' ],
			] );

			$this->add_control( "btn{$n}_transition", [
				'label'     => 'Transition (ms)',
				'type'      => Controls_Manager::NUMBER,
				'selectors' => [ $sel => 'transition-duration: {{VALUE}}ms;' ],
			] );

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();
		}
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$eyebrow_tag = Utils::validate_html_tag( $s['eyebrow_tag'] );
		$heading_tag = Utils::validate_html_tag( $s['heading_tag'] );

		$buttons = [];
		foreach ( [ 1, 2 ] as $n ) {
			if ( 'yes' === $s[ "btn{$n}_show" ] && '' !== trim( (string) $s[ "btn{$n}_text" ] ) ) {
				$buttons[] = $n;
			}
		}
		?>
		<div class="bbsi">
			<?php if ( '' !== trim( (string) $s['eyebrow'] ) ) : ?>
				<div class="bbsi-eyebrow">
					<<?php echo $eyebrow_tag; ?> class="bbsi-eyebrow-text"><?php if ( 'yes' === $s['show_dot'] ) : ?><span class="bbsi-eyebrow-dot" aria-hidden="true"></span><?php endif; ?><?php echo esc_html( $s['eyebrow'] ); ?></<?php echo $eyebrow_tag; ?>>
				</div>
			<?php endif; ?>

			<?php if ( '' !== trim( (string) $s['heading'] ) ) : ?>
				<<?php echo $heading_tag; ?> class="bbsi-heading"><?php echo wp_kses_post( nl2br( $s['heading'] ) ); ?></<?php echo $heading_tag; ?>>
			<?php endif; ?>

			<?php if ( '' !== trim( wp_strip_all_tags( (string) $s['text'] ) ) ) : ?>
				<div class="bbsi-text"><?php echo wp_kses_post( $s['text'] ); ?></div>
			<?php endif; ?>

			<?php if ( $buttons ) : ?>
				<div class="bbsi-buttons">
					<?php
					foreach ( $buttons as $n ) :
						$key   = "btn{$n}";
						$class = 'bbsi-btn bbsi-btn--' . $n . ' elementor-button';
						$this->add_render_attribute( $key, 'class', $class );
						if ( ! empty( $s[ "btn{$n}_link" ]['url'] ) ) {
							$this->add_link_attributes( $key, $s[ "btn{$n}_link" ] );
							$el = 'a';
						} else {
							$el = 'span';
						}
						$has_icon = ! empty( $s[ "btn{$n}_icon" ]['value'] );
						$before   = $has_icon && 'before' === $s[ "btn{$n}_icon_position" ];
						ob_start();
						if ( $has_icon ) {
							Icons_Manager::render_icon( $s[ "btn{$n}_icon" ], [ 'aria-hidden' => 'true' ] );
						}
						$icon_html = $has_icon ? '<span class="elementor-button-icon">' . ob_get_clean() . '</span>' : ob_get_clean();
						$text_html = '<span class="elementor-button-text">' . esc_html( $s[ "btn{$n}_text" ] ) . '</span>';
						?>
						<<?php echo $el; ?> <?php $this->print_render_attribute_string( $key ); ?>>
							<span class="elementor-button-content-wrapper"><?php echo $before ? $icon_html . $text_html : $text_html . $icon_html; ?></span>
						</<?php echo $el; ?>>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
