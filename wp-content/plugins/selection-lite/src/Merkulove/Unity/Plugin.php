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
 * Plugin class used to prepare plugin variables.
 * It can be called in any time and work without any dependencies.
 *
 * @since 1.0
 *
 **/
final class Plugin {

    /**
	 * Plugin version.
	 *
     * @since 1.0
     * @access private
	 * @var string
	 **/
	private static $version;

	/**
	 * Plugin name.
	 *
     * @since 1.0
     * @access private
	 * @var string
	 **/
	private static $name;

	/**
	 * Using minified css and js files if SCRIPT_DEBUG is turned off.
     *
     * @since 1.0
     * @access private
     * @var string
	 **/
	private static $suffix;

	/**
	 * URL to plugin folder, with trailing slash.
	 *
     * @since 1.0
     * @access private
     * @var string
	 **/
    private static $url;

	/**
	 * Full PATH to plugin folder, with trailing slash.
	 *
     * @since 1.0
     * @access private
     * @var string
	 **/
	private static $path;

	/**
	 * Plugin base name.
	 *
     * @since 1.0
     * @access private
     * @var string
	 **/
	private static $basename;

	/**
	 * Plugin admin menu bases.
	 *
     * @since 1.0
     * @access private
     * @var array
	 **/
	private static $menu_bases = [];

	/**
	 * Full path to main plugin file.
	 *
     * @since 1.0
     * @access private
	 * @var string
	 **/
    private static $plugin_file;

	/**
	 * Plugin slug.
	 *
     * @since 1.0
     * @access private
	 * @var string
	 **/
    private static $slug;

    /**
     * Plugin type.
     *
     * @since 1.0
     * @access private
     * @var string
     **/
    private static $type;

    /**
     * Settings Tabs.
     *
     * Holds the list of all tabs and fields with settings.
     *
     * @since 1.0
     * @access private
     * @var array
     **/
    private static $tabs;

    /**
     * The one true Plugin.
     *
     * @since  1.0
     * @access private
     * @var Plugin
     **/
    private static $instance;

    /**
     * Sets up a new Plugin instance.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function __construct() {

        /** Initialize main variables. */
	    $this->initialization();

    }

    /**
     * Initialize main variables.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function initialization() {

        /** Full path to main plugin file. */
        self::$plugin_file = dirname( dirname( dirname( __DIR__ ) ) ) . '/selection-lite.php';

		/** Set Plugin version. */
        self::$version = self::get_plugin_data( 'Version' );

        /** Set Plugin name. */
		self::$name = self::get_plugin_data( 'Name' );

		/** Plugin slug. */
		self::$slug = self::get_plugin_data( 'TextDomain' );

        /** Plugin type. */
        self::$type = self::extract_plugin_type();

		/** Gets the plugin URL (with trailing slash). */
		self::$url = plugin_dir_url( self::$plugin_file );

		/** Gets the plugin PATH. */
		self::$path = plugin_dir_path( self::$plugin_file );

		/** Using minified css and js files if SCRIPT_DEBUG is turned off. */
		self::$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		/** Set plugin basename. */
		self::$basename = plugin_basename( self::$plugin_file  );

		/** Plugin settings page menu base. There may be several. */
        /** For Elementor plugins. */
        if ( 'elementor' === self::$type ) {

            self::$menu_bases[] = 'elementor_page_mdp_selection_lite_settings';
            self::$menu_bases[] = 'settings_page_mdp_selection_lite_settings';

        /** For general WordPress plugins. */
        } else {

            self::$menu_bases[] = 'toplevel_page_mdp_selection_lite_settings';
            self::$menu_bases[] = 'selection_lite_page_mdp_selection_lite_settings';

        }

		/** Fill $tabs field with default settings. */
		$this->default_settings();
		
    }

    /**
     * Fill $tabs field with default settings.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function default_settings() {

        /** Add Status Tab. */
        $this->add_status_tab();

        /** Add Uninstall Tab. */
        $this->add_uninstall_tab();

		/** Add PRO Tab */
		$this->add_pro_tab();

    }


    /**
     * Add Status Tab to settings page.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function add_status_tab() {

        self::$tabs['status'] = [
            'enabled'       => true,
            'class'         => TabStatus::class,
            'label'         => esc_html__( 'Status', 'selection-lite' ),
            'title'         => esc_html__( 'System Status', 'selection-lite' ),
            'show_title'    => true,
            'icon'          => 'info',
            'reports'       => [
                'server'    => [
                    'enabled'               => true,
                    'os'                    => true,
                    'software'              => true,
                    'mysql_version'         => true,
                    'php_version'           => true,
                    'write_permissions'     => true,
                    'zip_installed'         => true,
                    'elementor_installed'   => true,
                ],
                'wordpress' => [
                    'enabled' => true
                ],
                'plugins'   => [
                    'enabled' => true
                ],
                'theme'     => [
                    'enabled' => true
                ],
            ]
        ];

    }

	/**
	 * Add GO PRO Tab
	 */
	private function add_pro_tab() {

		self::$tabs['pro'] = [
			'enabled'       => true,
			'class'         => TabPro::class,
			'label'         => esc_html__( 'Get PRO', 'selection-lite' ),
			'show_title'    => false,
			'icon'          => 'info',
		];

	}

    /**
     * Add Uninstall Tab to settings page.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function add_uninstall_tab() {

        self::$tabs['uninstall'] = [
            'enabled'       => true,
            'class'         => TabUninstall::class,
            'label'         => esc_html__( 'Uninstall', 'selection-lite' ),
            'title'         => esc_html__( 'Uninstall Settings', 'selection-lite' ),
            'show_title'    => true,
            'icon'          => 'delete_sweep',
            'fields'        => [
                'delete_plugin' => [
                    'type'              => 'select',
                    'options'           => [
                        'plugin'                => esc_html__( 'Delete plugin only', 'selection-lite' ),
                        'plugin+settings'       => esc_html__( 'Delete plugin and settings', 'selection-lite' ),
                    ],
                    'default'           => 'plugin',
                ]
            ]
        ];

    }

    /**
     * Return current plugin metadata.
     *
     * @param string $field - Field name from plugin data.
     *
     * @since 1.0
     * @access private
     *
     * @return string|array {
     *     Plugin data. Values will be empty if not supplied by the plugin.
     *
     *     @type string $Name        Name of the plugin. Should be unique.
     *     @type string $Title       Title of the plugin and link to the plugin's site (if set).
     *     @type string $Description Carefully selected Elementor addons bundle, for building the most awesome websites.
     *     @type string $Author      Author's name.
     *     @type string $AuthorURI   Author's website address (if set).
     *     @type string $Version     Plugin version.
     *     @type string $TextDomain  Plugin textdomain.
     *     @type string $DomainPath  Plugins relative directory path to .mo files.
     *     @type bool   $Network     Whether the plugin can only be activated network-wide.
     *     @type string $RequiresWP  Minimum required version of WordPress.
     *     @type string $RequiresPHP Minimum required version of PHP.
     * }
     **/
    private static function get_plugin_data( $field ) {

        static $plugin_data;

        /** We already have $plugin_data. */
        if ( $plugin_data !== null ) {
            return $plugin_data[$field];
        }

        /** This is first time call of method, so prepare $plugin_data. */
        if ( ! function_exists('get_plugin_data') ) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }

        $plugin_data = get_plugin_data( self::get_plugin_file() );

        return $plugin_data[$field];

    }

    /**
     * Get Plugin version.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_version() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$version;

    }

    /**
     * Get Plugin Name.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_name() {

        return self::get_plugin_data( 'Name' );

    }

    /**
     * Get .min suffix.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_suffix() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$suffix;

    }

    /**
     * Get URL to plugin folder with trailing slash.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_url() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$url;

    }

    /**
     * Get full Path to plugin folder with trailing slash.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_path() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$path;

    }

    /**
     * Get Plugin Basename.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_basename() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$basename;

    }

    /**
     * Get plugin menu bases.
     *
     * @since 1.0
     * @access public
     *
     * @return array
     **/
    public static function get_menu_bases() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$menu_bases;

    }

    /**
     * Get path to plugin file.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_plugin_file() {

        return dirname( dirname( dirname( __DIR__ ) ) ) . '/selection-lite.php';

    }

    /**
     * Get Plugin slug.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_slug() {

        return self::get_plugin_data( 'TextDomain' );

    }

    /**
     * Get Plugin type.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public static function get_type() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$type;

    }

    /**
     * Set Plugin type.
     *
     * @param string $type - Allow change plugin type.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     **/
    public static function set_type( $type ) {

        if ( empty( $type ) ) { return; }

        self::$type = $type;

    }

    /**
     * Extract plugin type from slug.
     *
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    private static function extract_plugin_type() {

        $slug = self::get_plugin_data( 'TextDomain' );
        $type = 'wordpress';

        if ( strpos( $slug, 'elementor' ) !== false ) {
            $type = 'elementor';
        }

        if ( strpos( $slug, 'wpbakery' ) !== false ) {
            $type = 'wpbakery';
        }

        return $type;

    }

    /**
     * Get Plugin tabs.
     *
     * @since 1.0
     * @access public
     *
     * @return array
     **/
    public static function get_tabs() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) { self::get_instance(); }

        return self::$tabs;

    }

    /**
     * Set Plugin tabs.
     *
     * @param array $tabs - Tabs and fields with settings.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     **/
    public static function set_tabs( $tabs ) {

        self::$tabs = $tabs;

    }

    /**
     * Get instance of Plugin.
     *
     * Insures that only one instance of Plugin exists in memory at any one time.
     *
     * @static
     * @since 1.0
     *
     * @return Plugin
     **/
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

            self::$instance = new self;

        }

        return self::$instance;

    }

}
