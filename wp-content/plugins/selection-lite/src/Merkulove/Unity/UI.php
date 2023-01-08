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
 * SINGLETON: Class used to render UI controls.
 *
 * @since 1.0
 *
 **/
final class UI {

	/**
	 * The one true UI.
	 *
     * @since 1.0
	 * @var UI
	 **/
	private static $instance;

	/**
	 * Render snackbar.
	 *
	 * @see https://material-components.github.io/material-components-web-catalog/#/component/snackbar
	 * @access public
	 *
	 * @param $message - HTML message to show.
	 * @param string $design - Snackbar message design (info, error, warning)
     * @param int $timeout - Auto-close timeout (-1 or 4000-10000)
	 * @param bool $closeable - Can a user close?
	 * @param array $buttons - Additional buttons array( [ 'caption', 'link' ] )
     * @param string $class_name - CSS class name
     *
     * @since 1.0
     * @access public
     *
     * @return void
     **/
	public function render_snackbar( $message, $design = '', $timeout = 5000, $closeable = true, $buttons = [], $class_name = '' ) {
		?>
        <div class="mdc-snackbar <?php echo ( $design === '' ) ? 'mdc-info' : 'mdc-' . esc_attr( $design ); ?> <?php echo esc_attr( $class_name ); ?>" data-timeout="<?php echo esc_attr( $timeout ); ?>">
            <div class="mdc-snackbar__surface">
                <div class="mdc-snackbar__label" role="status"
                     aria-live="polite"><?php echo wp_kses_post( $message ); ?></div>
                    <div class="mdc-snackbar__actions">
                        <?php foreach ( $buttons as $btn) : ?>
                            <button class="mdc-button mdc-snackbar__action" type="button" onclick="window.open( '<?php echo esc_attr( $btn[ 'link' ] ); ?>', '_blank' )" title="<?php echo esc_attr( $btn[ 'caption' ] ); ?>"><?php esc_html_e( $btn[ 'caption' ] ); ?></button>
                        <?php endforeach; ?>
                        <?php if ( $closeable ) : ?>
                            <button class="mdc-icon-button mdc-snackbar__dismiss material-icons" title="<?php esc_html_e( 'Dismiss' ); ?>" type="button">close</button>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
		<?php
	}

	/**
	 * Render select field.
	 *
	 * @param array $options - Options for select. Required.
	 * @param string $selected - Selected value. Optional.
	 * @param string $label - Label for select. Optional.
	 * @param string $helper_text - Text after select. Optional.
	 * @param array  $attributes - Additional attributes for select: id, name, class. Optional.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 **/
	public function render_select( $options, $selected = '', $label = '', $helper_text = '', $attributes = [] ) {

		if ( ! count( $options ) ) { return; }

		/** Prepare html attributes. */
		$name = isset( $attributes['name'] ) ? $attributes['name'] : '';
		$id   = isset( $attributes['id'] ) ? $attributes['id'] : 'mdp-' . uniqid( '', true );

		$class = isset( $attributes['class'] ) ? $attributes['class'] : '';
		$class = 'mdc-select mdc-select-width mdc-select--outlined ' . $class;
		$class = trim( $class );

		/** Check selected option. If we don't have it, select first one. */
		if ( ! array_key_exists( $selected,  $options ) ) {

			reset( $options );

			/** @noinspection CallableParameterUseCaseInTypeContextInspection */
			$selected = key( $options );

		}
		?>

        <div class="<?php echo esc_attr( $class ); ?>">
            <input type="hidden"
				<?php echo ( $id ) ? 'id="' . esc_attr( $id ) . '"' : ''; ?>
				<?php echo ( $name ) ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
                   value="<?php echo esc_attr( $selected ); ?>"
            >

            <div class="mdc-select__anchor mdc-select-width">
                <i class="mdc-select__dropdown-icon"></i>
                <div id="<?php echo esc_attr( $id ) ?>-text" class="mdc-select__selected-text" aria-labelledby="outlined-select-label"><?php esc_html_e( $options[$selected] ); ?></div>
                <div class="mdc-notched-outline">
                    <div class="mdc-notched-outline__leading"></div>
                    <div class="mdc-notched-outline__notch">
						<?php if ( $label ) : ?>
                            <span id="<?php echo esc_attr( $id ) ?>-label" class="mdc-floating-label"><?php echo esc_html( $label ); ?></span>
						<?php endif; ?>
                    </div>
                    <div class="mdc-notched-outline__trailing"></div>
                </div>
            </div>

            <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-select-width" role="listbox">
                <ul class="mdc-list">
					<?php foreach ( $options as $key => $value ) : ?>
						<?php $selected_class = ( $key === $selected ) ? 'mdc-list-item--selected' : ''; ?>
                        <li class="mdc-list-item <?php echo esc_attr( $selected_class ); ?>" data-value="<?php echo esc_attr( $key ) ?>" role="option"><?php echo wp_kses_post( $value ) ?></li>
					<?php endforeach; ?>
                </ul>
            </div>
        </div>

		<?php if ( $helper_text ) : ?>
            <div class="mdc-text-field-helper-line">
                <div class="mdc-select-helper-text mdc-select-helper-text--persistent" aria-hidden="true"><?php echo wp_kses_post( $helper_text ); ?></div>
            </div>
		<?php endif;

	}

	/**
     * Render the Switch
     *
     * @param string $value - Switch value on/off
     * @param string $label - Switch label
     * @param string $helper_text - Switch helper text
     * @param array $attributes - Additional attributes for the switch: id, name, class. Optional.
     *
     * @since 1.0
     * @access public
     **/
    public function render_switcher( $value, $label = '', $helper_text = '', $attributes = [] ) {

        /** Prepare html attributes. */
        $id   = isset( $attributes['id'] ) ? $attributes['id'] : '';
        $name   = isset( $attributes['name'] ) ? $attributes['name'] : '';

        $class = isset( $attributes['class'] ) ? trim( $attributes['class'] ) : '';
        $class = ' mdc-switch ' . $class;
        if ( $value === 'on' ) {
            $class .= ' mdc-switch--checked ';
        }
        $class = trim( $class );
        ?>

        <div <?php echo ( $class ) ? 'class="' . esc_attr( $class ) . '"' : ''; ?>>
            <div class="mdc-switch__track"></div>
            <div class="mdc-switch__thumb-underlay">
                <div class="mdc-switch__thumb">
                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input
                        <?php echo ( $id ) ? 'id="' . esc_attr( $id . '-i' ) . '"' : ''; ?>
                        <?php echo ( $name ) ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
                            type='hidden'
                            value='off'>
                    <!--suppress HtmlFormInputWithoutLabel -->
                    <input
                        <?php echo ( $id ) ? 'id="' . esc_attr( $id ) . '"' : ''; ?>
                        <?php echo ( $name ) ? 'name="' . esc_attr( $name ) . '"' : ''; ?>
                            class="mdc-switch__native-control" type="checkbox" role="switch" <?php echo ( $value === 'on' ) ? 'checked' : ''; ?>>
                </div>
            </div>
        </div>
        <label <?php echo isset( $attributes['id'] ) ? 'for="'. esc_attr( $attributes['id'] ) .'"' : '' ?>class="mdc-switch-label"><?php echo esc_html( $label ) ?></label>

        <?php if ( $helper_text ) : ?>
            <div class="mdc-text-field-helper-line">
                <div class="mdc-switcher-helper mdc-text-field-helper-text mdc-text-field-helper-text--persistent"><?php echo wp_kses_post( $helper_text ); ?></div>
            </div>
        <?php endif;

    }

	/**
	 * Main UI Instance.
	 * Insures that only one instance of UI exists in memory at any one time.
	 *
	 * @static
     * @since 1.0
     * @access public
     *
     * @return UI
     **/
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) {

			self::$instance = new self;

		}

		return self::$instance;

	}

}
