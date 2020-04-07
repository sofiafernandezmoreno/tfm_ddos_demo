<?php
/**
 * Admin Setup Class
 *
 * Setup Agama backend.
 *
 * @since 1.0.0
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Setup {
    
    /**
     * Instance
     *
	 * Single instance of this object.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;
    
    /**
     * Get Instance
     *
	 * Access the single instance of this class.
	 *
     * @since 1.0.0
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
    function __construct() {
        
        $this->get_template_parts();
        
    }
    
    /**
     * Admin Notices
     *
     * The Agama admin notices.
     *
     * @since 1.4.52
     * @access public
     * @return mixed
     */
    public function admin_notices() {}
    
    /**
     * Get Template Part
     *
     * Include all template parts for backend.
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    private function get_template_parts() {
        get_template_part( 'framework/admin/animate' );
        get_template_part( 'framework/admin/kirki/kirki' );
        get_template_part( 'framework/admin/customizer' );
        get_template_part( 'framework/admin/class-menu' );
    }
    
}

Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
