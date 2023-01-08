<?php
/**
 * Selection Lite
 * Carefully selected Elementor addons bundle, for building the most awesome websites
 *
 * @encoding        UTF-8
 * @version         1.7
 * @copyright       (C) 2018 - 2021 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         GPLv3
 * @contributors    merkulove, vladcherviakov, phoenixmkua, podolianochka, viktorialev01
 * @support         help@merkulov.design
 **/

namespace Merkulove\SelectionLite;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

use Merkulove\SelectionLite\Unity\Plugin;
use Merkulove\SelectionLite\Unity\Settings;
use Merkulove\SelectionLite\Unity\TabGeneral;

/**
 * SINGLETON: Settings class used to modify default plugin settings.
 *
 * @since 1.0
 *
 **/
final class Config {

	/**
	 * The one true Settings.
	 *
     * @since 1.0
     * @access private
	 * @var Config
	 **/
	private static $instance;

    /**
     * Prepare plugin settings by modifying the default one.
     *
     * @since 1.0
     * @access public
     *
     * @return void
     **/
    public function prepare_settings() {

        $tabs = Plugin::get_tabs(); // Get default plugin settings.
        $tabs = $this->set_requirements_checks( $tabs ); // Set System Requirements checks

        // Remove 'Delete plugin, settings and data' option from Uninstall tab.
        unset( $tabs['uninstall']['fields']['delete_plugin']['options']['plugin+settings+data'] );

        unset( $tabs['general'] ); // Special config for Elementor plugins

        // Widgets tab
        $offset = 0;
        $tabs = array_slice( $tabs, 0, $offset, true ) +
            [ 'widgets' => [
                'enabled'       => true,
                'class'         => TabWidgets::class, // Handler
                'label'         => esc_html__( 'Widgets', 'selection-lite' ),
                'title'         => esc_html__( 'The Selection widgets', 'selection-lite' ),
                'show_title'    => true,
                'icon'          => 'widgets', // Icon for tab
                'fields'        => []
            ],
            ] +

            array_slice( $tabs, $offset, NULL, true );

        // Additional setting for the widgets tab
        $tabs[ 'widgets' ][ 'fields' ][ 'widgets_grid' ] = [
            'type'              => 'custom_type',
            'render'            => [ TabWidgets::get_instance(), 'widgets_additional' ],
            'label'             => '', 'show_label'        => false,
            'description'       => '', 'show_description'  => false,
            'default'           => '',
        ];


        /** Set updated tabs. */
        Plugin::set_tabs( $tabs );

        /** Refresh settings. */
        Settings::get_instance()->get_options();

    }

    /**
     * Set System Requirements checks.
     *
     * @param array $tabs - All plugin tabs with fields and settings.
     *
     * @access public
     *
     * @return array
     **/
    private function set_requirements_checks( $tabs ) {

        /** Set System Requirements. */
        $tabs['status']['reports']['server']['elementor_installed'] = true;
        $tabs['status']['reports']['server']['allow_url_fopen'] = false;
        $tabs['status']['reports']['server']['dom_installed'] = false;
        $tabs['status']['reports']['server']['xml_installed'] = false;
        $tabs['status']['reports']['server']['bcmath_installed'] = false;

        return $tabs;

    }

	/**
	 * Main Settings Instance.
	 * Insures that only one instance of Settings exists in memory at any one time.
	 *
	 * @static
     * @since 1.0
     * @access public
     *
	 * @return Config
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
