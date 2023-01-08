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

use Exception;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Controls_Manager;
use Merkulove\SelectionLite\Unity\Plugin as UnityPlugin;

/** @noinspection PhpUnused */
/**
 * Headinger - Custom Elementor Widget.
 **/
class headinger_elementor extends Widget_Base {

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
        wp_register_style( 'mdp-headinger-elementor', UnityPlugin::get_url() . 'css/headinger-elementor' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );

    }

    /**
     * Return a widget name.
     *
     * @return string
     **/
    public function get_name() {

        return 'mdp-headinger-elementor';

    }

    /**
     * Return the widget title that will be displayed as the widget label.
     *
     * @return string
     **/
    public function get_title() {

        return esc_html__( 'Heading', 'selection-lite' );

    }

    /**
     * Set the widget icon.
     *
     * @return string
     */
    public function get_icon() {

        return 'mdp-headinger-elementor-widget-icon';

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

        return [ 'Merkulove', 'Heading', 'Title', 'Headline', 'Heading' ];

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

        return [ 'mdp-headinger-elementor', 'mdp-selection-elementor-admin', 'elementor-icons-fa-solid', 'elementor-icons' ];

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

		return [];

    }

    /**
     * Content Section – Header Section
     */
    private function content_header() {

        /** Header tab. */
        $this->start_controls_section(
            'section_header',
            [ 'label' => esc_html__( 'Header', 'selection-lite' ) ]
        );

        /** Header text. */
        $this->add_control(
            'header_text',
            [
                'label' => esc_html__( 'Header', 'selection-lite' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__( 'Heading', 'selection-lite' ),
                'placeholder' => esc_html__( 'Heading', 'selection-lite' ),
            ]
        );

        /** Heading link. */
        $this->add_control(
            'heading_link',
            [
                'label' => esc_html__( 'Link', 'selection-lite' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://codecanyon.net/user/merkulove', 'selection-lite' ),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        /** HTML Tag. */
        $this->add_control(
            'header_tag',
            [
                'label' => esc_html__( 'HTML Tag', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        /** Header word breaker. */
        $this->add_control(
            'header_word_break',
            [
                'label' => esc_html__( 'Word break', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'selection-lite' ),
                'label_off' => esc_html__( 'Off', 'selection-lite' ),
                'return_value' => 'word-break: break-all',
                'selectors' => [
                    '{{WRAPPER}} .mdp-header-text' => '{{VALUE}}',
                ],
            ]
        );

        /** Header line. */
        $this->add_control(
            'header_line',
            [
                'label' => esc_html__( 'Line', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
                'separator' => 'after'
            ]
        );

        /** Split header. */
        $this->add_control(
            'header_split',
            [
                'label' => esc_html__( 'Split header', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
            ]
        );

        /** Split text. */
        $this->add_control(
            'split_text',
            [
                'label' => esc_html__( 'Split text', 'selection-lite' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__( 'Split text', 'selection-lite' ),
                'placeholder' => esc_html__( 'Split text', 'selection-lite' ),
                'condition'  => ['header_split' => 'yes'],
                'separator' => 'after'
            ]
        );

        /** Show Subheader. */
        $this->add_control(
            'show_subheader',
            [
                'label' => esc_html__( 'Subheader', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
            ]
        );

        /** Show Content Header. */
        $this->add_control(
            'show_content_header',
            [
                'label' => esc_html__( 'Additional Header', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
            ]
        );

        /** End section content. */
        $this->end_controls_section();

    }

    /**
     * Content Tab - Subheader Section
     */
    private function content_subheader() {

        /** Subheader. */
        $this->start_controls_section(
            'section_subheader',
            [
                'label' => esc_html__( 'Subheader', 'selection-lite' ),
                'condition'   => ['show_subheader' => 'yes' ]
            ]
        );

        /** Subheader. */
        $this->add_control(
            'sub_heading',
            [
                'label' => esc_html__( 'Subheader', 'selection-lite' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => esc_html__( 'Subheader', 'selection-lite' ),
                'placeholder' => esc_html__( 'Subheader', 'selection-lite' ),
            ]
        );

        /** Subheader bottom. */
        $this->add_control(
            'header_bottom',
            [
                'label' => esc_html__( 'Subheader bottom', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
            ]
        );

        /** Header word breaker. */
        $this->add_control(
            'subheader_word_break',
            [
                'label' => esc_html__( 'Word break', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'selection-lite' ),
                'label_off' => esc_html__( 'Off', 'selection-lite' ),
                'return_value' => 'word-break: break-all',
                'selectors' => [
                    '{{WRAPPER}} .mdp-sub-heading' => '{{VALUE}}',
                ],
            ]
        );

        /** Header line. */
        $this->add_control(
            'subheader_line',
            [
                'label' => esc_html__( 'Line', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes'
            ]
        );

        /** End section content. */
        $this->end_controls_section();

    }

    /**
     * Add the widget controls.
     *
     * @since 1.0
     * @access protected
     *
     * @return void with category names
     **/
    protected function register_controls() {

        /** Content Header */
        $this->content_header();

        /** Content Subheader */
        $this->content_subheader();

        /** Content header. */
        $this->start_controls_section( 'section_content',
            [
                'label' => esc_html__( 'Additional Header', 'selection-lite' ),
                'condition'   => ['show_content_header' => 'yes' ]
            ] );

        /** Sub heading. */
        $this->add_control(
            'text_content_heading',
            [
                'label' => esc_html__( 'Text', 'selection-lite' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 10,
                'separator' => 'before',
                'default' => esc_html__( 'Additional Header', 'selection-lite' ),
                'placeholder' => esc_html__( 'Additional Header', 'selection-lite' ),
            ]
        );

        /** End section content. */
        $this->end_controls_section();

	    /** Pro Content */
	    $this->section_content_pro();

        /** Style header tab. */
        $this->start_controls_section( 'style_header', [ 'label' => esc_html__( 'Header', 'selection-lite' ), 'tab' => Controls_Manager::TAB_STYLE, ] );

        $this->start_controls_tabs('tabs_header_style');

        /** Text style tab. */
        $this->start_controls_tab(
            'tab_style_text',
            [
                'label' => esc_html__('Text style', 'selection-lite')
            ]
        );

        /** Color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'color_header',
            [
                'label' => esc_html__( 'Text Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'color: {{VALUE}}',
                ],
                'default' => '#333333'
            ]
        );

	    $this->add_control(
		    'color_stroke',
		    [
			    'label' => esc_html__( 'Stroke Color', 'selection-lite' ),
			    'type' => Controls_Manager::COLOR,
			    'selectors' => [
				    '{{WRAPPER}} .mdp-typography-default-header' => '-webkit-text-stroke: {{stroke_size.size}}{{stroke_size.unit}} {{value}}',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'stroke_size',
		    [
			    'label' => esc_html__( 'Stroke Size', 'selection-lite' ),
			    'type' => Controls_Manager::SLIDER,
			    'selectors' => [
				    '{{WRAPPER}} .mdp-typography-default-header' => '-webkit-text-stroke: {{SIZE}}{{UNIT}} {{color_stroke.value}};',
			    ],
                'separator' => 'after'
		    ]
	    );

        /** Typography. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-typography-header',
            ]
        );

        /** Shadow. */
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'header_shadow',
                'label' => esc_html__( 'Text Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-shadow-header',
            ]
        );

        /** Alignment. */
        $this->add_responsive_control(
            'header_align',
            [
                'label' => esc_html__( 'Alignment', 'selection-lite' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'selection-lite' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'selection-lite' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'selection-lite' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mdp-header-align' => 'text-align: {{header_align}};',
                ],
                'toggle' => true,
            ]
        );

        $this->end_controls_tab();

        /** Box tab. */
        $this->start_controls_tab(
            'tab_style_box',
            [
                'label' => esc_html__('Box style', 'selection-lite')
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'header_background',
                'label' => esc_html__( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .mdp-headinger-box-style',
            ]
        );

        /** Background effect. */
        $this->add_control(
            'header_background_effect',
            [
                'label' => esc_html__( 'Inner Background', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
            ]
        );

        /** Border type. */
        $this->add_control(
            'header_border_type',
            [
                'label' => esc_html__( 'Border', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'  => esc_html__( 'None', 'selection-lite' ),
                    'double' => esc_html__( 'Double', 'selection-lite' ),
                    'dashed' => esc_html__( 'Dashed', 'selection-lite' ),
                    'dotted' => esc_html__( 'Dotted', 'selection-lite' ),
                    'solid' => esc_html__( 'Solid', 'selection-lite' ),
                    'grove' => esc_html__( 'Groove', 'selection-lite' ),
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'border-style: {{VALUE}}',
                ],
            ]
        );

        /** Border color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'border_color_header',
            [
                'label' => esc_html__( 'Border color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'border-color: {{VALUE}}',
                ],
                'default' => '#333333',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'header_border_type',
                            'operator' => '!in',
                            'value' => [
                                'none',
                            ],
                        ],
                    ],
                ]
            ]
        );

        /** Border radius. */
        $this->add_responsive_control(
            'header_border_radius',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'border-radius: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'header_border_type',
                            'operator' => '!in',
                            'value' => [
                                'none',
                            ],
                        ],
                    ],
                ]
            ]
        );

        /** Border width. */
        $this->add_responsive_control(
            'header_border_width',
            [
                'label' => esc_html__( 'Border width', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'border-width: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'header_border_type',
                            'operator' => '!in',
                            'value' => [
                                'none',
                            ],
                        ],
                    ],
                ]
            ]
        );

        /** Border padding. */
        $this->add_responsive_control(
            'header_border_padding',
            [
                'label' => esc_html__( 'Border padding', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-default-header' => 'padding: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'header_border_type',
                            'operator' => '!in',
                            'value' => [
                                'none',
                            ],
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        /** Line style. */
        $this->add_control(
            'line_style',
            [
                'label' => esc_html__( 'Line style', 'selection-lite' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** Position. */
        $this->add_control(
            'header_position',
            [
                'label' => esc_html__( 'Position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'after'  => esc_html__( 'After', 'selection-lite' ),
                    'before' => esc_html__( 'Before', 'selection-lite' ),
                    'bottom' => esc_html__( 'Bottom', 'selection-lite' ),
                    'after_before' => esc_html__( 'After and Before', 'selection-lite' ),
                ],
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** Line color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'line_color_header',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#96c93d',
                'selectors' => [
                    '{{WRAPPER}} .line:after' => 'background-color: {{VALUE}};',
                ],
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** Line width. */
        $this->add_responsive_control(
            'line_width_header',
            [
                'label' => esc_html__( 'Width', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 25, ],
                'selectors' => [
                    '{{WRAPPER}} .line:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** Line height. */
        $this->add_responsive_control(
            'line_height_header',
            [
                'label' => esc_html__( 'Height', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 2, ],
                'selectors' => [
                    '{{WRAPPER}} .line:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** Line spacing. */
        $this->add_responsive_control(
            'line_spacing_header',
            [
                'label' => esc_html__( 'Spacing', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 10, ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-header-line-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mdp-header-line-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mdp-header-line-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['header_line' => 'yes' ]
            ]
        );

        /** End section style header. */
        $this->end_controls_section();

        /** Style Subheader tab. */
        $this->start_controls_section( 'style_subheader',
            [
                'label' => esc_html__( 'Subheader', 'selection-lite' ), 'tab' => Controls_Manager::TAB_STYLE,
                'condition'   => ['show_subheader' => 'yes' ]
            ]
        );

        /** Color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'subheader',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-color-sub-header' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        /** Typography. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subheader_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-typography-subheader',
            ]
        );

        /** Shadow. */
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'subheader_shadow',
                'label' => esc_html__( 'Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-shadow-subheader',
            ]
        );

        /** Alignment. */
        $this->add_responsive_control(
            'subheader_align',
            [
                'label' => esc_html__( 'Alignment', 'selection-lite' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'selection-lite' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'selection-lite' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'selection-lite' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mdp-sub-header-align' => 'text-align: {{subheader_align}};',
                ],
                'toggle' => true,
                'label_block' => true,
            ]
        );

        /** Line style. */
        $this->add_control(
            'subline_style',
            [
                'label' => esc_html__( 'Line style', 'selection-lite' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** Position. */
        $this->add_control(
            'subheader_position',
            [
                'label' => esc_html__( 'Position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'after'  => esc_html__( 'After', 'selection-lite' ),
                    'before' => esc_html__( 'Before', 'selection-lite' ),
                    'bottom' => esc_html__( 'Bottom', 'selection-lite' ),
                    'after_before' => esc_html__( 'After and Before', 'selection-lite' ),
                ],
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** Line color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'line_color_subheader',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .sub-line:after' => 'background-color: {{VALUE}};'
                ],
                'default' => '#96c93d',
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** Line width. */
        $this->add_responsive_control(
            'line_width_subheader',
            [
                'label' => esc_html__( 'Width', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 25, ],
                'selectors' => [
                    '{{WRAPPER}} .sub-line:after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** Line height. */
        $this->add_responsive_control(
            'line_height_subheader',
            [
                'label' => esc_html__( 'Height', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 2, ],
                'selectors' => [
                    '{{WRAPPER}} .sub-line:after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** Line spacing. */
        $this->add_responsive_control(
            'line_spacing_subheader',
            [
                'label' => esc_html__( 'Spacing', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [ 'unit' => 'px', 'size' => 10, ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-subheader-line-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mdp-subheader-line-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mdp-subheader-line-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition'   => ['subheader_line' => 'yes' ]
            ]
        );

        /** End section style Subheader. */
        $this->end_controls_section();

        /** Style content tab. */
        $this->start_controls_section( 'style_content',
            [
                'label' => esc_html__( 'Additional Header', 'selection-lite' ), 'tab' => Controls_Manager::TAB_STYLE,
                'condition'   => ['show_content_header' => 'yes' ]
            ]
        );

        /** Color. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_control(
            'content_color_header',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-color-content-header' => 'color: {{VALUE}}',
                ],
                'default' => 'rgba(156, 156, 156, 0.2)',
            ]
        );

        /** Typography. */
        /** @noinspection PhpUndefinedClassInspection */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_header_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-typography-content-header',
            ]
        );

        /** Shadow. */
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'content_shadow',
                'label' => esc_html__( 'Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-shadow-content',
            ]
        );

        /** Alignment. */
        $this->add_responsive_control(
            'test_advanced_align',
            [
                'label' => esc_html__( 'Alignment', 'selection-lite' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'selection-lite' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'selection-lite' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'selection-lite' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mdp-text-content-align' => 'text-align: {{subheader_align}};',
                ],
                'toggle' => true,
                'label_block' => true,
            ]
        );

        /** Transform origin */
        $this->add_control(
            'advanced_transform_origin',
            [
                'label' => esc_html__( 'Transform origin', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'top center'  => esc_html__( 'Top Center', 'selection-lite' ),
                    'top left' => esc_html__( 'Top Left', 'selection-lite' ),
                    'top right' => esc_html__( 'Top Right', 'selection-lite' ),
                    'center center' => esc_html__( 'Center Center', 'selection-lite' ),
                    'center left' => esc_html__( 'Center Left', 'selection-lite' ),
                    'center right' => esc_html__( 'Center Right', 'selection-lite' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'selection-lite' ),
                    'bottom left' => esc_html__( 'Bottom Left', 'selection-lite' ),
                    'bottom right' => esc_html__( 'Bottom Right', 'selection-lite' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-typography-content-header' => 'transform-origin: {{advanced_transform_origin}};',
                ],
            ]
        );

        /** Rotate. */
        $this->add_responsive_control(
            'line_rotate_advanced',
            [
                'label' => esc_html__( 'Rotate', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'deg' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1
                    ],
                ],
                'default' => [ 'unit' => 'deg', 'size' => 0, ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(tablet){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_tablet.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_tablet.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(mobile){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_mobile.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_mobile.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                ],
            ]
        );

        /** X Offset. */
        $this->add_responsive_control(
            'line_xoffset_advanced',
            [
                'label' => esc_html__( 'X Offset', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ]
                ],
                'default' => [ 'unit' => 'px', 'size' => 0, ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(tablet){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_tablet.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_tablet.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(mobile){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_mobile.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_mobile.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                ],
            ]
        );

        /** Y Offset. */
        $this->add_responsive_control(
            'line_yoffset_advanced',
            [
                'label' => esc_html__( 'Y Offset', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ]
                ],
                'default' => [ 'unit' => 'px', 'size' => 0, ],
                'selectors' => [
                    '(desktop){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(tablet){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_tablet.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_tablet.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                    '(mobile){{WRAPPER}} .mdp-typography-content-header' => 'transform: translate({{line_xoffset_advanced_mobile.SIZE}}{{line_xoffset_advanced.UNIT}}, {{line_yoffset_advanced_mobile.SIZE}}{{line_yoffset_advanced.UNIT}}) rotate({{line_rotate_advanced.SIZE}}{{line_rotate_advanced.UNIT}});',
                ],
            ]
        );

        /** End section style content. */
        $this->end_controls_section();

    }

    /**
     * Render Frontend Output. Generate the final HTML on the frontend.
     *
     * @since 1.0
     * @access protected
     **/
    protected function render() {

        /** We get all the values from the admin panel. */
        $settings = $this->get_settings_for_display();

        /** We write the section style class to a variable. */
        $globalClass = 'mdp-' . $this->get_id();

        /** Heading link. */
        $url = $settings['heading_link']['url'];
        $target = $settings['heading_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['heading_link']['nofollow'] ? ' rel="nofollow"' : '';

        $this->add_render_attribute( 'sub_heading', 'class', 'mdp-sub-heading-content mdp-typography-subheader mdp-shadow-subheader mdp-color-sub-header' );

        /** Use the gradient style class where necessary. */
        $this->add_render_attribute(
            [
                'header_text' => [
                    'class' => [
                        'mdp-typography-header mdp-typography-default-header mdp-shadow-header mdp-heading-margin mdp-headinger-box-style',
                        $settings["header_background_effect"] === 'yes' ? 'mdp-header-background-effect' : '',
                    ],
                ],
            ]
        );

        $this->add_render_attribute(
            [
                'split_text' => [
                    'class' => [
                        'mdp-typography-header mdp-typography-default-header mdp-shadow-header mdp-heading-margin mdp-headinger-box-style mdp-headinger-split-text',
                        $settings["header_background_effect"] === 'yes' ? 'mdp-header-background-effect' : '',
                    ],
                ],
            ]
        );

        ?>

    <div id="<?php esc_attr_e( $globalClass ); ?>" >

        <?php if ( !wp_is_mobile() ): ?>
            <div class="mdp-content-header mdp-color-content-header mdp-text-content-align mdp-text-content-margin mdp-shadow-content">
                <div class="mdp-typography-content-header">
                    <?php esc_html_e( $settings["text_content_heading"] ); ?>
                </div>
            </div>
        <?php endif ?>

        <?php if ( $settings["show_subheader"] === 'yes' and  $settings["header_bottom"] === '' ): ?>

            <div class="mdp-sub-heading mdp-sub-header-align mdp-subheading-margin">
                <div class="mdp-sub-header-box">
                    <?php $this->add_inline_editing_attributes( 'sub_heading', 'basic' ); ?>
                    <div <?php echo $this->get_render_attribute_string( 'sub_heading' ); ?>>
                        <?php esc_html_e( $settings["sub_heading"] ); ?>
                    </div>

                    <?php if ( $settings["subheader_line"] === 'yes' ): ?>

                        <?php if ( $settings["subheader_position"] === 'before' or $settings["subheader_position"] === 'after_before' ): ?>
                            <div class="sub-line mdp-subheader-line-left mdp-typography-subheader"></div>
                        <?php endif ?>

                        <?php if ( $settings["subheader_position"] === 'after' or $settings["subheader_position"] === 'after_before' ): ?>
                            <div class="sub-line mdp-subheader-line-right mdp-typography-subheader"></div>
                        <?php endif ?>

                        <?php if ( $settings["subheader_position"] === 'bottom' ): ?>
                            <div class="sub-line mdp-subheader-line-bottom"></div>
                        <?php endif ?>

                    <?php endif ?>

                </div>
            </div>

        <?php endif ?>

        <<?php esc_attr_e( $settings["header_tag"] ); ?>  class="mdp-header-text mdp-header-align">

        <?php if (!empty($url) ): ?>
        <a href="<?php esc_html_e( $url ); ?>"
           class="mdp-color-header" <?php esc_attr_e( $target ); ?> <?php esc_attr_e( $nofollow ); ?>>
    <?php endif; ?>

        <div class="mdp-sub-header-box">
            <?php $this->add_inline_editing_attributes( 'header_text', 'none' ); ?>
            <div <?php  echo $this->get_render_attribute_string( 'header_text' ); ?>>
                <?php echo wp_kses_post( $settings["header_text"] ); ?>
            </div>

            <?php if ( $settings["header_line"] === 'yes' ): ?>

                <?php if ( $settings["header_position"] === 'before' or $settings["header_position"] === 'after_before' ): ?>
                    <div class="line mdp-header-line-left mdp-typography-header"></div>
                <?php endif ?>

                <?php if ( $settings["header_position"] === 'after' or $settings["header_position"] === 'after_before' ): ?>
                    <div class="line mdp-header-line-right mdp-typography-header"></div>
                <?php endif ?>

                <?php if ( $settings["header_position"] === 'bottom' ): ?>
                    <div class="line mdp-header-line-bottom"></div>
                <?php endif ?>

            <?php endif ?>

        </div>

        <?php $this->add_inline_editing_attributes( 'split_text', 'none' ); ?>
        <?php if ( $settings["header_split"] === 'yes' ): ?>
            <div <?php echo $this->get_render_attribute_string( 'split_text' ); ?>>
                <?php esc_html_e( $settings["split_text"] ); ?>
            </div>
        <?php endif ?>

        <?php if (!empty($url) ): ?>
        </a>
    <?php endif; ?>

        </<?php esc_attr_e( $settings["header_tag"] ); ?>>

        <?php if ( $settings["show_subheader"] === 'yes' and  $settings["header_bottom"] === 'yes' ): ?>

            <div class="mdp-sub-heading mdp-sub-header-align mdp-subheading-margin">
                <div class="mdp-sub-header-box">
                    <?php $this->add_inline_editing_attributes( 'sub_heading', 'basic' ); ?>
                    <div <?php echo $this->get_render_attribute_string( 'sub_heading' ); ?>>
                        <?php esc_html_e( $settings["sub_heading"] ); ?>
                    </div>

                    <?php if ( $settings["subheader_line"] === 'yes' ): ?>

                        <?php if ( $settings["subheader_position"] === 'before' or $settings["subheader_position"] === 'after_before' ): ?>
                            <div class="sub-line mdp-subheader-line-left mdp-typography-subheader"></div>
                        <?php endif ?>

                        <?php if ( $settings["subheader_position"] === 'after' or $settings["subheader_position"] === 'after_before' ): ?>
                            <div class="sub-line mdp-subheader-line-right mdp-typography-subheader"></div>
                        <?php endif ?>

                        <?php if ( $settings["subheader_position"] === 'bottom' ): ?>
                            <div class="sub-line mdp-subheader-line-bottom"></div>
                        <?php endif ?>

                    <?php endif ?>

                </div>
            </div>

        <?php endif ?>

        </div>

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
     * Return link for documentation.
     *
     * Used to add stuff after widget.
     *
     * @since 1.0
     * @access public
     **/
    public function get_custom_help_url() {
        return 'https://docs.merkulov.design/category/headinger-elementor';
    }

}
