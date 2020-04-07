<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define kirki framework file path.
$Kirki = get_template_directory() . '/framework/admin/kirki/kirki.php';

// Load Kirki Framework
if( file_exists( $Kirki ) ) {
    require_once( $Kirki );
}

// If Kirki Framework Not Found
if( ! class_exists( 'Kirki' ) )
    return;

###############################################
# AGAMA BLUE OPTIONS
###############################################
Kirki::add_config( 'agama_blue_options', array(
    'option_type' => 'theme_mod',
    'capability'  => 'edit_theme_options'
) );
Kirki::add_panel( 'agama_blue_theme_options_panel', array(
    'title'     => esc_html__( 'Agama Blue Options', 'agama-blue' ),
    'priority'  => 2
) );
Kirki::add_section( 'agama_blue_blog_section', array(
    'title'     => esc_html__( 'Blog', 'agama-blue' ),
    'panel'     => 'agama_blue_theme_options_panel'
) );
Kirki::add_field( 'agama_blue_options', array(
    'label'     => esc_html__( 'Enable', 'agama-blue' ),
    'tooltip'   => esc_html__( 'Enable blog section on home page.', 'agama-blue' ),
    'settings'  => 'agama_blue_blog',
    'section'   => 'agama_blue_blog_section',
    'type'      => 'switch',
    'default'   => true
) );
Kirki::add_field( 'agama_blue_options', array(
    'label'     => esc_html__( 'Heading Title', 'agama-blue' ),
    'tooltip'   => esc_html__( 'Set blog section heading title.', 'agama-blue' ),
    'settings'  => 'agama_blue_blog_heading',
    'section'   => 'agama_blue_blog_section',
    'type'      => 'text',
    'default'   => esc_html__( 'Latest from the Blog', 'agama-blue' )
) );

/**
 * Generating Dynamic CSS
 *
 * @since 1.0.1
 */
function agama_blue_customize_css() { ?>
	<style type="text/css" id="agama-blue-customize-css">
	a:hover,
	.header_v1 .site-header .sticky-header h1 a,
	.header_v1 .site-header .sticky-header nav a { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#00a4d0' ) ); ?> !important; }
	.ipost .entry-title h3 a:hover,
	.ipost .entry-title h4 a:hover { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#00a4d0' ) ); ?>; }
	.fbox-1 i { color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_1_icon_color', '#00a4d0' ) ); ?>;}
	.fbox-2 i { color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_2_icon_color', '#00a4d0' ) ); ?>;}
	.fbox-3 i { color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_3_icon_color', '#00a4d0' ) ); ?>;}
	.fbox-4 i { color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_4_icon_color', '#00a4d0' ) ); ?>;}
	#agama_slider .slide-content a.button {
		color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_1_icon_color', '#00a4d0' ) ); ?>;
		border-color: <?php echo esc_attr( get_theme_mod( 'agama_frontpage_box_1_icon_color', '#00a4d0' ) ); ?>;
	}
	<?php if( get_theme_mod( 'agama_layout_style', 'boxed' ) == 'boxed' ): ?>
	#main-wrapper { position: relative; }
	@media only screen and (min-width: 1100px) {
		.container-blog { width: 1100px; }
	}
	<?php endif; ?>
	</style>
<?php }
add_action( 'wp_head', 'agama_blue_customize_css' );

/**
* Customize Stylesheet
*
* @since 1.0
*/
add_action( 'customize_controls_print_styles', 'agama_blue_customize_styles_support' );
function agama_blue_customize_styles_support() { ?>
<style type="text/css">
#accordion-panel-agama_blue_theme_options_panel h3:before {
    font-family: FontAwesome;
    content: '\f013';
}
</style>
<?php } ?>