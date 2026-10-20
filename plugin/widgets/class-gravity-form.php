<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class BBEA_Gravity_Form_Widget extends Widget_Base {

	public function get_name() {
		return 'bb-gravity-form';
	}

	public function get_title() {
		return 'Gravity Form';
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'bb-media' ];
	}

	public function get_keywords() {
		return [ 'gravity', 'form', 'forms', 'contact' ];
	}

	private function form_options() {
		$options = [ '' => 'Select a form' ];
		if ( ! class_exists( 'GFAPI' ) ) {
			return $options;
		}
		foreach ( \GFAPI::get_forms( true, false, 'title' ) as $form ) {
			$options[ (string) $form['id'] ] = $form['title'];
		}
		return $options;
	}

	protected function register_controls() {
		$this->start_controls_section( 'section_form', [
			'label' => 'Form',
		] );

		$this->add_control( 'form_id', [
			'label'   => 'Form',
			'type'    => Controls_Manager::SELECT,
			'options' => $this->form_options(),
			'default' => '',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$id = absint( $this->get_settings_for_display( 'form_id' ) );
		if ( ! $id ) {
			return;
		}
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			echo '<style>.elementor-element-' . esc_attr( $this->get_id() ) . ' .gform_wrapper{display:block!important}</style>';
		}
		echo do_shortcode( '[gravityform id="' . $id . '" title="false" description="false" ajax="true"]' );
	}
}
