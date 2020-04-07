<?php
/**
 * Menu
 *
 * The "About Agama" admin menu class.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.1
 * @since 1.5.1 Updated the code.
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Menu {
    
    /**
	 * Instance
	 *
	 * Single instance of this object.
	 *
	 * @since 1.5.1
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Get Instance
	 *
	 * Access the single instance of this class.
	 *
	 * @since 1.5.1
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
     */
    public function __construct() {

        add_action('admin_menu', [ $this, 'register_page' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

    }

    function admin_enqueue_scripts() {
        $screen = get_current_screen();
        if( $screen->base == 'appearance_page_about-agama' ) {
            wp_enqueue_style( 'agama-about', AGAMA_CSS . 'admin-about.css', [], Agama()->version() );
        }
    }

    /**
     * Register Page
     *
     * Add submenu page to the Appearance main menu.
     *
     * @since 1.0.1
     * @access public
     * @return false | string
     */
    public function register_page() {
        add_theme_page( 
            esc_html__( 'About Agama', 'agama' ), 
            esc_html__( 'About Agama', 'agama' ), 
            'edit_theme_options', 
            'about-agama', 
            [ $this, 'render_page' ]
        );
    }

    /**
     * Render Page
     *
     * Render the "About Agama" admin page.
     *
     * @since 1.0.1
     * @access public
     * @return mixed
     */
    public function render_page() {
        
        get_template_part( 'framework/admin/pages/about' );
        
    }
}

Menu::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
