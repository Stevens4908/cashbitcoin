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

use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Exception;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Merkulove\SelectionLite\Unity\Plugin as UnityPlugin;

/** @noinspection PhpUnused */
/**
 * Logar - Custom Elementor Widget.
 **/
class logar_elementor extends Widget_Base {

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
        wp_register_style( 'mdp-logar-elementor', UnityPlugin::get_url() . 'css/logar-elementor' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );

    }

    /**
     * Return a widget name.
     *
     * @return string
     **/
    public function get_name() {

        return 'mdp-logar-elementor';

    }

    /**
     * Return the widget title that will be displayed as the widget label.
     *
     * @return string
     **/
    public function get_title() {

        return esc_html__( 'Site logo', 'selection-lite' );

    }

    /**
     * Set the widget icon.
     *
     * @return string
     */
    public function get_icon() {

        return 'mdp-logar-elementor-widget-icon';

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

        return [ 'Merkulove', 'Site logo' ];

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

        return [ 'mdp-logar-elementor', 'mdp-selection-elementor-admin', 'elementor-icons-fa-solid', 'elementor-icons' ];

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
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function tab_content() {

        /** Content -> Logo Content Section. */
        $this->section_content_logo();

	    /** Pro Content */
	    $this->section_content_pro();

    }

    /**
     * Add widget controls on Style tab.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function tab_style() {

        /** Style -> Section Style Logo. */
        $this->section_style_logo();

        /** Style -> Section Style Logo Image. */
        $this->section_style_logo_image();

        /** Style -> Section Style Logo Text Type. */
        $this->section_style_logo_text();

    }

    /**
     * Add widget controls: Content -> Logo Content Section.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_content_logo() {

        $this->start_controls_section( 'section_content_logo', [
            'label' => esc_html__( 'Logo', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_CONTENT
        ] );

        $this->add_control(
            'custom_logo',
            [
                'label' => esc_html__( 'Custom logo', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'custom_logo_type',
            [
                'label' => esc_html__( 'Custom logo type', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'image',
                'label_block' => true,
                'options' => [
                    'image'  => esc_html__( 'Image', 'selection-lite' ),
                    'text'  => esc_html__( 'Text', 'selection-lite' ),
                ],
                'condition' => [
                    'custom_logo' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'custom_logo_text',
            [
                'label' => esc_html__( 'Text', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your text logo here', 'selection-lite' ),
                'condition' => [
                    'custom_logo_type' => 'text',
                    'custom_logo' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'custom_logo_image',
            [
                'label' => esc_html__( 'Choose Image', 'selection-lite' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'custom_logo_type' => 'image',
                    'custom_logo' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'medium',
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                       [
                           'name' => 'custom_logo',
                           'operator' => '!==',
                           'value' => 'yes'
                       ],
                       [
                           'name' => 'custom_logo_type',
                           'operator' => '!==',
                           'value' => 'text'
                       ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'logo_alignment',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-logar-elementor-site-logo' => 'justify-content: {{VALUE}}'
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'selection-lite' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'separator' => 'after',
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
     * @since 1.0
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
    }

    /**
     * Function for generating typography and tabs controls.
     *
     * @param $section_id
     * @param $html_class
     * @param bool $include_color
     * @param bool $include_bg
     * @param bool $include_css_filter
     * @param bool $include_typography
     * @param bool $include_transition
     * @param string $additional_color_class
     * @param string $additional_color_hover_class
     * @return void
     * @since 1.0
     * @access private
     */
    private function generate_typography_tabs_controls( $section_id, $html_class, $include_color = true,
                                                        $include_bg = true, $include_css_filter = false, $include_typography = true, $include_transition = true,
                                                        $additional_color_class = '', $additional_color_hover_class = '' ) {

        if ( $include_typography ) {
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => $section_id . '_typography',
                    'label' => esc_html__('Typography', 'selection-lite'),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => "{{WRAPPER}} .$html_class",
                ]
            );
        }

        $this->start_controls_tabs( $section_id.'_style_tabs' );

        $this->start_controls_tab( $section_id.'_normal_style_tab', ['label' => esc_html__( 'NORMAL', 'selection-lite' )] );

        if ( $include_color ) {

            $this->add_control(
                $section_id . '_normal_text_color',
                [
                    'label' => esc_html__('Color', 'selection-lite'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_3,
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .$html_class, {{WRAPPER}} .$additional_color_class" => 'color: {{VALUE}} !important;',
                    ],
                ]
            );

        }

        if ( $include_css_filter ) {
            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name' => 'css_filters_normal',
                    'selector' => '{{WRAPPER}} .'.$html_class,
                ]
            );

        }

        if ( $include_bg ) {

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $section_id . '_normal_background',
                    'label' => esc_html__('Background type', 'selection-lite'),
                    'types' => ['classic', 'gradient', 'video'],
                    'selector' => "{{WRAPPER}} .$html_class",
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
                'selector' => "{{WRAPPER}} .$html_class",
            ]
        );

        $this->add_responsive_control(
            $section_id.'_border_radius_normal',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    "{{WRAPPER}} .$html_class" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $section_id.'_box_shadow_normal',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .$html_class",
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab( $section_id.'_hover_style_tab', ['label' => esc_html__( 'HOVER', 'selection-lite' )] );

        if ( $include_color ) {
            $this->add_control(
                $section_id . '_hover_color',
                [
                    'label' => esc_html__('Color', 'selection-lite'),
                    'type' => Controls_Manager::COLOR,
                    'scheme' => [
                        'type' => Color::get_type(),
                        'value' => Color::COLOR_3,
                    ],
                    'selectors' => [
                        "{{WRAPPER}} .$html_class:hover, {{WRAPPER}} .$additional_color_hover_class" => 'color: {{VALUE}} !important;',
                    ],
                ]
            );
        }

        if ( $include_bg ) {
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => $section_id . '_background_hover',
                    'label' => esc_html__('Background type', 'selection-lite'),
                    'types' => ['classic', 'gradient', 'video'],
                    'selector' => "{{WRAPPER}} .$html_class:hover",
                ]
            );
        }

        if ( $include_css_filter ) {
            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name' => 'css_filters_hover',
                    'selector' => '{{WRAPPER}} .'.$html_class.':hover',
                ]
            );
        }

        if ( $include_transition ) {
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
                        '{{WRAPPER}} .'.$html_class => 'transition: color {{SIZE}}{{UNIT}}, background {{SIZE}}{{UNIT}}, box-shadow {{SIZE}}{{UNIT}}, border-radius {{SIZE}}{{UNIT}}, border {{SIZE}}{{UNIT}}, filter {{SIZE}}{{UNIT}};',
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
                'selector' => "{{WRAPPER}} .$html_class:hover",
            ]
        );

        $this->add_responsive_control(
            $section_id.'_border_radius_hover',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    "{{WRAPPER}} .$html_class:hover" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $section_id.'_box_shadow_hover',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => "{{WRAPPER}} .$html_class:hover",
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    /**
     * Add widget controls: Style -> Section Style Logo.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_style_logo() {

        $this->start_controls_section( 'section_style_logo', [
            'label' => esc_html__( 'Logo', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_STYLE
        ] );

       $this->generate_margin_padding_controls( 'section_style_logo', 'mdp-logar-elementor-site-logo' );

        $this->add_responsive_control(
            'logo_height',
            [
                'label' => esc_html__( 'Height', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-logar-elementor-site-logo' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__( 'Width', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-logar-elementor-site-logo' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->generate_typography_tabs_controls( 'section_style_logo', 'mdp-logar-elementor-site-logo', false, true, false,
            false );

        $this->end_controls_section();
    }

    /**
     * Add widget controls: Style -> Section Style Logo Image.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_style_logo_image()
    {

        $this->start_controls_section( 'section_style_logo_image', [
            'label' => esc_html__( 'Logo Image', 'selection-lite' ),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                    'custom_logo_type!' => 'text'
            ]
        ] );

        $this->generate_typography_tabs_controls( 'section_style_logo_image', 'mdp-logar-elementor-site-logo img', false, false, true, false );

        $this->end_controls_section();

    }

    /**
     * Add widget controls: Style -> Section Style Logo Text Type.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_style_logo_text()
    {

        $this->start_controls_section( 'section_style_logo_text_type', [
            'label' => esc_html__( 'Logo Text Type', 'selection-lite' ),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                    'custom_logo' => 'yes',
                    'custom_logo_type' => 'text'
            ]
        ] );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'section_style_logo_text_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' =>  Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-logar-elementor-logo-text',
            ]
        );

        $this->start_controls_tabs('control_style_tabs');

        $this->start_controls_tab( 'normal_style_tab', ['label' => esc_html__( 'NORMAL', 'selection-lite' )] );

        $this->add_control(
            'style_logo_text_color',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-logar-elementor-logo-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow_normal',
                'label' => esc_html__( 'Text Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-logar-elementor-logo-text',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover_style_tab', ['label' => esc_html__( 'HOVER', 'selection-lite' )] );

        $this->add_control(
            'style_logo_text_color_hover',
            [
                'label' => esc_html__( 'Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-logar-elementor-logo-text:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'text_logo_hover_transition',
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
                    '{{WRAPPER}} .mdp-logar-elementor-logo-text' => 'transition: color {{SIZE}}{{UNIT}}, text-shadow {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow_hover',
                'label' => esc_html__( 'Text Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-logar-elementor-logo-text:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * Site logo block.
     *
     * @access private
     *
     * @param $settings
     * @param $custom_size
     * @return void
     */
    private function site_logo_block( $settings, $custom_size ) {
        ?>
        <div class="mdp-logar-elementor-site-logo">
            <?php if ( $settings['custom_logo'] === 'yes' && $settings['custom_logo_type'] === 'text' ): ?>
                <div class="mdp-logar-elementor-logo-text elementor-animation-<?php esc_attr_e( $settings['hover_animation'] ); ?>"><?php esc_html_e( $settings['custom_logo_text'] ); ?></div>
            <?php elseif ( $settings['custom_logo'] === 'yes' && $settings['custom_logo_type'] === 'image' ): ?>
                <?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_size', 'custom_logo_image' ) ); ?>
            <?php else: ?>
                <img class="elementor-animation-<?php esc_attr_e( $settings['hover_animation'] ); ?>" src="<?php echo esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), $settings['image_size_size'] === 'custom'
                    ? $custom_size
                    : $settings['image_size_size'], true )[0] ) ?>" alt="">
            <?php endif; ?>
        </div>
        <?php
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

        //setting custom size of not custom site logo
        $custom_size = [];
        if ( $settings['image_size_size'] === 'custom' && $settings['custom_logo'] !== 'yes' ) {
            require_once ELEMENTOR_PATH . 'includes/libraries/bfi-thumb/bfi-thumb.php';
            $custom_size = [
                0 => $settings['image_size_custom_dimension']['width'],
                1 => $settings['image_size_custom_dimension']['height'],

                'bfi_thumb' => true,
                'crop' => true,
            ];
        }
        ?>
        <!-- Start Logar for Elementor WordPress Plugin -->
        <div class="mdp-logar-elementor-box">
            <?php if ( $settings['custom_logo_type'] !== 'text' ): ?>
                <figure class="mdp-logar-elementor-caption-figure">
            <?php endif; ?>
            <a href="<?php echo esc_url( site_url() ) ?>"
                <div class="mdp-logar-elementor-site-logo-wrapper">
                    <?php $this->site_logo_block( $settings, $custom_size ) ?>
                </div>
            </a>
            <?php if ( $settings['custom_logo_type'] !== 'text'  ): ?>
                </figure>
            <?php endif; ?>
        </div>
        <!-- End Logar for Elementor WordPress Plugin -->
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

        return 'https://docs.merkulov.design/tag/logar';

    }

}
