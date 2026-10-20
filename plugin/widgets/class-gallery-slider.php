<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

class BBEA_Gallery_Slider_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-gallery-slider';
	}

	public function get_title() {
		return 'Gallery Slider';
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'gallery', 'slider', 'carousel', 'thumbnails', 'lightbox', 'photos' ];
	}

	public function get_style_depends() {
		return [ 'e-swiper', 'bb-gallery-slider' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'bb-gallery-slider' ];
	}

	private function image_size_options() {
		$sizes = [];
		foreach ( get_intermediate_image_sizes() as $size ) {
			$sizes[ $size ] = ucwords( str_replace( [ '_', '-' ], ' ', $size ) );
		}
		$sizes['full'] = 'Full';
		return $sizes;
	}

	private function ratio_options() {
		return [
			''     => 'Original',
			'1/1'  => '1:1',
			'4/3'  => '4:3',
			'3/2'  => '3:2',
			'16/9' => '16:9',
			'21/9' => '21:9',
			'3/4'  => '3:4',
			'2/3'  => '2:3',
		];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_images', [
			'label' => 'Images',
		] );

		$this->add_control( 'gallery', [
			'label'   => 'Images',
			'type'    => Controls_Manager::GALLERY,
			'default' => [],
			'dynamic' => [ 'active' => true ],
		] );

		$this->add_control( 'main_size', [
			'label'   => 'Slider Image Size',
			'type'    => Controls_Manager::SELECT,
			'default' => 'large',
			'options' => $this->image_size_options(),
		] );

		$this->add_control( 'thumb_size', [
			'label'   => 'Thumbnail Image Size',
			'type'    => Controls_Manager::SELECT,
			'default' => 'medium',
			'options' => $this->image_size_options(),
		] );

		$this->add_control( 'lightbox', [
			'label'        => 'Lightbox',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->add_control( 'main_opens_lightbox', [
			'label'        => 'Clicking Slider Image Opens Lightbox',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'lightbox' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_slider', [
			'label' => 'Slider',
		] );

		$this->add_control( 'effect', [
			'label'   => 'Transition',
			'type'    => Controls_Manager::SELECT,
			'default' => 'fade',
			'options' => [
				'fade'  => 'Fade',
				'slide' => 'Slide',
			],
		] );

		$this->add_control( 'speed', [
			'label'   => 'Transition Speed (ms)',
			'type'    => Controls_Manager::NUMBER,
			'default' => 500,
			'min'     => 100,
			'step'    => 50,
		] );

		$this->add_control( 'loop', [
			'label'        => 'Loop',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->add_control( 'autoplay', [
			'label'        => 'Autoplay',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'return_value' => 'yes',
		] );

		$this->add_control( 'autoplay_delay', [
			'label'     => 'Autoplay Delay (ms)',
			'type'      => Controls_Manager::NUMBER,
			'default'   => 5000,
			'min'       => 1000,
			'step'      => 500,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'navigation', [
			'label'   => 'Navigation',
			'type'    => Controls_Manager::SELECT,
			'default' => 'arrows',
			'options' => [
				'both'   => 'Arrows and Dots',
				'arrows' => 'Arrows',
				'dots'   => 'Dots',
				'none'   => 'None',
			],
		] );

		$this->add_control( 'prev_icon', [
			'label'       => 'Previous Arrow Icon',
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'default'     => [ 'value' => 'eicon-chevron-left', 'library' => 'eicons' ],
			'condition'   => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_control( 'next_icon', [
			'label'       => 'Next Arrow Icon',
			'type'        => Controls_Manager::ICONS,
			'skin'        => 'inline',
			'label_block' => false,
			'default'     => [ 'value' => 'eicon-chevron-right', 'library' => 'eicons' ],
			'condition'   => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_thumbs', [
			'label' => 'Thumbnails',
		] );

		$this->add_control( 'show_thumbs', [
			'label'        => 'Show Thumbnails',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
		] );

		$this->add_responsive_control( 'thumb_columns', [
			'label'          => 'Visible Thumbnails',
			'type'           => Controls_Manager::NUMBER,
			'min'            => 1,
			'max'            => 12,
			'default'        => 4,
			'tablet_default' => 3,
			'mobile_default' => 2,
			'selectors'      => [ '{{WRAPPER}} .bbgs-thumbs' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
			'condition'      => [ 'show_thumbs' => 'yes' ],
		] );

		$this->add_control( 'more_overlay', [
			'label'        => 'See All Overlay on Last Thumbnail',
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'condition'    => [ 'show_thumbs' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_control( 'more_label', [
			'label'     => 'Overlay Label',
			'type'      => Controls_Manager::TEXT,
			'default'   => 'See All',
			'condition' => [ 'show_thumbs' => 'yes', 'lightbox' => 'yes', 'more_overlay' => 'yes' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_slider', [
			'label' => 'Slider',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'main_ratio', [
			'label'     => 'Aspect Ratio',
			'type'      => Controls_Manager::SELECT,
			'default'   => '4/3',
			'options'   => $this->ratio_options(),
			'selectors' => [ '{{WRAPPER}} .bbgs-main' => 'aspect-ratio: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'main_fit', [
			'label'     => 'Image Fit',
			'type'      => Controls_Manager::SELECT,
			'default'   => 'cover',
			'options'   => [
				'cover'   => 'Cover',
				'contain' => 'Contain',
			],
			'selectors' => [ '{{WRAPPER}} .bbgs .bbgs-main .bbgs-main-img' => 'object-fit: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'main_position', [
			'label'     => 'Image Position',
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => [ '' => 'Default' ] + [
				'center center' => 'Center Center',
				'center top'    => 'Center Top',
				'center bottom' => 'Center Bottom',
				'left center'   => 'Left Center',
				'left top'      => 'Left Top',
				'left bottom'   => 'Left Bottom',
				'right center'  => 'Right Center',
				'right top'     => 'Right Top',
				'right bottom'  => 'Right Bottom',
			],
			'selectors' => [ '{{WRAPPER}} .bbgs .bbgs-main .bbgs-main-img' => 'object-position: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'main_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-main' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'main_bg', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbgs-main' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'heading_arrows', [
			'label'     => 'Arrows',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_responsive_control( 'arrow_size', [
			'label'      => 'Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-arrow' => 'font-size: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .bbgs-arrow svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_control( 'arrow_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbgs-arrow' => 'color: {{VALUE}};', '{{WRAPPER}} .bbgs-arrow svg' => 'fill: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_control( 'arrow_bg', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbgs-arrow' => 'background-color: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_responsive_control( 'arrow_padding', [
			'label'      => 'Padding',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-arrow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_responsive_control( 'arrow_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_responsive_control( 'arrow_offset', [
			'label'      => 'Side Offset',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => -60, 'max' => 120 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-prev' => 'left: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .bbgs-next' => 'right: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'both', 'arrows' ] ],
		] );

		$this->add_control( 'heading_dots', [
			'label'     => 'Dots',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [ 'navigation' => [ 'both', 'dots' ] ],
		] );

		$this->add_responsive_control( 'dot_size', [
			'label'      => 'Size',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 2, 'max' => 30 ] ],
			'selectors'  => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
			'condition'  => [ 'navigation' => [ 'both', 'dots' ] ],
		] );

		$this->add_control( 'dot_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'both', 'dots' ] ],
		] );

		$this->add_control( 'dot_active_color', [
			'label'     => 'Active Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}};' ],
			'condition' => [ 'navigation' => [ 'both', 'dots' ] ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_thumbs', [
			'label'     => 'Thumbnails',
			'tab'       => Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_thumbs' => 'yes' ],
		] );

		$this->add_responsive_control( 'thumbs_spacing', [
			'label'      => 'Space Above Thumbnails',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-thumbs' => 'margin-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'thumbs_gap', [
			'label'      => 'Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-thumbs' => 'column-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'thumb_ratio', [
			'label'     => 'Aspect Ratio',
			'type'      => Controls_Manager::SELECT,
			'default'   => '3/2',
			'options'   => $this->ratio_options(),
			'selectors' => [ '{{WRAPPER}} .bbgs-thumb' => 'aspect-ratio: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'thumb_position', [
			'label'     => 'Image Position',
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => [ '' => 'Default' ] + [
				'center center' => 'Center Center',
				'center top'    => 'Center Top',
				'center bottom' => 'Center Bottom',
				'left center'   => 'Left Center',
				'left top'      => 'Left Top',
				'left bottom'   => 'Left Bottom',
				'right center'  => 'Right Center',
				'right top'     => 'Right Top',
				'right bottom'  => 'Right Bottom',
			],
			'selectors' => [ '{{WRAPPER}} .bbgs .bbgs-thumb .bbgs-thumb-img' => 'object-position: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'thumb_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbgs-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_control( 'thumb_inactive_opacity', [
			'label'     => 'Inactive Opacity',
			'type'      => Controls_Manager::SLIDER,
			'range'     => [ 'px' => [ 'min' => 0.1, 'max' => 1, 'step' => 0.05 ] ],
			'selectors' => [ '{{WRAPPER}} .bbgs .bbgs-thumb:not(.is-active) img' => 'opacity: {{SIZE}};' ],
		] );

		$this->add_control( 'thumb_active_border', [
			'label'     => 'Active Outline Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbgs-thumb.is-active' => 'outline: 2px solid {{VALUE}}; outline-offset: -2px;' ],
		] );

		$this->add_control( 'heading_overlay', [
			'label'     => 'See All Overlay',
			'type'      => Controls_Manager::HEADING,
			'separator' => 'before',
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_control( 'overlay_bg', [
			'label'     => 'Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.55)',
			'selectors' => [ '{{WRAPPER}} .bbgs-more' => 'background-color: {{VALUE}};' ],
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_control( 'overlay_bg_hover', [
			'label'     => 'Hover Background',
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(0, 0, 0, 0.72)',
			'selectors' => [ '{{WRAPPER}} .bbgs-more:hover' => 'background-color: {{VALUE}};' ],
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_control( 'overlay_count_color', [
			'label'     => 'Count Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => '#FFFFFF',
			'selectors' => [ '{{WRAPPER}} .bbgs-more-count' => 'color: {{VALUE}};' ],
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'overlay_count_typography',
			'label'     => 'Count Typography',
			'selector'  => '{{WRAPPER}} .bbgs-more-count',
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_control( 'overlay_label_color', [
			'label'     => 'Label Color',
			'type'      => Controls_Manager::COLOR,
			'default'   => 'rgba(255, 255, 255, 0.85)',
			'selectors' => [ '{{WRAPPER}} .bbgs-more-label' => 'color: {{VALUE}};' ],
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'      => 'overlay_label_typography',
			'label'     => 'Label Typography',
			'selector'  => '{{WRAPPER}} .bbgs-more-label',
			'condition' => [ 'more_overlay' => 'yes', 'lightbox' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$images = ! empty( $s['gallery'] ) ? $s['gallery'] : [];

		if ( ! $images ) {
			return;
		}

		$id       = $this->get_id();
		$lightbox = 'yes' === $s['lightbox'];
		$nav      = $s['navigation'];
		$arrows   = in_array( $nav, [ 'both', 'arrows' ], true ) && count( $images ) > 1;
		$dots     = in_array( $nav, [ 'both', 'dots' ], true ) && count( $images ) > 1;

		$config = [
			'effect'   => 'slide' === $s['effect'] ? 'slide' : 'fade',
			'speed'    => max( 100, intval( $s['speed'] ) ),
			'loop'     => 'yes' === $s['loop'],
			'autoplay' => 'yes' === $s['autoplay'] ? max( 1000, intval( $s['autoplay_delay'] ) ) : 0,
			'lightbox' => $lightbox,
			'mainLb'   => $lightbox && 'yes' === $s['main_opens_lightbox'],
			'more'     => $lightbox && 'yes' === $s['more_overlay'] && 'yes' === $s['show_thumbs'],
			'label'    => (string) $s['more_label'],
		];
		?>
		<div class="bbgs<?php echo $config['mainLb'] ? ' bbgs--lightbox-main' : ''; ?>" data-config="<?php echo esc_attr( wp_json_encode( $config ) ); ?>">
			<div class="bbgs-main">
				<div class="bbgs-swiper swiper">
					<div class="swiper-wrapper">
						<?php foreach ( $images as $i => $image ) : ?>
							<div class="swiper-slide bbgs-slide" data-index="<?php echo esc_attr( $i ); ?>">
								<?php echo $this->img( $image, $s['main_size'], 'bbgs-main-img', 0 === $i ? 'eager' : 'lazy' ); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<?php if ( $arrows ) : ?>
					<div class="bbgs-arrow bbgs-prev elementor-swiper-button elementor-swiper-button-prev" role="button" tabindex="0" aria-label="Previous image"><?php Icons_Manager::render_icon( $s['prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
					<div class="bbgs-arrow bbgs-next elementor-swiper-button elementor-swiper-button-next" role="button" tabindex="0" aria-label="Next image"><?php Icons_Manager::render_icon( $s['next_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
				<?php endif; ?>
				<?php if ( $dots ) : ?>
					<div class="bbgs-dots swiper-pagination"></div>
				<?php endif; ?>
			</div>

			<div class="bbgs-thumbs<?php echo 'yes' === $s['show_thumbs'] ? '' : ' bbgs-thumbs--hidden'; ?>">
				<?php
				foreach ( $images as $i => $image ) :
					$full = wp_get_attachment_image_url( $image['id'], 'full' );
					$full = $full ? $full : $image['url'];
					$attrs = [
						'href'       => esc_url( $full ),
						'class'      => 'bbgs-thumb' . ( 0 === $i ? ' is-active' : '' ),
						'data-index' => $i,
						'aria-label' => 'Show image ' . ( $i + 1 ),
					];
					if ( $lightbox ) {
						$attrs['data-elementor-open-lightbox']      = 'yes';
						$attrs['data-elementor-lightbox-slideshow'] = 'bbgs-' . $id;
					} else {
						$attrs['data-elementor-open-lightbox'] = 'no';
					}
					$attr_str = '';
					foreach ( $attrs as $k => $v ) {
						$attr_str .= ' ' . $k . '="' . esc_attr( $v ) . '"';
					}
					?>
					<a<?php echo $attr_str; ?>><?php echo $this->img( $image, $s['thumb_size'], 'bbgs-thumb-img', 'lazy' ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	private function img( $image, $size, $class, $loading ) {
		if ( ! empty( $image['id'] ) ) {
			$html = wp_get_attachment_image( $image['id'], $size, false, [ 'class' => $class, 'loading' => $loading ] );
			if ( $html ) {
				return $html;
			}
		}
		if ( ! empty( $image['url'] ) ) {
			return sprintf( '<img class="%s" src="%s" alt="" loading="%s">', esc_attr( $class ), esc_url( $image['url'] ), esc_attr( $loading ) );
		}
		return '';
	}
}
