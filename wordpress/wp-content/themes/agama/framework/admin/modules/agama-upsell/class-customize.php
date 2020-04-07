<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.3.7
 * @access public
 */
final class Agama_Customizer_Upsell {

    /**
     * Returns the instance.
     *
     * @since  1.3.7
     * @access public
     * @return object
     */
    public static function get_instance() {

        static $instance = null;

        if ( is_null( $instance ) ) {
            $instance = new self;
            $instance->setup_actions();
        }

        return $instance;
    }

    /**
     * Constructor method.
     *
     * @since  1.3.7
     * @access private
     * @return void
     */
    private function __construct() {}

    /**
     * Sets up initial actions.
     *
     * @since  1.3.7
     * @access private
     * @return void
     */
    private function setup_actions() {

        // Register panels, sections, settings, controls, and partials.
        add_action( 'customize_register', array( $this, 'sections' ) );

        // Register scripts and styles for the controls.
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
    }

    /**
     * Sets up the customizer sections.
     *
     * @since  1.3.7
     * @access public
     * @param  object $manager Customizer manager.
     * @return void
     */
    public function sections( $manager ) {

        // Load custom sections.
        get_template_part( 'framework/admin/modules/agama-upsell/class-agama-customize-theme-info-main' );
        get_template_part( 'framework/admin/modules/agama-upsell/class-agama-customize-upsell-section' );

        // Register custom section types.
        $manager->register_section_type( 'Agama_Customizer_Theme_Info_Main' );

        // Main Documentation Link In Customizer Root.
        $manager->add_section(
            new Agama_Customizer_Theme_Info_Main(
                $manager, 
                'agama-theme-info', 
                array(
                    'theme_info_title' => esc_html__( 'Extend Agama', 'agama' ),
                    'label_url'        => esc_url( 'https://theme-vision.com/agama-pro/' ),
                    'label_text'       => esc_html__( 'Upgrade to Pro', 'agama' ),
                    'priority'         => 1
                )
            )
        );
        
        // General Section Upsell
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager,
                'agama-upsell-general-sections',
                [
                    'panel'     => 'agama_general_panel',
                    'priority'  => 500,
                    'options'   => [
                        __( 'Headings', 'agama' ),
                        __( 'Preloader', 'agama' )
                    ]
                ]
            )
        );

        // Slider Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-upsell-slider-sections', 
                array(
                    'panel'       => 'agama_slider_panel',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'Slide #3', 'agama' ),
                        esc_html__( 'Slide #4', 'agama' ),
                        esc_html__( 'Slide #5', 'agama' ),
                        esc_html__( 'Slide #6', 'agama' ),
                        esc_html__( 'Slide #7', 'agama' ),
                        esc_html__( 'Slide #8', 'agama' ),
                        esc_html__( 'Slide #9', 'agama' ),
                        esc_html__( 'Slide #10', 'agama' ),
                    )
                )
            )
        );
        
        // Front Page Boxes Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-upsell-frontpage-boxes-sections', 
                array(
                    'panel'       => 'agama_frontpage_boxes_panel',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'Front Page Box #5', 'agama' ),
                        esc_html__( 'Front Page Box #6', 'agama' ),
                        esc_html__( 'Front Page Box #7', 'agama' ),
                        esc_html__( 'Front Page Box #8', 'agama' ),
                    )
                )
            )
        );
        
        // WooCommerce Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-woocommerce-sections', 
                array(
                    'panel'       => 'woocommerce',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'General', 'agama' ),
                        esc_html__( 'Styling', 'agama' )
                    )
                )
            )
        );
        
        // Footer Sections Upsell.
        $manager->add_section(
            new Agama_Customizer_Upsell_Section(
                $manager, 
                'agama-footer-sections', 
                array(
                    'panel'       => 'agama_footer_panel',
                    'priority'    => 500,
                    'options'     => array(
                        esc_html__( 'Widgets', 'agama' )
                    )
                )
            )
        );
    }

    /**
     * Loads theme customizer CSS.
     *
     * @since  1.3.7
     * @access public
     * @return void
     */
    public function enqueue_control_scripts() {

        wp_enqueue_script( 
            'agama-upsell-js', 
            AGAMA_MODULES_URI . 'agama-upsell/js/agama-upsell-customize-controls.js', 
            [ 'customize-controls' ], 
            Agama()->version() 
        );

        wp_enqueue_style( 
            'agama-theme-info-style', 
            AGAMA_MODULES_URI . 'agama-upsell/css/style.css', 
            [], 
            Agama()->version()
        );

    }
}
Agama_Customizer_Upsell::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
