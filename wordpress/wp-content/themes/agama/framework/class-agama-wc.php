<?php
/**
 * WooCommerce
 *
 * The Agama theme WooCommerce class.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 * @since 1.5.0 Updated the code.
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( class_exists( 'Woocommerce' ) ) {
    
	class WooCommerce {
        
        /**
         * Instance
         *
         * Single instance of this object.
         *
         * @since 1.5.0
         * @access public
         * @return null|object
         */
        public static $instance = null;

        /**
         * Get Instance
         *
         * Access the single instance of this class.
         *
         * @since 1.5.0
         * @access public
         * @return object
         */
        public static function get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self();
            }
            return self::$instance;
        }
		
		/**
		 * Class Constructor
		 *
		 * @since 1.0.0
		 */
		function __construct() {
			
			// Remove WooCommerce Shop Page Title
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			
			// Remove WooCommerce Breadcrumbs
			add_action( 'init', array( $this, 'agama_remove_wc_breadcrumbs' ) );
			
			// Unhook WooCommerce Wrappers
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
			
			// Hook Agama Wrappers
			add_action('woocommerce_before_main_content', array( $this, 'agama_wrapper_start' ), 10);
			add_action('woocommerce_after_main_content', array( $this, 'agama_wrapper_end' ), 10);
			
		}
		
		/**
		 * Register WooCommerce Agama Start Wrappers
		 *
		 * @since 1.0.0
		 */
		function agama_wrapper_start() {
			echo '<div id="primary" class="site-content tv-col-md-9">';
				echo '<div id="content" role="main">';
		}
		
		/**
		 * Register WooCommerce Agama End Wrappers
		 *
		 * @since 1.0.0
         * @since 1.5.0 Updated the code.
		 */
		function agama_wrapper_end() {
				echo '</div><!-- #content -->';
			echo '</div><!-- #primary -->';
		}
		
		/**
		 * Remove WooCommerce Breadcrumbs
		 *
		 * @since 1.0.9
		 */
		function agama_remove_wc_breadcrumbs() {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		}
	}
	
    WooCommerce::get_instance();
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
