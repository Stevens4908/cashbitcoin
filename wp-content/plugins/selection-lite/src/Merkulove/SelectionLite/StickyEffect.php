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

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Merkulove\SelectionLite\Unity\Plugin;

final class StickyEffect  {

    /**
     * The one true StickyEffect.
     *
     * @since 1.0.0
     * @access private
     * @var StickyEffect
     **/
    private static $instance;


    public function __construct() {

        add_action( 'elementor/element/section/section_advanced/after_section_end', [ $this, 'register_section_controls' ], 10, 2 );

        add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'register_column_controls' ], 10, 2 );

        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );
    }

    /**
     * Register scripts for sticky effect.
     *
     * @since 1.0.0
     * @access public
     *
     * @return void.
     */
    public function enqueue_scripts() {
        wp_enqueue_script( 'mdp-selection-sticky-effect', Plugin::get_url() . 'js/sticky-effect' . Plugin::get_suffix() . '.js', [ 'elementor-frontend' ], Plugin::get_version(), true  );
    }

    /**
     * Register styles for sticky effect.
     *
     * @since 1.0.0
     * @access public
     *
     * @return void.
     */
    public function enqueue_styles() {
        wp_enqueue_style( 'mdp-selection-sticky-effect-styles', Plugin::get_url() . 'css/sticky-effect' . Plugin::get_suffix() . '.css', [], Plugin::get_version() );
    }

    /**
     * Register controls for column sticky effect.
     *
     * @since 1.0.0
     * @access public
     *
     * @return void.
     */
    public function register_column_controls ( Controls_Stack $element ) {
        $element->start_controls_section(
            'mdp_selection_sticky_column_effect',
            [
                'label' => esc_html__( 'Sticky Column Effect', 'selection-lite' ),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_column_effect_enable',
            [
                'label'        => esc_html__( 'Enable column sticky effect', 'selection-lite' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => false,
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_column_effect_enable_on',
            [
                'label' => esc_html__( 'Enable On', 'selection-lite' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => 'true',
                'default' => [ 'desktop', 'tablet', 'mobile' ],
                'options' => [
                    'desktop' => esc_html__( 'Desktop', 'selection-lite' ),
                    'tablet' => esc_html__( 'Tablet', 'selection-lite' ),
                    'mobile' => esc_html__( 'Mobile', 'selection-lite' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_column_effect_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_column_effect_offset_top',
            [
                'label' => esc_html__( 'Offset top', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                ],
                'size_units' => [ 'px' ],
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_column_effect_enable' => 'yes',
                ],
            ]
        );

        $element->end_controls_section();

    }

    /**
     * Register controls for section sticky effect.
     *
     * @since 1.0.0
     * @access public
     *
     * @return void.
     */
    public function register_section_controls( Controls_Stack $element ) {

        $element->start_controls_section(
            'mdp_selection_sticky_effect',
            [
                'label' => esc_html__( 'Sticky Effect', 'selection-lite' ),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_effect_enable',
            [
                'label'        => esc_html__( 'Enable', 'selection-lite' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => false,
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_effect_enable_on',
            [
                'label' => esc_html__( 'Enable On', 'selection-lite' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => 'true',
                'default' => [ 'desktop', 'tablet', 'mobile' ],
                'options' => [
                    'desktop' => esc_html__( 'Desktop', 'selection-lite' ),
                    'tablet' => esc_html__( 'Tablet', 'selection-lite' ),
                    'mobile' => esc_html__( 'Mobile', 'selection-lite' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );


        $element->add_control(
            'enable_separate',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_effect_scroll_offset',
            [
                'label' => esc_html__( 'Scroll Offset', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'size_units' => [ 'px' ],
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'scroll_offset_separate',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_section_effect_offset_top',
            [
                'label' => esc_html__( 'Offset top', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 20,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1
                    ],
                ],
                'size_units' => [ 'px' ],
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes',
                ],
            ]
        );

        $element->add_control(
            'offset_separate',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );

        $element->add_control(
            'mdp_selection_sticky_effect_z_index',
            [
                'label' => esc_html__( 'Z-Index', 'selection-lite' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 1,
                'frontend_available' => true,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mdp_selection_sticky_effect_background',
				'label' => esc_html__( 'Background', 'selection-lite' ),
				'types' => [ 'classic', 'gradient' ],
				'condition' => [
					'mdp_selection_sticky_effect_enable' => 'yes'
				],
				'selector' => '.elementor-element.elementor-element-{{ID}}.mdp-selection-section-sticky-effect-yes-{{ID}}.mdp-selection-section-sticky',
			]
		);


        $element->add_control(
            'background_separate',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );


		$element->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mdp_selection_sticky_effect_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
				'condition' => [
					'mdp_selection_sticky_effect_enable' => 'yes'
				],
				'selector' => '.elementor-element.elementor-element-{{ID}}.mdp-selection-section-sticky-effect-yes-{{ID}}.mdp-selection-section-sticky',
			]
		);

        $element->add_control(
            'box_shadow_separate',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
            ]
        );

		$element->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mdp_selection_sticky_effect_borders',
				'label' => esc_html__( 'Border', 'selection-lite' ),
				'selector' => '.elementor-element.elementor-element-{{ID}}.mdp-selection-section-sticky-effect-yes-{{ID}}.mdp-selection-section-sticky',
				'condition' => [
					'mdp_selection_sticky_effect_enable' => 'yes'
				],
			]
		);


        $element->add_control(
            'mdp_selection_sticky_effect_hide_on_scroll_down',
            [
                'label'        => esc_html__( 'Hide on scroll down', 'selection-lite' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => false,
                'separator' => 'before',
                'condition' => [
                    'mdp_selection_sticky_effect_enable' => 'yes'
                ],
                'return_value' => 'yes',
                'frontend_available' => true,
            ]
        );


        $element->end_controls_section();

    }


    /**
     * Main StickyEffect Instance.
     * Insures that only one instance of StickyEffect exists in memory at any one time.
     *
     * @static
     * @since 1.0.0
     * @access public
     *
     * @return StickyEffect
     **/
    public static function get_instance() {

        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

            self::$instance = new self;

        }

        return self::$instance;

    }


}
