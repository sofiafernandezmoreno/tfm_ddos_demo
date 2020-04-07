<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 * @since 1.5.0 Updated the code.
 */

use Agama\Theme;
use Agama\Engine;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

#####################################
# INCLUDE THE AGAMA THEME CLASS FILE
#####################################
get_template_part( 'framework/class-agama-theme' );

/**
 * Agama
 *
 * Access to the main "Theme" class instance.
 *
 * @since 1.5.0
 * @return object
 */
function Agama() {
    
    return Theme::get_instance();
    
}

############################################
# INCLUDE THE AGAMA THEME ENGINE CLASS FILE
############################################
get_template_part( 'framework/class-agama-engine' );

###############################
# START THE AGAMA THEME ENGINE
###############################
Engine::run();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
