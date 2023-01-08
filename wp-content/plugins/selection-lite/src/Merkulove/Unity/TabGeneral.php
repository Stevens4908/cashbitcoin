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
 * SINGLETON: Class used to implement any tab with settings.
 *
 * @since 1.0
 *
 **/
final class TabGeneral extends Tab {

	/**
	 * The one true TabGeneral.
	 *
     * @since 1.0
     * @access private
	 * @var TabGeneral
	 **/
	private static $instance;

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

        /** Render title. */
        $this->render_title( $tab_slug );

        /** Render fields. */
        $this->do_settings_base( $tab_slug );

    }

    /**
     * Generate General Tab.
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

        $group = 'SelectionLite' . $tab_slug . 'OptionsGroup';
        $section = 'mdp_selection_lite_' . $tab_slug . '_page_status_section';

        /** Exit if no fields to process. */
        if ( empty( Plugin::get_tabs()[$tab_slug]['fields'] ) ) { return; }

        $fields = Plugin::get_tabs()[$tab_slug]['fields'];

        /** Create settings for each field. */
        foreach ( $fields as $key => $field ) {

            /** Prepare field label. */
            $label = isset( $field[ 'label' ] ) && ! empty( $field[ 'label' ] ) ? $field[ 'label' ] : '';

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
     * Prepare general field params.
     *
     * @param $tab_slug
     * @param $key
     *
     * @return array
     **/
    public function prepare_general_params( $tab_slug, $key ) {

        /** Get field settings. */
        $field = Plugin::get_tabs()[ $tab_slug ][ 'fields' ][ $key ];

        /** Prepare label, description and attributes. */
        if ( isset( $field[ 'placeholder' ] ) && ! empty( $field[ 'placeholder' ] ) ) {
            $label = $field[ 'placeholder' ];
        } else {
            $label = isset( $field[ 'label' ] ) && ! empty( $field[ 'label' ] ) ? $field[ 'label' ] : '';
        }
        $description = ! empty( $field[ 'description' ] ) ? $field[ 'description' ] : '';

        $attr = $this->prepare_attr( $key, $tab_slug, $field );

        return [ $field, $label, $description, $attr ];
    }

    /**
     * Prepare array with attributes.
     *
     * @param string $key - Field key.
     * @param string $tab_slug - Tab slug to which the field belongs.
     * @param array $field
     *
     * @since  1.0
     * @access private
     *
     * @return array
     **/
    private function prepare_attr( $key, $tab_slug, $field ) {

        $name = 'mdp_selection_lite_' . $tab_slug . '_settings';

        $attr = [
            'name'      => $name . '[' . $key . ']',
            'id'        => $name . '_' . $key,
        ];

        if ( ! empty( $field['attr'] ) ) {
            $attr = array_merge( $attr, $field['attr'] );
        }

        return $attr;

    }

	/**
	 * Main TabGeneral Instance.
	 * Insures that only one instance of TabGeneral exists in memory at any one time.
	 *
	 * @static
	 * @return TabGeneral
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
