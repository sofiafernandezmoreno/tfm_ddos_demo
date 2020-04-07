<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Agama Page Builder
 *
 * @since 1.3.8
 */
if( ! class_exists( 'Agama_Page_Builder' ) ) {
    class Agama_Page_Builder {
        
        /**
         * Path to Builder DIR
         *
         * @since 1.3.8
         * @access public
         */
        public $dir_path;
        
        /**
         * Path to Builder URL
         *
         * @since 1.3.8
         * @access public
         */
        public $url_path;

        /**
         * Class Constructor
         */
        function __construct() {
            
            $this->dir_path = get_template_directory() . '/framework/admin/customizer/builder/';
            $this->url_path = get_template_directory_uri() . '/framework/admin/customizer/builder/';
            
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
            add_action( 'customize_preview_init', [ $this, 'customize_preview' ] );
            add_action( 'customize_controls_print_scripts', [ $this, 'customize_controls_print_scripts' ], 30 );
            add_action( 'agama_add_widget', [ $this, 'add_widget' ] );

        }
        
        /**
         * Enqueue Admin Scripts
         *
         * @since 1.3.8
         */
        function admin_scripts( $hook ) {
            wp_enqueue_style( 'agama-page-builder-misc', $this->url_path . 'assets/css/widgets.css', [], Agama()->version() );
            if( 'widgets.php' == $hook || 'post.php' == $hook ){
                wp_enqueue_style( 'wp-color-picker' );        
                wp_enqueue_script( 'wp-color-picker' );
                wp_enqueue_script( 'agama-widgets', $this->url_path . 'assets/js/widgets.min.js', [ 'jquery' ], Agama()->version() );
            }
        }
        
        /**
         * Customize Live Preview
         *
         * @since 1.3.8
         */
        function customize_preview() {
            $strings = [
                'skin_url'     => AGAMA_CSS . 'skins/',
                'layout_style' => esc_attr( get_theme_mod( 'agama_layout_style', 'fullwidth' ) )
            ];
            
            wp_register_script( 
                'agama-customize-preview', 
                AGAMA_JS . 'customize-preview.js', 
                [ 'jquery', 'customize-preview' ], 
                Agama()->version(), 
                true 
            );
            
            wp_localize_script( 'agama-customize-preview', '_AgamaPreviewData', $strings );
            wp_enqueue_script( 'agama-customize-preview' );
            
            wp_register_style( 'agama-partial-refresh', $this->url_path . '/assets/css/partial-refresh.css', [], Agama()->version() );
            wp_enqueue_style( 'agama-partial-refresh' );
        }

        /**
         * Add Scripts
         *
         * @since 1.3.8
         */
        function customize_controls_print_scripts() {
            $strings = [
                'ajax_url'          => admin_url( 'admin-ajax.php' ),
                'agamaWidgetsLabel' => esc_html__( 'Agama Widgets', 'agama' ),
                'otherWidgetsLabel' => esc_html__( 'Other Widgets', 'agama' ),
                'proWidgetDesc'     => esc_html__( 'Upgrade to PRO to unlock this widget.', 'agama' ),
                'testimonialLabel'  => esc_html__( 'Testimonial', 'agama' ),
                'portfolioLabel'    => esc_html__( 'Portfolio', 'agama' ),
                'countdownLabel'    => esc_html__( 'Countdown', 'agama' ),
                'contactLabel'      => esc_html__( 'Contact', 'agama' ),
                'mapsLabel'         => esc_html__( 'Maps', 'agama' ),
                'comingSoonLabel'   => esc_html__( 'Coming Soon', 'agama' )
            ];
            
            // Enqueue Page Builder Script
            wp_register_script( 'agama-page-builder', AGAMA_JS . 'min/customize-controls.min.js', [ 'jquery' ], Agama()->version() );
            wp_localize_script( 'agama-page-builder', 'agama_builder', $strings );
            wp_enqueue_script( 'agama-page-builder' );
            
            // Enqueue Page Builder Stylesheet
            wp_register_style( 'agama-page-builder', $this->url_path . 'assets/css/page-builder.css', [], Agama()->version() );
            wp_enqueue_style( 'agama-page-builder' );
        }
        
        /**
         * Add New Widget Button
         *
         * @since 1.3.8
         * @is_customize_preview
         */
        function add_widget( $page_id ) {
            if( is_customize_preview() ) {
                
                $html  = '<div class="agama-page-builder-add-widget" data-id="sidebar-widgets-page-widget-'. esc_attr( $page_id ) .'">';
                    $html .= '<a class="add-new-widget" data-toggle="tooltip" data-placement="top" title="'. esc_html__( 'Add New', 'agama' ) .'"><i class="fa fa-plus"></i></a>';
                $html .= '</div>';
                
                echo $html;
            }
        }

    }
    new Agama_Page_Builder();
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
