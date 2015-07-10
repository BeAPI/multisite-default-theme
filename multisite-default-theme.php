<?php
/*
 Plugin Name: Multisite Default Theme
 Version: 0.1
 Plugin URI: https://github.com/beapi/multi-network-default-theme
 Description: Allows to choose a default theme for your multisite installation
 Author: Beapi
 Author URI: http://www.beapi.fr
 Domain Path: languages
 Text Domain: ms-dt
----
Copyright 2015 Beapi Technical team (human@beapi.fr)
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.
                            This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
                                     You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
                                                                       */
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

define( 'BMNDT_VERSION', '0.1' );
define( 'BMNDT_DIR', plugin_dir_path( __FILE__ ) );
define( 'BMNDT_MIN_PHP_VERSION', '5.3' );

// Check PHP min version
if ( version_compare( PHP_VERSION, BMNDT_MIN_PHP_VERSION, '<' ) || ! function_exists( 'is_multisite' ) || ! is_multisite() ) {
	require_once( BMNDT_DIR . 'compat.php' );
	// possibly display a notice, trigger error
	add_action( 'admin_init', array( 'Bea\Multisite\Theme\Bydefault\Compatibility', 'admin_init' ) );

	// stop execution of this file
	return;
}

/**
 * Autoload resources
 */
require_once( BMNDT_DIR . 'autoload.php' );

/**
 * Early init
 */
function _bea_ms_dt_init() {

	if ( is_admin() ) {
		new Bea\Multisite\Theme\Bydefault\Admin\Main();
	}

	new Bea\Multisite\Theme\Bydefault\Main();

}

add_action( 'plugins_loaded', '_bea_ms_dt_init' );