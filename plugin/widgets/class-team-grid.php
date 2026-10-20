<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

class BBEA_Team_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-team-grid';
	}

	public function get_title() {
		return 'Team Grid';
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'team', 'staff', 'people', 'members', 'employees', 'grid', 'headshots' ];
	}

	public function get_style_depends() {
		return [ 'bb-team-grid' ];
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

		$this->start_controls_section( 'section_members', [
			'label' => 'Team Members',
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'photo', [
			'label'   => 'Photo',
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			'dynamic' => [ 'active' => true ],
		] );

		$repeater->add_control( 'name', [
			'label'       => 'Name',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Full Name',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$repeater->add_control( 'job_title', [
			'label'       => 'Title',
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Job Title',
			'label_block' => true,
			'dynamic'     => [ 'active' => true ],
		] );

		$this->add_control( 'members', [
			'label'       => 'Members',
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => [
				[ 'name' => 'Full Name', 'job_title' => 'Job Title' ],
				[ 'name' => 'Full Name', 'job_title' => 'Job Title' ],
				[ 'name' => 'Full Name', 'job_title' => 'Job Title' ],
				[ 'name' => 'Full Name', 'job_title' => 'Job Title' ],
			],
		] );

		$this->add_control( 'image_size', [
			'label'   => 'Image Size',
			'type'    => Controls_Manager::SELECT,
			'default' => 'large',
			'options' => $this->image_size_options(),
		] );

		$this->add_control( 'name_tag', [
			'label'   => 'Name HTML Tag',
			'type'    => Controls_Manager::SELECT,
			'default' => 'h3',
			'options' => $this->tag_options(),
		] );

		$this->add_control( 'title_tag', [
			'label'   => 'Title HTML Tag',
			'type'    => Controls_Manager::SELECT,
			'default' => 'p',
			'options' => $this->tag_options(),
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_layout', [
			'label' => 'Layout',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'columns', [
			'label'     => 'Columns',
			'type'      => Controls_Manager::NUMBER,
			'min'       => 1,
			'max'       => 12,
			'step'      => 1,
			'default'   => 4,
			'selectors' => [ '{{WRAPPER}} .bbtg' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
		] );

		$this->add_responsive_control( 'column_gap', [
			'label'      => 'Column Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 10 ],
			'selectors'  => [ '{{WRAPPER}} .bbtg' => 'column-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'row_gap', [
			'label'      => 'Row Gap',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
			'default'    => [ 'unit' => 'px', 'size' => 10 ],
			'selectors'  => [ '{{WRAPPER}} .bbtg' => 'row-gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'text_align', [
			'label'     => 'Text Alignment',
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => 'Left', 'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => 'Center', 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => 'Right', 'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [ '{{WRAPPER}} .bbtg-info' => 'text-align: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_photo', [
			'label' => 'Photo',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'photo_ratio', [
			'label'     => 'Aspect Ratio',
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => [
				''     => 'Original',
				'1/1'  => '1:1',
				'3/4'  => '3:4',
				'4/5'  => '4:5',
				'2/3'  => '2:3',
				'4/3'  => '4:3',
				'3/2'  => '3:2',
				'16/9' => '16:9',
			],
			'selectors' => [ '{{WRAPPER}} .bbtg-photo' => 'aspect-ratio: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'photo_fit', [
			'label'     => 'Fit',
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => [
				''        => 'Default',
				'cover'   => 'Cover',
				'contain' => 'Contain',
			],
			'selectors' => [ '{{WRAPPER}} .bbtg .bbtg-photo .bbtg-img' => 'object-fit: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'photo_position', [
			'label'     => 'Position',
			'type'      => Controls_Manager::SELECT,
			'default'   => '',
			'options'   => [
				''              => 'Default',
				'center center' => 'Center Center',
				'center top'    => 'Center Top',
				'center bottom' => 'Center Bottom',
				'left center'   => 'Left Center',
				'right center'  => 'Right Center',
			],
			'selectors' => [ '{{WRAPPER}} .bbtg .bbtg-photo .bbtg-img' => 'object-position: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'photo_radius', [
			'label'      => 'Border Radius',
			'type'       => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .bbtg-photo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'photo_spacing', [
			'label'      => 'Space Below Photo',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbtg-photo' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_name', [
			'label' => 'Name',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'name_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbtg .bbtg-name' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'name_typography',
			'selector' => '{{WRAPPER}} .bbtg .bbtg-name',
		] );

		$this->add_responsive_control( 'name_spacing', [
			'label'      => 'Space Below Name',
			'type'       => Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'em', 'rem' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .bbtg .bbtg-name' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		$this->start_controls_section( 'section_style_title', [
			'label' => 'Title',
			'tab'   => Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => 'Color',
			'type'      => Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .bbtg .bbtg-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( Group_Control_Typography::get_type(), [
			'name'     => 'title_typography',
			'selector' => '{{WRAPPER}} .bbtg .bbtg-title',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$members = ! empty( $s['members'] ) ? $s['members'] : [];

		if ( ! $members ) {
			return;
		}

		$name_tag  = Utils::validate_html_tag( $s['name_tag'] );
		$title_tag = Utils::validate_html_tag( $s['title_tag'] );
		?>
		<div class="bbtg" role="list">
			<?php foreach ( $members as $m ) : ?>
				<?php
				$name  = isset( $m['name'] ) ? trim( (string) $m['name'] ) : '';
				$title = isset( $m['job_title'] ) ? trim( (string) $m['job_title'] ) : '';
				$img   = $this->photo_html( $m, $s['image_size'], $name, $title );
				?>
				<div class="bbtg-member" role="listitem">
					<?php if ( $img ) : ?>
						<div class="bbtg-photo"><?php echo $img; ?></div>
					<?php endif; ?>
					<?php if ( '' !== $name || '' !== $title ) : ?>
						<div class="bbtg-info">
							<?php if ( '' !== $name ) : ?>
								<<?php echo $name_tag; ?> class="bbtg-name"><?php echo esc_html( $name ); ?></<?php echo $name_tag; ?>>
							<?php endif; ?>
							<?php if ( '' !== $title ) : ?>
								<<?php echo $title_tag; ?> class="bbtg-title"><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function photo_html( $m, $size, $name, $title ) {
		$photo = isset( $m['photo'] ) ? $m['photo'] : [];
		$alt   = trim( $name . ( '' !== $title ? ', ' . $title : '' ) );

		if ( ! empty( $photo['id'] ) ) {
			$own = trim( (string) get_post_meta( $photo['id'], '_wp_attachment_image_alt', true ) );
			$html = wp_get_attachment_image( $photo['id'], $size, false, [
				'class'   => 'bbtg-img',
				'alt'     => '' !== $own ? $own : $alt,
				'loading' => 'lazy',
			] );
			if ( $html ) {
				return $html;
			}
		}
		if ( ! empty( $photo['url'] ) ) {
			return sprintf( '<img class="bbtg-img" src="%s" alt="%s" loading="lazy">', esc_url( $photo['url'] ), esc_attr( $alt ) );
		}
		return '';
	}
}
