<?php
/**
 * Holds all of the public side functions.
 *
 * PHP version 7.3
 *
 * @link       https://crosswindsframework.com/downloads/crosswinds-blocks
 * @since      1.0.0
 *
 * @package    Crosswinds_Blocks
 * @subpackage Crosswinds_Blocks/public
 */

/**
 * Runs the public side.
 *
 * This class defines all code necessary to run on the public side of the plugin.
 *
 * @since      1.0.0
 * @package    Crosswinds_Blocks
 * @subpackage Crosswinds_Blocks/public
 */
class Crosswinds_Blocks_Public {

	/**
	 * Version of the plugin.
	 *
	 * @var string $version Description.
	 * @since 1.0.0
	 */
	private $version;

	/**
	 * Builds the Crosswinds_Blocks_Public object.
	 *
	 * @param string $version Version of the plugin.
	 * @since 1.0.0
	 */
	public function __construct( $version ) {
		$this->version = $version;
	}

	/**
	 * Enqueues the styles for the front end of the website.
	 *
	 * @since 1.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'crosswinds-blocks-font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
	}

	/**
	 * Enqueues the scripts for the front end of the website.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'crosswinds-blocks-accordions', plugin_dir_url( __FILE__ ) . 'js/accordions.min.js', array(), $this->version, true );
		wp_enqueue_script( 'crosswinds-blocks-tabs', plugin_dir_url( __FILE__ ) . 'js/tabs.min.js', array(), $this->version, true );
	}

	/**
	 * Updates the search query for a project if the project_client parameter is in the URL.
	 *
	 * @param object $query      The queried object.
	 * @since 1.0
	 */
	public function project_search_query( $query ) {
		if ( $query->is_main_query() && is_search() && 'project' === $query->get( 'post_type' ) && ( isset( $_GET['project_client'] ) && '' !== $_GET['project_client'] ) ) {
			$client = sanitize_text_field( wp_unslash( $_GET['project_client'] ) );
			$query->set(
				'meta_query',
				array(
					array(
						'key'     => 'project_client',
						'compare' => 'LIKE',
						'value'   => $client,
					),
				)
			);
		}
	}

	public function set_theme_styles( $theme_json ) {
		if ( $this->is_crosswinds_framework_theme_active() ) {
			$settings         = get_option( 'crosswinds', array() );
			$crosswinds_style = json_decode( file_get_contents( get_stylesheet_directory() . '/theme.json' ) );

			if ( isset( $settings['style'] ) ) {

				if ( 'base' === $settings['style'] ) {
					$crosswinds_style = json_decode( file_get_contents( get_stylesheet_directory() . '/theme.json' ) );
				} else {
					$crosswinds_style = json_decode( file_get_contents( get_stylesheet_directory() . '/styles/' . $settings['style'] . '.json' ) );
				}
			}

			$crosswinds_palette = $crosswinds_style->settings->color->palette;

			// Convert values for the filter.
			foreach ( $crosswinds_palette as $key => $value ) {
				$crosswinds_palette[ $key ] = (array) $value;
			}

			$new_data = array(
				'version'  => 2,
				'settings' => array(
					'color' => array(
						'palette' => $crosswinds_palette,
					),
				),
			);

			// Return the modified theme JSON data.
			return $theme_json->update_with( $new_data );
		}

		return $theme_json;
	}

	public function add_favicon() {
		$options = get_option( 'crosswinds' );

		if ( isset( $options['site_icon'] ) && '' !== $options['site_icon'] ) {
			?>
			<link rel="shortcut icon" href="<?php echo esc_url( $options['site_icon'] ); ?>">
			<?php
		}
	}

	/**
	 * Checks to see if the Crosswinds Framework main theme is the active theme or is a parent theme.
	 *
	 * @return boolean      Whether or not the Crosswinds Framework is the active theme or parent theme.
	 * @since 1.2
	 */
	public function is_crosswinds_framework_theme_active() {
		$current_theme_name = '';
		$current_theme      = wp_get_theme();
		if ( $current_theme->exists() && $current_theme->parent() ) {
			$parent_theme = $current_theme->parent();

			if ( $parent_theme->exists() ) {
				$current_theme_name = $parent_theme->get( 'Name' );
			}
		} elseif ( $current_theme->exists() ) {
			$current_theme_name = $current_theme->get( 'Name' );
		}

		if ( 'Crosswinds Framework' === $current_theme_name ) {
			return true;
		} else {
			return false;
		}
	}

	public function allow_form_elements_kses( $html, $context ) {
		if ( 'post' === $context ) {
			$html['label']  = array(
				'for' => true,
			);
			$html['select'] = array(
				'id'   => true,
				'name' => true,
			);
			$html['option'] = array(
				'value'    => true,
				'selected' => true,
			);
			$html['input']  = array(
				'id'          => true,
				'name'        => true,
				'type'        => true,
				'value'       => true,
				'placeholder' => true,
				'title'       => true,
				'class'       => true,
			);
		}
		return $html;
	}

}
