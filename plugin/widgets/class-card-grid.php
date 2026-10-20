<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

class BBEA_Card_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-card-grid';
	}

	public function get_title() {
		return 'Product & Service Grid';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'card', 'cards', 'grid', 'product', 'service', 'logo', 'badge', 'label' ];
	}

	public function get_style_depends() {
		return [ 'bb-card-grid' ];
	}

	private function image_size_options() {
		$sizes = [];
		foreach ( get_intermediate_image_sizes() as $size ) {
			$sizes[ $size ] = ucwords( str_replace( [ '_', '-' ], ' ', $size ) );
		}
		$sizes['full'] = 'Full';
		return $sizes;
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

		$this->start_controls_section( 'section_cards', [
			'label' => 'Cards',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'image', [
			'label'   => 'Image',
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'logo', [
			'label' => 'Logo',
			'type'  => Controls_Manager::MEDIA,
		] );

		$repeater->add_control( 'label', [
			'label'       => 'Label',
			'type'        => Controls_Manager::TEXT,
			'placeholder' => 'New',
			'label_block' => true,
		] );

		$repeater->add_control( 'title', [
			'label'       => 'Title',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Card Title',
			'label_block' => true,
		] );

		$repeater->add_control( 'description', [
			'label'   => 'Description',
			'type'    => Controls_Manager::TEXTAREA,
			'default' => 'A short description of this item goes here.',
		] );

		$repeater->add_control( 'link_text', [
			'label'   => 'Link Text',
			'type'    => Controls_Manager::TEXT,
			'default' => 'Learn More',
		] );

		$repeater->add_control( 'link', [
			'label'       => 'Link',
			'type'        => Controls_Manager::URL,
			'placeholder' => 'Search pages or paste a URL',
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'cards', [
			'label'       => 'Cards',
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[ 'title' => 'Card Title', 'label' => 'New' ],
				[ 'title' => 'Card Title' ],
				[ 'title' => 'Card Title' ],
			],
		] );

		$this->add_control( 'image_size', [
			'label'     => 'Image Size',
			'type'      => Controls_Manager::SELECT,
			'options'   => $this->image_size_options(),
			'default'   => 'large',
			'separator' => 'before',
		] );

		$this->add_control( 'title_tag', [
			'label'   => 'Title Tag',
			'type'    => Controls_Manager::SELECT,
			'options' => $this->tag_options(),
			'default' => 'h3',
		] );

		$this->add_control( 'link_icon', [
			'label'   => 'Link Icon',
			'type'    => Controls_Manager::ICONS,
			'default' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_layout', [
			'label' => 'Layout',
		] );

		$this->add_responsive_control( 'columns', [
			'label'     => 'Columns',
			'type'      => Controls_Manager::NUMBER,
			'min'       => 1,
			'max'       => 12,
			'step'      => 1,
			'default'   => 3,
			'selectors' => [ '{{WRAPPER}} .bbcg' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'      => 'Column Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg' => 'column-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'row_gap', [
			'label'      => 'Row Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg' => 'row-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'text_align', [
			'label'                => 'Content Alignment',
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'selectors_dictionary' => [
				'left'   => 'text-align: left; --bbcg-link-justify: flex-start;',
				'center' => 'text-align: center; --bbcg-link-justify: center;',
				'right'  => 'text-align: right; --bbcg-link-justify: flex-end;',
			],
			'selectors'            => [ '{{WRAPPER}} .bbcg-content' => '{{VALUE}}' ],
		] );

		$this->add_control( 'equal_height', [
			'label'        => 'Pin Link to Bottom',
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'prefix_class' => 'bbcg-pin-link-',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_card', [
			'label' => 'Card',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'card_bg',
			'types'    => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .bbcg-card',
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'card_border',
			'selector' => '{{WRAPPER}} .bbcg-card',
		] );

		$this->add_responsive_control( 'card_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'card_shadow',
			'selector' => '{{WRAPPER}} .bbcg-card',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_image', [
			'label' => 'Image',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'image_ratio', [
			'label'     => 'Aspect Ratio',
			'type'      => Controls_Manager::SELECT,
			'default'   => '4 / 3',
			'options'   => [
				'auto'   => 'Original',
				'1 / 1'  => '1:1',
				'4 / 3'  => '4:3',
				'3 / 2'  => '3:2',
				'16 / 9' => '16:9',
				'21 / 9' => '21:9',
				'3 / 4'  => '3:4',
				'2 / 3'  => '2:3',
				'9 / 16' => '9:16',
			],
			'selectors' => [ '{{WRAPPER}} .bbcg-image' => 'aspect-ratio: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'image_fit', [
			'label'     => 'Object Fit',
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				''        => 'Default',
				'cover'   => 'Cover',
				'contain' => 'Contain',
				'fill'    => 'Fill',
			],
			'selectors' => [ '{{WRAPPER}} .bbcg-image .bbcg-img' => 'object-fit: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'image_position', [
			'label'     => 'Object Position',
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				''              => 'Default',
				'center center' => 'Center Center',
				'center top'    => 'Center Top',
				'center bottom' => 'Center Bottom',
				'left center'   => 'Left Center',
				'right center'  => 'Right Center',
			],
			'selectors' => [ '{{WRAPPER}} .bbcg-image .bbcg-img' => 'object-position: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'image_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_label', [
			'label' => 'Label',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'label_corner', [
			'label'                => 'Position',
			'type'                 => Controls_Manager::SELECT,
			'default'              => 'top-left',
			'options'              => [
				'top-left'     => 'Top Left',
				'top-right'    => 'Top Right',
				'bottom-left'  => 'Bottom Left',
				'bottom-right' => 'Bottom Right',
			],
			'selectors_dictionary' => [
				'top-left'     => 'top: var(--bbcg-label-y, 0px); bottom: auto; left: var(--bbcg-label-x, 0px); right: auto;',
				'top-right'    => 'top: var(--bbcg-label-y, 0px); bottom: auto; left: auto; right: var(--bbcg-label-x, 0px);',
				'bottom-left'  => 'top: auto; bottom: var(--bbcg-label-y, 0px); left: var(--bbcg-label-x, 0px); right: auto;',
				'bottom-right' => 'top: auto; bottom: var(--bbcg-label-y, 0px); left: auto; right: var(--bbcg-label-x, 0px);',
			],
			'selectors'            => [ '{{WRAPPER}} .bbcg-label' => '{{VALUE}}' ],
		] );

		$this->add_responsive_control( 'label_offset_x', [
			'label'      => 'Horizontal Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-label' => '--bbcg-label-x: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'label_offset_y', [
			'label'      => 'Vertical Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-label' => '--bbcg-label-y: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'label_color', [
			'label'     => 'Text Color',
			'type'      => Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [ '{{WRAPPER}} .bbcg-label' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'label_typography',
			'selector' => '{{WRAPPER}} .bbcg-label',
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'     => 'label_bg',
			'types'    => [ 'classic', 'gradient' ],
			'exclude'  => [ 'image' ],
			'selector' => '{{WRAPPER}} .bbcg-label',
		] );

		$this->add_responsive_control( 'label_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'label_border',
			'selector' => '{{WRAPPER}} .bbcg-label',
		] );

		$this->add_responsive_control( 'label_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_logo', [
			'label' => 'Logo',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'logo_align', [
			'label'                => 'Horizontal Position',
			'type'                 => Controls_Manager::CHOOSE,
			'default'              => 'right',
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-h-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-h-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
			],
			'selectors_dictionary' => [
				'left'   => 'left: var(--bbcg-logo-x, 0px); right: auto; --bbcg-logo-tx: 0%;',
				'center' => 'left: 50%; right: auto; --bbcg-logo-tx: -50%;',
				'right'  => 'left: auto; right: var(--bbcg-logo-x, 0px); --bbcg-logo-tx: 0%;',
			],
			'selectors'            => [ '{{WRAPPER}} .bbcg-logo' => '{{VALUE}}' ],
		] );

		$this->add_responsive_control( 'logo_offset_x', [
			'label'      => 'Horizontal Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'condition'  => [ 'logo_align!' => 'center' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-logo' => '--bbcg-logo-x: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_height', [
			'label'      => 'Logo Height',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 160 ] ],
			'separator'  => 'before',
			'selectors'  => [ '{{WRAPPER}} .bbcg .bbcg-logo .bbcg-logo-img' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_max_width', [
			'label'      => 'Logo Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 400 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg .bbcg-logo .bbcg-logo-img' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Background::get_type(), [
			'name'      => 'logo_bg',
			'types'     => [ 'classic', 'gradient' ],
			'exclude'   => [ 'image' ],
			'separator' => 'before',
			'selector'  => '{{WRAPPER}} .bbcg-logo',
		] );

		$this->add_responsive_control( 'logo_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'logo_border',
			'selector' => '{{WRAPPER}} .bbcg-logo',
		] );

		$this->add_responsive_control( 'logo_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Box_Shadow::get_type(), [
			'name'     => 'logo_shadow',
			'selector' => '{{WRAPPER}} .bbcg-logo',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_content', [
			'label' => 'Content',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( Group_Control_Border::get_type(), [
			'name'     => 'content_border',
			'selector' => '{{WRAPPER}} .bbcg-content',
		] );

		$this->add_responsive_control( 'content_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'title_heading', [
			'label'     => 'Title',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'title_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbcg-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .bbcg-title',
		] );

		$this->add_responsive_control( 'title_spacing', [
			'label'      => 'Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'desc_heading', [
			'label'     => 'Description',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'desc_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbcg-desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'desc_typography',
			'selector' => '{{WRAPPER}} .bbcg-desc',
		] );

		$this->add_responsive_control( 'desc_spacing', [
			'label'      => 'Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_link', [
			'label' => 'Link',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'link_typography',
			'selector' => '{{WRAPPER}} .bbcg-link',
		] );

		$this->add_responsive_control( 'link_icon_size', [
			'label'      => 'Icon Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 6, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-link-icon' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'link_icon_gap', [
			'label'      => 'Icon Spacing',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbcg-link' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'link_tabs' );

		$this->start_controls_tab( 'link_tab_normal', [ 'label' => 'Normal' ] );

		$this->add_control( 'link_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbcg-link' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'link_tab_hover', [ 'label' => 'Hover' ] );

		$this->add_control( 'link_color_hover', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbcg-link:hover, {{WRAPPER}} .bbcg-link:focus-visible' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cards = ! empty( $s['cards'] ) ? $s['cards'] : [];

		if ( ! $cards ) {
			return;
		}

		$title_tag = Utils::validate_html_tag( $s['title_tag'] );
		$icon      = '';
		if ( ! empty( $s['link_icon']['value'] ) ) {
			ob_start();
			Icons_Manager::render_icon( $s['link_icon'], [ 'aria-hidden' => 'true' ] );
			$icon = ob_get_clean();
		}
		?>
		<div class="bbcg" role="list">
			<?php foreach ( $cards as $i => $c ) : ?>
				<?php
				$title     = isset( $c['title'] ) ? trim( (string) $c['title'] ) : '';
				$desc      = isset( $c['description'] ) ? trim( (string) $c['description'] ) : '';
				$label     = isset( $c['label'] ) ? trim( (string) $c['label'] ) : '';
				$link_text = isset( $c['link_text'] ) ? trim( (string) $c['link_text'] ) : '';
				$img       = $this->image_html( isset( $c['image'] ) ? $c['image'] : [], $s['image_size'], 'bbcg-img', '' );
				$logo      = $this->image_html( isset( $c['logo'] ) ? $c['logo'] : [], 'medium', 'bbcg-logo-img', null );
				$has_link  = ! empty( $c['link']['url'] ) && '' !== $link_text;
				if ( $has_link ) {
					$key = 'link_' . $i;
					$this->add_link_attributes( $key, $c['link'] );
					$this->add_render_attribute( $key, 'class', 'bbcg-link' );
				}
				?>
				<div class="bbcg-card" role="listitem">
					<?php if ( $img || $logo || '' !== $label ) : ?>
						<div class="bbcg-media">
							<?php if ( $img ) : ?>
								<div class="bbcg-image"><?php echo $img; ?></div>
							<?php endif; ?>
							<?php if ( '' !== $label ) : ?>
								<span class="bbcg-label"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php if ( $logo ) : ?>
								<div class="bbcg-logo"><?php echo $logo; ?></div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div class="bbcg-content">
						<?php if ( '' !== $title ) : ?>
							<<?php echo $title_tag; ?> class="bbcg-title"><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
						<?php endif; ?>
						<?php if ( '' !== $desc ) : ?>
							<p class="bbcg-desc"><?php echo esc_html( $desc ); ?></p>
						<?php endif; ?>
						<?php if ( $has_link ) : ?>
							<a <?php $this->print_render_attribute_string( $key ); ?>>
								<span class="bbcg-link-text"><?php echo esc_html( $link_text ); ?><?php if ( '' !== $title ) : ?><span class="elementor-screen-only"> <?php echo esc_html( 'about ' . $title ); ?></span><?php endif; ?></span>
								<?php if ( $icon ) : ?>
									<span class="bbcg-link-icon"><?php echo $icon; ?></span>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function image_html( $media, $size, $class, $fallback_alt ) {
		if ( ! empty( $media['id'] ) ) {
			$own  = trim( (string) get_post_meta( $media['id'], '_wp_attachment_image_alt', true ) );
			$html = wp_get_attachment_image( $media['id'], $size, false, [
				'class'   => $class,
				'alt'     => '' !== $own ? $own : (string) $fallback_alt,
				'loading' => 'lazy',
			] );
			if ( $html ) {
				return $html;
			}
		}
		if ( ! empty( $media['url'] ) ) {
			return sprintf( '<img class="%s" src="%s" alt="%s" loading="lazy">', esc_attr( $class ), esc_url( $media['url'] ), esc_attr( (string) $fallback_alt ) );
		}
		return '';
	}
}
