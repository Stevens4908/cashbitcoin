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

namespace Merkulove\SelectionLite\Unity;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * Class adds admin CSS styles.
 *
 * @since 1.0
 *
 **/
final class AdminStyles {

	/**
	 * The one true AdminStyles.
	 *
	 * @var AdminStyles
	 **/
	private static $instance;

	/**
	 * Sets up a new AdminStyles instance.
	 *
	 * @access public
	 **/
	private function __construct() {

		add_action( 'admin_enqueue_scripts', [$this, 'admin_styles'] );

	}

	/**
	 * Add CSS for admin area.
     *
     * @since 1.0
     * @access public
	 *
	 * @return void
	 **/
	public function admin_styles() {

		/** Plugin Settings Page. */
		$this->settings_styles();

	}

	/**
	 * Styles for plugin setting page.
     *
     * @since 1.0
     * @access private
	 *
	 * @return void
	 **/
	private function settings_styles() {

		/** Add styles only on setting page. */
		$screen = get_current_screen();
		if ( null === $screen ) { return; }

		/** Add styles only on plugin settings page */
		if ( in_array( $screen->base, Plugin::get_menu_bases(), true ) ) {

			wp_enqueue_style( 'mdp-selection-lite-ui', Plugin::get_url() . 'src/Merkulove/Unity/assets/css/merkulov-ui.min.css', [], Plugin::get_version() );
			wp_enqueue_style( 'mdp-selection-lite-admin', Plugin::get_url() . 'css/admin' . Plugin::get_suffix() . '.css', [], Plugin::get_version() );

		}

	}

	/**
	 * Main AdminStyles Instance.
	 * Insures that only one instance of AdminStyles exists in memory at any one time.
	 *
	 * @static
     * @since 1.0
     * @access public
     *
	 * @return AdminStyles
	 **/
	public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
