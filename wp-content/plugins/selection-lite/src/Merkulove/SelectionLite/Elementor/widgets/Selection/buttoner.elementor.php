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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Controls_Manager;
use Merkulove\SelectionLite\Unity\Plugin as UnityPlugin;

/** @noinspection PhpUnused */
/**
 * Buttoner - Custom Elementor Widget.
 **/
class buttoner_elementor extends Widget_Base {

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
        wp_register_style( 'mdp-buttoner-elementor', UnityPlugin::get_url() . 'css/buttoner-elementor' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );
        wp_register_style( 'animations-list', UnityPlugin::get_url() . 'css/hover' . UnityPlugin::get_suffix() . '.css', [], UnityPlugin::get_version() );


    }

    /**
     * Return a widget name.
     *
     * @return string
     **/
    public function get_name() {

        return 'mdp-buttoner-elementor';

    }

    /**
     * Return the widget title that will be displayed as the widget label.
     *
     * @return string
     **/
    public function get_title() {

        return esc_html__( 'Button', 'selection-lite' );

    }

    /**
     * Set the widget icon.
     *
     * @return string
     */
    public function get_icon() {

        return 'mdp-buttoner-elementor-widget-icon';

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

        return [ 'Merkulove', 'Button', 'button', 'buttoner', 'click', 'action', 'hover', 'shadow' ];

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

        return [ 'mdp-buttoner-elementor', 'animations-list', 'mdp-selection-elementor-admin', 'elementor-icons-fa-solid', 'elementor-icons' ];

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
     *  We return an array with style classes for rotating the button along three axes.
     *
     * @since 1.0
     * @access public
     *
     * @return array
     **/
    public function get_rotate_class() {

        return [
            '(desktop){{WRAPPER}} .mdp-buttoner-link' => 'transform: translate({{buttoner_xoffset.SIZE}}px, {{buttoner_yoffset.SIZE}}px) rotate({{buttoner_rotate.SIZE}}deg);',
            '(tablet){{WRAPPER}} .mdp-buttoner-link' => 'transform: translate({{buttoner_xoffset.SIZE}}px, {{buttoner_yoffset.SIZE}}px) rotate({{buttoner_rotate.SIZE}}deg);',
            '(mobile){{WRAPPER}} .mdp-buttoner-link' => 'transform: translate({{buttoner_xoffset.SIZE}}px, {{buttoner_yoffset.SIZE}}px) rotate({{buttoner_rotate.SIZE}}deg);',
        ];

    }

    /**
     * Register controls for multi-shadow controls in the Style Tab
     *
     * @param string $key - Key of the button style tab ( normal, hover, active )
     *
     * @since 1.0
     * @access protected
     *
     * @return void with category names
     */
    private function button_style_controls( $key ) {

        /** @var CSS pseudo class $pseudo_class */
        $pseudo_class = ':' . $key;
        if ( 'normal' === $key ) {
            $pseudo_class = '';
        }

        /** Text Color. */
        $this->add_control(
            $key . '_color',
            [
                'label' => esc_html__( 'Text Color', 'selection-lite' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class => 'color: {{VALUE}}',
                ],
            ]
        );

        /** Text Shadow. */
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => $key . '_buttoner_text_shadow',
                'label' => esc_html__( 'Text Shadow', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class,
            ]
        );

        /** Background. */
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => $key . '_background',
                'label' => esc_html__( 'Background', 'selection-lite' ),
                'types' => [ 'classic', 'gradient' ],
                'fields_options' => [
                    'color' => [
                        'scheme' => [
                            'type' => Color::get_type(),
                            'value' => Color::COLOR_4,
                        ],
                    ],
                ],
                'selector' => '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class,
            ]
        );

        /** Border. */
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $key . '_border',
                'label' => esc_html__( 'Border', 'selection-lite' ),
                'selector' => '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class,
                'separator' => 'before'
            ]
        );

        /** Border Radius. */
        $this->add_responsive_control(
            $key . '_border',
            [
                'label' => esc_html__( 'Border Radius', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class => 'border-radius: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
                ],
                'toggle' => true,
            ]
        );

        /** Padding. */
        $this->add_responsive_control(
            $key . '_padding',
            [
                'label' => esc_html__( 'Padding', 'selection-lite' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-buttoner-link' . $pseudo_class => 'padding: {{top}}{{unit}} {{right}}{{unit}} {{bottom}}{{unit}} {{left}}{{unit}};',
                ],
                'default' => [
                    'top' => '4',
                    'right' => '12',
                    'bottom' => '4',
                    'left' => '12',
                    'isLinked' => false,
                ],
                'toggle' => true,
                'separator' => 'before'
            ]
        );

    }

    /**
     * Register tab with pseudo-classes controls in the Style Tab
     *
     * @param string $key - Key of the button style tab ( normal, hover, active )
     *
     * @since 1.0
     * @access protected
     *
     * @return void with category names
     */
    private function pseudo_classes_tab( $key ) {

        $this->start_controls_tab(
            'tab_style_' . $key,
            [ 'label' => $key ]
        );

        $this->button_style_controls( $key );

        $this->end_controls_tab();

    }


    /**
     * General Tab Controls
     *
     * @since 1.0
     * @access protected
     *
     * @return void with category names
     */
    private function section_content() {

        /** Section Start */
        $this->start_controls_section('content_buttoner', [
            'label' => esc_html__( 'Button', 'selection-lite' ),
            'tab' => Controls_Manager::TAB_CONTENT,
        ] );

        /** Button Text. */
        $this->add_control(
            'text_link',
            [
                'label' => esc_html__( 'Button Text', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__( 'Button', 'selection-lite' ),
                'placeholder' => esc_html__( 'Button Text', 'selection-lite' ),
            ]
        );

        /** Link. */
        $this->add_control(
            'buttoner_link',
            [
                'label' => esc_html__( 'Link', 'selection-lite' ),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'placeholder' => esc_html__( 'Link', 'selection-lite' ),
                'show_external' => true,
                'default' => [
                    'url' => esc_url( 'https://1.envato.market/cc-merkulove' ),
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        /** Width */
        $this->add_responsive_control(
            'width_buttoner',
            [
                'label' => esc_html__( 'Width', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-buttoner-link' => 'width: {{size}}{{unit}};',
                ],
            ]
        );

        /** Alignment. */
        $this->add_responsive_control(
            'buttoner_align',
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
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'selection-lite' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors_dictionary' => [
                        'left' => 'text-align: left; width: auto',
                        'center' => 'text-align: center; width: auto',
                        'right' => 'text-align: right; width: auto',
                        'justify' => 'text-align: center; width: 100%'
                ],
                'selectors' => [
                        '{{WRAPPER}} .mdp-buttoner-container, {{WRAPPER}} .mdp-buttoner-link' => '{{VALUE}}'
                ],
                'toggle' => true,
            ]
        );

        /** Show Icon. */
        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__( 'Show Icon', 'selection-lite' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'selection-lite' ),
                'label_off' => esc_html__( 'Hide', 'selection-lite' ),
                'return_value' => 'yes',
            ]
        );

        /** Button icon. */
        $this->add_control(
            'buttoner_icon',
            [
                'label' => esc_html__( 'Button icon', 'selection-lite' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-bell',
                    'library' => 'fa-solid',
                ],
                'condition' => [ 'show_icon' => 'yes']
            ]
        );

        /** Icon position. */
        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon position', 'selection-lite' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right'  => esc_html__( 'Before', 'selection-lite' ),
                    'left' => esc_html__( 'After', 'selection-lite' ),
                    'bottom' => esc_html__( 'Top', 'selection-lite' ),
                    'top' => esc_html__( 'Bottom', 'selection-lite' ),
                ],
                'condition' => [ 'show_icon' => 'yes']
            ]
        );

        /** Icon spacing */
        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__( 'Icon spacing', 'selection-lite' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mdp-buttoner-icon' => 'margin-{{icon_position.value}}: {{size}}{{unit}};',
                ],
                'condition' => [ 'show_icon' => 'yes']
            ]
        );

        /** Button id. */
        $this->add_control(
            'buttoner_id',
            [
                'label' => esc_html__( 'Button ID', 'selection-lite' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'description' => esc_html__( 'Please make sure the ID is unique 
				    and not used elsewhere on the page this 
				    form is displayed. This field allows A-z 0-9 & 
				    underscore chars without spaces.', 'selection-lite' ),
                'placeholder' => esc_html__( 'Button ID', 'selection-lite' ),
            ]
        );

        /** Cursor type. */
        $this->add_control(
            'buttoner_cursor_type',
            [
                'label' => esc_html__( 'Cursor type', 'selection-lite' ),
                'type' => Controls_Manager::SELECT2,
                'separator' => 'before',
                'label_block' => true,
                'default' => 'pointer',
                'options' => [
                    'auto'       => esc_html__( 'Default', 'selection-lite' ),
                    'context-menu'  => esc_html__( 'Context menu', 'selection-lite' ),
                    'help'          => esc_html__( 'Help', 'selection-lite' ),
                    'pointer'       => esc_html__( 'Pointer', 'selection-lite' ),
                    'progress'      => esc_html__( 'Progress', 'selection-lite' ),
                    'wait'          => esc_html__( 'Wait', 'selection-lite' ),
                    'cell'          => esc_html__( 'Cell', 'selection-lite' ),
                    'crosshair'     => esc_html__( 'Crosshair', 'selection-lite' ),
                    'text'          => esc_html__( 'Text', 'selection-lite' ),
                    'vertical-text' => esc_html__( 'Vertical text', 'selection-lite' ),
                    'alias'         => esc_html__( 'Alias', 'selection-lite' ),
                    'copy'          => esc_html__( 'Copy', 'selection-lite' ),
                    'move'          => esc_html__( 'Move', 'selection-lite' ),
                    'no-drop'       => esc_html__( 'No drop', 'selection-lite' ),
                    'not-allowed'   => esc_html__( 'Not allowed	', 'selection-lite' ),
                    'all-scroll'    => esc_html__( 'All scroll', 'selection-lite' ),
                    'col-resize'    => esc_html__( 'Col resize', 'selection-lite' ),
                    'row-resize'    => esc_html__( 'Row resize', 'selection-lite' ),
                    'n-resize'      => esc_html__( 'N resize', 'selection-lite' ),
                    'ne-resize'     => esc_html__( 'Ne resize', 'selection-lite' ),
                    'e-resize'      => esc_html__( 'E resize', 'selection-lite' ),
                    'se-resize'     => esc_html__( 'Se resize', 'selection-lite' ),
                    's-resize'      => esc_html__( 'S resize', 'selection-lite' ),
                    'sw-resize'     => esc_html__( 'Sw resize', 'selection-lite' ),
                    'w-resize'      => esc_html__( 'W resize', 'selection-lite' ),
                    'nw-resize'     => esc_html__( 'Nw resize', 'selection-lite' ),
                    'nesw-resize'   => esc_html__( 'Nesw resize', 'selection-lite' ),
                    'nwse-resize'   => esc_html__( 'Nwse resize', 'selection-lite' ),
                    'zoom-in'       => esc_html__( 'Zoom in', 'selection-lite' ),
                    'zoom-out'      => esc_html__( 'Zoom out', 'selection-lite' ),
                    'grab'          => esc_html__( 'Grab', 'selection-lite' ),
                    'grabbing'      => esc_html__( 'Grabbing', 'selection-lite' ),
                    'custom'        => esc_html__( 'Custom', 'selection-lite' ),
                ],
            ]
        );

        /** Cursor Image. */
        $this->add_control(
            'buttoner_image',
            [
                'label' => esc_html__( 'Cursor image', 'selection-lite' ),
                'type' => Controls_Manager::MEDIA,
                'condition' => [ 'buttoner_cursor_type' => 'custom'],
                'description' => esc_html__( 'Select an image(png) with transparent background and not more 120x120px size.','selection-lite' ),
            ]
        );

        /** Section End */
        $this->end_controls_section();

	    /** Pro Content */
	    $this->section_content_pro();

    }

    /**
     * Style Tab Controls
     *
     * @since 1.0
     * @access protected
     *
     * @return void with category names
     */
    private function section_style() {

        /** Section Start */
        $this->start_controls_section( 'style_buttoner',
            [
                'label' => esc_html__( 'Button', 'selection-lite' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        /** Typography. */
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'buttoner_typography',
                'label' => esc_html__( 'Typography', 'selection-lite' ),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .mdp-buttoner-link',
            ]
        );

        /** Pseudo Classes Tabs Start */
        $this->start_controls_tabs( 'tabs_buttoner' );

        # Normal Style Controls
        $this->pseudo_classes_tab( 'normal' );

        # Hover Style Controls
        $this->pseudo_classes_tab( 'hover' );

        # Active Style Controls
        $this->pseudo_classes_tab( 'active' );

        /** Pseudo Classes Tabs End */
        $this->end_controls_tabs();

        /** Hover Animation. */
        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'buttoner-domain' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'prefix_class' => 'elementor-animation-',
            ]
        );

        /** Section End */
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

        /** Content section */
        $this->section_content();

        /** Style section */
        $this->section_style();

    }

    /**
     *  we generate box shadow style.
     *
     * @param $settings - Settings for setting styles.
     * @param $type - Type of event.
     *
     * @return string
     */
    public function get_box_shadow_style( $settings, $type ) {

        $box_shadow = 'box-shadow: ';

        foreach ( $settings[$type . '_neumorphism'] as $val ) {

            /** Is this inset shadow? */
            $inset = '';
            if ( 'yes' === $val[$type . '_inner_shadow'] ) { $inset = 'inset '; }

            $box_shadow .=
                esc_attr__( $inset ) . esc_attr__( $val[ $type . '_x_offset']['size'] ) . esc_attr__( $val[ $type . '_x_offset']['unit'] ) . ' '
                . esc_attr__( $val[$type . '_y_offset']['size'] ) . esc_attr__( $val[ $type . '_y_offset']['unit'] ) . ' '
                . esc_attr__( $val[$type . '_blur_radius']['size'] ) . esc_attr__( $val[ $type . '_blur_radius']['unit'] ) . ' '
                . esc_attr__( $val[$type . '_spread_radius']['size'] ) . esc_attr__( $val[ $type . '_spread_radius']['unit'] ). ' '
                . esc_attr__( $val[$type . '_box_shadow_color'] );

            /** Combine multiple shadow into one css rule. */
            if ( next( $settings[$type . '_neumorphism'] ) ) {

                $box_shadow .= ", ";

            } else {

                $box_shadow .= ";";

            }

        }

        return $box_shadow;

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

        /** Prepare variables. */
        $icon_position = $settings['icon_position'];
        $target = $settings['buttoner_link']['is_external'] ? ' target="_blank" ' : '';
        $nofollow = $settings['buttoner_link']['nofollow'] ? ' rel="nofollow" ' : '';

        /** Add a class of styles for the position of the icon top or bottom. */
        $style_display_class = '';
        $style_display = '';
        if ( in_array( $icon_position, ['top', 'bottom'] ) ) {
            $style_display_class = 'class="mdp-display-block"';
            $style_display = 'mdp-display-block';
        }

        /** Render CSS for each instance of buttoner widget. */
        $this->render_css( $settings );

        ?>
        <!-- Start Buttoner for Elementor WordPress Plugin -->
        <div class="mdp-buttoner-container mdp-buttoner-container-<?php esc_attr_e( $this->get_id() ); ?>">
            <a id="<?php esc_attr_e( $settings['buttoner_id'] ); ?>"
               href="<?php echo esc_url( $settings['buttoner_link']['url'] ); ?>"
               class="mdp-buttoner-link elementor-animation-<?php esc_attr_e( $settings['hover_animation'] ); ?>"
                <?php esc_attr_e( $target ); ?>
                <?php esc_attr_e( $nofollow ); ?>
            >

		        <span <?php esc_attr_e( $style_display_class ); ?>>

			        <?php if ( in_array( $icon_position, ['right', 'bottom'] ) ) { $this->render_icon( $settings, $style_display ); } ?>

                    <span class="mdp-buttoner-text"><?php esc_html_e( $settings['text_link'] ); ?></span>

                    <?php if ( in_array( $icon_position, ['left', 'top'] ) ) { $this->render_icon( $settings, $style_display ); } ?>

		        </span>

            </a>
        </div>
        <!-- End Buttoner for Elementor WordPress Plugin -->
        <?php

    }

    /**
     * Render Frontend output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0
     * @access protected
     **/
    protected function content_template() {
        ?>

        <#

        /**
        * PHP's in_array in JavaScript.
        * @see https://locutus.io/php/in_array/
        *
        * @param needle
        * @param haystack
        * @param argStrict
        * @return {boolean}
        **/
        function in_array ( needle, haystack, argStrict ) {

        var key = '';
        var strict = !!argStrict;

        /**
        * we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] === ndl)
        * in just one for, in order to improve the performance
        * deciding wich type of comparation will do before walk array
        **/
        if ( strict ) {
        for ( key in haystack ) {
        if ( haystack[key] === needle ) {
        return true;
        }
        }
        } else {
        for ( key in haystack ) {
        if ( haystack[key] == needle ) {
        return true;
        }
        }
        }

        return false;

        }

        /**
        * PHP's empty in JavaScript.
        * @see https://locutus.io/php/empty/
        *
        * @param mixedVar
        **/
        function empty ( mixedVar ) {

        var undef;
        var key;
        var i;
        var len;
        var emptyValues = [undef, null, false, 0, '', '0'];

        for ( i = 0, len = emptyValues.length; i < len; i++ ) {

        if ( mixedVar === emptyValues[i] ) { return true; }

        }

        if ( typeof mixedVar === 'object' ) {

        for ( key in mixedVar ) {

        if ( mixedVar.hasOwnProperty( key ) ) { return false; }

        }

        return true;
        }

        return false;

        }

        /**
        * Return box-shadow CSS property.
        **/
        function get_box_shadow_style( type ) {

        var box_shadow = 'box-shadow: ';

        settings[type + '_neumorphism'].forEach( function( val ) {

        /** Is this inset shadow? */
        var inset = '';
        if ( 'yes' === val[type + '_inner_shadow'] ) { inset = 'inset '; }

        box_shadow += inset + val[type + '_x_offset']['size'] + val[type + '_x_offset']['unit'] + ' '
        + val[type + '_y_offset']['size'] + val[type + '_y_offset']['unit'] + ' '
        + val[type + '_blur_radius']['size'] + val[type + '_blur_radius']['unit'] + ' '
        + val[type + '_spread_radius']['size'] + val[type + '_spread_radius']['unit'] + ' '
        + val[type + '_box_shadow_color'];

        /** Combine multiple shadow into one css rule. */
        box_shadow += ", ";

        } );

        box_shadow = box_shadow.slice( 0, -2 ) + ';';

        return box_shadow;

        }

        /** Render CSS for each instance of buttoner widget. */
        function render_css( widget_id ) {

        var css = '';

        /** Get unique widget id. */
        var id = widget_id;

        /** Prepare cursor value. */
        var cursor_type = settings.buttoner_cursor_type;
        if ( 'custom' === settings.buttoner_cursor_type ) {

        var url = settings.buttoner_image.url;
        cursor_type = "url( " + url + " ), auto";

        }

        /** Styles for the cursor. */
        css += ".mdp-buttoner-container-" + id + " .mdp-buttoner-link { cursor: " + cursor_type + "; } ";

        /** Normal. */
        if ( ! empty( settings.normal_neumorphism ) ) {

        /** Get shadow values. */
        var shadows = get_box_shadow_style( 'normal' );

        css += ".mdp-buttoner-container-" + id + " .mdp-buttoner-link { " + shadows + " }";

        }

        /** Hover. */
        if ( ! empty( settings.hover_neumorphism ) ) {

        /** Get shadow values. */
        var shadows = get_box_shadow_style( 'hover' );

        css += ".mdp-buttoner-container-" + id + " .mdp-buttoner-link:hover { " + shadows + " }";

        }

        /** Active. */
        if ( ! empty( settings.active_neumorphism ) ) {

        /** Get shadow values. */
        var shadows = get_box_shadow_style( 'active' );

        css += ".mdp-buttoner-container-" + id + " .mdp-buttoner-link:active { " + shadows + " }";

        }

        #><style>{{{ css }}}</style><#

        }

        function render_icon( style_display ) {

        /** No icon => Nothing to render. */
        if ( 'yes' !== settings.show_icon ) { return; }

        #>
        <span class="mdp-buttoner-icon {{{ style_display }}}">
                <i aria-hidden="true" class="{{{ settings.buttoner_icon.value }}}"></i>
            </span>
        <#

        }

        /** Prepare variables. */
        var icon_position = settings.icon_position;
        var target = settings.buttoner_link.is_external ? ' target="_blank" ' : '';
        var nofollow = settings.buttoner_link.nofollow ? ' rel="nofollow" ' : '';
        var widget_id = view.getID();

        /** Add a class of styles for the position of the icon top or bottom. */
        style_display_class = '';
        style_display = '';
        if ( in_array( icon_position, ['top', 'bottom'] ) ) {
        style_display_class = 'class="mdp-display-block"';
        style_display = 'mdp-display-block';
        }

        /** Render CSS for each instance of buttoner widget. */
        render_css( widget_id );

        #>

        <!-- Start Buttoner for Elementor WordPress Plugin -->
        <div class="mdp-buttoner-container mdp-buttoner-container-{{{ widget_id }}}">
            <a id="{{{ settings.buttoner_id }}}"
               href="{{{ settings.buttoner_link.url }}}"
               class="mdp-buttoner-link {{{ settings.hover_animation }}}"
               {{{ target }}}
               {{{ nofollow }}}
            >

		        <span {{{ style_display_class }}}>
			        <# if ( in_array( icon_position, ['right', 'bottom'] ) ) { render_icon( style_display ); } #>
                    <span class="mdp-buttoner-text">{{{ settings.text_link }}}</span>
                    <# if ( in_array( icon_position, ['left', 'top'] ) ) { render_icon( style_display ); } #>
		        </span>

            </a>
        </div>
        <!-- End Buttoner for Elementor WordPress Plugin -->
        <?php
    }

    /**
     * Render icon for button.
     *
     * @param array $settings - Current buttoner widget settings.
     * @param string $style_display
     *
     * @since  1.0
     * @access public
     *
     * @return string
     **/
    private function render_icon( $settings, $style_display ) {

        /** No icon => Nothing to render. */
        if ( null === $settings["buttoner_icon"]['value'] ) { return; }

        ?>
        <span class="mdp-buttoner-icon <?php esc_attr_e( $style_display ); ?>">
            <i aria-hidden="true" class="<?php esc_attr_e( $settings['buttoner_icon']['value'] ); ?>"></i>
        </span>
        <?php

    }

    /**
     * Render CSS for each instance of buttoner widget.
     *
     * @param array $settings - Current buttoner widget settings.
     *
     * @since  1.0
     * @access public
     *
     * @return string
     **/
    private function render_css( $settings ) {

        $css = "";

        /** Get unique widget id. */
        $id = $this->get_id();

        /** Prepare cursor value. */
        $cursor_type = $settings['buttoner_cursor_type'];
        if ( 'custom' === $settings['buttoner_cursor_type'] ) {

            $url = $settings['buttoner_image']['url'];
            $cursor_type = "url( {$url} ), auto";

        }

        /** Styles for the cursor. */
        // language=CSS
        $css .= ".mdp-buttoner-container-{$id} .mdp-buttoner-link { cursor: {$cursor_type}; } ";

        /** Normal. */
        if ( ! empty( $settings['normal_neumorphism'] ) ) {

            /** Get shadow values. */
            $shadows = $this->get_box_shadow_style( $settings, 'normal' );

            // language=CSS
            $css .= ".mdp-buttoner-container-{$id} .mdp-buttoner-link { {$shadows} }";

        }

        /** Hover. */
        if ( ! empty( $settings['hover_neumorphism'] ) ) {

            /** Get shadow values. */
            $shadows = $this->get_box_shadow_style( $settings, 'hover' );

            // language=CSS
            $css .= ".mdp-buttoner-container-{$id} .mdp-buttoner-link:hover { {$shadows} }";

        }

        /** Active. */
        if ( ! empty( $settings['active_neumorphism'] ) ) {

            /** Get shadow values. */
            $shadows = $this->get_box_shadow_style( $settings, 'active' );

            // language=CSS
            $css .= ".mdp-buttoner-container-{$id} .mdp-buttoner-link:active { {$shadows} }";

        }

        echo wp_sprintf( '<style>%s</style>', $css ); // XSS ok.

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
     * @since 1.0
     * @access public
     *
     * @return string
     **/
    public function get_custom_help_url() {

        return 'https://docs.merkulov.design/category/buttoner-elementor/';

    }

}
