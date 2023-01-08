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
use Merkulove\SelectionLite\Unity\UI;

/**
 * SINGLETON: Caster class contain main plugin logic.
 *
 * @since 1.0
 *
 **/
final class Caster {

	/**
	 * The one true Caster.
	 *
     * @since 1.0
     * @access private
	 * @var Caster
	 **/
	private static $instance;

    /**
     * Array of duplicated activated plugins that used Selection
     * @var array
     */
    private static $duplicates = array();

    /**
     * Set up the plugin.
     *
     * @since 1.0
     * @access public
     *
     * @return void
     **/
    public function setup() {

        /** Define hooks that runs on both the front-end and the dashboard. */
        $this->both_hooks();
        /** Define admin hooks. */
        $this->admin_hooks();

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

	    /** Add Sticky Effect */
	    StickyEffect::get_instance();

        /** Add Elementor Widgets */
        Elementor::get_instance()->register_elementor_widgets();

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

        /** Work only in admin area. */
        if ( ! is_admin() ) { return; }

        /**  Add custom category. */
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

        /** Add meta-box scripts and styles */
        add_action( 'current_screen', [ $this, 'enqueue_edit' ] );

        /** Show message on the plugins page */
        add_action( 'current_screen', [ $this, 'active_merkulove_plugins' ] );

        /** Render notices */
        add_action( 'admin_notices', [ $this, 'render_notice_duplicate' ] );
        add_action( 'admin_footer', [ $this, 'render_snackbar_duplicate' ] );

    }

    /**
     * Find and store activated merkulove plugins for Elementor
     */
    public function active_merkulove_plugins() {

        $screen = get_current_screen();
        if ( null === $screen ) { return; }

        // Run only on the Plugins page and Selection settings
        if ( ! in_array( $screen->id, [ 'plugins', 'toplevel_page_mdp_selection_lite_settings' ] ) ) { return; }

        // Get active plugins
        $active_plugin = get_option('active_plugins');
        if ( ! is_array( $active_plugin ) ) { return; }

        // Get selection plugins
        $selection_plugins = get_option( 'mdp_selection_lite_widgets_settings' );
        if ( ! is_array( $selection_plugins ) ) { return; }

        foreach ( $active_plugin as $plugin_path ) {

            $plugin_slug = explode( '/', $plugin_path )[ 0 ];

            // Find plugins contains -elementor in the file name
            if ( strpos( $plugin_slug, '-elementor' ) ) {

                $selection_slug = str_replace( '-elementor', '', $plugin_slug );

                if ( isset( $selection_plugins[ $selection_slug ] ) && $selection_plugins[ $selection_slug ] === 'on' ) {

                    array_push( self::$duplicates, ucfirst( $selection_slug ) );

                }

            }

        }

    }

    /**
     * Render message about duplicated elementor widgets as single plugin by merkulove
     */
    public function render_notice_duplicate() {

        if ( empty( self::$duplicates ) ) { return; }

        $duplicates = preg_filter('/$/', ' for Elementor', self::$duplicates );
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong>Selection</strong><?php esc_html_e( ' already uses the functionality of these plugins: ', 'selection-lite' ); ?>
                <strong><?php echo implode( ', ', $duplicates ); ?></strong>.
                <?php esc_html_e( ' You can safely deactivate these plugins.', 'selection-lite' ); ?>
            </p>
        </div>
        <?php

    }

    /**
     * Render snackbar about duplicated elementor widgets as single plugin by merkulove
     */
    public function render_snackbar_duplicate() {

        if ( empty( self::$duplicates ) ) { return; }

        $duplicates = preg_filter('/$/', ' for Elementor', self::$duplicates );
        UI::get_instance()->render_snackbar(
            esc_html__( 'Selection already uses the functionality of these plugins: ', 'selection-lite' ) . implode( ', ', $duplicates ),
            'warning',
            -1,
            true,
            [
                [
                    'caption' => esc_html__( 'Plugins', 'selection-lite' ),
                    'link' => admin_url( 'plugins.php' )
                ]
            ]
        );

    }

    /**
     * Add custom category.
     *
     * @param $elements_manager
     * @since 1.0
     * @return void
     */
    public function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'selection-category',
            [
                'title' => esc_html__( 'Selection Lite', 'selection-lite' ),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    /**
     * Scripts and Styles for the Template edit page
     *
     * @since   1.0
     * @return void
     **/
    public function enqueue_edit() {

        $screen = get_current_screen();

        // Run only on Elementor Templates
        if ( null === $screen ) { return; }
        if ( 'elementor_library' !== $screen->id ) { return; }

        // Add class .mdc-disable to body. So we can use UI without overrides WP CSS, only for this page
        add_action( 'admin_body_class', [$this, 'add_admin_class'] );

        // Enqueue styles
        wp_enqueue_style( 'merkulov-ui', Plugin::get_url() . 'src/Merkulove/Unity/assets/css/merkulov-ui' . Plugin::get_suffix() . '.css', [], Plugin::get_version() );
        wp_enqueue_style( 'mdp-selection-edit', Plugin::get_url() . 'css/admin-edit' . Plugin::get_suffix() . '.css', [], Plugin::get_version() );

        // Enqueue scripts
        wp_enqueue_script( 'merkulov-ui', Plugin::get_url() . 'src/Merkulove/Unity/assets/js/merkulov-ui' . Plugin::get_suffix() . '.js', [], Plugin::get_version(), true );
        wp_enqueue_script( 'mdp-selection-edit', Plugin::get_url() . 'js/assignments' . Plugin::get_suffix() . '.js', ['jquery'], Plugin::get_version(), true );

        /** Add code editor for Custom PHP. */
        wp_enqueue_code_editor( array( 'type' => 'application/x-httpd-php' ) );

    }

	/**
	 * Generates data for breadcrumbs.
	 *
	 * @return array
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_data_breadcrumbs() {
		$breadcrumbs = [];

		// check if woocommerce plugin is active
		$woocommerce_active = false;
		if (  in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$woocommerce_active = true;
		}

		$page_num = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( is_front_page() ) {
			if ( $page_num > 1 ) {
				$breadcrumbs[ 'homepage' ] = [ 'name' => get_bloginfo( 'name' ), 'is_homepage' => true, 'is_parent' => false, 'is_child' => false, 'link' => site_url(), 'is_active' => true, 'element' => '',  ];

			}
		} else {
			if ( $woocommerce_active ) {
				if ( !is_woocommerce() ) {
					$breadcrumbs[ 'homepage' ] = [ 'name' => get_bloginfo( 'name' ), 'is_homepage' => true, 'is_parent' => false, 'is_child' => false, 'link' => site_url(), 'is_active' => false, 'element' => '' ];
				}
			} else {
				$breadcrumbs[ 'homepage' ] = [ 'name' => get_bloginfo( 'name' ), 'is_homepage' => true, 'is_parent' => false, 'is_child' => false, 'link' => site_url(), 'is_active' => false, 'element' => '' ];
			}
			if ( get_post_type() === 'post'  ) {
				$post_categories = get_the_category();
				if ( !empty( $post_categories[0]->cat_ID ) ) {
					$elements = array_filter( explode( ',', get_category_parents( $post_categories[0]->cat_ID, true, ',' ) ) );
					for ( $i = 0; $i < count( $elements ); $i++ ) {
						$breadcrumbs[ 'element_'.$i ] = [ 'name' => '', 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => '', 'is_active' => false, 'element' => $elements[$i] ];
					}
				}
				$breadcrumbs[ 'post' ] = [ 'name' => get_the_title(), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => '', 'is_active' => true, 'element' => '' ];

			} elseif ( get_post_type() === 'page' ) {

				// if page has parent pages
				global $post;
				if ( $post->post_parent ) {
					$parent_id = $post->post_parent;
					while ( $parent_id ) {
						$page = get_post( $parent_id );
						$breadcrumbs[ 'parent_page' ] = [ 'name' => get_the_title( $page->ID ), 'is_homepage' => false, 'is_child' => false, 'link' => get_permalink( $page->ID ), 'is_parent' => true, 'is_active' => false, 'element' => '' ];
						$parent_id = $page->post_parent;
					}
				}

				$breadcrumbs[ 'page' ] = [ 'name' => get_the_title(), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];

				// if page has child pages
				$children = get_children( [ 'post_type' => 'page', 'post_parent' => get_the_ID() ] );
				if ( $children ) {
					foreach ( $children as $child ) {
						$breadcrumbs[ 'child_page' ] = [ 'name' => $child->post_title, 'is_homepage' => false, 'is_parent' => false, 'link' => $child->guid, 'is_active' => false, 'element' => '', 'is_child' => true ];
					}
				}

			} elseif ( is_category() ) {
				$breadcrumbs[ 'category' ] = [ 'name' => single_cat_title( '', 0 ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( is_tag() ) {
				$breadcrumbs[ 'tag' ] = [ 'name' => single_tag_title( '', 0 ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( is_day() ) {
				$breadcrumbs[ 'year_archive' ] = [ 'name' => get_the_time( 'Y' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => get_year_link( get_the_time( 'Y' ) ), 'is_active' => false, 'element' => '' ];
				$breadcrumbs[ 'month_archive' ] = [ 'name' => get_the_time( 'F' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), 'is_active' => false, 'element' => '' ];
				$breadcrumbs[ 'day_archive' ] = [ 'name' => get_the_time( 'd' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( is_month() ) {
				$breadcrumbs[ 'year_archive' ] = [ 'name' => get_the_time( 'Y' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => get_year_link( get_the_time( 'Y' ) ), 'is_active' => false, 'element' => '' ];
				$breadcrumbs[ 'month_archive' ] = [ 'name' => get_the_time( 'F' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( get_post_type() === 'elementor_library' ) {
				$breadcrumbs[ 'elementor_library' ] = [ 'name' => get_the_title(), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'link' => '', 'is_active' => true, 'element' => '' ];
			} elseif ( is_year() ) {
				$breadcrumbs[ 'year_archive' ] = [ 'name' => get_the_time( 'Y' ), 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				$breadcrumbs[ 'author_archive' ] = [ 'name' => $userdata->display_name, 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( is_404() ) {
				$breadcrumbs[ 'Error 404' ] = [ 'name' => 'Error 404', 'is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => true, 'link' => '', 'element' => '' ];
			} elseif ( $woocommerce_active ) {
				if ( is_woocommerce() ) {
					$breadcrumbs['woocommerce'] = ['is_homepage' => false, 'is_parent' => false, 'is_child' => false, 'is_active' => false, 'link' => '', 'element' => ''];
				}
			}
		}

		return $breadcrumbs;
	}

    /**
     * Add class to body in admin area.
     *
     * @param string $classes - Space-separated list of CSS classes.
     *
     * @since 1.0
     * @return string
     */
    public function add_admin_class( $classes ) {

        return $classes . ' mdc-disable ';

    }

	/**
	 * Main Caster Instance.
	 * Insures that only one instance of Caster exists in memory at any one time.
	 *
	 * @static
     * @since 1.0
     * @access public
     *
	 * @return Caster
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
