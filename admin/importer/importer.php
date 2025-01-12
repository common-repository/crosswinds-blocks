<?php
/**
 * The file to create the custom importer.
 *
 * @since 1.0
 *
 * @version 1.0
 *
 * @package Portafoglio
 */

/*if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	return;
}*/

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require $class_wp_importer;
	}
}

/** Functions missing in older WordPress versions. */
require_once dirname( __FILE__ ) . '/compat.php';

/** WXR_Parser class */
if ( ! class_exists( 'WXR_Parser' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
}

/** WXR_Parser_SimpleXML class */
if ( ! class_exists( 'WXR_Parser_SimpleXML' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
}

/** WXR_Parser_XML class */
if ( ! class_exists( 'WXR_Parser_XML' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
}

/** WXR_Parser_Regex class */
if ( ! class_exists( 'WXR_Parser_Regex' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
}

/** WP_Import class */
require_once dirname( __FILE__ ) . '/class-wp-import.php';
