<?php
/**
 * Theme
 *
 * The Agama theme class holding theme details.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.5.0
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Theme {
    
    /**
     * Development
     *
     * The development mode, meant to be used for cache busting purposes.
     *
     * @since 1.5.0
     * @access private
     * @return bool
     */
    private $development = false;
    
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
     * Development
     *
     * Return a status of development mode.
     *
     * @since 1.5.0
     * @access public
     * @return bool
     */
    public function development() {
        return esc_attr( $this->development );
    }
    
    /**
     * Version
     *
     * Return the Agama theme version.
     *
     * @since 1.5.0
     * @access public
     * @return bool
     */
    public function version() {
        $theme   = wp_get_theme();
        $version = $theme->get( 'Version' );
        
        if( $this->development ) {
            $version = uniqid();
        }
        
        return esc_attr( $version );
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
