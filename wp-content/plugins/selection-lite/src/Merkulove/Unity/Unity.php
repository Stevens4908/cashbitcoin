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
 * Unity main class
 *
 * @since 1.0
 */
final class Unity {

    /**
     * The one true Unity.
     *
     * @since 1.0
     * @var Unity
     **/
    private static $instance;

    /**
     * Sets up a new plugin instance.
     *
     * @since 1.0
     * @access public
     *
     * @return void
     **/
    private function __construct() {

	    /** Initialize main variables. */
	    Plugin::get_instance();

    }

    /**
     * Do critical compatibility checks and stop work if fails.
     *
     * @param array $checks - List of critical initial checks to run. List of available checks: 'php56'
     *
     * @since  1.0
     * @access public
     *
     * @return bool
     **/
    public function initial_checks( $checks ) {

        /** Do critical initial checks. */
		if ( ! CheckCompatibility::get_instance()->do_initial_checks( $checks, true ) ) { return  false; }

        return true;

    }

    /**
     * Set up the Unity.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     **/
	public function setup() {

        /** Define hooks that runs on both the front-end and the dashboard. */
        $this->both_hooks();

		/** Define admin hooks. */
		$this->admin_hooks();

		/** Extra setup for Elementor plugins. */
        if ( 'elementor' === Plugin::get_type() ) {
            Elementor::get_instance()->setup();
        }

	}

	/**
	 * Define hooks that runs on both the front-end and the dashboard.
	 *
     * @since 1.0
	 * @access private
     *
	 * @return void
	 **/
	private function both_hooks() {

    	/** Load the plugin text domain for translation. */
        PluginHelper::load_textdomain();

    }

	/**
	 * Register all the hooks related to the admin area functionality.
	 *
     * @since 1.0
	 * @access private
     *
	 * @return void
	 **/
	private function admin_hooks() {

		if ( ! is_admin() ) { return; }

		/** Initialize plugin settings. */
		Settings::get_instance();

        /** Add admin CSS */
		AdminStyles::get_instance();

		/** Add admin JS */
		AdminScripts::get_instance();

        /** Initialize PluginHelper. */
		PluginHelper::get_instance();

    }

	/**
	 * Run when the plugin is activated.
	 *
     * @static
     * @since 1.0
     * @access public
     *
     * @return void
	 **/
	public static function on_activation() {

		/** Security checks. */
		if ( ! current_user_can( 'activate_plugins' ) ) { return; }

		/** Do critical initial checks. */
		if ( ! CheckCompatibility::get_instance()->do_initial_checks( ['php56'], false ) ) { return; }

	}

    /**
     * Called when a plugin is deactivated.
     *
     * @static
     * @since 1.0
     * @access public
     *
     * @return void
     **/
    public static function on_deactivation() {}

    /**
     * Main Instance.
     *
     * Insures that only one instance of Unity exists in memory at any one time.
     *
     * @static
     * @since 1.0
     *
     * @return Unity
     **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self();

		}

		return self::$instance;

	}

}