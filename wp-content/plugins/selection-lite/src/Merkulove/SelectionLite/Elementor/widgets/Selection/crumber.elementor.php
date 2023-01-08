<?php /** @noinspection PhpUndefinedClassInspection */
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

use Elementor\Core\Files\Assets\Svg\Svg_Handler;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Exception;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Merkulove\SelectionLite\Unity\Plugin as UnityPlugin;

/** @noinspection PhpUnused */
/**
 * Crumber - Custom Elementor Widget.
 **/
class crumber_elementor extends Widget_Base {

    /**
     * Use this to sort widgets.
     * A smaller value means earlier initialization of the widget.
     * Can take negative values.
     * Default widgets and widgets from 3rd party developers have 0 $mdp_order
     **/
    public $mdp_order = 1;

    /**
     * Widget base constructor.
     * Initializing the widget base class.
     *
     * @access public
     * @throws Exception If arguments are missing when initializing a full widget instance.
     * @param array      $data Widget data. Default is an empty array.
     * @param array|null $args Optional. Widget default arguments. Default is null.
     *
     * @return void
     **/
    public function __construct( $data = [], $args = null ) {

        parent::__construct( $data, $args );

        wp_register_style( 'mdp-selection-elementor-admin', UnityPlugin::get_url() . 'css/elementor-admin' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );
        wp_register_style( 'mdp-crumber', UnityPlugin::get_url() . 'css/crumber-elementor' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );
    }

    /**
     * Return a widget name.
     *
     * @return string
     **/
    public function get_name() {

        return 'mdp-crumber-elementor';

    }

    /**
     * Return the widget title that will be displayed as the widget label.
     *
     * @return string
     **/
    public function get_title() {

        return esc_html__( 'Breadcrumbs', 'selection-lite' );

    }

    /**
     * Set the widget icon.
     *
     * @return string
     */
    public function get_icon() {

        return 'mdp-crumber-elementor-widget-icon';

    }

    /**
     * Set the category of the widget.
     *
     * @return array with category names
     **/
    public function get_categories() {

        return [ 'selection-category' ];

    }

    /**
     * Get widget keywords. Retrieve the list of keywords the widget belongs to.
     *
     * @access public
     *
     * @return array Widget keywords.
     **/
    public function get_keywords() {

        return [ 'Merkulove', 'Breadcrumbs', 'breadcrumbs', 'navigation', 'seo' ];

    }

    /**
     * Get style dependencies.
     * Retrieve the list of style dependencies the widget requires.
     *
     * @access public
     *
     * @return array Widget styles dependencies.
     **/
    public function get_style_depends() {

        return [ 'mdp-crumber', 'mdp-selection-elementor-admin', 'elementor-icons-fa-solid' ];

    }

	/**
	 * Get script dependencies.
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @access public
     *
	 * @return array Element scripts dependencies.
	 **/
	public function get_script_depends() {

		return [ 'mdp-crumber' ];

    }

    /**
     * Add the widget controls.
     *
     * @access protected
     * @return void with category names
     **/
    protected function register_controls() {

        /** Content Tab. */
        $this->tab_content();

        /** Style Tab. */
        $this->tab_style();

    }

    /**
     * Add widget controls on Content tab.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function tab_content() {

        /** Content -> General Content Section. */
        $this->section_content_general();

        /** Content -> Custom Breadcrumbs Content Section. */
        $this->section_content_custom_breadcrumbs();

	    /** Pro Content */
	    $this->section_content_pro();

    }

    /**
     * Add widget controls on Style tab.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function tab_style() {

        /** Style -> Section Style Breadcrumbs Items. */
        $this->section_style_breadcrumbs_items();

        /** Style -> Section Style Separator. */
        $this->section_style_separator();
    }

    /**
     * Get post types for select options.
     *
     * @return array
     * @since 1.0.0
     * @access private
     *
     */
    private function get_post_types_options() {
        $types = wp_list_pluck( get_post_types( [ 'public' => true, 'show_in_nav_menus' => true ], 'objects' ), 'label', 'name' );
        return array_diff_key( $types, ['elementor_library', 'attachment'] );
    }

    /**
     * Add widget controls: Content -> General Content Section.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function section_content_general() {

        $this->start_controls_section( 'section_content_general', [
            'label' => esc_html__( 'General', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_CONTENT
        ] );

        $this->add_control(
            'custom_breadcrumbs',
            [
                'label' => esc_html__( 'Custom breadcrumbs', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'displaying_items',
            [
                'label' => esc_html__( 'Displaying items', 'selection-lite' ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'show_homepage'  => esc_html__( 'Show homepage', 'selection-lite' ),
                    'show_parent_page' => esc_html__( 'Show parent page', 'selection-lite' ),
                    'show_child_pages' => esc_html__( 'Show child pages', 'selection-lite' ),
                ],
                'condition' => [
                        'custom_breadcrumbs!' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'breadcrumbs_alignment',
            [
                'label' => esc_html__( 'Alignment', 'selection-lite' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'selection-lite' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'selection-lite' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'selection-lite' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space around', 'selection-lite' ),
                        'icon' => 'fa fa-compress-arrows-alt',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space between', 'selection-lite' ),
                        'icon' => 'fa fa-expand-arrows-alt',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs' => 'justify-content: {{VALUE}}',
                ],
                'default' => 'flex-start',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'show_separator',
            [
                'label' => esc_html__( 'Show separator', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'separator_type',
            [
                'label' => esc_html__( 'Separator type', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__( 'Text', 'selection-lite' ),
                    'icon' => esc_html__( 'Icon', 'selection-lite' ),
                ],
                'condition' => [
                    'show_separator' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'separator_text',
            [
                'label' => esc_html__( 'Separator', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__( 'Type your inner text here', 'selection-lite' ),
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( '/', 'selection-lite' ),
                'condition' => [
                    'show_separator' => 'yes',
                    'separator_type' => 'text'
                ]
            ]
        );

        $this->add_control(
            'separator_icon',
            [
                'label' => esc_html__( 'Separator icon', 'selection-lite' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_separator' => 'yes',
                    'separator_type' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'show_current_page',
            [
                'label' => esc_html__( 'Show current page', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->end_controls_section();

    }

    /**
     * Add widget controls: Content -> Custom Breadcrumbs Content Section.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function section_content_custom_breadcrumbs() {

        $this->start_controls_section( 'section_content_custom_breadcrumbs', [
            'label' => esc_html__( 'Custom breadcrumbs', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
            'condition' => [
                 'custom_breadcrumbs' => 'yes'
            ]
        ] );

        $repeater = new Repeater();

        $repeater->add_control(
            'custom_breadcrumb_name', [
                'label' => esc_html__( 'Name', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Name' , 'selection-lite' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'custom_breadcrumb_link',
            [
                'label' => esc_html__( 'Link', 'selection-lite' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'selection-lite' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $repeater->add_control(
            'is_active_custom_breadcrumb',
            [
                'label' => esc_html__( 'Is active', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'show_custom_item_icon',
            [
                'label' => esc_html__( 'Show icon', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'custom_breadcrumbs_icon',
            [
                'label' => esc_html__( 'Icon', 'selection-lite' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [
                        'show_custom_item_icon' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'custom_breadcrumbs_icon_position',
            [
                'label' => esc_html__( 'Icon position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'before',
                'options' => [
                    'before' => esc_html__( 'Before', 'selection-lite' ),
                    'after' => esc_html__( 'After', 'selection-lite' ),
                    'above-left' => esc_html__( 'Above left', 'selection-lite' ),
                    'above-center' => esc_html__( 'Above center', 'selection-lite' ),
                    'above-right' => esc_html__( 'Above right', 'selection-lite' ),
                    'under-left' => esc_html__( 'Under left', 'selection-lite' ),
                    'under-center' => esc_html__( 'Under center', 'selection-lite' ),
                    'under-right' => esc_html__( 'Under right', 'selection-lite' ),
                ],
                'condition' => [
                    'show_custom_item_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'custom_breadcrumbs_list',
            [
                'label' => esc_html__( 'Custom breadcrumbs', 'selection-lite' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'custom_breadcrumb_name' => esc_html__( 'Title #1', 'selection-lite' ),
                    ],
                    [
                        'custom_breadcrumb_name' => esc_html__( 'Title #2', 'selection-lite' ),
                    ],
                ],
                'title_field' => '{{{ custom_breadcrumb_name }}}',
            ]
        );


        $this->end_controls_section();

    }

    /**
     * Function for generating margin padding controls.
     *
     * @param $section_id
     * @param $html_class
     * @return void
     * @since 1.0.0
     * @access private
     *
     */
    private function generate_margin_padding_controls( $section_id, $html_class ) {
        $this->add_responsive_control(
            $section_id.'_margin',
            [
                'label' => esc_html__( 'Margin', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    "{{WRAPPER}} .$html_class" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            $section_id.'_padding',
            [
                'label' => esc_html__( 'Padding', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    "{{WRAPPER}} .$html_class" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            $section_id . '_separate_margin_padding',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );
    }


    /**
     * Function for generating typography and tabs controls.
     *
     * @param $section_id
     * @param $opts
     * @return void
     * @since 1.0.0
     * @access private
     */
    private function generate_typography_tabs_controls($section_id, $opts = [] ) {
        $style_opts = [
            'html_class' => array_key_exists( 'html_class', $opts ) ? $opts['html_class'] : '',
            'active_class' => array_key_exists( 'active_class', $opts ) ? $opts['active_class'] : '',
            'include_color' => array_key_exists( 'include_color', $opts ) ? $opts['include_color'] : true,
            'include_bg' => array_key_exists( 'include_bg', $opts ) ? $opts['include_color'] : true,
            'include_typography' => array_key_exists( 'include_typography', $opts ) ? $opts['include_typography'] : true,
            'include_transition' => array_key_exists( 'include_transition', $opts ) ? $opts['include_transition'] : true,
            'additional_color' => array_key_exists( 'additional_color', $opts ) ? $opts['additional_color'] : false,
            'include_active_tab' => array_key_exists( 'include_active_tab', $opts ) ? $opts['include_active_tab'] : false,
            'color_prefix' => array_key_exists( 'color_prefix', $opts ) ? $opts['color_prefix'] : '',
            'color_class' => array_key_exists( 'color_class', $opts ) ? $opts['color_class'] : '',
            'color_hover_class' => array_key_exists( 'color_hover_class', $opts ) ? $opts['color_hover_class'] : '',
            'color_active_class' => array_key_exists( 'color_active_class', $opts ) ? $opts['color_active_class'] : '',
            'color_hover_selector' => array_key_exists( 'color_hover_selector', $opts ) ? $opts['color_hover_selector'] : '',
            'additional_color_name' => array_key_exists( 'additional_color_name', $opts ) ? $opts['additional_color_name'] : '',
            'additional_color_class' => array_key_exists( 'additional_color_class', $opts ) ? $opts['additional_color_class'] : '',
            'additional_color_hover_class' => array_key_exists( 'additional_color_hover_class', $opts ) ? $opts['additional_color_hover_class'] : '',
            'additional_color_active_class' => array_key_exists( 'additional_color_active_class', $opts ) ? $opts['additional_color_active_class'] : '',
            'additional_transition_selector' => array_key_exists( 'additional_transition_selector', $opts ) ? $opts['additional_transition_selector'] : '',
            'typography_class' => array_key_exists( 'typography_class', $opts ) ? $opts['typography_class'] : '',
            'color_scheme_default' => array_key_exists( 'color_scheme_default', $opts ) ? $opts['color_scheme_default'] : Color::COLOR_3,
            'additional_color_scheme_default' => array_key_exists( 'additional_color_scheme_default', $opts ) ? $opts['additional_color_scheme_default'] : Color::COLOR_3
        ];


        if ( $style_opts['include_typography'] ) {
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => $section_id . '_typography',
                    'label' => esc_html__('Typography', 'selection-lite'),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => "{{WRAPPER}} .".$style_opts['typography_class'],
                ]
            );
        }

        $this->start_controls_tabs( $section_id.'_style_tabs' );

        $this->start_controls_tab( $section_id.'_normal_style_tab', ['label' => esc_html__( 'NORMAL', 'selection-lite' )] );

        if ( $style_opts['include_color'] ) {

            $this->add_control(
                $section_id . '_normal_text_color',
                [
                    'label' => esc_html__($style_opts['color_prefix'].'Color', 'selection-lite'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => $style_opts['color_scheme_default'],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .".$style_opts['color_class'] => 'color: {{VALUE}};',
                    ],
                ]
            );

        }

        if ( $style_opts['additional_color'] ) {
            $this->add_control(
                $section_id . '_' . $style_opts['additional_color_name'] . '_normal_text_color',
                [
                    'label' => esc_html__( $style_opts['additional_color_name'], 'selection-lite' ),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => $style_opts['additional_color_scheme_default'],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .".$style_opts['additional_color_class'] => 'color: {{VALUE}};',

                    ],
                ]
            );
        }

        if ( $style_opts['include_bg'] ) {

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $section_id . '_normal_background',
                    'label' => esc_html__('Background type', 'selection-lite'),
                    'types' => ['classic', 'gradient', 'video'],
                    'selector' => "{{WRAPPER}} .".$style_opts['html_class'],
                ]
            );

        }

        $this->add_control(
            $section_id . '_separate_normal',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $section_id.'_border_normal',
                'label' => esc_html__( 'Border Type', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .".$style_opts['html_class'],
            ]
        );

        $this->add_responsive_control(
            $section_id.'_border_radius_normal',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    "{{WRAPPER}} .".$style_opts['html_class'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $section_id.'_box_shadow_normal',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .".$style_opts['html_class'],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab( $section_id.'_hover_style_tab', ['label' => esc_html__( 'HOVER', 'selection-lite' )] );

        if ( $style_opts['include_color'] ) {
            $this->add_control(
                $section_id . '_hover_color',
                [
                    'label' => esc_html__($style_opts['color_prefix'].'Color', 'selection-lite'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => $style_opts['color_scheme_default'],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .".$style_opts['color_hover_class'] => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
        }

        if ( $style_opts['additional_color'] ) {
            $this->add_control(
                $section_id . '_' . $style_opts['additional_color_name'] . '_hover_text_color',
                [
                    'label' => esc_html__( $style_opts['additional_color_name'], 'selection-lite'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => $style_opts['additional_color_scheme_default'],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .".$style_opts['additional_color_hover_class'] => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
        }

        if ( $style_opts['include_bg'] ) {
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $section_id . '_background_hover',
                    'label' => esc_html__('Background type', 'selection-lite'),
                    'types' => ['classic', 'gradient', 'video'],
                    'selector' => "{{WRAPPER}} .".$style_opts['html_class'].":hover",
                ]
            );
        }

        if ( $style_opts['include_transition'] ) {
            $this->add_control(
                $section_id.'_hover_transition',
                [
                    'label' => esc_html__( 'Hover transition duration', 'selection-lite' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 's' ],
                    'range' => [
                        's' => [
                            'min' => 0.1,
                            'max' => 5,
                            'step' => 0.1,
                        ],
                    ],
                    'default' => [
                        'unit' => 's',
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .'.$style_opts['html_class'] => 'transition: color {{SIZE}}{{UNIT}}, background {{SIZE}}{{UNIT}}, box-shadow {{SIZE}}{{UNIT}}, border-radius {{SIZE}}{{UNIT}}, border {{SIZE}}{{UNIT}}, filter {{SIZE}}{{UNIT}}, stroke {{SIZE}}{{UNIT}};',
                        $style_opts['additional_transition_selector'] => 'transition: color {{SIZE}}{{UNIT}}, background {{SIZE}}{{UNIT}}, box-shadow {{SIZE}}{{UNIT}}, border-radius {{SIZE}}{{UNIT}}, border {{SIZE}}{{UNIT}}, filter {{SIZE}}{{UNIT}}, stroke {{SIZE}}{{UNIT}};;'
                    ],
                ]
            );
        }

        $this->add_control(
            $section_id.'_separate_hover',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $section_id.'_border_hover',
                'label' => esc_html__( 'Border Type', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .".$style_opts['html_class'].":hover",
            ]
        );

        $this->add_responsive_control(
            $section_id.'_border_radius_hover',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    "{{WRAPPER}} .".$style_opts['html_class'].":hover" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $section_id.'_box_shadow_hover',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .".$style_opts['html_class'].":hover",
            ]
        );

        $this->end_controls_tab();

        if ( $style_opts['include_active_tab'] ) {

            $this->start_controls_tab( $section_id . '_active_style_tab', ['label' => esc_html__( 'ACTIVE', 'selection-lite' )] );

            if ( $style_opts['include_color'] ) {
                $this->add_control(
                    $section_id . '_active_color',
                    [
                        'label' => esc_html__( $style_opts['color_prefix'] . 'Color', 'crumber-elementor '),
                        'type' => Controls_Manager::COLOR,
                        'scheme' => [
                            'type' => Color::get_type(),
                            'value' => $style_opts['color_scheme_default'],
                        ],
                        'selectors' => [
                            "{{WRAPPER}} ." . $style_opts['color_active_class'] => 'color: {{VALUE}};',
                        ],
                    ]
                );
            }

            if ( $style_opts['additional_color'] ) {
                $this->add_control(
                    $section_id . '_' . $style_opts['additional_color_name'] . '_active_text_color',
                    [
                        'label' => esc_html__( $style_opts['additional_color_name'], 'selection-lite' ),
                        'type' => Controls_Manager::COLOR,
                        'scheme' => [
                            'type' => Color::get_type(),
                            'value' => $style_opts['additional_color_scheme_default'],
                        ],
                        'selectors' => [
                            "{{WRAPPER}} ." . $style_opts['additional_color_active_class'] => 'color: {{VALUE}};',
                        ],
                    ]
                );
            }

            if ( $style_opts['include_bg'] ) {
                $this->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => $section_id . '_background_active',
                        'label' => esc_html__( 'Background type', 'selection-lite' ),
                        'types' => ['classic', 'gradient', 'video'],
                        'selector' => "{{WRAPPER}} ." . $style_opts['active_class'],
                    ]
                );
            }

            $this->add_control(
                $section_id . '_separate_active',
                [
                    'type' => Controls_Manager::DIVIDER,
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => $section_id . '_border_active',
                    'label' => esc_html__( 'Border Type', 'selection-lite' ),
                    'selector' => "{{WRAPPER}} ." . $style_opts['active_class'],
                ]
            );

            $this->add_responsive_control(
                $section_id . '_border_radius_active',
                [
                    'label' => esc_html__( 'Border radius', 'selection-lite' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} ." . $style_opts['active_class'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => $section_id . '_box_shadow_active',
                    'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                    'selector' => "{{WRAPPER}} ." . $style_opts['active_class'],
                ]
            );

            $this->end_controls_tab();

        }

        $this->end_controls_tabs();
    }

    /**
     * Add widget controls: Style -> Section Style Breadcrumbs Items.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function section_style_breadcrumbs_items() {

        $this->start_controls_section( 'section_style_breadcrumbs_items', [
            'label' => esc_html__( 'Breadcrumbs items', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_STYLE
        ] );


        $this->generate_margin_padding_controls( 'section_style_breadcrumbs_items', 'mdp-crumber-elementor-breadcrumbs-item' );

        $this->add_responsive_control(
            'space_between_items',
            [
                'label' => esc_html__( 'Space between items', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                        '{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
                        '{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item:first-of-type' => 'margin-left: 0;',
                        '{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item:last-of-type' => 'margin-right: 0;'

                ]
            ]
        );

        $this->add_control(
            'separate_space_between_items',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'custom_breadcrumbs!' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon size', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'separator' => 'before',
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    "{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item-icon" => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'custom_breadcrumbs' => 'yes'
                ]
            ]
        );


        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon spacing', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'separator' => 'after',
                'condition' => [
                    'custom_breadcrumbs' => 'yes'
                ],
                'selectors' => [
                    "{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item-icon" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $style_opts = [
            'html_class' => 'mdp-crumber-elementor-breadcrumbs-item',
            'include_active_tab' => true,
            'color_class' => 'mdp-crumber-elementor-breadcrumbs-item, {{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item a',
            'typography_class' => 'mdp-crumber-elementor-breadcrumbs-item, {{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item a',
            'color_hover_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item:hover a, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item:hover span, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active:hover span, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active:hover a, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-woocommerce:last-of-type:hover span',
            'color_active_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active, {{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active a, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-woocommerce:last-of-type',
            'active_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item-active',
            'additional_transition_selector' => '{{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item a, {{WRAPPER}} .mdp-crumber-elementor-breadcrumbs-item .mdp-crumber-elementor-breadcrumbs-item-icon',
            'additional_color' => true,
            'additional_color_class' => 'mdp-crumber-elementor-breadcrumbs-item .mdp-crumber-elementor-breadcrumbs-item-icon',
            'additional_color_hover_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item:hover .mdp-crumber-elementor-breadcrumbs-item-icon, {{WRAPPER}} .mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active:hover .mdp-crumber-elementor-breadcrumbs-item-icon i',
            'additional_color_name' => 'Icon color',
            'additional_color_active_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-breadcrumbs-item.mdp-crumber-elementor-breadcrumbs-item-active .mdp-crumber-elementor-breadcrumbs-item-icon'
        ];

        $this->generate_typography_tabs_controls( 'section_style_breadcrumbs_items', $style_opts );

        $this->end_controls_section();

    }


    /**
     * Add widget controls: Style -> Section Style Separator.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function section_style_separator()
    {

        $this->start_controls_section('section_style_separator', [
            'label' => esc_html__('Separator', 'selection-lite'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                  'show_separator' => 'yes'
            ]
        ] );

        $this->generate_margin_padding_controls( 'section_style_separator', 'mdp-crumber-elementor-separator' );

        $this->add_responsive_control(
            'separator_icon_size',
            [
                'label' => esc_html__( 'Icon size', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    "{{WRAPPER}} .mdp-crumber-elementor-separator" => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    "{{WRAPPER}} .mdp-crumber-elementor-separator svg" => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                     'separator_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'separate_icon_size',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => [
                    'separator_type' => 'icon'
                ]
            ]
        );

        $style_opts = [
                'html_class' => 'mdp-crumber-elementor-separator',
                'color_class' => 'mdp-crumber-elementor-separator',
                'color_hover_class' => 'mdp-crumber-elementor-box .mdp-crumber-elementor-breadcrumbs .mdp-crumber-elementor-separator:hover',
                'typography_class' => 'mdp-crumber-elementor-separator'
        ];

        $this->generate_typography_tabs_controls( 'section_style_separator', $style_opts );

        $this->end_controls_section();
    }

    /**
     * Render breadcrumbs item.
     *
     * @param $settings
     * @param string $title
     * @param string $link
     * @param bool $is_active
     * @param string $element
     * @param array $custom_item_icon
     * @param string $icon_position
     * @param string $show_custom_item_icon
     * @return void
     * @since 1.0.0
     * @access private
     */
    private function generate_breadcrumbs_item ( $settings, $title = '', $link = '', $is_active = false, $element = '', $custom_item_icon = [], $icon_position = '', $show_custom_item_icon = '' ) {
        ?>
        <div class="mdp-crumber-elementor-breadcrumbs-item <?php if ( $is_active ): ?>mdp-crumber-elementor-breadcrumbs-item-active<?php endif; ?> <?php if ( $settings['custom_breadcrumbs'] === 'yes' ): ?>mdp-crumber-elementor-breadcrumbs-icon-position-<?php esc_attr_e( $icon_position ); ?><?php endif; ?>">
            <?php if (  $element === '' ): ?>
                <?php if ( $link !== '' ): ?>
                    <?php if ( $settings['custom_breadcrumbs'] === 'yes' && $show_custom_item_icon === 'yes' ): ?>
                        <div class="mdp-crumber-elementor-breadcrumbs-item-icon">
                            <?php Icons_Manager::render_icon( $custom_item_icon, [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $link )?>"><?php esc_html_e( $title ); ?></a>
                <?php else: ?>
                <?php if ( $settings['custom_breadcrumbs'] === 'yes' && $show_custom_item_icon === 'yes' ): ?>
                <div class="mdp-crumber-elementor-breadcrumbs-item-icon">
                    <?php Icons_Manager::render_icon( $custom_item_icon, [ 'aria-hidden' => 'true' ] ); ?>
                </div>
                <?php endif; ?>
                    <span><?php esc_html_e( $title ); ?></span>
                <?php endif; ?>
            <?php
                elseif( $element !== '' ):
                    echo wp_kses_post( $element );
               endif;
            ?>
        </div>
        <?php if ( $settings['show_separator'] === 'yes' ): ?>
        <span class="mdp-crumber-elementor-separator mdp-crumber-elementor-separator-hide-last">
            <?php
                if ( $settings['separator_type'] === 'text' ) {
                    esc_html_e( $settings['separator_text'] );
                } else {
                    Icons_Manager::render_icon( $settings['separator_icon'], [ 'aria-hidden' => 'true' ] );
                }
            ?>
        </span>
        <?php endif; ?>
    <?php
    }

    /**
     * Render breadcrumbs.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function generate_breadcrumbs( $settings ) {
        $breadcrumbs = Caster::get_instance()->get_data_breadcrumbs();

        $separator = '';

        if( $settings['show_separator'] === 'yes' ) {
            if ( $settings['separator_type'] === 'text' ) {
                $separator = esc_html__( $settings['separator_text'] );
            } else {
                $icon = $settings['separator_icon'];
                $separator = $icon['library'] === 'svg' ? Svg_Handler::get_inline_svg( esc_sql( $settings['separator_icon']['value']['id'] ) ) : '<i class="'.esc_attr( $settings['separator_icon']['value'] ).'"></i>';
            }
        }

        foreach ( $breadcrumbs as $key => $value ) {

            if ( $key === 'woocommerce' ) {
                woocommerce_breadcrumb( [
                    'delimiter'   => '<span class="mdp-crumber-elementor-separator">'.$separator.'</span>',
                    'wrap_before' => '',
                    'wrap_after'  => '',
                    'before'      => '<div class="mdp-crumber-elementor-breadcrumbs-item mdp-crumber-elementor-breadcrumbs-item-woocommerce">',
                    'after'       => '</div>',
                    'home'        => in_array( 'show_homepage', $settings['displaying_items'] ) ? '<a href="'.esc_url( site_url() ).'">'.esc_html__( get_bloginfo( 'name' ) ).'</a>' : '',
                ] );
            } else {
                if ( !empty( $settings['displaying_items'] ) && in_array( 'show_homepage', $settings['displaying_items'] ) && $value['is_homepage'] ) {
                    if ( $settings['show_current_page'] !== 'yes' && $value['is_active'] === true  ) {
                        return;
                    } else {
                        $this->generate_breadcrumbs_item($settings, $value['name'], $value['link'], $value['is_active'], $value['element']);
                    }
                }

            if ( !empty( $settings['displaying_items'] ) && in_array( 'show_parent_page', $settings['displaying_items'] ) && $value['is_parent'] ) {
                if ( $settings['show_current_page'] !== 'yes' && $value['is_active'] === true  ) {
                    return;
                } else {
                    $this->generate_breadcrumbs_item( $settings, $value['name'], $value['link'], $value['is_active'], $value['element'] );
                }
            }

            if ( !empty( $settings['displaying_items'] ) && in_array( 'show_child_pages', $settings['displaying_items'] ) && $value['is_child'] ) {
                if ( $settings['show_current_page'] !== 'yes' && $value['is_active'] === true  ) {
                    return;
                } else {
                    $this->generate_breadcrumbs_item( $settings, $value['name'], $value['link'], $value['is_active'], $value['element'] );
                }
            }

            if ( !$value['is_homepage'] && !$value['is_parent'] && !$value['is_child'] ) {
                if ( $settings['show_current_page'] !== 'yes' && $value['is_active'] === true  ) {
                    return;
                } else {
                    $this->generate_breadcrumbs_item( $settings, $value['name'], $value['link'], $value['is_active'], $value['element'] );
                }
             }
           }
        }

    }

    /**
     * Render custom breadcrumbs.
     *
     * @since 1.0.0
     * @access private
     *
     * @return void
     **/
    private function generate_custom_breadcrumbs( $settings ) {
        foreach ( $settings['custom_breadcrumbs_list'] as $item ) {
            $this->generate_breadcrumbs_item( $settings, $item['custom_breadcrumb_name'], $item['custom_breadcrumb_link']['url'], $item['is_active_custom_breadcrumb'] === 'yes','',
                $item['custom_breadcrumbs_icon'], $item['custom_breadcrumbs_icon_position'], $item['show_custom_item_icon'] );
        }
    }

    /**
     * Render Frontend Output. Generate the final HTML on the frontend.
     *
     * @access protected
     *
     * @return void
     **/
    protected function render() {
        $settings = $this->get_settings_for_display();
        set_transient( 'plugin_id', $this->get_id() );
        $display = true;

        ?>
        <!-- Start Crumber for Elementor WordPress Plugin -->
        <?php if ( $display ): ?>
        <div class="mdp-crumber-elementor-box">
            <div class="mdp-crumber-elementor-breadcrumbs">
                <?php
                    if ( $settings['custom_breadcrumbs'] === 'yes' ) {
                        $this->generate_custom_breadcrumbs( $settings );
                    } else {
                        $this->generate_breadcrumbs( $settings );
                    }
                ?>
            </div>
        </div>
        <?php endif; ?>
        <!-- End Crumber for Elementor WordPress Plugin -->
	    <?php

    }

	/**
	 * Selection Pro Section
	 */
	private function section_content_pro() {

		$this->start_controls_section('section_content_pro', [
			'label' => esc_html__('Additional features', 'selection-lite' ),
			'tab' => Controls_Manager::TAB_CONTENT
		] );

		$this->add_control(
			'selection_pro',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Selection Lite includes only few basic widgets. Go ', 'selection-lite' ) .
				         '<a href="https://1.envato.market/selection" target="_blank">' . esc_html__( 'Selection PRO', 'selection-lite' ) . '</a>' .
				         esc_html__( ' to get more awesome widgets. Buy a license and gain access to all hidden features.', 'selection-lite' ),
				'content_classes' => 'selection-pro'
			]
		);

		$this->end_controls_section();

	}

    /**
     * Return link for documentation
     * Used to add stuff after widget
     *
     * @access public
     *
     * @return string
     **/
    public function get_custom_help_url() {

        return 'https://docs.merkulov.design/tag/crumber';

    }

}
