<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class BBEA_Stats_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-stats-grid';
	}

	public function get_title() {
		return 'Stats Grid';
	}

	public function get_icon() {
		return 'eicon-number-field';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'stats', 'statistics', 'numbers', 'counter', 'facts', 'figures', 'grid' ];
	}

	public function get_style_depends() {
		return [ 'bb-stats-grid' ];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_stats', [
			'label' => 'Stats',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'prefix', [
			'label'       => 'Prefix',
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'e.g. $',
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'number', [
			'label'       => 'Number',
			'type'        => Controls_Manager::TEXT,
			'default'     => '100',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'suffix', [
			'label'       => 'Suffix',
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'e.g. + or %',
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'label', [
			'label'       => 'Label',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Label',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'stats', [
			'label'       => 'Stats',
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ prefix }}}{{{ number }}}{{{ suffix }}} {{{ label }}}',
			'default'     => [
				[ 'number' => '20', 'suffix' => '+', 'label' => 'Years in Business' ],
				[ 'number' => '1,200', 'suffix' => '+', 'label' => 'Projects Completed' ],
				[ 'number' => '98', 'suffix' => '%', 'label' => 'Client Satisfaction' ],
				[ 'number' => '50', 'suffix' => '+', 'label' => 'Clients Served' ],
			],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_layout', [
			'label' => 'Layout',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'columns', [
			'label'       => 'Columns',
			'type'        => Controls_Manager::NUMBER,
			'min'         => 1,
			'max'         => 12,
			'step'        => 1,
			'default'        => 4,
			'tablet_default' => 4,
			'mobile_default' => 1,
			'description'    => 'Leave empty to fit as many as there is room for.',
			'selectors'      => [ '{{WRAPPER}} .bbsg-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
		] );

		$this->add_responsive_control( 'align', [
			'label'     => 'Alignment',
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [ '{{WRAPPER}} .bbsg-item' => 'text-align: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'item_padding', [
			'label'          => 'Stat Padding',
			'type'           => Controls_Manager::DIMENSIONS,
			'size_units'     => [ 'px', 'em', 'rem', '%' ],
			'default'        => [ 'top' => '32', 'right' => '40', 'bottom' => '32', 'left' => '40', 'unit' => 'px', 'isLinked' => false ],
			'tablet_default' => [ 'top' => '24', 'right' => '24', 'bottom' => '24', 'left' => '24', 'unit' => 'px', 'isLinked' => true ],
			'mobile_default' => [ 'top' => '24', 'right' => '0', 'bottom' => '24', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
			'selectors'  => [ '{{WRAPPER}} .bbsg-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_stat', [
			'label' => 'Stat',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		// Applies to every stat except the last, so the default right (or, on
		// phones, bottom) border reads as a divider between stats. With no
		// color set, stats-grid.css uses a faint tint of the text color.
		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'           => 'item_border',
			'selector'       => '{{WRAPPER}} .bbsg-item:not(:last-child)',
			'fields_options' => [
				'border' => [ 'default' => 'solid' ],
				'width'  => [
					'default'        => [ 'top' => '0', 'right' => '1', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
					'tablet_default' => [ 'top' => '0', 'right' => '1', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
					'mobile_default' => [ 'top' => '0', 'right' => '0', 'bottom' => '1', 'left' => '0', 'unit' => 'px', 'isLinked' => false ],
				],
			],
		] );

		$this->add_responsive_control( 'item_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbsg-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_box', [
			'label' => 'Box',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'box_bg',
			'types'    => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .bbsg',
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'box_border',
			'selector' => '{{WRAPPER}} .bbsg',
		] );

		$this->add_responsive_control( 'box_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbsg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'box_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbsg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_number', [
			'label' => 'Number',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'number_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbsg-value' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'number_typography',
			'selector'       => '{{WRAPPER}} .bbsg-value',
			'fields_options' => [
				'typography'  => [ 'default' => 'custom' ],
				'font_weight' => [ 'default' => '700' ],
				'font_size'   => [
					'default'        => [ 'unit' => 'px', 'size' => 56 ],
					'tablet_default' => [ 'unit' => 'px', 'size' => 44 ],
					'mobile_default' => [ 'unit' => 'px', 'size' => 40 ],
				],
				'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1 ] ],
			],
		] );

		$this->add_control( 'affix_heading', [
			'label'       => 'Prefix & Suffix',
			'type'        => Controls_Manager::HEADING,
			'separator'   => 'before',
			'description' => 'Leave these empty to match the number.',
		] );

		$this->add_control( 'affix_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbsg-prefix, {{WRAPPER}} .bbsg-suffix' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'affix_typography',
			'selector' => '{{WRAPPER}} .bbsg-prefix, {{WRAPPER}} .bbsg-suffix',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_label', [
			'label' => 'Label',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'label_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbsg-label' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'           => 'label_typography',
			'selector'       => '{{WRAPPER}} .bbsg-label',
			'fields_options' => [
				'typography'     => [ 'default' => 'custom' ],
				'font_size'      => [ 'default' => [ 'unit' => 'px', 'size' => 14 ] ],
				'font_weight'    => [ 'default' => '500' ],
				'text_transform' => [ 'default' => 'uppercase' ],
				'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 2 ] ],
			],
		] );

		$this->add_responsive_control( 'label_spacing', [
			'label'      => 'Space Above',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 12 ],
			'selectors'  => [ '{{WRAPPER}} .bbsg-label' => 'margin-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$stats = ! empty( $s['stats'] ) ? $s['stats'] : [];

		if ( ! $stats ) {
			return;
		}
		?>
		<div class="bbsg">
			<div class="bbsg-grid" role="list">
				<?php foreach ( $stats as $stat ) : ?>
					<?php
					$prefix = isset( $stat['prefix'] ) ? trim( (string) $stat['prefix'] ) : '';
					$number = isset( $stat['number'] ) ? trim( (string) $stat['number'] ) : '';
					$suffix = isset( $stat['suffix'] ) ? trim( (string) $stat['suffix'] ) : '';
					$label  = isset( $stat['label'] ) ? trim( (string) $stat['label'] ) : '';
					if ( '' === $number && '' === $label ) {
						continue;
					}
					?>
					<div class="bbsg-item" role="listitem">
						<?php if ( '' !== $prefix . $number . $suffix ) : ?>
							<div class="bbsg-value"><?php if ( '' !== $prefix ) : ?><span class="bbsg-prefix"><?php echo esc_html( $prefix ); ?></span><?php endif; ?><span class="bbsg-number"><?php echo esc_html( $number ); ?></span><?php if ( '' !== $suffix ) : ?><span class="bbsg-suffix"><?php echo esc_html( $suffix ); ?></span><?php endif; ?></div>
						<?php endif; ?>
						<?php if ( '' !== $label ) : ?>
							<div class="bbsg-label"><?php echo esc_html( $label ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
