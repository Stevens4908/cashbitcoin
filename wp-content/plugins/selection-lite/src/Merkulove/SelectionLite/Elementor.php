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

use Merkulove\SelectionLite\Unity\Settings;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Merkulove\SelectionLite\Unity\Plugin;

/**
 * Class to implement Elementor Widget.
 *
 * @since 1.0
 *
 **/
final class Elementor {

	/**
	 * The one true Elementor.
	 *
	 * @var Elementor
	 **/
	private static $instance;

    /**
     * Setup the Unity.
     *
     * @since  1.0
     * @access public
     *
     * @return void
     **/
    public function setup() {

        /** Define hooks that runs on both the front-end as well as the dashboard. */
	    $this->register_elementor_widgets();

    }

    /**
     * Registers a Elementor Widget.
     *
     * @return void
     * @access public
     **/
    public function register_elementor_widgets() {

        /** Check for basic requirements. */
        $this->initialization();

        /** Elementor widget Editor CSS. */
        add_action( 'elementor/editor/before_enqueue_styles', [$this, 'editor_styles'] );

    }

	/**
	 * Add our css to admin editor.
	 *
	 * @access public
	 **/
	public function editor_styles() {

		wp_enqueue_style( 'mdp-selection-admin', Plugin::get_url() . 'css/elementor-admin' . Plugin::get_suffix() . '.css', [], Plugin::get_version() );

	}

	/**
	 * The init process check for basic requirements and then then run the plugin logic.
	 *
	 * @access public
	 **/
	public function initialization() {

		/** Check if Elementor installed and activated. */
		if ( ! did_action( 'elementor/loaded' ) ) { return; }

		/** Register custom widgets. */
		add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets'] );

	}

	/**
	 * Register new Elementor widgets.
	 *
	 * @access public
     * @since 1.0
     *
     * @return void
     **/
	public function register_widgets() {

		/** Load and register Elementor widgets. */
		$path = Plugin::get_path() . 'src/Merkulove/SelectionLite/Elementor/widgets/';

		/** @var array $options Shorthand for options */
		$options = get_option( 'mdp_selection_lite_widgets_settings' );

		/** Get list of the Selection widgets from settings */
		$selection_widgets = is_array( $options ) ? $options : array();

		foreach ( new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path ) ) as $filename ) {

			if ( substr( $filename, -4 ) === '.php' ) {

				/** @noinspection PhpIncludeInspection */
				require_once $filename;

				/** Prepare class name from file. */
				$widget_class = $filename->getBasename( '.php' );

				/** @var string $widget_key - Prepare widget key */
				$widget_key = str_replace( '.', '-', $widget_class );
				$widget_key = str_replace( 'graphist-', '', $widget_key );
				$widget_key = str_replace( '-elementor', '', $widget_key );

				/** @var string $widget_class - Prepare widget class name for registration widgets */
				$widget_class = str_replace( '.', '_', $widget_class );

				/** @var string $widget_class Add Namespace. */
				$widget_class = 'Merkulove\SelectionLite\\' . $widget_class;

				/** Register Elementor widgets */
				if ( isset( $options[ $widget_key ] ) ) {

					/** Register widgets with 'ON' status */
					if ( $options[ $widget_key ] === 'on' ) {

						/** Instantiate 'ON' widget and register it in Elementor. */
						\Elementor\Plugin::instance()->widgets_manager->register( new $widget_class() );

					}

				} else {

					/** Instantiate 'NEW' widget and register it in Elementor. */
					\Elementor\Plugin::instance()->widgets_manager->register( new $widget_class() );

					$selection_widgets[ $widget_key ] = "on";

				}

			}

		}

		/** Update option if widgets list changed */
		if ( $options !== $selection_widgets ) {

			update_option( 'mdp_selection_lite_widgets_settings', $selection_widgets );

		}

        /** Sort our widgets inside Category. */
        $this->sort_widgets();

	}

    /**
     * Sort our widgets inside Category.
     *
     * @access public
     * @since 1.0
     *
     * @return void
     **/
	private function sort_widgets() {

	    /** Get Widget Manager. */
        $widgets_manager = \Elementor\Plugin::instance()->widgets_manager;

        /** Retrieve all registered widgets. */
        $widget_types = $widgets_manager->get_widget_types();

        /** Collection of widget classes and initialisation order. */
        $new_order = [];

        foreach ( $widget_types as $key => $widget_type ) {

            /** Get widget class name. */
            $widget_class = get_class( $widget_type );

            /** Skip this widget, it cause warning on reinitialisation */
            if ( 'Elementor\Widget_WordPress' === $widget_class ) { continue; }

            /** Get widget order. */
            $order = property_exists( $widget_type, 'mdp_order' ) ? $widget_type->mdp_order : 0;

            /** Remember class and order. */
            $new_order[$widget_class] = $order;

            /** Unregister all widgets. */
            $widgets_manager->unregister( $key );

        }

        /** Sort widgets by mdp_order. */
        asort( $new_order );

        /** Instantiate widgets in correct order. */
        foreach ( $new_order as $class => $o ) {
            $widgets_manager->register( new $class );
        }

    }

	/**
	 * Main Elementor Instance.
	 *
	 * Insures that only one instance of Elementor exists in memory at any one time.
	 *
	 * @static
     *
	 * @return Elementor
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
