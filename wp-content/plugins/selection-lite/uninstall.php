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

namespace Merkulove;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/** Include plugin autoloader for additional classes. */
require __DIR__ . '/src/autoload.php';

use Merkulove\SelectionLite\Unity\Plugin;

/**
 * SINGLETON: Class used to implement plugin uninstallation.
 *
 * @since  1.0
 *
 **/
final class Uninstall {

    /**
     * The one true Uninstallation.
     *
     * @since 1.0
     * @var Uninstall
     **/
    private static $instance;

    /**
     * Sets up a new Uninstallation instance.
     *
     * @since  1.0
     * @access public
     **/
    private function __construct() {

        /** Get Uninstall mode. */
        $uninstall_mode = $this->get_uninstall_mode();

        /** Remove Plugin and Settings. */
        if ( 'plugin+settings' === $uninstall_mode ) {

            /** Remove Plugin Settings. */
            $this->remove_settings();

        }

    }

    /**
     * Delete Plugin Options.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function remove_settings() {

        /** Prepare array with options to remove. */
        $settings = [];

        foreach ( wp_load_alloptions() as $option => $value ) {
            if ( strpos( $option, 'mdp_selection_lite' ) === 0 ) {
                $settings[] = $option;
            }
        }

        /** Remove options for Multisite. */
        if ( is_multisite() ) {

            foreach ( $settings as $key ) {

                if ( ! get_site_option( $key ) ) { continue; }

                delete_site_option( $key );

            }

        /** Remove options for Singular site. */
        } else {

            foreach ( $settings as $key ) {

                if ( ! get_option( $key ) ) { continue; }

                delete_option( $key );

            }

        }

    }

    /**
     * Delete Plugin data.
     * Remove all tables started with plugin slug and folder from Uploads.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function remove_data() {

        /** Remove all tables started with plugin slug. */
        $this->remove_tables();

    }

    /**
     * Remove all tables started with plugin slug.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function remove_tables() {

        global $wpdb;

        $tables = $wpdb->tables( 'all' );

        foreach ( $tables as $table ) {

            /** Convert plugin slug to table name. */
            $table_slug = str_replace( '-', '_', Plugin::get_slug() );

            /** If table name starts with prefix_plugin_slug */
            if ( strpos( $table, $wpdb->prefix . $table_slug ) === 0 ) {

                /** Remove this table. */
                /** @noinspection SqlNoDataSourceInspection */
                $wpdb->query( "DROP TABLE IF EXISTS {$table}" );

            }

        }

    }

    /**
     * Return uninstall mode.
     * plugin - Will remove the plugin only. Settings and Audio files will be saved. Used when updating the plugin.
     * plugin+settings - Will remove the plugin and settings. Audio files will be saved. As a result, all settings will be set to default values. Like after the first installation.
     *
     * @since  1.0
     * @access public
     *
     * @return string
     **/
    public function get_uninstall_mode() {

        $uninstall_settings = get_option( 'mdp_selection_lite_uninstall_settings' );

        if ( isset( $uninstall_settings[ 'mdp_selection_lite_uninstall_settings' ] ) && $uninstall_settings[ 'mdp_selection_lite_uninstall_settings' ] ) { // Default value.
            $uninstall_settings = [
                'delete_plugin' => 'plugin'
            ];
        }

        return $uninstall_settings[ 'delete_plugin' ];

    }

    /**
     * Main Uninstallation Instance.
     *
     * Insures that only one instance of Uninstall exists in memory at any one time.
     *
     * @static
     * @since 1.0
     *
     * @return Uninstall
     **/
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

            self::$instance = new self;

        }

        return self::$instance;

    }

}

/** Call Unity Uninstall. */
Uninstall::get_instance();
