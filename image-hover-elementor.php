<?php
/**
 * Plugin Name:       Image Hover for Elementor
 * Plugin URI:        https://example.com/image-hover-elementor
 * Description:       Elementor widget with dual images on hover, overlay, heading and rich text — similar to the native Image widget.
 * Version:           1.0.0
 * Author:            Shahzaib Ahmed
 * Text Domain:       image-hover-elementor
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Elementor tested up to: 3.25
 * Elementor Pro tested up to: 3.25
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'IHE_VERSION', '1.0.0' );
define( 'IHE_PLUGIN_FILE', __FILE__ );
define( 'IHE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'IHE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Check Elementor is active.
 */
function ihe_is_elementor_active() {
	return did_action( 'elementor/loaded' );
}

/**
 * Admin notice when Elementor is missing.
 */
function ihe_admin_notice_missing_elementor() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	$message = sprintf(
		/* translators: %s: plugin name */
		esc_html__( '"%s" requires Elementor to be installed and activated.', 'image-hover-elementor' ),
		'<strong>' . esc_html__( 'Image Hover for Elementor', 'image-hover-elementor' ) . '</strong>'
	);

	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
}

/**
 * Load plugin textdomain and register widget.
 */
function ihe_init() {
	if ( ! ihe_is_elementor_active() ) {
		add_action( 'admin_notices', 'ihe_admin_notice_missing_elementor' );
		return;
	}

	require_once IHE_PLUGIN_DIR . 'includes/class-ihe-plugin.php';
	\IHE\Plugin::instance();
}
add_action( 'plugins_loaded', 'ihe_init' );

/**
 * Register frontend styles.
 */
function ihe_register_assets() {
	wp_register_style(
		'image-hover-elementor',
		IHE_PLUGIN_URL . 'assets/css/image-hover.css',
		[],
		IHE_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'ihe_register_assets' );
add_action( 'elementor/editor/before_enqueue_scripts', 'ihe_register_assets' );
