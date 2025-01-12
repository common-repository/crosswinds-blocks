<?php
/**
 * Fired during plugin activation
 *
 * @link       https://crosswindsframework.com/downloads/crosswinds-blocks
 * @since      1.0.0
 *
 * @package    Crosswinds_Blocks
 * @subpackage Crosswinds_Blocks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Crosswinds_Blocks
 * @subpackage Crosswinds_Blocks/includes
 */
class Crosswinds_Blocks_Activator {

	/**
	 * Runs code when the plugin is activated.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		wp_redirect( admin_url( 'admin.php?page=crosswinds-framework-block-options' ) );
	}

}
