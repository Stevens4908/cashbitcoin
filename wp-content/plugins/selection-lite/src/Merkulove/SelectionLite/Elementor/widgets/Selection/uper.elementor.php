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
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Exception;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Merkulove\SelectionLite\Unity\Plugin as UnityPlugin;

/** @noinspection PhpUnused */
/**
 * Uper - Custom Elementor Widget.
 **/
class uper_elementor extends Widget_Base {

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
        wp_register_style( 'mdp-uper-elementor', UnityPlugin::get_url() . 'css/uper-elementor' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );
	    wp_register_script( 'mdp-uper-elementor', UnityPlugin::get_url() . 'js/uper-elementor' . UnityPlugin::get_suffix() . '.js', [ 'elementor-frontend' ], UnityPlugin::get_version(), true );

    }

    /**
     * Return a widget name.
     *
     * @return string
     **/
    public function get_name() {

        return 'mdp-uper-elementor';

    }

    /**
     * Return the widget title that will be displayed as the widget label.
     *
     * @return string
     **/
    public function get_title() {

        return esc_html__( 'Scroll to top', 'selection-lite' );

    }

    /**
     * Set the widget icon.
     *
     * @return string
     */
    public function get_icon() {

        return 'mdp-uper-elementor-widget-icon';

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

        return [ 'Merkulove', 'Scroll to top' ];

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

        return [ 'mdp-uper-elementor', 'mdp-selection-elementor-admin', 'elementor-icons-fa-solid', 'elementor-icons' ];

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

		return [ 'mdp-uper-elementor' ];

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

        /** Content -> Button Section. */
        $this->section_content_button();

        /** Content -> Button Content Section. */
        $this->section_content_button_content();

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

        /** Style -> Section Style Button. */
        $this->section_style_button();

    }

    /**
     * Add widget controls: Content -> Button Section.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_content_button() {

        $this->start_controls_section( 'section_content_button', [
            'label' => esc_html__( 'Button', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_CONTENT
        ] );

        $this->add_control(
            'alignment',
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
                'condition' => [
                        'fixed!' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-box' => 'text-align: {{VALUE}}'
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'fixed',
            [
                'label' => esc_html__( 'Fixed', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'selection-lite' ),
                'label_off' => esc_html__( 'No', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'fixed_button_position',
            [
                'label' => esc_html__( 'Fixed position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => [
                    'top-left'  => esc_html__( 'Top left', 'selection-lite' ),
                    'top-center' => esc_html__( 'Top center', 'selection-lite' ),
                    'top-right' => esc_html__( 'Top right', 'selection-lite' ),
                    'left-center' => esc_html__( 'Left center', 'selection-lite' ),
                    'right-center' => esc_html__( 'Right center', 'selection-lite' ),
                    'bottom-left' => esc_html__( 'Bottom left', 'selection-lite' ),
                    'bottom-center' => esc_html__( 'Bottom center', 'selection-lite' ),
                    'bottom-right' => esc_html__( 'Bottom right', 'selection-lite' ),
                ],
                'condition' => [
                        'fixed' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'auto_hide',
            [
                'label' => esc_html__( 'Auto hide', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                        'fixed' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'auto_hide_after',
            [
                'label' => esc_html__( 'Auto hide after', 'selection-lite' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 10,
                'condition' => [
                        'auto_hide' => 'yes',
                        'fixed' => 'yes'
                ],
                'description' => wp_kses_post( 'Specify after how many seconds button will disappear' ),
            ]
        );

        $this->add_control(
            'start_displaying_button_position',
            [
                'label' => esc_html__( 'Start displaying button position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'pixels',
                'label_block' => true,
                'options' => [
                    'pixels'  => esc_html__( 'Pixels', 'selection-lite' ),
                    'percentage' => esc_html__( 'Percentage', 'selection-lite' ),
                    'custom-element' => esc_html__( 'Custom element', 'selection-lite' ),
                    'always-show' => esc_html__( 'Always show', 'selection-lite' )
                ],
                'condition' => [
                    'fixed' => 'yes'
                ]
            ]
        );


        $this->add_control(
            'start_displaying_button_position_pixels',
            [
                'label' => esc_html__( 'Pixels', 'selection-lite' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000,
                'step' => 1,
                'default' => 100,
                'condition' => [
                    'start_displaying_button_position' => 'pixels',
                    'fixed' => 'yes'
                ]
            ]
        );


        $this->add_control(
            'start_displaying_button_position_percentage',
            [
                'label' => esc_html__( 'Percentage', 'selection-lite' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 10,
                'condition' => [
                    'start_displaying_button_position' => 'percentage',
                    'fixed' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'start_displaying_button_position_element',
            [
                'label' => esc_html__( 'Element ID', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type element id here', 'selection-lite' ),
                'separator' => 'after',
                'condition' => [
                    'start_displaying_button_position' => 'custom-element',
                    'fixed' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Add widget controls: Content -> Button Content Section.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_content_button_content() {
        $this->start_controls_section('section_content_button_content', [
            'label' => esc_html__('Button content', 'selection-lite'),
            'tab' => Controls_Manager::TAB_CONTENT
        ] );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button text', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Up', 'selection-lite' ),
                'placeholder' => esc_html__( 'Type button text here', 'selection-lite' ),
            ]
        );

        $this->add_control(
            'button_text_alignment',
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
                        '{{WRAPPER}} .mdp-uper-elementor-button' => 'justify-content: {{VALUE}}'
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__( 'Button icon', 'selection-lite' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-long-arrow-alt-up',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_control(
            'button_icon_position',
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
                    'under-right' => esc_html__( 'Under right', 'selection-lite' )
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Add widget controls: Style -> Section Style Button.
     *
     * @since 1.0
     * @access private
     *
     * @return void
     **/
    private function section_style_button() {

        $this->start_controls_section( 'section_style_button', [
            'label' => esc_html__( 'Button', 'selection-lite' ),
            'tab'   => Controls_Manager::TAB_STYLE
        ] );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__( 'Margin', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__( 'Padding', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'separator' => 'after',
                'default' => [
                    'top' => '10',
                    'right' => '25',
                    'bottom' => '10',
                    'left' => '25',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon spacing', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon size', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .mdp-uper-elementor-button-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_title_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' =>  Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-text-wrapper',
            ]
        );

        $this->start_controls_tabs('control_style_tabs');

        $this->start_controls_tab( 'normal_style_tab', ['label' => esc_html__( 'NORMAL', 'selection-lite' )] );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Text color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => esc_html__( 'Background type', 'selection-lite' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_button_normal',
                'label' => esc_html__( 'Border Type', 'selection-lite' ),
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius_normal',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_normal',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover_style_tab', ['label' => esc_html__( 'HOVER', 'selection-lite' )] );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__( 'Text color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button:hover .mdp-uper-elementor-button-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__( 'Icon color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button:hover .mdp-uper-elementor-button-icon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover',
                'label' => esc_html__( 'Background type', 'selection-lite' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button:hover',
            ]
        );


        $this->add_control(
            'button_hover_transition',
            [
                'label' => esc_html__( 'Hover transition', 'selection-lite' ),
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
                    '{{WRAPPER}} .mdp-uper-elementor-button' => 'transition: color {{SIZE}}{{UNIT}}, background {{SIZE}}{{UNIT}}, box-shadow {{SIZE}}{{UNIT}}, border-radius {{SIZE}}{{UNIT}}, border {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_button_hover',
                'label' => esc_html__( 'Border Type', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button:hover',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius_hover',
            [
                'label' => esc_html__( 'Border radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-uper-elementor-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'label' => esc_html__( 'Box Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-uper-elementor-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

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
        ?>
        <!-- Start Uper for Elementor WordPress Plugin -->
        <div class="mdp-uper-elementor-box"
         <?php if ( $settings['start_displaying_button_position'] === 'pixels' || $settings['start_displaying_button_position'] === 'percentage' ): ?>
            data-offset="<?php $settings['start_displaying_button_position'] === 'pixels' ? esc_attr_e( $settings['start_displaying_button_position_pixels'] ) : esc_attr_e( $settings['start_displaying_button_position_percentage'] ); ?>"
         <?php endif; ?>
            data-offset-type="<?php esc_attr_e( $settings['start_displaying_button_position'] ); ?>"
         <?php if ( $settings['start_displaying_button_position'] === 'custom-element' ): ?>
            data-custom-element-id="<?php esc_attr_e( $settings['start_displaying_button_position_element'] ); ?>"
         <?php endif; ?>
         <?php if( $settings['auto_hide'] === 'yes' ): ?>
            data-autohide="<?php esc_attr_e( $settings['auto_hide'] ); ?>"
            data-autohide-seconds="<?php esc_attr_e( $settings['auto_hide_after'] ); ?>"
         <?php endif; ?>
             data-scroll-to="top"
             data-scroll-speed="1"
             data-scroll-easing="smooth"
             data-is-fixed="<?php esc_attr_e( $settings['fixed'] ); ?>"
             data-scroll-indicator=""
        >
                <div class="mdp-uper-elementor-button <?php if( $settings['fixed'] === 'yes' ):  ?>
                mdp-uper-elementor-button-fixed mdp-uper-elementor-button-fixed-position-<?php esc_attr_e( $settings['fixed_button_position'] ); ?>  <?php endif; ?>">
                 <div class="mdp-uper-elementor-text-wrapper mdp-uper-elementor-icon-position-<?php esc_attr_e( $settings['button_icon_position'] ); ?>">
                     <div class="mdp-uper-elementor-button-icon">
                         <?php Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                     </div>
                     <div class="mdp-uper-elementor-button-title">
                         <?php esc_attr_e( $settings['button_text'] ); ?>
                     </div>
                 </div>
            </div>
        </div>
        <?php if( $settings['fixed'] === 'yes' ): ?>
            <style>
                .elementor-element-<?php esc_html_e( $this->get_id() ); ?> .elementor-widget-empty-icon {
                    padding: 0 !important;
                }

                .elementor-widget-mdp-uper-elementor {
                    animation: 0;
                }

            </style>
        <?php endif; ?>
        <!-- End Uper for Elementor WordPress Plugin -->
        <?php
        if ( is_admin() ) {
            $widget_hash = substr( hash( 'ripemd160', date('l jS \of F Y h:i:s A') ), rand( 0 , 20 ), 3 ) . rand( 11 , 99 );
            ?>
            <!--suppress JSUnresolvedFunction -->
            <script>
                try {
                    uperReady<?php esc_attr_e( $widget_hash ); ?>( mdpUper.addUper.bind( mdpUper ) );
                } catch ( msg ) {
                    const uperReady<?php esc_attr_e( $widget_hash ); ?> = ( callback ) => {
                        'loading' !== document.readyState ?
                            callback() :
                            document.addEventListener( 'DOMContentLoaded', callback );
                    };
                    uperReady<?php esc_attr_e( $widget_hash ); ?>( mdpUper.addUper.bind( mdpUper ) );
                }
            </script>
	    <?php
        }
    }


    /**
     * JS Render.
     *
     * @access protected
     *
     * @return void
     **/
    function content_template()
    {
        ?>
        <!-- Start Uper for Elementor WordPress Plugin -->
        <div class="mdp-uper-elementor-box"
            <# if( settings.start_displaying_button_position === 'pixels' || settings.start_displaying_button_position === 'percentage' ) { #>
                data-offset="<# if ( settings.start_displaying_button_position === 'pixels' ) { #>
                        {{{ settings.start_displaying_button_position_pixels }}}
                <# } else { #>
                    {{{ settings.start_displaying_button_position_percentage }}}
                <# } #>"
            <#}#>
             data-offset-type="{{{ settings.start_displaying_button_position }}}"
            <# if ( settings.start_displaying_button_position === 'custom-element' ) { #>
                data-custom-element-id="{{{ settings.start_displaying_button_position_element }}}"
            <# } #>
            <# if ( settings.auto_hide === 'yes' ) { #>
                data-autohide="{{{ settings.auto_hide }}}"
                data-autohide-seconds="{{{ settings.auto_hide_after }}}"
            <# } #>
             data-scroll-to="top"
             data-scroll-speed="1"
             data-is-fixed="{{{ settings.fixed }}}"
             data-scroll-indicator=""
            >
            <div class="mdp-uper-elementor-button <# if ( settings.fixed === 'yes' ) { #>
                mdp-uper-elementor-button-fixed mdp-uper-elementor-button-fixed-position-{{{ settings.fixed_button_position }}} <# } #>">
                <div class="mdp-uper-elementor-text-wrapper mdp-uper-elementor-icon-position-{{{ settings.button_icon_position }}}">
                    <div class="mdp-uper-elementor-button-icon">
                        <# var iconHTML = elementor.helpers.renderIcon( view, settings.button_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
                        <# if ( !iconHTML.rendered ) { #>
                            <i class="{{{ settings.button_icon.value }}}" ></i>
                        <# } else { #>
                            {{{ iconHTML.value }}}
                        <# } #>
                    </div>
                    <div class="mdp-uper-elementor-button-title">
                        {{{ settings.button_text }}}
                    </div>
                </div>
            </div>
        </div>
        <# if ( settings.fixed === 'yes' ) { #>
        <style>
            .elementor-element-<?php esc_html_e( $this->get_id() ); ?> .elementor-widget-empty-icon {
                padding: 0 !important;
            }

            .elementor-widget-mdp-uper-elementor {
                animation: 0;
            }
        </style>
        <# } #>
        <!-- End Uper for Elementor WordPress Plugin -->
        <?php
        if ( is_admin() ) {
            $widget_hash = substr( hash( 'ripemd160', date('l jS \of F Y h:i:s A') ), rand( 0 , 20 ), 3 ) . rand( 11 , 99 );
            ?>
            <!--suppress JSUnresolvedFunction -->
            <script>
                try {
                    uperReady<?php esc_attr_e( $widget_hash ); ?>( mdpUper.addUper.bind( mdpUper ) );
                } catch ( msg ) {
                    const uperReady<?php esc_attr_e( $widget_hash ); ?> = ( callback ) => {
                        'loading' !== document.readyState ?
                            callback() :
                            document.addEventListener( 'DOMContentLoaded', callback );
                    };
                    uperReady<?php esc_attr_e( $widget_hash ); ?>( mdpUper.addUper.bind( mdpUper ) );
                }
            </script>
            <?php
        }
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

        return 'https://docs.merkulov.design/tag/uper';

    }

}
