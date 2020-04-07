<?php
/**
 * Template Name: Template Empty
 *
 * Agama empty template with header and footer only.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @author Theme Vision <support@theme-vision.com>
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.4.5
 */

// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

get_header();

/**
 * Empty
 *
 * @hook: agama/template_empty
 *
 * @since 1.0.0
 */
do_action( 'agama/template_empty' );

get_footer();
