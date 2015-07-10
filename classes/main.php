<?php
namespace Bea\Multisite\Theme\Bydefault;

class Main {

	public function __construct() {

		/**
		 * do_action( 'wpmu_new_blog', $blog_id, $user_id, $domain, $path, $site_id, $meta );
		 * FRONT
		 */
		add_action( 'wpmu_new_blog', array( __CLASS__, 'switch_theme' ), 10, 6 );
		add_action( 'init', array( __CLASS__, 'init' ) );
	}

	/**
	 * Load the plugin translation
	 */
	public static function init() {
		// Load translations
		load_plugin_textdomain( 'ms-dt', false, BMNDT_DIR . 'languages' );
	}

	/**
	 * Change theme according to network option default theme
	 * @param $blog_id
	 * @param $user_id
	 * @param $domain
	 * @param $path
	 * @param $site_id
	 * @param $meta
	 * @author Julien Maury
	 */
	static function switch_theme( $blog_id, $user_id, $domain, $path, $site_id, $meta ){
		$default = get_site_option( 'default_network_theme' );

		if ( empty( $default ) ) {
			return;
		}
		switch_to_blog( $blog_id );
			switch_theme( $default );
		restore_current_blog();
	}

}