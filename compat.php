<?php
namespace Bea\Multisite\Theme\Bydefault;

class Compatibility {

	/**
	 * admin_init hook callback
	 *
	 * @since 0.1
	 */
	static function admin_init() {

		// Not on ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		// Check activation
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		// Load the textdomain
		load_plugin_textdomain( 'bea-plugin-boilerplate', false,  BMNDT_DIR . 'languages' );
		trigger_error( sprintf( __( 'Multisite Default Theme requires PHP version %s or greater to be activated.', 'ms-dt' ), BMNDT_MIN_PHP_VERSION ) );

		if ( ! function_exists( 'is_multisite' ) || ! is_multisite() ) {
			trigger_error( sprintf( __( 'Multisite Default Theme MUST be activated on multisite installations only.', 'ms-dt' ) ) );

		}

		// Deactive self
		deactivate_plugins( BMNDT_DIR . 'multisite-default-theme.php' );
		unset( $_GET['activate'] );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notices' ) );
	}

	/**
	 * Alert admins
	 */
	static function admin_notices() {
		echo '<div class="notice error is-dismissible">';
		echo '<p>' . esc_html( sprintf( __( 'Multisite Default Theme require PHP version %s or greater to be activated. Your server is currently running PHP version %s.', 'ms-dt' ), BMNDT_MIN_PHP_VERSION, PHP_VERSION ) ) . '</p>';
		echo '</div>';

		if ( ! function_exists( 'is_multisite' ) || ! is_multisite() ) {
			echo '<div class="notice error is-dismissible">';
			echo '<p>' . esc_html( sprintf( __( 'Multisite Default Theme MUST be activated on multisite installations only.', 'ms-dt' ) ) ) . '</p>';
			echo '</div>';
		}

	}
}