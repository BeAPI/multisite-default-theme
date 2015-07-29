<?php
namespace Bea\Multisite\Theme\Bydefault\Admin;

class Main {

	public function __construct() {

		/**
		 * ADMIN
		 */
		if ( is_admin() ) {
			add_action( 'wpmu_options', array( __CLASS__, 'network_admin_option' ) );
			add_action( 'load-settings.php', array( __CLASS__, 'network_save_theme_option' ) );
		}

	}


	/**
	 * Save default theme for network
	 *
	 * @author Julien Maury
	 */
	static function network_save_theme_option() {

		/**
		 * is there an action ?
		 */
		if ( ! isset( $_POST['default_network_theme'] ) ) {
			return false;
		}

		/**
		 * check admin referer
		 */
		check_admin_referer( 'siteoptions' );
		
		if ( $_POST['default_network_theme'] ) {
			return update_site_option( 'default_network_theme', apply_filters( 'default_network_theme_pre_update_option', sanitize_option( 'default_network_theme', $_POST['default_network_theme'] ) ) );
		}

		return true;

	}


	/**
	 * Add option to the network settings
	 *
	 * @author Julien Maury
	 * @return bool
	 */
	static function network_admin_option() {

		if ( ! current_user_can( 'manage_network' ) ) {
			return false;
		}
		$themes        = wp_get_themes( array( 'allowed' => true ) );
		$default_theme = get_site_option( 'default_network_theme' );

		if ( empty( $themes ) || ! is_array( $themes ) ) {
			return false;
		}
		?>

		<h3><?php _e( 'Theme settings', 'ms-dt' ); ?></h3>
		<table id="menu" class="form-table">
			<tbody>
			<tr>
				<th scope="row"><?php _e( 'Theme by default', 'ms-dt' ); ?></th>
				<td>
					<select name="default_network_theme" id="default-network-theme">
						<?php foreach ( $themes as $theme ) : ?>
							<option value="<?php esc_attr_e( $theme->template ); ?>" <?php selected( esc_attr( $theme->template ), $default_theme ); ?>><?php esc_html_e( $theme->name ); ?></option> ;
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			</tbody>
		</table>
		<a href="<?php echo esc_url( network_admin_url( 'themes.php' ) ); ?>"><?php _e( 'See themes available', 'ms-dt' ); ?></a>
		<?php

	}

}
