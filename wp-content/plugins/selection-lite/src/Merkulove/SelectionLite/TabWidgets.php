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

use Merkulove\SelectionLite\Unity\Tab;
use Merkulove\SelectionLite\Unity\Plugin;
use Merkulove\SelectionLite\Unity\Settings;
use Merkulove\SelectionLite\Unity\UI;

/** Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}

/**
 * SINGLETON: Class used to implement any tab with settings.
 *
 * @since 1.0
 **/
final class TabWidgets extends Tab {

	/**
	 * The one true TabWidgets.
	 *
     * @since 1.0
     * @access private
	 * @var TabWidgets
	 **/
	private static $instance;

	/**
     * Selection settings
	 * @var array
	 */
	private static $options = array();

	/**
	 * @var array
	 */
	private static $widgets = array();

	/**
	 * @var array
	 */
	private static $widgets_name = array();

	/**
	 * @var string[]
	 */
	private static $upcoming = array();

	/**
	 * @var array[]
	 */
	private static $widget_categories = [

		'basic' => [
			'headinger',
			'motionger',
			'highlighter',
			'buttoner',
			'glider',
			'sliper',
			'timeliner',
			'countdowner',
			'liner',
			'imager',
			'line-bar',
			'circle-bar',
			'semicircle-bar'
		],
		'content' => [
			'lottier',
			'taber',
			'masker',
			'videor',
			'modalier',
			'pricer',
			'reviewer',
			'questionar',
			'worker',
			'testimoner',
			'logger',
			'coder',
		],
		'blog' => [
			'avatar',
			'crawler'
		],
		'charts' => [
			'dots',
			'gauge',
			'holes',
			'multiline-bar',
			'bar',
			'bipolar-line',
			'line',
			'donut',
			'pie',
			'stacked-bar',
			'bipolar-bar',
			'area',
		],
		'navigation' => [
			'menuar',
			'huger',
			'floater',
			'uper',
			'logar',
			'crumber'
		],
		'integrations' => [
			'gmaper',
			'walker',
			'synopter'
		],
		'woocommerce' => [
			'couponer',
			'product-add-to-cart',
			'custom-add-to-cart'
		]

	];

	/**
	 * @var \string[][]
	 */
	private static $pro_widgets = [

		'sliper' => 'Slider',
		'motionger' => 'Animated Heading',
		'glider' => 'Carousel',
		'highlighter' => 'Text Highlight',
		'timeliner' => 'Timeliner',
		'imager' => 'Image box',
		'countdowner' => 'Countdown',
		'liner' => 'Animated Icon',
		'questionar' => 'FAQs',
		'masker' => 'Mask',
		'coder' => 'Code',
		'pricer' => 'Price Table',
		'taber' => 'Tabs',
		'videor' => 'Video',
		'lottier' => 'Animated Images',
		'worker' => 'Business Hours',
		'logger' => 'Changelog',
		'testimoner' => 'Testimonials',
		'reviewer' => 'Reviews',
		'avatar' => 'Author box',
		'dots'=> 'Dots Chart',
		'gauge'=> 'Gauge Chart',
		'holes'=> 'Holes Chart',
		'multiline-bar'=> 'Multiline Bar Chart',
		'bar'=> 'Bar Chart',
		'bipolar-line' => 'Bipolar Line Chart',
		'line' => 'Line Chart',
		'donut' => 'Donut Chart',
		'pie' => 'Pie Chart',
		'stacked-bar' => 'Stacked Bar Chart',
		'bipolar-bar' => 'Bipolar Bar Chart',
		'area' => 'Area Chart',
		'menuar'=> 'Menu',
		'huger'=> 'Mega Menu',
		'floater'=> 'Float navigation',
		'gmaper' => 'Google Maps',
		'walker' => 'Open Weather',
		'synopter' => 'Google Street View',
		'couponer' => 'Discount Coupons',
        'line-bar' => 'Progress Bar',
        'circle-bar' => 'Circle Progress Bar',
        'semicircle-bar' => 'Semicircle Progress Bar',
        'modalier' => 'Modal Popup',
        'crumber' => 'Breadcrumbs',
        'product-add-to-cart' => 'Add to Cart',
        'custom-add-to-cart' => 'Custom Add to Cart'

    ];

    /**
     * Render form with all settings fields.
     *
     * @since 1.0
     * @access public
     *
     * @param string $tab_slug - Slug of current tab.
     *
     * @return void
     **/
    public function do_settings( $tab_slug ) {

        /** No status tab, nothing to do. */
        if ( ! $this->is_enabled( $tab_slug ) ) { return; }

        /** @var array options */
	    self::$options = Settings::get_instance()->options;

        /** Render title. */
        $this->render_title( $tab_slug );

        /** Render grid of the Selection widget */
        $this->render_widgets_grid();

        /** Render fields. */
        $this->do_settings_base( $tab_slug );

    }

    /**
     * Generate Tab.
     *
     * @since 1.0
     * @access public
     *
     * @param string $tab_slug - Slug of current tab.
     *
     * @return void
     **/
	public function add_settings( $tab_slug ) {

        /** Custom General Tab. */
        $this->add_settings_base( $tab_slug );

        $group = 'Selection' . $tab_slug . 'OptionsGroup';
        $section = 'mdp_selection_lite_' . $tab_slug . '_page_status_section';

        /** Exit if no fields to process. */
        if ( empty( Plugin::get_tabs()[$tab_slug]['fields'] ) ) { return; }

        $fields = Plugin::get_tabs()[$tab_slug]['fields'];

        /** Create settings for each field. */
        foreach ( $fields as $key => $field ) {

            /** Prepare field label. */
            $label = $field['show_label'] ? $field['label'] : '';

            /** Hide label for header fields. */
            if ( 'header' === $field['type'] ) { $label = ''; }

            /** Create field. */
            add_settings_field( $key, $label, [ $this, 'create_field' ], $group, $section, [ 'key' => $key, 'type' => $field[ 'type' ], 'tab_slug' => $tab_slug ] );

        }

	}

    /**
     * Render Settings field.
     *
     * @param array $args - Array of params for render: field key and type.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     **/
	public function create_field( $args = [] ) {

        /** Do we have custom handler for this field type? */
        $handler = $this->get_field_handler( $args );
        if ( is_array( $handler ) && is_callable( $handler ) ) {

            /** Call custom render for field. */
            $handler( $args[ 'key' ], $args[ 'tab_slug' ] );
            return;

        }

        /** In field haven't custom render check maybe we have standard handler for this field type? */
        if ( ! is_callable( [ $this, 'render_' . $args[ 'type' ] ] ) ) {
            ?><div class="mdc-system-warn"><?php esc_html_e( 'Handler for this field type not found.' ); ?></div><?php
            return;
        }

        /** Call render field by type. */
        $this->{'render_' . $args[ 'type' ]}( $args['key'], $args['tab_slug'] );

	}

    /**
     * Return custom handler for field or false.
     *
     * @param array $args - Array of params for render: field key and type.
     *
     * @since  1.0
     * @access public
     *
     * @return array|false
     **/
	private function get_field_handler( $args ) {

	    /** Get field. */
        $tabs = Plugin::get_tabs();
        $tab = $tabs[ $args[ 'tab_slug' ] ];
        $fields = $tab[ 'fields' ];
        $field = $fields[ $args[ 'key' ] ];

        if ( ! empty( $field[ 'render' ] ) ) {
            return $field[ 'render' ];
        }

	    return false;

    }

    /**
     * Prepare array with attributes.
     *
     * @param string $key - Field key.
     * @param string $tab_slug - Tab slug to which the field belongs.
     *
     * @since  1.0
     * @access private
     *
     * @return array
     **/
    private function prepare_attr( $key, $tab_slug ) {

        $name = 'mdp_selection_lite_' . $tab_slug . '_settings';

	    return [
            'name'      => $name . '[' . $key . ']',
            'id'        => $name . '_' . $key,
        ];

    }

    /**
     * Clears widgets name option
     */
    private function clear_widget_names_option() {
        delete_transient( 'mdp_selection_lite_widgets_names' );
    }

	/**
	 * Render Widgets grid
	 */
	private function render_widgets_grid() {

        // clear widgets names
        if ( isset( $_GET['refresh_names'] ) ) {
            $this->clear_widget_names_option();
            $this->update_widgets_name();
        }

	    self::$widgets = get_option( 'mdp_selection_lite_widgets_settings' );
	    self::$widgets_name = get_transient( 'mdp_selection_lite_widgets_names' );
        if ( ! self::$widgets_name ) { $this->update_widgets_name(); }

	    // Show message if elementor not installed or not active
	    if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {

		    $this->render_elementor_less_description();
		    return;

	    }

        $this->render_main_description(); // Main widgets description

        if ( ! is_array( self::$widgets ) ) { // No stored names

	        // Render welcome snackbar
	        UI::get_instance()->render_snackbar(
                esc_html__( 'Hey ' ) . wp_get_current_user()->user_nicename . esc_html__( '! Manage widgets and settings' ),
		        'info'
	        );

	        // Update and store all widgets name
            $this->update_widgets_name();

        } else if ( is_array( self::$widgets ) && is_array( self::$widgets_name ) ) {

	        if ( count( self::$widgets_name ) < count( self::$widgets ) ) {

		        // Render New widgets snackbar
		        $new_widgets_count = count( self::$widgets ) - count( self::$widgets_name );
		        UI::get_instance()->render_snackbar(
			        $new_widgets_count . esc_html__( ' new widget(s) added. Check the changelog for more.' ),
			        'info'
		        );

		        // Update and store all widgets name
		        $this->update_widgets_name( array_diff_key( self::$widgets, self::$widgets_name ) );

	        }

        }

        $this->render_categories(); // Render widgets by categories

    }

	/**
     * Get and store widget name for unnamed widgets
	 * @param array $no_named
	 */
    private function update_widgets_name( $no_named = [] ) {

	    $widgets_name = $this->get_widget_names(); // All selection widgets

	    $named = ! empty( $no_named ) ? array_intersect_key( $widgets_name, $no_named ) : $widgets_name;

	    self::$widgets_name = ! empty( $no_named ) ? array_merge( self::$widgets_name, $named ) : $named;

	    // Store names
        set_transient( 'mdp_selection_lite_widgets_names', self::$widgets_name, 86400 ); // 1 day

    }

	/**
     * Get widgets name from widgets classes
	 * @return array
	 */
    private function get_widget_names() {

	    /** Get Widget Manager. */
	    $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

	    /** Retrieve all registered widgets. */
	    $widget_types = $widgets_manager->get_widget_types();

	    /** @var array Prepare widgets names array $widgets_name */
	    $widgets_name = array();

	    foreach ( $widget_types as $widget_type ) {

	        // Prepare title
		    $title = $widget_type->get_title();

		    // Prepare name
		    $name = $widget_type->get_name();
		    $name = str_replace( 'graphist-', '', $name );
		    $name = str_replace( 'mdp-', '', $name );
		    $name = str_replace( '-elementor', '', $name );

		    // Prepare class
		    $class = $widget_type->get_class_name();

		    // If widget is path of the Selection
		    if ( strpos( $class, 'Merkulove\SelectionLite' ) === 0 ) {

			    $widgets_name[ $name ] = $title;

		    }

	    }

	    return $widgets_name;

    }

	/**
	 * Render main description
	 */
    private function render_main_description() {

	    ?><p class="mdp-selection-main-description"><?php esc_html_e( 'Disable widgets that you do not plan to use to exclude their loading in the editor and on the site.', 'selection-lite' ); ?></p><?php

    }

	/**
	 * Render disabled elementor message
	 */
	private function render_elementor_less_description() {

		?><p class="mdp-selection-main-description"><?php esc_html_e( 'Install and activate Elementor Page Builder to start managing widgets.', 'selection-lite' ); ?></p><?php

	}

	/**
	 * Render widgets by category
	 */
    private function render_categories() {

        // Only for the first run
	    if ( empty( self::$widgets ) ) {

            self::$widgets = get_option( 'mdp_selection_lite_widgets_settings' );

        }

        // Render widgets by category
	    foreach ( self::$widget_categories as $category => $widgets ) {

		    $this->render_category_grid( $widgets, $category );

	    }

	    // Exit if no more widgets for rendering
	    if ( empty( self::$widgets ) ) { return; }

	    // Render miscellaneous category with widgets that not entry in any category
	    $this->render_category_grid( [ '*' ], 'Miscellaneous' );

    }

	/**
	 * Render grid for single category
	 *
	 * @param string $category - Category slug
	 * @param array  $widgets  - Widgets included to category
	 */
    private function render_category_grid( $widgets = [], $category = '' ) {

        if ( empty( $widgets ) ) { return; } // Exit if 0 widgets in category

	    ?>
        <h4 class="mdp-selection-category--title"><?php esc_html_e( $category . ' widgets', 'selection-lite' ); ?></h4>
        <div class="mdp-selection-grid mdp-selection-grid--<?php esc_attr_e( $category ); ?>"><?php

        $free_widgets = [];
        $unlisted = '';

        /** Render free widgets */
	    foreach ( self::$widgets as $key => $widget ) {

		    /**
		     * Render categorized widget in category
		     * or
		     * every uncategorized widgets
		     */
            if ( in_array( $key, $widgets ) || $widgets === [ '*' ] ) {

			    $title = isset( self::$widgets_name[ $key ] ) ? self::$widgets_name[ $key ] : $key;

			    $this->render_widget( $title, $key );

	            array_push( $free_widgets, $key ); // Save free widgets for current category
			    unset( self::$widgets[ $key ] ); // Remove displayed widget from stack

		    }

	    }

        /** Render pro widgets */
        foreach ( $widgets as $key => $widget ) {

            if ( array_key_exists( $widget, self::$pro_widgets ) ) {

                $this->render_widget_pro( self::$pro_widgets[ $widget ], $widget );

            } else {

                if ( in_array( $widget, $free_widgets ) ) { continue; }

	            $unlisted .= '<p>Added new pro widget: <strong>' . $widget . '</strong></p>';

            }

        }

        /** Render unlisted widgets */
        if ( $unlisted ) {

            ?><div style='width: 100%'><?php
	        echo wp_kses_post( $unlisted );
	        ?></div><?php

        }

	    ?></div><?php

    }

	/**
     * Render single widget for grid view
	 * @param $title
	 * @param $name
	 */
	private function render_widget( $title, $name ) {

        ?>

        <div class="mdp-selection-widget">

            <div class="mdp-selection-widget--header">

                <div class="mdp-selection-widget--logo">
                    <a href="" target="_blank" rel="noopener">
                        <img src="<?php esc_attr_e( Plugin::get_url() ); ?>/images/widgets/<?php esc_attr_e( $name );?>.svg" alt="<?php esc_attr_e( $title );?>">
                    </a>
                </div>

                <div class="mdp-selection-widget--title">

                    <h4><?php esc_attr_e( $title );?></h4>

                    <div class="mdp-selection-widget--switcher">
		                <?php $this->render_widget_switcher( $name ); ?>
                    </div>

                </div>

            </div>

            <div class="mdp-selection-widget--links" style="display: none">

                <a href="#" title="<?php esc_html_e( 'Explore', 'selection-lite' ); ?>" target="_blank" rel="noopener">
                    <i class="material-icons">track_changes</i>
	                <?php esc_html_e( 'Explore', 'selection-lite' ); ?>
                </a>

                <a href="https://docs.merkulov.design/" title="<?php esc_html_e( 'Documentation', 'selection-lite' ); ?>" target="_blank" rel="noopener">
                    <i class="material-icons">info_outline</i>
	                <?php esc_html_e( 'Documentation', 'selection-lite' ); ?>
                </a>

            </div>

        </div>

        <?php

    }

	/**
	 * @param $title
	 * @param $name
	 */
    private function render_widget_pro( $title, $name ) {

        ?>

        <div class="mdp-selection-widget mdp-pro">

            <div class="mdp-selection-widget--header">

                <div class="mdp-selection-widget--logo">
                    <a href="" target="_blank" rel="noopener">
                        <img src="<?php esc_attr_e( Plugin::get_url() ); ?>/images/widgets/<?php esc_attr_e( $name );?>.svg" alt="<?php esc_attr_e( $title );?>">
                    </a>
                </div>

                <div class="mdp-selection-widget--title">

                    <h4><?php esc_attr_e( $title );?></h4>

                    <div class="mdp-selection-widget--pro-badge">

                        <a href="https://1.envato.market/selection" target="_blank">
                            <i class="material-icons mdc-list-item__graphic" aria-hidden="true">label_important</i><?php esc_html_e( 'Pro', 'selection-lite' ); ?>
                        </a>

                    </div>

                </div>

            </div>

            <div class="mdp-selection-widget--links" style="display: none">

                <a href="#" title="<?php esc_html_e( 'Explore', 'selection-lite' ); ?>" target="_blank" rel="noopener">
                    <i class="material-icons">track_changes</i>
                    <?php esc_html_e( 'Explore', 'selection-lite' ); ?>
                </a>

                <a href="https://docs.merkulov.design/" title="<?php esc_html_e( 'Documentation', 'selection-lite' ); ?>" target="_blank" rel="noopener">
                    <i class="material-icons">info_outline</i>
                    <?php esc_html_e( 'Documentation', 'selection-lite' ); ?>
                </a>

            </div>

        </div>

        <?php

    }

	/**
	 * @param $title
	 * @param $name
	 */
	private function render_upcoming_widget( $title, $name ) {

		?>

        <div class="mdp-selection-widget">

            <div class="mdp-selection-widget--header">

                <div class="mdp-selection-widget--logo">
                    <img src="<?php esc_attr_e( Plugin::get_url() ); ?>/images/widgets/<?php esc_attr_e( $name );?>.svg" alt="<?php esc_attr_e( $title );?>">
                </div>

                <div class="mdp-selection-widget--title">

                    <h4><?php esc_attr_e( $title );?></h4>

                </div>

                <span class="mdp-selection-widget--badge">new</span>

            </div>

            <div class="mdp-selection-widget--links">

                <p><?php esc_html_e( 'In the next release', 'selection-lite' ); ?></p>

            </div>

        </div>

		<?php

	}

	/**
     * Render widget on/off switcher
	 * @param $key - Slug of the single elementor widget
	 */
    private function render_widget_switcher( $key ) {

	    /** Prepare general field params. */
	    $tab_slug = 'widgets';
	    $switcher = isset( self::$options[ $key ] ) ? self::$options[ $key ] : 'on';

	    /** Render switcher. */
	    UI::get_instance()->render_switcher( $switcher, '', '', $this->prepare_attr( $key, $tab_slug ) );

    }

	/**
	 * Render additional block of settings below the widgets grid
	 */
    private function widgets_additional() {}

	/**
	 * Main TabWidgets Instance.
	 * Insures that only one instance of TabWidgets exists in memory at any one time.
	 *
	 * @static
	 * @return TabWidgets
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
