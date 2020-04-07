<?php
/**
 * Engine
 *
 * The Agama engine class.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.5.0
 */

namespace Agama;

use Agama\Core;
use Agama\Filters;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Engine {
    
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
     * Run
     *
     * Access the single instance of this class.
     *
     * @since 1.5.0
     * @access public
     * @return object
     */
    public static function run() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Construct
     *
     * The class constructor.
     *
     * @since 1.5.0
     * @access public
     * @return void
     */
    public function __construct() {
        ###################################
        # DEFINE THE AGAMA THEME CONSTANTS 
        ###################################
        $this->constants();
        
        ##########################################
        # INCLUDE THE AGAMA THEME CORE CLASS FILE
        ##########################################
        get_template_part( 'framework/class-agama-core' );
        
        ##################################
        # INITIALIZE THE AGAMA CORE CLASS
        ##################################
        Core::get_instance();
        
        ################################
        # INCLUDE THE AGAMA THEME FILES
        ################################
        $this->get_template_parts();
        
        ###########################
        # INITIALIZE AGAMA CLASSES
        ###########################
        Filters::get_instance();
        
        #####################################
        # THE AGAMA THEME LOADED ACTION HOOK
        #####################################
        if( has_action( 'agama_loaded' ) ) {
            /**
             * Hook: agama_loaded
             *
             * Fires after the Agama theme is fully loaded.
             *
             * @hooked none
             *
             * @since 1.5.0
             */
            do_action( 'agama_loaded' );
        }
    }
    
    /**
     * Constants
     *
     * The Agama theme constants definitions.
     *
     * @since 1.5.0
     * @access private
     * @return bool|num|string
     */
    private function constants() {
        if( ! defined( 'AGAMA_VERSION' ) )
              define( 'AGAMA_VERSION', Agama()->version() );
        
        if( ! defined( 'AGAMA_URI' ) )
              define( 'AGAMA_URI', get_template_directory_uri() . '/' );

        if( ! defined( 'AGAMA_DIR' ) ) 
              define( 'AGAMA_DIR', get_template_directory() . '/' );

        if( ! defined( 'AGAMA_FMW' ) )
              define( 'AGAMA_FMW', AGAMA_DIR . 'framework/' );

        if( ! defined( 'AGAMA_INC' ) )
              define( 'AGAMA_INC', AGAMA_DIR . 'includes/' );

        if( ! defined( 'AGAMA_CSS' ) )
              define( 'AGAMA_CSS', AGAMA_URI . 'assets/css/' );

        if( ! defined( 'AGAMA_JS' ) )
              define( 'AGAMA_JS', AGAMA_URI . 'assets/js/' );

        if( ! defined( 'AGAMA_IMG' ) )
              define( 'AGAMA_IMG', AGAMA_URI . 'assets/img/' );

        if( ! defined( 'AGAMA_MODULES_DIR' ) )
              define( 'AGAMA_MODULES_DIR', AGAMA_FMW . 'admin/modules/' );

        if( ! defined( 'AGAMA_MODULES_URI' ) ) 
              define( 'AGAMA_MODULES_URI', AGAMA_URI . 'framework/admin/modules/' );
    }
    
    /**
     * Template Parts
     *
     * Include the Agama theme template parts.
     *
     * @since 1.5.0
     * @access private
     * @return void
     */
    private function get_template_parts() {
        get_template_part( 'framework/admin/admin-init' );
        get_template_part( 'framework/class-agama-filters' );
        get_template_part( 'framework/agama-actions' );
        get_template_part( 'framework/agama-functions' );
        get_template_part( 'framework/class-agama-inline-style' );
        get_template_part( 'framework/class-agama-plugin-activation' );
        get_template_part( 'framework/class-agama-helper' );
		get_template_part( 'framework/class-agama-slider' );
		get_template_part( 'framework/class-agama' );
		get_template_part( 'framework/class-agama-wc' );
		get_template_part( 'framework/class-agama-breadcrumb' );
		get_template_part( 'framework/class-agama-frontpage-boxes' );
		get_template_part( 'framework/widgets/widgets' );
        get_template_part( 'framework/admin/customizer/builder/class-agama-page-builder' );
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
