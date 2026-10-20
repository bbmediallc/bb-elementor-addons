<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

class BBEA_Photo_Carousel_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-photo-carousel';
	}

	public function get_title() {
		return 'Photo Carousel';
	}

	public function get_icon() {
		return 'eicon-gallery-group';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'photo', 'photos', 'images', 'gallery', 'carousel', 'marquee', 'ticker', 'slider' ];
	}

	public function get_style_depends() {
		return [ 'e-swiper', 'bb-logo-carousel' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'bb-logo-carousel' ];
	}

	private function image_size_options() {
		$sizes = [];
		foreach ( get_intermediate_image_sizes() as $size ) {
			$sizes[ $size ] = ucwords( str_replace( [ '_', '-' ], ' ', $size ) );
		}
		$sizes['full'] = 'Full';
		return $sizes;
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_logos', [
			'label' => 'Photos',
		] );

		$this->add_control( 'gallery', [
			'label'   => 'Photos',
			'type'    => Controls_Manager::GALLERY,
			'default' => [],
			'dynamic' => [ 'active' => true ],
		] );

		$this->add_control( 'image_size', [
			'label'   => 'Image Size',
			'type'    => Controls_Manager::SELECT,
			'default' => 'large',
			'options' => $this->image_size_options(),
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_settings', [
			'label' => 'Settings',
		] );

		$this->add_control( 'mode', [
			'label'   => 'Mode',
			'type'    => Controls_Manager::SELECT,
			'default' => 'marquee',
			'options' => [
				'marquee' => 'Marquee (continuous scroll)',
				'slider'  => 'Slider (step by step)',
			],
		] );

		$this->add_responsive_control( 'per_view', [
			'label'       => 'Photos Per View',
			'description' => 'Leave empty to size by the photo width settings.',
			'type'        => Controls_Manager::NUMBER,
			'min'         => 1,
			'max'         => 12,
			'step'        => 1,
			'condition'   => [ 'mode' => 'slider' ],
		] );

		$this->add_control( 'slider_speed', [
			'label'     => 'Transition Speed (ms)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 600,
			'min'       => 100,
			'step'      => 50,
			'condition' => [ 'mode' => 'slider' ],
		] );

		$this->add_control( 'slider_delay', [
			'label'       => 'Autoplay Delay (ms)',
			'description' => '0 turns autoplay off.',
			'type'        => Controls_Manager::NUMBER,
			'default'     => 3000,
			'min'         => 0,
			'step'        => 250,
			'condition'   => [ 'mode' => 'slider' ],
		] );

		$this->add_control( 'slider_loop', [
			'label'        => 'Loop',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'mode' => 'slider' ],
		] );

		$this->add_control( 'navigation', [
			'label'     => 'Navigation',
			'type'      => Controls_Manager::SELECT,
			'default'   => 'none',
			'options'   => [
				'none'   => 'None',
				'arrows' => 'Arrows',
				'dots'   => 'Dots',
				'both'   => 'Arrows and Dots',
			],
			'condition' => [ 'mode' => 'slider' ],
		] );

		$this->add_control( 'prev_icon', [
			'label'       => 'Previous Arrow Icon',
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'default'     => [ 'value' => 'eicon-chevron-left', 'library' => 'eicons' ],
			'condition'   => [ 'mode' => 'slider', 'navigation' => [ 'arrows', 'both' ] ],
		] );

		$this->add_control( 'next_icon', [
			'label'       => 'Next Arrow Icon',
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'default'     => [ 'value' => 'eicon-chevron-right', 'library' => 'eicons' ],
			'condition'   => [ 'mode' => 'slider', 'navigation' => [ 'arrows', 'both' ] ],
		] );

		$this->add_control( 'marquee_speed', [
			'label'       => 'Speed (pixels per second)',
			'type'        => Controls_Manager::NUMBER,
			'default'     => 40,
			'min'         => 5,
			'max'         => 400,
			'step'        => 5,
			'condition'   => [ 'mode' => 'marquee' ],
		] );

		$this->add_control( 'marquee_direction', [
			'label'     => 'Direction',
			'type'      => Controls_Manager::CHOOSE,
			'default'   => 'left',
			'toggle'    => false,
			'options'   => [
				'left'  => [ 'title' => 'Left', 'icon' => 'eicon-arrow-left' ],
				'right' => [ 'title' => 'Right', 'icon' => 'eicon-arrow-right' ],
			],
			'condition' => [ 'mode' => 'marquee' ],
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => 'Pause on Hover',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_logos', [
			'label' => 'Photos',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'logo_height', [
			'label'      => 'Height',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', 'vw' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 300 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-item' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_min_width', [
			'label'      => 'Min Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 500 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-item' => 'min-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_max_width', [
			'label'      => 'Max Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 600 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-item' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_fit', [
			'label'     => 'Fit',
			'type'      => Controls_Manager::SELECT,
			'default'   => 'contain',
			'options'   => [
				'contain'    => 'Contain',
				'cover'      => 'Cover',
				'scale-down' => 'Scale Down',
				'fill'       => 'Fill',
			],
			'selectors' => [ '{{WRAPPER}} .bblc .bblc-img' => 'object-fit: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'logo_gap', [
			'label'      => 'Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'selectors'  => [
				'{{WRAPPER}} .bblc-group' => 'gap: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .bblc-slide' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
			],
		] );

		$this->add_responsive_control( 'logo_align', [
			'label'                => 'Horizontal Alignment',
			'type'                 => Controls_Manager::CHOOSE,
			'options'              => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-h-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-h-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-h-align-right' ],
			],
			'selectors_dictionary' => [
				'left'   => 'flex-start',
				'center' => 'center',
				'right'  => 'flex-end',
			],
			'selectors'            => [ '{{WRAPPER}} .bblc-slide' => 'justify-content: {{VALUE}};' ],
			'condition'            => [ 'mode' => 'slider' ],
		] );

		$this->add_responsive_control( 'area_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bblc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'logo_tabs' );

		$this->start_controls_tab( 'logo_tab_normal', [ 'label' => 'Normal' ] );

		$this->add_control( 'logo_opacity', [
			'label'     => 'Opacity',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'selectors' => [ '{{WRAPPER}} .bblc-img' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_control( 'logo_grayscale', [
			'label'     => 'Grayscale (%)',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors' => [ '{{WRAPPER}} .bblc-img' => 'filter: grayscale({{SIZE}}%);' ],
		] );

		$this->end_controls_tab();

		$this->start_controls_tab( 'logo_tab_hover', [ 'label' => 'Hover' ] );

		$this->add_control( 'logo_opacity_hover', [
			'label'     => 'Opacity',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
			'selectors' => [ '{{WRAPPER}} .bblc-item:hover .bblc-img' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_control( 'logo_grayscale_hover', [
			'label'     => 'Grayscale (%)',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
			'selectors' => [ '{{WRAPPER}} .bblc-item:hover .bblc-img' => 'filter: grayscale({{SIZE}}%);' ],
		] );

		$this->add_control( 'logo_transition', [
			'label'     => 'Transition (ms)',
			'type'      => Controls_Manager::NUMBER,
			'selectors' => [ '{{WRAPPER}} .bblc-img' => 'transition: opacity {{VALUE}}ms ease, filter {{VALUE}}ms ease;' ],
		] );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_fade', [
			'label'     => 'Edge Fade',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'mode' => 'marquee' ],
		] );

		$this->add_control( 'fade', [
			'label'        => 'Edge Fade',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'return_value' => 'yes',
			'prefix_class' => 'bblc-fade-',
		] );

		$this->add_control( 'fade_color', [
			'label'       => 'Fade Color',
			'description' => 'Match the section background.',
			'type'        => Controls_Manager::COLOR,
			'selectors'   => [
				'{{WRAPPER}} .bblc--marquee::before' => 'background-image: linear-gradient(90deg, {{VALUE}}, transparent);',
				'{{WRAPPER}} .bblc--marquee::after'  => 'background-image: linear-gradient(270deg, {{VALUE}}, transparent);',
			],
			'condition'   => [ 'fade' => 'yes' ],
		] );

		$this->add_responsive_control( 'fade_width', [
			'label'      => 'Fade Width',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 300 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 80 ],
			'selectors'  => [ '{{WRAPPER}} .bblc--marquee::before, {{WRAPPER}} .bblc--marquee::after' => 'width: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'fade' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_nav', [
			'label'     => 'Navigation',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'mode' => 'slider', 'navigation!' => 'none' ],
		] );

		$this->add_responsive_control( 'arrow_size', [
			'label'      => 'Arrow Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-arrow' => 'font-size: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .bblc-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'arrows', 'both' ] ],
		] );

		$this->add_control( 'arrow_color', [
			'label'     => 'Arrow Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bblc-arrow' => 'color: {{VALUE}};', '{{WRAPPER}} .bblc-arrow svg' => 'fill: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'arrows', 'both' ] ],
		] );

		$this->add_responsive_control( 'arrow_offset', [
			'label'      => 'Arrow Side Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -80, 'max' => 120 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-prev' => 'left: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .bblc-next' => 'right: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'arrows', 'both' ] ],
		] );

		$this->add_responsive_control( 'dot_size', [
			'label'      => 'Dot Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 30 ] ],
			'selectors'  => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'dots', 'both' ] ],
		] );

		$this->add_control( 'dot_color', [
			'label'     => 'Dot Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'dots', 'both' ] ],
		] );

		$this->add_control( 'dot_active_color', [
			'label'     => 'Active Dot Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'dots', 'both' ] ],
		] );

		$this->add_responsive_control( 'dots_spacing', [
			'label'      => 'Space Above Dots',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bblc-dots' => 'margin-top: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'dots', 'both' ] ],
		] );

		$this->end_controls_section();
	}

	private function per_view_map( $s ) {
		$map = [ 'desktop' => isset( $s['per_view'] ) ? $s['per_view'] : '' ];
		$devices = [];
		if ( class_exists( '\Elementor\Plugin' ) && isset( Plugin::$instance->breakpoints ) ) {
			$devices = array_keys( Plugin::$instance->breakpoints->get_active_breakpoints() );
		}
		foreach ( $devices as $device ) {
			$key = 'per_view_' . $device;
			$map[ $device ] = isset( $s[ $key ] ) ? $s[ $key ] : '';
		}
		foreach ( $map as $k => $v ) {
			$map[ $k ] = '' === $v || null === $v ? null : max( 1, intval( $v ) );
		}
		return $map;
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$logos = [];
		foreach ( ! empty( $s['gallery'] ) ? $s['gallery'] : [] as $photo ) {
			$logos[] = [
				'title' => ! empty( $photo['id'] ) ? get_the_title( $photo['id'] ) : '',
				'image' => $photo,
			];
		}

		if ( ! $logos ) {
			return;
		}

		$mode   = 'slider' === $s['mode'] ? 'slider' : 'marquee';
		$nav    = isset( $s['navigation'] ) ? $s['navigation'] : 'none';
		$arrows = 'slider' === $mode && in_array( $nav, [ 'arrows', 'both' ], true );
		$dots   = 'slider' === $mode && in_array( $nav, [ 'dots', 'both' ], true );

		$config = [
			'mode'      => $mode,
			'pause'     => 'yes' === $s['pause_on_hover'],
			'perView'   => $this->per_view_map( $s ),
			'speed'     => max( 100, intval( $s['slider_speed'] ) ),
			'delay'     => max( 0, intval( $s['slider_delay'] ) ),
			'loop'      => 'yes' === $s['slider_loop'],
			'pxPerSec'  => max( 5, intval( $s['marquee_speed'] ) ),
			'direction' => 'right' === $s['marquee_direction'] ? 'right' : 'left',
		];

		$items = [];
		foreach ( $logos as $i => $logo ) {
			$items[] = $this->item_html( $logo, $s['image_size'], $i );
		}
		?>
		<div class="bblc bblc--<?php echo esc_attr( $mode ); ?><?php echo $config['pause'] ? ' bblc--pause' : ''; ?>" data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>">
			<?php if ( 'marquee' === $mode ) : ?>
				<div class="bblc-viewport">
					<div class="bblc-track">
						<div class="bblc-group" role="list">
							<?php foreach ( $items as $html ) : ?>
								<div class="bblc-cell" role="listitem"><?php echo $html; ?></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php else : ?>
				<div class="bblc-slider-wrap">
					<div class="bblc-swiper swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $items as $html ) : ?>
								<div class="swiper-slide bblc-slide"><?php echo $html; ?></div>
							<?php endforeach; ?>
						</div>
					</div>
					<?php if ( $arrows ) : ?>
						<div class="bblc-arrow bblc-prev elementor-swiper-button elementor-swiper-button-prev" role="button" tabindex="0" aria-label="Previous photos"><?php Icons_Manager::render_icon( $s['prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
						<div class="bblc-arrow bblc-next elementor-swiper-button elementor-swiper-button-next" role="button" tabindex="0" aria-label="Next photos"><?php Icons_Manager::render_icon( $s['next_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
					<?php endif; ?>
				</div>
				<?php if ( $dots ) : ?>
					<div class="bblc-dots swiper-pagination"></div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
	}

	private function item_html( $logo, $size, $i ) {
		$title = isset( $logo['title'] ) ? trim( (string) $logo['title'] ) : '';
		$image = isset( $logo['image'] ) ? $logo['image'] : [];
		$img   = '';

		if ( ! empty( $image['id'] ) ) {
			$alt = trim( (string) get_post_meta( $image['id'], '_wp_attachment_image_alt', true ) );
			$img = wp_get_attachment_image( $image['id'], $size, false, [
				'class'   => 'bblc-img',
				'alt'     => '' !== $alt ? $alt : $title,
				'loading' => 'lazy',
			] );
		}
		if ( ! $img && ! empty( $image['url'] ) ) {
			$img = sprintf( '<img class="bblc-img" src="%s" alt="%s" loading="lazy">', esc_url( $image['url'] ), esc_attr( $title ) );
		}
		if ( ! $img ) {
			return '';
		}

		if ( ! empty( $logo['link']['url'] ) ) {
			$key = 'logo_link_' . $i;
			$this->add_render_attribute( $key, 'class', 'bblc-item' );
			$this->add_link_attributes( $key, $logo['link'] );
			if ( $title ) {
				$this->add_render_attribute( $key, 'title', $title );
			}
			return '<a ' . $this->get_render_attribute_string( $key ) . '>' . $img . '</a>';
		}

		return '<div class="bblc-item">' . $img . '</div>';
	}
}
