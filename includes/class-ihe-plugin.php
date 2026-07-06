<?php
namespace IHE;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
	}

	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'image-hover-elementor',
			[
				'title' => esc_html__( 'Image Hover', 'image-hover-elementor' ),
				'icon'  => 'fa fa-image',
			]
		);
	}

	public function register_widgets( $widgets_manager ) {
		require_once IHE_PLUGIN_DIR . 'includes/widgets/class-image-hover-widget.php';
		$widgets_manager->register( new Widgets\Image_Hover_Widget() );
	}
}
