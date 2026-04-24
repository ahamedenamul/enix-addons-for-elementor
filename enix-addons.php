<?php
/**
 * Plugin Name:       Enix Addons – Advanced Addons for Elementor
 * Plugin URI:        https://github.com/ahamedenamul
 * Description:       A premium collection of advanced widgets for Elementor, starting with the Interactive Advanced Accordion.
 * Version:           1.0.4
 * Author:            Enamul Islam
 * Author URI:        https://github.com/ahamedenamul
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       enix-addons
 * Domain Path:       /languages
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Tested up to:      6.5
 * Elementor tested up to: 3.21.0
 *
 * @package EnixAddons
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ─── Constants ───────────────────────────────────────────────────────────────
define( 'ENIX_ADDONS_VERSION',  '1.0.4' );
define( 'ENIX_ADDONS_FILE',     __FILE__ );
define( 'ENIX_ADDONS_PATH',     plugin_dir_path( __FILE__ ) );
define( 'ENIX_ADDONS_URL',      plugin_dir_url( __FILE__ ) );
define( 'ENIX_ADDONS_BASENAME', plugin_basename( __FILE__ ) );

// ─── Elementor check ─────────────────────────────────────────────────────────
function enix_check_elementor() {
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'enix_elementor_missing_notice' );
		return false;
	}
	return true;
}

function enix_elementor_missing_notice() {
	$message = sprintf(
		/* translators: 1: Plugin name  2: Elementor */
		esc_html__( '"%1$s" requires "%2$s" to be installed and active.', 'enix-addons' ),
		'<strong>' . esc_html__( 'Enix Addons', 'enix-addons' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor', 'enix-addons' ) . '</strong>'
	);
	printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', $message ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

// ─── Boot ────────────────────────────────────────────────────────────────────
add_action( 'plugins_loaded', 'enix_init' );

function enix_init() {

	if ( ! enix_check_elementor() ) {
		return;
	}

	// Load plugin text domain.
	load_plugin_textdomain(
		'enix-addons',
		false,
		dirname( ENIX_ADDONS_BASENAME ) . '/languages'
	);

	// Register custom Elementor category.
	add_action( 'elementor/elements/categories_registered', 'enix_register_widget_category' );

	// Register widgets.
	add_action( 'elementor/widgets/register', 'enix_register_widgets' );

	// Enqueue frontend assets.
	add_action( 'elementor/frontend/after_enqueue_styles', 'enix_enqueue_frontend_assets' );
}

/**
 * Register "Enix Elements" category in the Elementor panel.
 *
 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
 */
function enix_register_widget_category( $elements_manager ) {
	$elements_manager->add_category(
		'enix-elements',
		array(
			'title' => esc_html__( 'Enix Elements', 'enix-addons' ),
			'icon'  => 'fa fa-plug',
		)
	);
}

/**
 * Load widget files and register them with Elementor.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 */
function enix_register_widgets( $widgets_manager ) {

	// ── Accordion widget ──────────────────────────────────────────────────────
	require_once ENIX_ADDONS_PATH . 'includes/widgets/advanced-accordion.php';
	$widgets_manager->register( new \Enix_Advanced_Accordion() );

	// ── Timeline Steps widget ─────────────────────────────────────────────────
	require_once ENIX_ADDONS_PATH . 'includes/widgets/timeline-steps.php';
	$widgets_manager->register( new \Enix_Timeline_Steps() );
}

/**
 * Enqueue shared frontend CSS & JS.
 */
function enix_enqueue_frontend_assets() {

	// ── Shared widgets stylesheet & script ────────────────────────────────────
	wp_enqueue_style(
		'enix-widgets',
		ENIX_ADDONS_URL . 'assets/css/enix-widgets.css',
		array(),
		ENIX_ADDONS_VERSION
	);

	wp_enqueue_script(
		'enix-widgets',
		ENIX_ADDONS_URL . 'assets/js/enix-widgets.js',
		array( 'jquery' ),
		ENIX_ADDONS_VERSION,
		true
	);

	// ── Timeline Steps stylesheet & script ────────────────────────────────────
	wp_register_style(
		'enix-timeline-steps',
		ENIX_ADDONS_URL . 'assets/css/enix-timeline-steps.css',
		array(),
		ENIX_ADDONS_VERSION
	);

	wp_register_script(
		'enix-timeline-steps',
		ENIX_ADDONS_URL . 'assets/js/enix-timeline-steps.js',
		array(),
		ENIX_ADDONS_VERSION,
		true
	);
}
