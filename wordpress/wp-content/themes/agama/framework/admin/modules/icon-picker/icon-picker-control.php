<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register FontAwesome Icons Control
 *
 * @since 1.3.1
 */
add_action( 'customize_register', function( $wp_customize ) {
    /**
	 * The custom control class
	 */
	class Kirki_Controls_Agama_Icon_Picker_Control extends WP_Customize_Control {
        public $type    = 'agip';
        public function enqueue() {
            $uri = get_template_directory_uri() . '/framework/admin/modules/icon-picker/';
            
            // Deregister FontAwesome if enqueued by third party plugins.
            wp_deregister_style( 'font-awesome' );
            
            // Enqueue FontAwesome from theme assets.
            wp_enqueue_style( 'font-awesome', AGAMA_URI . 'assets/css/font-awesome.min.css', [], Agama()->version() );
            
            wp_enqueue_style( 'agip', $uri . 'assets/css/icon-picker.css', [], Agama()->version() );
            
            wp_enqueue_script( 'agip-control', $uri . 'assets/js/icon-picker-control.js', [], Agama()->version() );
            wp_enqueue_script( 'agip', $uri . 'assets/js/icon-picker.js', [], Agama()->version() );
        }
        public function render_content() { ?>
            <label for="preview_agip_icon">
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>
            <div id="<?php echo $this->id; ?>">
                <input class="agama-icon-picker regular-text agip-icon-value" type="hidden" name="agip-icon-value" value="<?php echo esc_attr( $this->value() ); ?>"/>
            
                <div id="preview_agip_icon" data-target="#preview_agip_icon" class="button agip-icon-picker fa <?php echo $this->value(); ?>"></div>
            </div>
            </label>
            <?php
        }
    }
    // Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['agip'] = 'Kirki_Controls_Agama_Icon_Picker_Control';
		return $controls;
	});
});