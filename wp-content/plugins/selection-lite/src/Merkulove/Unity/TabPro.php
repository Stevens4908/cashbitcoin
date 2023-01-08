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
 * SINGLETON: Class used to implement Status Tab on plugin settings page.
 *
 * @since 1.0
 *
 **/
final class TabPro extends Tab {

    /**
     * Slug of current tab.
     *
     * @const TAB_SLUG
     **/
    const TAB_SLUG = 'pro';

	/**
	 * The one true StatusTab.
	 *
     * @var TabPro
	 **/
	private static $instance;

	/**
	 * Generate Status Tab.
	 *
	 * @access public
     * @return void
	 **/
	public function add_settings() {

		/** Status Tab. */
        $this->add_settings_base( self::TAB_SLUG );

	}

    /**
     * Render form with all settings fields.
     *
     * @since 1.0
     * @access public
     *
     * @return void
     **/
    public function do_settings() {

        /** No status tab, nothing to do. */
        if ( ! $this->is_enabled( self::TAB_SLUG ) ) { return; }

        /** Render title. */
        $this->render_title( self::TAB_SLUG );

        /** Render fields. */
        $this->do_settings_base( self::TAB_SLUG );

        /** Render GO PRO */
        $this->render_go_pro();

    }

	/**
	 * Render Purchase Code field.
	 *
	 * @since 1.0
	 * @access public
	 **/
	public function render_go_pro() {

		$this->render_PRO();
        $this->render_FAQ();

	}

	/**
	 * Render GO PRO block.
	 *
	 * @since 1.0
	 * @access public
	 **/
	private function render_PRO() {
		?>

        <div class="mdp-go-pro-box">
            <h3><?php esc_html_e( 'Unlock additional functionality!', 'selection-lite' ); ?></h3>
            <p>
				<?php esc_html_e( 'Selection Lite includes only few basic widgets. Go ', 'selection-lite' ); ?>
                <a href="https://myselection.io/lite" target="_blank"><?php esc_html_e( 'Selection PRO', 'selection-lite' ); ?></a>
				<?php esc_html_e( ' to get more awesome widgets. Buy a license and gain access to all hidden features.', 'selection-lite' ); ?>
            </p>
            <div class="mdp-pro-features">
                <ul>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>No prohibitions or restrictions</span>
                    </li>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>No limitation in widget settings</span>
                    </li>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>Elementor Header & Footer</span>
                    </li>
                </ul>
                <ul>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>50+ awesome Elementor widgets</span>
                    </li>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>200+ Elementor Templates</span>
                    </li>
                    <li>
                        <i class="material-icons">label_important</i>
                        <span>Premium Customer Support</span>
                    </li>
                </ul>
            </div>
            <div class="mdp-pro-buttons">
                <a href="https://1.envato.market/selection" target="_blank" class="mdp-button-pro">
					<?php esc_html_e( 'Upgrade to PRO', 'selection-lite' ); ?>
                </a>
                <a href="https://myselection.io/lite#compare" target="_blank" class="mdp-button-compare">
					<?php esc_html_e( 'Compare Selection', 'selection-lite' ); ?>
                </a>
            </div>

        </div>

		<?php
	}

	/**
	 * Render FAQ block.
	 *
	 * @since 1.0
	 * @access public
	 **/
	private function render_FAQ() {
		?>

        <div class="mdp-activation-faq">

            <div class="mdc-accordion" data-mdc-accordion="showfirst: true">

                <h3><?php esc_html_e( 'FAQ\'S', 'selection-lite' ); ?></h3>

                <div class="mdc-accordion-title">
                    <i class="material-icons">help</i>
                    <span class="mdc-list-item__text"><?php esc_html_e( 'Why should I go to Pro version?', 'selection-lite' ); ?></span>
                </div>
                <div class="mdc-accordion-content">
                    <p><?php esc_html_e( 'The Selection Pro provides ', 'selection-lite' ); ?>
                        <a href="https://myselection.io/lite/#compare" target="_blank"><?php esc_html_e( ' advanced widgets and features', 'selection-lite' );?></a>
						<?php esc_html_e( 'including Elementor Header and Footer, which makes the plugin compatible with most themes and plugins. ', 'selection-lite' ); ?>
                    </p>
                </div>

                <div class="mdc-accordion-title">
                    <i class="material-icons">help</i>
                    <span class="mdc-list-item__text"><?php esc_html_e( 'Can I use one license for multiple sites?', 'selection-lite' ); ?></span>
                </div>
                <div class="mdc-accordion-content">
                    <p>
						<?php esc_html_e( 'According to the Envato rules, all products with a', 'selection-lite' ); ?>
                        <a href="https://themeforest.net/licenses/terms/regular" target="_blank"><?php esc_html_e( 'regular license', 'selection-lite' );?></a>
						<?php esc_html_e( 'can be used only for one end product except the situation when several sites are used for one project. Otherwise, a separate license is needed for each site.', 'selection-lite' ); ?>
                    </p>
                </div>

                <div class="mdc-accordion-title">
                    <i class="material-icons">help</i>
                    <span class="mdc-list-item__text"><?php esc_html_e( 'Are there any restrictions in the Pro version?', 'selection-lite' ); ?></span>
                </div>
                <div class="mdc-accordion-content">
                    <p>
						<?php esc_html_e( 'You will have full access to the entire library of widgets and templates. The library is updated with new widgets and templates every month. In addition, you will get access to regular updates and new features.', 'selection-lite' ); ?>
                    </p>
                </div>

            </div>

        </div>
		<?php
	}

	/**
	 * Main StatusTab Instance.
	 * Insures that only one instance of StatusTab exists in memory at any one time.
	 *
	 * @static
     * @return TabPro
	 **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
