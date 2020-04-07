<?php
/**
 * Customizer Options
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Include necessary files.
get_template_part( 'framework/admin/customizer/controls/control-editor' );
get_template_part( 'framework/admin/modules/icon-picker/icon-picker-control' );
get_template_part( 'framework/admin/partial-refresh' );
get_template_part( 'framework/admin/modules/agama-upsell/class-customize' );
get_template_part( 'framework/admin/extra' );

// Disable Kirki Telemetry Module
add_filter( 'kirki_telemetry', '__return_false' );

/**
 * Update Kirki Path's
 *
 * @since 1.2.0
 */
if ( ! function_exists( 'agama_theme_kirki_update_url' ) ) {
    function agama_theme_kirki_update_url( $config ) {
        $config['url_path'] = AGAMA_URI . 'framework/admin/kirki/';
        return $config;
    }
}
add_filter( 'kirki/config', 'agama_theme_kirki_update_url' );

/**
 * Customize Register
 *
 * Access to $wp_customize object.
 *
 * @since 1.4.4
 * @return null
 */
function agama_customize_register( $wp_customize ) {
    
    $wp_customize->get_setting( 'blogname' )->transport           = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport    = 'postMessage';
    $wp_customize->get_setting( 'header_image' )->transport       = 'postMessage';
    $wp_customize->get_setting( 'header_image_data'  )->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial(
        'header_image',
        [
            'selector'        => '.agama-header-image-overlay',
            'render_callback' => [ 'Agama_Partial_Refresh', 'header_image' ]
        ]
    );
    
}
add_action( 'customize_register', 'agama_customize_register' );

##############################################
# SETUP THEME CONFIG
##############################################
    Kirki::add_config( 'agama_options', array(
        'option_type' => 'theme_mod',
        'capability'  => 'edit_theme_options'
    ) );
############################################################
# PAGE BUILDER SECTION
############################################################
    Kirki::add_section( 'agama_page_builder_section', array(
        'title'     => esc_attr__( 'Page Builder', 'agama' ),
        'priority'  => 1
    ) );
    Kirki::add_field( 'agama_options', array(
        'label'     => esc_attr__( 'Page to Build', 'agama' ),
        'tooltip'   => esc_attr__( 'Select page to build.', 'agama' ),
        'section'   => 'agama_page_builder_section',
        'settings'  => 'agama_page_builder_page',
        'type'      => 'dropdown-pages'
    ) );
#########################################################
# SITE IDENTITY PANEL
#########################################################
    Kirki::add_panel( 'agama_site_identity_panel', array(
        'title' => esc_attr__( 'Site Identity', 'agama' )
    ) );
    ###########################################
    # TITLE & TAGLINE GENERAL SECTION
    ###########################################
    Kirki::add_section( 'title_tagline', array(
        'title' => esc_attr__( 'General', 'agama' ),
        'panel' => 'agama_site_identity_panel'
    ) );
    #################################################################
    # TITLE & TAGLINE STYLING SECTION
    #################################################################
    Kirki::add_section( 'agama_title_tagline_styling_section', [
        'title'         => esc_attr__( 'Styling', 'agama' ),
        'panel'         => 'agama_site_identity_panel'
    ] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Site Identity Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select site identity color.', 'agama' ),
		'section'		=> 'agama_title_tagline_styling_section',
		'settings'		=> 'agama_header_logo_color',
		'type'			=> 'color',
        'transport'		=> 'auto',
        'default'		=> '#bdbdbd',
		'output'		=> [
			[
				'element'	=> '#masthead h1 a',
				'property'	=> 'color'
			]
		]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Site Identity Hover Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select site identity hover color.', 'agama' ),
		'section'		=> 'agama_title_tagline_styling_section',
		'settings'		=> 'agama_header_logo_hover_color',
		'type'			=> 'color',
        'transport'		=> 'auto',
        'default'		=> '#333',
		'output'		=> [
			[
				'element'	=> '#masthead h1 a:hover',
				'property'	=> 'color'
			]
		]
	] );
    ################################################
	# TITLE TAGLINE TYPOGRAPHY SECTION
	################################################
	Kirki::add_section( 'agama_title_tagline_typo', [
		'title'			=> esc_attr__( 'Typography', 'agama' ),
		'panel'			=> 'agama_site_identity_panel'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Site Title Font', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select site title font.', 'agama' ),
		'section'		    => 'agama_title_tagline_typo',
		'settings'		    => 'agama_logo_font',
		'type'			    => 'typography',
        'transport'         => 'auto',
		'default'			=> [
			'font-family' 	=> 'Montserrat',
            'variant'       => '900',
			'font-size'		=> '35px'
		],
        'output'			=> [
			[
				'element' 	=> '#masthead:not(.shrinked) .site-title a'
			]
		]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Site Title Shrinked', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select header shrinked site title font size.', 'agama' ),
		'section'		    => 'agama_title_tagline_typo',
		'settings'		    => 'agama_logo_shrink_font',
		'type'			    => 'typography',
        'transport'         => 'auto',
        'default'		    => [
            'font-family'   => 'Montserrat',
            'variant'       => '900',
			'font-size'	    => '28px'
		],
		'output'		    => [
			[
				'element'   => '#masthead.shrinked .site-title a'
			]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'default'
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_title_tagline_typo_upsell',
        'section'     => 'agama_title_tagline_typo',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Site Title Shrinked Typography</li>' .  
                         '</ul>' . 
                         '</div>'
    ] );
#######################################################
# GENERAL PANEL
#######################################################
	Kirki::add_panel( 'agama_general_panel', array(
		'title'			=> esc_attr__( 'General', 'agama' ),
		'priority'		=> 10
	) );
    ########################################################
    # GENERAL BODY SECTION
    ########################################################
    Kirki::add_section( 'background_image', [
		'title'			=> esc_attr__( 'Body', 'agama' ),
		'panel'			=> 'agama_general_panel'
	] );
    Kirki::add_field( 'agama_options', [
        'label'     => esc_attr__( 'Body Font', 'agama' ),
        'tooltip'   => esc_attr__( 'Customize body font.', 'agama' ),
        'section'   => 'background_image',
        'settings'  => 'agama_body_font',
        'type'      => 'typography',
        'transport' => 'auto',
        'default'   => [
            'font-family'       => 'Raleway',
            'variant'           => '400',
            'font-size'         => '14px',
            'line-height'       => '1',
            'letter-spacing'    => '0',
            'subsets'           => [],
            'color'             => '#747474',
            'text-transform'    => 'none',
            'text-align'        => 'left'
        ],
        'output' => [
            [
                'element' => 'body'
            ]
        ],
        'priority' => 1
    ] );
    Kirki::add_field( 'agama_options', [
        'label'     => esc_attr__( 'Background Color', 'agama' ),
        'tooltip'   => esc_attr__( 'Select body background color.', 'agama' ),
        'section'   => 'background_image',
        'settings'  => 'agama_body_background_color',
        'type'      => 'color',
        'transport' => 'auto',
        'default'   => '#e6e6e6',
        'output'    => [
            [
                'element'   => 'body',
                'property'  => 'background-color'
            ]
        ]
    ] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_general_body_upsell',
        'section'     => 'background_image',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Background Animate</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    #########################################################
    # GENERAL SKINS SECTION
    #########################################################
    Kirki::add_section( 'agama_general_skins_section', array(
        'title'         => __( 'Skins', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Skin', 'agama' ),
		'tooltip'	    => __( 'Select theme skin.', 'agama' ),
		'section'		=> 'agama_general_skins_section',
		'settings'		=> 'agama_skin',
		'type'			=> 'select',
		'choices'		=> array(
			'light'		=> __( 'Light', 'agama' ),
			'dark'		=> __( 'Dark', 'agama' )
		),
		'default'		=> 'light'
	) );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Primary Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Set theme primary color.', 'agama' ),
		'section'		=> 'agama_general_skins_section',
		'settings'		=> 'agama_primary_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'output'		=> [
			[
				'element'	=> 'a:hover, .mobile-menu-toggle-label, .vision-search-submit:hover, .entry-title a:hover, .entry-meta a:not(.button):hover, .entry-content a:hover, .comment-content a:hover, .single-line-meta a:hover, a.comment-reply-link:hover, a.comment-edit-link:hover, article header a:hover, .comments-title span, .comment-reply-title span, .widget a:hover, .comments-link a:hover, .entry-header header a:hover, .tagcloud a:hover, footer[role="contentinfo"] a:hover',
				'property'	=> 'color'
			],
			[
				'element'	=> '.mobile-menu-toggle-inner, .mobile-menu-toggle-inner::before, .mobile-menu-toggle-inner::after, .woocommerce span.onsale, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .loader-ellips__dot',
				'property'	=> 'background-color'
			],
            [
                'element'   => '#masthead:not(.header_v1), ul.agama-navigation ul:not(.mega-menu-column)',
                'property'  => 'border-top-color'
            ],
			[
				'element'	=> '#masthead.header_v2, .tagcloud a:hover, .wpcf7-text:focus, .wpcf7-email:focus, .wpcf7-textarea:focus',
				'property'	=> 'border-color'
			],
		],
		'transport'		=> 'auto',
		'default'		=> '#ac32e4'
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_general_skins_upsell',
        'section'     => 'agama_general_skins_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Links Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Links Hover Color</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    #######################################################
    # SEARCH PAGE SECTION
    #######################################################
    Kirki::add_section( 'agama_search_page_section', array(
        'title'         => __( 'Search Page', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Thumbnails', 'agama' ),
		'tooltip'	    => __( 'Enable posts featured thumbnails on search page.', 'agama' ),
		'section'		=> 'agama_search_page_section',
		'settings'		=> 'agama_search_page_thumbnails',
		'type'			=> 'switch',
		'default'		=> false
	) );
    ###############################################
    # STATIC FRONT PAGE SECTION
    ###############################################
    Kirki::add_section( 'static_front_page', array(
		'title'			=> __( 'Static Front Page', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_general_panel',
	) );
    ####################################################
    # COMMENTS SECTION
    ####################################################
    Kirki::add_section( 'agama_comments_section', array(
        'title'         => __( 'Comments', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'HTML Tags Suggestion', 'agama' ),
		'tooltip'	    => __( 'Enable tags usage suggestion below comment form ?', 'agama' ),
		'settings'		=> 'agama_comments_tags_suggestion',
		'section'		=> 'agama_comments_section',
		'type'			=> 'switch',
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_general_comments_upsell',
        'section'     => 'agama_comments_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Enable / Disable Comments</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    #################################################
    # EXTRA SECTION
    #################################################
    Kirki::add_section( 'agama_extra_section', array(
        'title'         => __( 'Extra', 'agama' ),
        'panel'         => 'agama_general_panel'
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Nicescroll', 'agama' ),
		'tooltip'	    => __( 'Enable browser nicescroll.', 'agama' ),
		'section'		=> 'agama_extra_section',
		'settings'		=> 'agama_nicescroll',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Back to Top', 'agama' ),
		'tooltip'	    => __( 'Enable back to top button.', 'agama' ),
		'section'		=> 'agama_extra_section',
		'settings'		=> 'agama_to_top',
		'type'			=> 'switch',
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_general_extra_upsell',
        'section'     => 'agama_extra_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Development Mode</li>' . 
                         '<li><span class="upsell-pro-label"></span> Rich Snippets</li>' . 
                         '<li><span class="upsell-pro-label"></span> Custom jQuery Head</li>' . 
                         '<li><span class="upsell-pro-label"></span> Custom jQuery Footer</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    ########################################
    # GENERAL ADDITIONAL CSS SECTION
    ########################################
    Kirki::add_section( 'custom_css', array(
		'title'			=> __( 'Additional CSS', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_general_panel'
	) );
######################################################
# LAYOUT PANEL
######################################################
    Kirki::add_panel( 'agama_layout_panel', array(
        'title'         => __( 'Layout', 'agama' ),
        'priority'      => 20
    ) );
    ##########################################################
    # LAYOUT GENERAL SECTION
    ##########################################################
	Kirki::add_section( 'agama_layout_general_section', [
		'title'			=> esc_attr__( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_layout_panel'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Layout Style', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select layout style.', 'agama' ),
		'section'		=> 'agama_layout_general_section',
		'settings'		=> 'agama_layout_style',
		'type'			=> 'select',
        'transport'     => 'postMessage',
		'choices'		=> [
			'fullwidth'	=> esc_attr__( 'Full-Width', 'agama' ),
			'boxed'		=> esc_attr__( 'Boxed', 'agama' )
		],
		'default'		=> 'fullwidth'
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_layout_general_upsell',
        'section'     => 'agama_layout_general_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Layout Width</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    ##########################################################
    # LAYOUT SIDEBAR SECTION
    ##########################################################
    Kirki::add_section( 'agama_layout_sidebar_section', [
        'title'      => esc_attr__( 'Sidebar', 'agama' ),
        'capability' => 'edit_theme_options',
        'panel'      => 'agama_layout_panel'
    ] );
	Kirki::add_field( 'agama_options', [
		'label'		=> esc_attr__( 'Sidebar Position', 'agama' ),
		'tooltip'	=> esc_attr__( 'Select sidebar position.', 'agama' ),
		'section'	=> 'agama_layout_sidebar_section',
		'settings'	=> 'agama_sidebar_position',
		'type'		=> 'select',
		'choices'	=> [
			'left'	=> esc_attr__( 'Left', 'agama' ),
			'right' => esc_attr__( 'Right', 'agama' )
		],
		'default'	=> 'right'
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_layout_sidebar_upsell',
        'section'     => 'agama_layout_sidebar_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Heading Typography</li>' . 
                         '<li><span class="upsell-pro-label"></span> Body Typography</li>' . 
                         '<li><span class="upsell-pro-label"></span> Links Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Links Hover Color</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
###################################################################################
# HEADER
###################################################################################
	Kirki::add_panel( 'agama_header_panel', array(
		'title'			=> __( 'Header', 'agama' ),
		'priority'		=> 30
	) );
	##################################################
	# HEADER GENERAL SECTION
	##################################################
	Kirki::add_section( 'agama_header_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_header_panel'
	) );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Style', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select header style.', 'agama' ),
		'section'		    => 'agama_header_section',
		'settings'		    => 'agama_header_style',
		'type'			    => 'radio-buttonset',
		'choices'		    => [
			'transparent'	=> esc_attr__( 'Header V1', 'agama' ),
			'default'		=> esc_attr__( 'Header V2', 'agama' ),
			'sticky'		=> esc_attr__( 'Header V3', 'agama' )
		],
		'default'		    => 'transparent'
	] );
    Kirki::add_field( 'agama_options', [
		'label'				=> esc_attr__( 'Enable Top Navigation', 'agama' ),
		'section'			=> 'agama_header_section',
		'settings'			=> 'agama_top_navigation',
		'type'				=> 'checkbox',
		'default'			=> true,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ],
        'partial_refresh'   => [
            'agama_top_navigation' => [
                'selector'         => [ '#agama-top-nav', 'div.top-links div' ],
                'render_callback'  => [ 'Agama_Partial_Refresh', 'preview_top_navigation' ]
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Enable Social Icons', 'agama' ),
		'section'		    => 'agama_header_section',
		'settings'		    => 'agama_top_nav_social',
		'type'			    => 'checkbox',
		'default'		    => true,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ],
        'partial_refresh'   => [
            'agama_top_nav_social' => [
                'selector'         => [ '#agama-top-social' ],
                'render_callback'  => [ 'Agama_Partial_Refresh', 'preview_top_nav_social_icons' ]
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'	           => esc_attr__( 'Top Margin', 'agama' ),
		'tooltip'          => esc_attr__( 'Set header top margin in PX. This feature works only with header V2', 'agama' ),
		'section'          => 'agama_header_section',
		'settings'         => 'agama_header_top_margin',
		'type'	           => 'slider',
		'choices'          => [
			'step'         => '1',
			'min'          => '0',
			'max'          => '100'
		],
        'transport'        => 'auto',
        'output'           => [
            [
                'element'  => 'body.header_v2 #agama-main-wrapper',
                'property' => 'margin-top',
                'suffix'   => 'px'
            ]
        ],
         'active_callback' => [
            [
                'setting'  => 'agama_header_style',
                'operator' => '==',
                'value'    => 'default'
            ]
        ],
		'default'		   => '0'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			   => esc_attr__( 'Top Border', 'agama' ),
		'tooltip'	       => esc_attr__( 'Select header top border height in PX. This feature works with header V2 & V3.', 'agama' ),
		'section'		   => 'agama_header_section',
		'settings'		   => 'agama_header_top_border_size',
		'type'			   => 'slider',
        'choices'          => [
            'min'          => '0',
            'max'          => '20',
            'step'         => '1'
        ],
        'transport'        => 'auto',
        'output'           => [
            [
                'element'  => '#masthead:not(.header_v1)',
                'property' => 'border-top-width',
                'suffix'   => 'px'
            ]
        ],
        'active_callback'  => [
            [
                'setting'  => 'agama_header_style',
                'operator' => 'contains',
                'value'    => [ 'default', 'sticky' ]
            ]
        ],
		'default'		   => '3'
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_header_general_upsell',
        'section'     => 'agama_header_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Top Border Style</li>' . 
                         '<li><span class="upsell-pro-label"></span> Top Border Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Inner Margin (H-V2)</li>' . 
                         '<li><span class="upsell-pro-label"></span> Search Icon</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
	#######################################################
	# HEADER LOGO SECTION
	#######################################################
	Kirki::add_section( 'agama_header_logo_section', array(
		'title'			=> esc_attr__( 'Logo', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_header_panel'
	) );
    Kirki::add_field( 'agama_options', array(
        'type'          => 'radio-image',
        'settings'      => 'agama_media_logo',
        'section'       => 'agama_header_logo_section',
        'default'       => 'desktop',
        'priority'      => 10,
        'transport'     => 'auto',
        'choices'       => array(
            'desktop'   => get_template_directory_uri() . '/assets/img/desktop.png',
            'tablet'    => get_template_directory_uri() . '/assets/img/tablet.png',
            'mobile'    => get_template_directory_uri() . '/assets/img/mobile.png',
        ),
        'output'        => array(
            array(
                'element'   => '',
                'property'  => ''
            )
        )
    ) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Desktop Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for desktop devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'desktop'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Desktop Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set desktop logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-desktop',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'desktop'
            ),
            array(
                'setting'   => 'agama_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Tablet Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for tablet devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_tablet_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'tablet'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Tablet Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set tablet logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_tablet_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-tablet',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'tablet'
            ),
            array(
                'setting'   => 'agama_tablet_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    Kirki::add_field( 'agama_options', array(
		'label'				=> esc_attr__( 'Mobile Logo', 'agama' ),
		'tooltip'		    => esc_attr__( 'Upload custom logo for mobile devices.', 'agama' ),
		'section'			=> 'agama_header_logo_section',
		'settings'			=> 'agama_mobile_logo',
		'type'				=> 'image',
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'mobile'
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => esc_attr__( 'Mobile Logo Max-height', 'agama' ),
		'tooltip'	        => esc_attr__( 'Set mobile logo max-height in PX.', 'agama' ),
		'section'		    => 'agama_header_logo_section',
		'settings'		    => 'agama_mobile_logo_max_height',
        'transport'         => 'auto',
		'type'			    => 'slider',
		'choices'		    => array(
			'step'		    => '1',
			'min'		    => '0',
			'max'		    => '250'
		),
		'default'		    => '90',
        'output'            => array(
            array(
                'element'   => '#agama-logo .logo-mobile',
                'property'  => 'max-height',
                'suffix'    => 'px'
            )
        ),
        'active_callback'   => array(
            array(
                'setting'   => 'agama_media_logo',
                'operator'  => '==',
                'value'     => 'mobile'
            ),
            array(
                'setting'   => 'agama_mobile_logo',
                'operator'  => '!==',
                'value'     => ''
            )
        )
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_header_logo_upsell',
        'section'     => 'agama_header_logo_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Logo Align</li>' . 
                         '<li><span class="upsell-pro-label"></span> Logo Shrinked Max-Height</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
	##########################################
	# HEADER IMAGE SECTION
	##########################################
	Kirki::add_section( 'header_image', [
		'title'			=> __( 'Header Image', 'agama' ),
		'panel'			=> 'agama_header_panel',
        'capability'    => 'edit_theme_options'
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> __( 'Enable particles?', 'agama' ),
		'settings'		=> 'agama_header_image_particles',
		'section'		=> 'header_image',
		'type'			=> 'checkbox',
		'default'		=> true,
		'priority'		=> 1
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Particle Circles Color', 'agama' ),
		'tooltip'	        => __( 'Set particles custom circles color ?', 'agama' ),
		'settings'		    => 'agama_header_image_particles_circle_color',
		'section'		    => 'header_image',
		'type'			    => 'color',
		'default'		    => '#fff',
		'priority'		    => 1,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_image_particles',
                'operator'  => '==',
                'value'     => true
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Particles Lines Color', 'agama' ),
		'tooltip'	        => __( 'Set particles custom lines color', 'agama' ),
		'settings'		    => 'agama_header_image_particles_lines_color',
		'section'		    => 'header_image',
		'type'			    => 'color',
		'default'		    => '#ac32e4',
		'priority'		    => 1,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_image_particles',
                'operator'  => '==',
                'value'     => true
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> __( 'Enable background overlay?', 'agama' ),
		'settings'		=> 'agama_header_image_overlay',
		'section'		=> 'header_image',
		'type'			=> 'checkbox',
		'default'		=> true,
		'priority'		=> 1
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => __( 'Background', 'agama' ),
		'tooltip'	        => __( 'Select header image background overlay colors.', 'agama' ),
		'settings'		    => 'agama_header_image_background',
		'section'		    => 'header_image',
		'type'			    => 'multicolor',
        'transport'         => 'postMessage',
        'choices'           => [
            'left'          => __( 'Left', 'agama' ),
            'right'         => __( 'Right', 'agama' )
        ],
		'default'		    => [
            'left'          => 'rgba(160,47,212,0.8)',
            'right'         => 'rgba(69,104,220,0.8)'
        ],
		'priority'		    => 1,
        'active_callback'   => [
            [
                'setting'   => 'agama_header_image_overlay',
                'operator'  => '==',
                'value'     => true
            ]
        ]
	] );
    ##########################################################
    # HEADER STYLING SECTION
    ##########################################################
    Kirki::add_section( 'agama_header_styling_section', [
        'title'      => esc_attr__( 'Styling', 'agama' ),
        'panel'      => 'agama_header_panel',
        'capability' => 'edit_theme_options'
    ] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Background Color', 'agama' ),
		'tooltip'		    => esc_attr__( 'Doesn\'t work with header V1 style.', 'agama' ),
		'section'		    => 'agama_header_styling_section',
		'settings'		    => 'agama_header_bg_color',
		'type'			    => 'color',
        'transport'         => 'auto',
        'choices'           => [
            'alpha'		    => true
        ],
        'default'		    => 'rgba(255, 255, 255, 1)',
		'output'		    => [
			[
				'element'	=> '#masthead:not(.header_v1)',
				'property'	=> 'background-color'
			],
			[
				'element'	=> '#masthead nav:not(.mobile-menu) ul li ul',
				'property'	=> 'background-color'
			]
		],
		'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Header Shrinked BG Color', 'agama' ),
		'tooltip'		    => esc_attr__( 'Work\'s only with header V1 & V3.', 'agama' ),
		'section'		    => 'agama_header_styling_section',
		'settings'		    => 'agama_header_shrink_bg_color',
		'type'			    => 'color',
        'choices'           => [
            'alpha'		    => true
        ],
		'transport'		    => 'auto',
		'output'		    => [
			[
				'element'	=> '#masthead.shrinked, #masthead.shrinked nav ul li ul',
				'property'	=> 'background-color'
			],
            [
                'element'   => '#masthead.shrinked #agama-mobile-nav ul',
                'property'  => 'background-color'
            ]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'default'
            ]
        ],
		'default'		    => 'rgba(255, 255, 255, .9)'
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Header Borders Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select header borders color.', 'agama' ),
		'section'		=> 'agama_header_styling_section',
		'settings'		=> 'agama_header_border_color',
		'type'			=> 'color',
        'transport'		=> 'auto',
        'choices'       => [
            'alpha'	    => true
        ],
        'default'		=> 'rgba(238, 238, 238, 1)',
		'output'		=> [
			[
				'element'	=> '.header_v2 #agama-primary-nav, #agama-top-social li',
				'property'	=> 'border-color'
			],
            [
                'element'   => '.agama-top-nav-wrapper',
                'property'  => 'box-shadow',
                'prefix'    => '0 1px 4px 0 '
            ]
		],
        'active_callback'   => [
            [
                'setting'   => 'agama_header_style',
                'operator'  => '!==',
                'value'     => 'transparent'
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_header_styling_upsell',
        'section'     => 'agama_header_styling_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Background Image</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Repeat</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Size</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Attachment</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Position</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
###############################################
# NAVIGATIONS PANEL
###############################################
	Kirki::add_panel( 'agama_nav_panel', array(
		'title'			=> __( 'Navigations', 'agama' ),
		'priority'		=> 40
	) );
	###################################################
	# NAVIGATION TOP SECTION
	###################################################
	Kirki::add_section( 'agama_nav_top_section', [
		'title'		 => esc_attr__( 'Navigation Top', 'agama' ),
		'panel'		 => 'agama_nav_panel',
		'capability' => 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_attr__( 'Font', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize top navigation font.', 'agama' ),
        'section'           => 'agama_nav_top_section',
        'settings'          => 'agama_navigation_top_font',
        'type'              => 'typography',
        'transport'         => 'auto',
        'output'            => [
            [
                'element'   => '#agama-top-nav a'    
            ]
        ],
        'default' => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'color'             => '#757575',
            'text-transform'    => 'uppercase'
        ]
    ] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Links Hover Color', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select navigation top links hover color.', 'agama' ),
		'settings'		    => 'agama_nav_top_hover_color',
		'section'		    => 'agama_nav_top_section',
		'type'			    => 'color',
        'transport'         => 'auto',
		'output'		    => [
			[
				'element'	=> '#agama-top-nav a:hover',
				'property'	=> 'color'
			],
            [
                'element'   => '#agama-top-nav li.current-menu-ancestor a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-top-nav li.current-menu-item a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-top-nav li.current_page_item a',
                'property'  => 'color'
            ]
		],
		'default'		    => '#333'
	] );
	#######################################################
	# NAVIGATION PRIMARY SECTION
	#######################################################
	Kirki::add_section( 'agama_nav_primary_section', [
		'title'			=> esc_attr__( 'Navigation Primary', 'agama' ),
		'panel'			=> 'agama_nav_panel',
		'capability'	=> 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'label'                 => esc_attr__( 'Font', 'agama' ),
        'tooltip'               => esc_attr__( 'Customize primary navigation font.', 'agama' ),
        'section'               => 'agama_nav_primary_section',
        'settings'              => 'agama_navigation_primary_font',
        'type'                  => 'typography',
        'transport'             => 'auto',
        'output'                => [
            [
                'element'       => '#agama-primary-nav a'    
            ]
        ],
        'default'               => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'color'             => '#bdbdbd',
            'text-transform'    => 'uppercase'
        ]
    ] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Links Hover Color', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select navigation primary links hover color.', 'agama' ),
		'settings'		    => 'agama_nav_primary_hover_color',
		'section'		    => 'agama_nav_primary_section',
		'type'			    => 'color',
        'transport'         => 'auto',
		'output'		    => [
			[
				'element'	=> '#agama-primary-nav a:hover',
				'property'	=> 'color'
			],
            [
                'element'   => '#agama-primary-nav li.current-menu-ancestor a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-primary-nav li.current-menu-item a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-primary-nav li.current_page_item a',
                'property'  => 'color'
            ]
		],
		'default'		    => '#333'
	] );
	######################################################
	# NAVIGATION MOBILE SECTION
	######################################################
	Kirki::add_section( 'agama_nav_mobile_section', [
		'title'			=> esc_attr__( 'Navigation Mobile', 'agama' ),
		'panel'			=> esc_attr__( 'agama_nav_panel', 'agama' ),
		'capability'	=> 'edit_theme_options'
	] );
    Kirki::add_field( 'agama_options', [
        'label'             => esc_attr__( 'Font', 'agama' ),
        'tooltip'           => esc_attr__( 'Customize mobile navigation font.', 'agama' ),
        'section'           => 'agama_nav_mobile_section',
        'settings'          => 'agama_mobile_navigation_font',
        'type'              => 'typography',
        'transport'         => 'auto',
        'output'            => [
            [
                'element'   => '#agama-mobile-nav a'    
            ],
            [
                'element'   => '#agama-mobile-nav ul > li.menu-item-has-children.open > a'
            ],
            [
                'element'   => '#agama-mobile-nav ul > li > ul li.menu-item-has-children > a'
            ]
        ],
        'default'               => [
            'font-family'       => 'Roboto Condensed',
            'variant'           => '700',
            'font-size'         => '14px',
            'letter-spacing'    => '0',
            'color'             => '#757575',
            'text-transform'    => 'uppercase'
        ]
    ] );
	Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Links Hover Color', 'agama' ),
		'tooltip'	        => esc_attr__( 'Select mobile menu links hover color.', 'agama' ),
		'settings'		    => 'agama_nav_mobile_hover_color',
		'section'		    => 'agama_nav_mobile_section',
		'type'			    => 'color',
        'transport'         => 'auto',
        'default'		    => '#333',
		'output'		    => [
			[
				'element'	=> '#agama-mobile-nav a:hover',
				'property'	=> 'color',
				'suffix'	=> '!important'
			],
            [
                'element'   => '#agama-mobile-nav li.current-menu-ancestor a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-mobile-nav li.current-menu-item a',
                'property'  => 'color'
            ],
            [
                'element'   => '#agama-mobile-nav li.current_page_item a',
                'property'  => 'color'
            ]
		]
	] );
    Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Menu Icon Title', 'agama' ),
		'tooltip'	    => esc_attr__( 'Set custom mobile menu title.', 'agama' ),
		'settings'		=> 'agama_nav_mobile_icon_title',
		'section'		=> 'agama_nav_mobile_section',
		'type'			=> 'text',
		'default'		=> ''
	] );
    Kirki::add_field( 'agama_options', [
        'label'     => esc_attr__( 'Mobile Menu Icon Color', 'agama' ),
        'tootlip'   => esc_attr__( 'Customize mobile menu icon color.', 'agama' ),
        'settings'  => 'agama_nav_mobile_menu_icon_color',
        'section'   => 'agama_nav_mobile_section',
        'transport' => 'auto',
        'type'      => 'color',
        'output'    => [
            [
                'element'  => 'button.mobile-menu-toggle, .mobile-menu-toggle-label',
                'property' => 'color'
            ],
            [
                'element'  => '.mobile-menu-toggle-inner, .mobile-menu-toggle-inner:before, .mobile-menu-toggle-inner:after',
                'property' => 'background-color'
            ]
        ]
    ] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_navigation_mobile_upsell',
        'section'     => 'agama_nav_mobile_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Top Navigation</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Color</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
#########################################
# MENUS PANEL
#########################################
    Kirki::add_panel( 'nav_menus', array(
        'title'     => __( 'Menus', 'agama' ),
        'priority'  => 50
    ) );
##################################################
# SLIDER
##################################################
	Kirki::add_panel( 'agama_slider_panel', array(
		'title'			=> __( 'Slider', 'agama' ),
		'tooltip'	    => __( 'Slider settings.', 'agama' ),
		'priority'		=> 60,
	) );
	##########################################################
	# SLIDER GENERAL SECTION
	##########################################################
	Kirki::add_section( 'agama_slider_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable', 'agama' ),
		'tooltip'	    => __( 'Enable slider ?', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_enable',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Overlay', 'agama' ),
		'tooltip'	    => __( 'Enable slider overlay ?', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_overlay',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Overlay BG Color', 'agama' ),
		'tooltip'		    => __( 'Set custom overlay background color.', 'agama' ),
		'section'			=> 'agama_slider_general_section',
		'settings'			=> 'agama_slider_overlay_bg_color',
		'type'				=> 'color',
		'choices'     		=> array(
			'alpha' 		=> true
		),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_slider_overlay',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'output'			=> array(
            array(
                'element'	=> '.camera_overlayer',
                'property'	=> 'background'
            )
		),
		'default'			=> 'rgba(26,131,192,0.5)'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Height', 'agama' ),
		'tooltip'	    => __( 'Set slider height in pixels (px). Set 0 for full screen slider.', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_height',
		'type'			=> 'number',
		'choices'		=> array(
			'min'		=> '0',
			'max'		=> '1000',
			'step'		=> '1'
		),
		'default'		=> '0'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Time', 'agama' ),
		'tooltip'	    => __( 'Milliseconds between the end of the sliding effect and the start of the nex one. 1000ms = 1sec', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_time',
		'type'			=> 'number',
		'choices'		=> array(
			'min'		=> '1000',
			'max'		=> '28000',
			'step'		=> '1'
		),
		'default'		=> '7000'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Visibility', 'agama' ),
		'tooltip'	    => __( 'Select where the slider should be visible.', 'agama' ),
		'section'		=> 'agama_slider_general_section',
		'settings'		=> 'agama_slider_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'homepage'	=> __( 'Home Page', 'agama' ),
			'frontpage'	=> __( 'Front Page', 'agama' )
		),
		'default'		=> 'homepage'
	) );
	############################################################
	# PARTICLES SECTION
	############################################################
	Kirki::add_section( 'agama_slider_particles_section', array(
		'title'			=> __( 'Particles', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Particles', 'agama' ),
		'tooltip'	    => __( 'Enable particles on slider ?', 'agama' ),
		'settings'		=> 'agama_slider_particles',
		'section'		=> 'agama_slider_particles_section',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Particle Circles Color', 'agama' ),
		'tooltip'	    => __( 'Set particles custom circles color ?', 'agama' ),
		'settings'		=> 'agama_slider_particles_circle_color',
		'section'		=> 'agama_slider_particles_section',
		'type'			=> 'color',
		'default'		=> '#ac32e4'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Particles Lines Color', 'agama' ),
		'tooltip'	    => __( 'Set particles custom lines color', 'agama' ),
		'settings'		=> 'agama_slider_particles_lines_color',
		'section'		=> 'agama_slider_particles_section',
		'type'			=> 'color',
		'default'		=> '#ac32e4'
	) );
	###################################################
	# SLIDE 1 SECTION
	###################################################
	Kirki::add_section( 'agama_slide_1_section', array(
		'title'			=> __( 'Slide #1', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Image', 'agama' ),
		'settings'		=> 'agama_slider_image_1',
		'section'		=> 'agama_slide_1_section',
		'type'			=> 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Title', 'agama' ),
		'tooltip'	    => __( 'Add custom slide title. If empty the title will be hidden.', 'agama' ),
		'section'		    => 'agama_slide_1_section',
		'settings'		    => 'agama_slider_title_1',
		'type'			    => 'text',
		'default'		    => __( 'Welcome to Agama', 'agama' ),
        'partial_refresh'   => array(
            'agama_slider_title_1'  => array(
                'selector'          => '.slide-1 h2.slide-title',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_slide_1_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title Animation', 'agama' ),
		'tooltip'	    => __( 'Select title slide animation.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_title_animation_1',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'default'		=> 'bounceInLeft'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title Color', 'agama' ),
		'tooltip'	    => __( 'Select slide title color.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_title_color_1',
		'type'			=> 'color',
		'default'		=> '#fff'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Slider Content Top Distance', 'agama' ),
		'tooltip'	    => __( 'Set slider content top distance in %.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_content_top_1',
		'type'			=> 'slider',
		'choices'		=> array(
			'step'		=> '1',
			'min'		=> '0',
			'max'		=> '100'
		),
		'default'		=> '40'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Button Title', 'agama' ),
		'tooltip'	        => __( 'Set custom button title. If empty the button will be hidden.', 'agama' ),
		'section'		    => 'agama_slide_1_section',
		'settings'		    => 'agama_slider_button_title_1',
		'type'			    => 'text',
		'default'		    => __( 'Learn More', 'agama' ),
        'partial_refresh'   => array(
            'agama_slider_button_title_1' => array(
                'selector'          => '.slide-1 a.button',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_slide_1_button' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button Animation', 'agama' ),
		'tooltip'	    => __( 'Select button slide animation.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_button_animation_1',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'default'		=> 'bounceInRight'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button URL', 'agama' ),
		'tooltip'	    => __( 'Set button url.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_button_url_1',
		'type'			=> 'text',
		'default'		=> '#'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button BG Color', 'agama' ),
		'tooltip'	    => __( 'Select button background color.', 'agama' ),
		'section'		=> 'agama_slide_1_section',
		'settings'		=> 'agama_slider_button_bg_color_1',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '#agama_slider .slide-1 a.button',
				'property'	=> 'color'
			),
			array(
				'element'	=> '#agama_slider .slide-1 a.button',
				'property'	=> 'border-color'
			),
			array(
				'element'	=> '#agama_slider .slide-1 a.button:hover',
				'property'	=> 'background-color'
			)
		),
		'default'		=> '#ac32e4'
	) );
	###################################################
	# SLIDE 2 SECTION
	###################################################
	Kirki::add_section( 'agama_slide_2_section', array(
		'title'			=> __( 'Slide #2', 'agama' ),
		'panel'			=> 'agama_slider_panel',
		'capability'	=> 'edit_theme_options'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Image', 'agama' ),
		'settings'		=> 'agama_slider_image_2',
		'section'		=> 'agama_slide_2_section',
		'type'			=> 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title', 'agama' ),
		'tooltip'	    => __( 'Add custom slide title. If empty the title will be hidden.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_title_2',
		'type'			=> 'text',
		'default'		=> __( 'Welcome to Agama', 'agama' ),
        'partial_refresh'   => array(
            'agama_slider_title_2'  => array(
                'selector'          => '.slide-2 h2.slide-title',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_slide_2_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title Animation', 'agama' ),
		'tooltip'	    => __( 'Select title slide animation.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_title_animation_2',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'default'		=> 'bounceInLeft'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title Color', 'agama' ),
		'tooltip'	    => __( 'Select slide title color.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_title_color_2',
		'type'			=> 'color',
		'default'		=> '#fff'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Slider Content Top Distance', 'agama' ),
		'tooltip'	    => __( 'Set slider content top distance in %.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_content_top_2',
		'type'			=> 'slider',
		'choices'		=> array(
			'step'		=> '1',
			'min'		=> '0',
			'max'		=> '100'
		),
		'default'		=> '40'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Button Title', 'agama' ),
		'tooltip'	    => __( 'Set custom button title. If empty the button will be hidden.', 'agama' ),
		'section'		    => 'agama_slide_2_section',
		'settings'		    => 'agama_slider_button_title_2',
		'type'			    => 'text',
		'default'		    => __( 'Learn More', 'agama' ),
        'partial_refresh'   => array(
            'agama_slider_button_title_2' => array(
                'selector'          => '.slide-2 a.button',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_slide_2_button' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button Animation', 'agama' ),
		'tooltip'	    => __( 'Select button slide animation.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_button_animation_2',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'default'		=> 'bounceInRight'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button URL', 'agama' ),
		'tooltip'	    => __( 'Set button url.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_button_url_2',
		'type'			=> 'text',
		'default'		=> '#'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Button BG Color', 'agama' ),
		'tooltip'	    => __( 'Select button background color.', 'agama' ),
		'section'		=> 'agama_slide_2_section',
		'settings'		=> 'agama_slider_button_bg_color_2',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '#agama_slider .slide-2 a.button',
				'property'	=> 'color'
			),
			array(
				'element'	=> '#agama_slider .slide-2 a.button',
				'property'	=> 'border-color'
			),
			array(
				'element'	=> '#agama_slider .slide-2 a.button:hover',
				'property'	=> 'background-color'
			)
		),
		'default'		=> '#ac32e4'
	) );
###################################################################################
# BREADCRUMB
###################################################################################
	Kirki::add_section( 'agama_breadcrumb_section', array(
		'title'			=> __( 'Breadcrumb', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 50,
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb', 'agama' ),
		'tooltip'	    => __( 'Enable breadcrumb ?', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb on Home Page', 'agama' ),
		'tooltip'	    => __( 'Enable breadcrumb on home page ?', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_homepage',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Breadcrumb Style', 'agama' ),
		'tooltip'	    => __( 'Select breadcrumb style.', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_style',
		'type'			=> 'select',
		'choices'		=> array(
			'mini'		=> __( 'Mini', 'agama' ),
			'normal'	=> __( 'Normal', 'agama' )
		),
		'default'		=> 'mini'
	) );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Background Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb background color.', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_bg_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#F5F5F5',
        'output'        => [
            [
                'element'   => '#page-title',
                'property'  => 'background-color'
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Font Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb font color.', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_text_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#444',
        'output'        => [
            [
                'element'  => '#page-title h1, .breadcrumb > .active',
                'property' => 'color'
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', [
		'label'			=> esc_attr__( 'Links Color', 'agama' ),
		'tooltip'	    => esc_attr__( 'Select breadcrumb links color.', 'agama' ),
		'section'		=> 'agama_breadcrumb_section',
		'settings'		=> 'agama_breadcrumb_links_color',
		'type'			=> 'color',
        'transport'     => 'auto',
		'default'		=> '#444',
        'output'        => [
            [
                'element'  => '#page-title a',
                'property' => 'color'
            ]
        ]
	] );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_breadcrumb_upsell',
        'section'     => 'agama_breadcrumb_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Breadcrumb Height</li>' . 
                         '<li><span class="upsell-pro-label"></span> Breadcrumb Prefix</li>' . 
                         '<li><span class="upsell-pro-label"></span> Breadcrumb Separator</li>' . 
                         '<li><span class="upsell-pro-label"></span> Post Categories</li>' . 
                         '<li><span class="upsell-pro-label"></span> Post Archives</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Repeat</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Size</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Attachment</li>' . 
                         '<li><span class="upsell-pro-label"></span> Background Image Position</li>' . 
                         '<li><span class="upsell-pro-label"></span> Links Hover Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Breadcrumb Typography</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
###################################################################################
# FRONTPAGE BOXES
###################################################################################
	Kirki::add_panel( 'agama_frontpage_boxes_panel', array(
		'title'			=> __( 'Front Page Boxes', 'agama' ),
		'tooltip'	    => __( 'Front page boxes section.', 'agama' ),
		'priority'		=> 70
	) );
	#############################################################
	# FRONTPAGE BOXES GENERAL SECTION
	#############################################################
	Kirki::add_section( 'agama_frontpage_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable ?', 'agama' ),
		'tooltip'	    => __( 'Global enable | disable.', 'agama' ),
		'settings'		=> 'agama_frontpage_boxes',
		'section'		=> 'agama_frontpage_general_section',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Visibility', 'agama' ),
		'tooltip'	    => __( 'Select where you want front page boxes to be visible.', 'agama' ),
		'section'		=> 'agama_frontpage_general_section',
		'settings'		=> 'agama_frontpage_boxes_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'homepage'	=> __( 'Home Page', 'agama' ),
			'frontpage'	=> __( 'Front Page', 'agama' ),
			'allpages'	=> __( 'All Pages', 'agama' )
		),
		'default'		=> 'homepage'
	) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Front Page Boxes Heading', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom heading for front page boxes. Empty = Disabled', 'agama' ),
        'section'       => 'agama_frontpage_general_section',
        'settings'      => 'agama_frontpage_boxes_heading',
        'type'          => 'text',
        'default'       => esc_html__( 'Front Page Boxes', 'agama' )
    ) );
	#############################################################
	# FRONTPAGE BOXES SECTION 1
	#############################################################
	Kirki::add_section( 'agama_frontpage_boxes_section_1', array(
		'title'			=> __( 'Front Page Box #1', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable', 'agama' ),
        'tooltip'       => __( 'If disabled the front page box #1 will be hidden.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_1',
		'settings'		=> 'agama_frontpage_box_1_enable',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Title', 'agama' ),
		'tooltip'	        => __( 'Write box custom title.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_1',
		'settings'		    => 'agama_frontpage_box_1_title',
		'type'			    => 'text',
		'default'           => __( 'Responsive Layout', 'agama' ),
        'partial_refresh'   => array(
            'agama_frontpage_box_1_title' => array(
                'selector'          => '.fbox-1 h2',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_1_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Select Icon', 'agama' ),
		'tooltip'	        => __( 'Select desired box icon.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_1',
		'settings'		    => 'agama_frontpage_box_1_icon',
		'type'			    => 'agip',
		'default'		    => 'fa-tablet',
        'partial_refresh'   => array(
            'agama_frontpage_box_1_icon' => array(
                'selector'          => '.fbox-1 span.fbox-icon',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_1_icon' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Icon Color', 'agama' ),
		'tooltip'	    => __( 'Select icon color.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_1',
		'settings'		=> 'agama_frontpage_box_1_icon_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '.fbox-1 i',
				'property'	=> 'color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> '.fbox-1 i',
				'function'	=> 'css',
				'property'	=> 'color'
			)
		),
		'default'		=> '#ac32e4'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Image', 'agama' ),
		'tooltip'	        => __('You can use image instead of FontAwesome icon, just upload it here.', 'agama'),
		'section'		    => 'agama_frontpage_boxes_section_1',
		'settings'		    => 'agama_frontpage_1_img',
		'type'			    => 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Icon / Image URL', 'agama' ),
		'tooltip'	    => __( 'Add box icon / image custom url. Ex: http://google.com', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_1',
		'settings'		=> 'agama_frontpage_box_1_icon_url',
		'type'			=> 'text'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Box Text', 'agama' ),
		'tooltip'	        => __( 'Write box custom text.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_1',
		'settings'		    => 'agama_frontpage_box_1_text',
		'type'			    => 'textarea',
		'default'		    => 'Powerful Layout with Responsive functionality that can be adapted to any screen size.',
        'partial_refresh'   => array(
            'agama_frontpage_box_1_text' => array(
                'selector'          => '.fbox-1 p',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_1_desc' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Animated', 'agama' ),
		'tooltip'	    => __( 'Enable box loading animation.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_1',
		'settings'		=> 'agama_frontpage_box_1_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Box Animation', 'agama' ),
		'tooltip'		    => __( 'Select box appear loading animation.', 'agama' ),
		'section'			=> 'agama_frontpage_boxes_section_1',
		'settings'			=> 'agama_frontpage_box_1_animation',
		'type'				=> 'select',
		'choices'			=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_frontpage_box_1_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'			=> 'fadeInLeft'
	) );
	#############################################################
	# FRONTPAGE BOXES SECTION 2
	#############################################################
	Kirki::add_section( 'agama_frontpage_boxes_section_2', array(
		'title'			=> __( 'Front Page Box #2', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable', 'agama' ),
        'tooltip'       => __( 'If disabled the front page box #2 will be hidden.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_2',
		'settings'		=> 'agama_frontpage_box_2_enable',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Title', 'agama' ),
		'tooltip'	        => __( 'Write box custom title.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_2',
		'settings'		    => 'agama_frontpage_box_2_title',
		'type'			    => 'text',
		'default'		    => 'Endless Possibilities',
        'partial_refresh'   => array(
            'agama_frontpage_box_2_title' => array(
                'selector'          => '.fbox-2 h2',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_2_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Select Icon', 'agama' ),
		'tooltip'	        => __( 'Select desired box icon.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_2',
		'settings'		    => 'agama_frontpage_box_2_icon',
		'type'			    => 'agip',
		'default'		    => 'fa-cogs',
        'partial_refresh'   => array(
            'agama_frontpage_box_2_icon' => array(
                'selector'          => '.fbox-2 span.fbox-icon',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_2_icon' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Icon Color', 'agama' ),
		'tooltip'	    => __( 'Select icon color.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_2',
		'settings'		=> 'agama_frontpage_box_2_icon_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '.fbox-2 i',
				'property'	=> 'color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> '.fbox-2 i',
				'function'	=> 'css',
				'property'	=> 'color'
			)
		),
		'default'		=> '#ac32e4'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Image', 'agama' ),
		'tooltip'	    => __('You can use image instead of FontAwesome icon, just upload it here.', 'agama'),
		'section'		=> 'agama_frontpage_boxes_section_2',
		'settings'		=> 'agama_frontpage_2_img',
		'type'			=> 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Icon / Image URL', 'agama' ),
		'tooltip'	    => __( 'Add box icon / image custom url. Ex: http://google.com', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_2',
		'settings'		=> 'agama_frontpage_box_2_icon_url',
		'type'			=> 'text'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Box Text', 'agama' ),
		'tooltip'	        => __( 'Write custom text.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_2',
		'settings'		    => 'agama_frontpage_box_2_text',
		'type'			    => 'textarea',
		'default'		    => 'Complete control on each & every element that provides endless customization possibilities.',
        'partial_refresh'   => array(
            'agama_frontpage_box_2_text' => array(
                'selector'          => '.fbox-2 p',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_2_desc' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Animated', 'agama' ),
		'tooltip'	    => __( 'Enable box appear loading animation.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_2',
		'settings'		=> 'agama_frontpage_box_2_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Box Animation', 'agama' ),
		'tooltip'		    => __( 'Select box appear loading animation.', 'agama' ),
		'section'			=> 'agama_frontpage_boxes_section_2',
		'settings'			=> 'agama_frontpage_box_2_animation',
		'type'				=> 'select',
		'choices'			=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_frontpage_box_2_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'			=> 'fadeInDown'
	) );
	#############################################################
	# FRONTPAGE BOXES SECTION 3
	#############################################################
	Kirki::add_section( 'agama_frontpage_boxes_section_3', array(
		'title'			=> __( 'Front Page Box #3', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable', 'agama' ),
        'tooltip'       => __( 'If disabled the front page box #3 will be hidden.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_enable',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title', 'agama' ),
		'tooltip'	    => __( 'Write box custom title.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_title',
		'type'			=> 'text',
		'default'		=> 'Boxed & Wide Layouts',
        'partial_refresh'   => array(
            'agama_frontpage_box_3_title' => array(
                'selector'          => '.fbox-3 h2',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_3_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Select Icon', 'agama' ),
		'tooltip'	    => __( 'Select desired box icon.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_icon',
		'type'			=> 'agip',
		'default'		=> 'fa-laptop',
        'partial_refresh'   => array(
            'agama_frontpage_box_3_icon' => array(
                'selector'          => '.fbox-3 span.fbox-icon',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_3_icon' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Icon Color', 'agama' ),
		'tooltip'	    => __( 'Select icon color.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_icon_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '.fbox-3 i',
				'property'	=> 'color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> '.fbox-3 i',
				'function'	=> 'css',
				'property'	=> 'color'
			)
		),
		'default'		=> '#ac32e4'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Image', 'agama' ),
		'tooltip'	    => __('You can use image instead of FontAwesome icon, just upload it here.', 'agama'),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_3_img',
		'type'			=> 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Icon / Image URL', 'agama' ),
		'tooltip'	    => __( 'Add box icon / image custom url. Ex: http://google.com', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_icon_url',
		'type'			=> 'text'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Box Text', 'agama' ),
		'tooltip'	        => __( 'Write box custom text.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_3',
		'settings'		    => 'agama_frontpage_box_3_text',
		'type'			    => 'textarea',
		'default'		    => 'Stretch your Website to the Full Width or make it boxed to surprise your visitors.',
        'partial_refresh'   => array(
            'agama_frontpage_box_3_text' => array(
                'selector'          => '.fbox-3 p',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_3_desc' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Animated', 'agama' ),
		'tooltip'	    => __( 'Enable box appear loading animation.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_3',
		'settings'		=> 'agama_frontpage_box_3_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Box Animation', 'agama' ),
		'tooltip'		    => __( 'Select box appear loading animation.', 'agama' ),
		'section'			=> 'agama_frontpage_boxes_section_3',
		'settings'			=> 'agama_frontpage_box_3_animation',
		'type'				=> 'select',
		'choices'			=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_frontpage_box_3_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'			=> 'fadeInUp'
	) );
	#############################################################
	# FRONTPAGE BOXES SECTION 4
	#############################################################
	Kirki::add_section( 'agama_frontpage_boxes_section_4', array(
		'title'			=> __( 'Front Page Box #4', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 60,
		'panel'			=> 'agama_frontpage_boxes_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Enable', 'agama' ),
        'tooltip'       => __( 'If disabled the front page box #4 will be hidden.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_enable',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Title', 'agama' ),
		'tooltip'	    => __( 'Write box custom title.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_title',
		'type'			=> 'text',
		'default'		=> 'Powerful Performance',
        'partial_refresh'   => array(
            'agama_frontpage_box_4_title' => array(
                'selector'          => '.fbox-4 h2',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_4_title' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Select Icon', 'agama' ),
		'tooltip'	    => __( 'Select desired box icon.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_icon',
		'type'			=> 'agip',
		'default'		=> 'fa-magic',
        'partial_refresh'   => array(
            'agama_frontpage_box_4_icon' => array(
                'selector'          => '.fbox-4 span.fbox-icon',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_4_icon' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Icon Color', 'agama' ),
		'tooltip'	    => __( 'Select icon color.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_icon_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '.fbox-4 i',
				'property'	=> 'color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> '.fbox-4 i',
				'function'	=> 'css',
				'property'	=> 'color'
			)
		),
		'default'		=> '#ac32e4'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Image', 'agama' ),
		'tooltip'	    => __('You can use image instead of FontAwesome icon, just upload it here.', 'agama'),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_4_img',
		'type'			=> 'image'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Icon / Image URL', 'agama' ),
		'tooltip'	    => __( 'Add box icon / image custom url. Ex: http://google.com', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_icon_url',
		'type'			=> 'text'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Box Text', 'agama' ),
		'tooltip'	        => __( 'Write box custom text.', 'agama' ),
		'section'		    => 'agama_frontpage_boxes_section_4',
		'settings'		    => 'agama_frontpage_box_4_text',
		'type'			    => 'textarea',
		'default'		    => 'Optimized code that are completely customizable and deliver unmatched fast performance.',
        'partial_refresh'   => array(
            'agama_frontpage_box_4_text' => array(
                'selector'          => '.fbox-4 p',
                'render_callback'   => array( 'Agama_Partial_Refresh', 'preview_fbox_4_desc' )
            )
        )
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Box Animated', 'agama' ),
		'tooltip'	    => __( 'Enable box appear loading animation.', 'agama' ),
		'section'		=> 'agama_frontpage_boxes_section_4',
		'settings'		=> 'agama_frontpage_box_4_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Box Animation', 'agama' ),
		'tooltip'		    => __( 'Select box appear loading animation.', 'agama' ),
		'section'			=> 'agama_frontpage_boxes_section_4',
		'settings'			=> 'agama_frontpage_box_4_animation',
		'type'				=> 'select',
		'choices'			=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_frontpage_box_4_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'			=> 'fadeInRight'
	) );
###################################################################################
# BLOG
###################################################################################
	Kirki::add_panel( 'agama_blog_panel', array(
		'title'			=> __( 'Blog', 'agama' ),
		'tooltip'	    => __( 'Blog panel.', 'agama' ),
		'priority'		=> 80
	) );
	########################################################
	# BLOG GENERAL SECTION
	########################################################
	Kirki::add_section( 'agama_blog_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Layout', 'agama' ),
		'tooltip'	        => __( 'Select blog layout.', 'agama' ),
		'section'		    => 'agama_blog_general_section',
		'settings'		    => 'agama_blog_layout',
		'type'			    => 'select',
		'choices'		    => array(
			'list'			=> __( 'List Layout', 'agama' ),
			'grid'			=> __( 'Grid Layout', 'agama' ),
			'small_thumbs'	=> __( 'Small Thumbs Layout', 'agama' )
		),
		'default'		    => 'list'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Posts Animated', 'agama' ),
		'tooltip'	    => __( 'Enable posts loading animation ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_posts_load_animated',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Posts Animation', 'agama' ),
		'tooltip'	    => __( 'Select posts loading animation.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_posts_load_animation',
		'type'			=> 'select',
		'choices'		=> AgamaAnimate::choices(),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_posts_load_animated',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> 'bounceInUp'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'				=> __( 'Featured Image Permalink', 'agama' ),
		'tooltip'		=> __( 'Enable post featured image permalink ? If enabled the post featured images will become clickable links.', 'agama' ),
		'section'			=> 'agama_blog_general_section',
		'settings'			=> 'agama_blog_thumbnails_permalink',
		'type'				=> 'switch',
		'default'			=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Excerpt', 'agama' ),
		'tooltip'	    => __( 'Set posts lenght on blog loop page.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_excerpt',
		'type'			=> 'slider',
		'choices'		=> array(
			'step'		=> '1',
			'min'		=> '0',
			'max'		=> '500'
		),
		'default'		=> '70'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Read More', 'agama' ),
		'tooltip'	    => __( 'Enable read more url on blog excerpt ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_readmore_url',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'About Author', 'agama' ),
		'tooltip'	    => __( 'Enable about author section below single post content ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_about_author',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Infinite Scroll', 'agama' ),
		'tooltip'	    => __( 'Enable infinite scroll ?', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_infinite_scroll',
		'type'			=> 'switch',
		'default'		=> false
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Infinite Trigger', 'agama' ),
		'tooltip'	    => __( 'Select infinite scroll trigger.', 'agama' ),
		'section'		=> 'agama_blog_general_section',
		'settings'		=> 'agama_blog_infinite_trigger',
		'type'			=> 'select',
		'choices'		=> array(
			'auto'		=> __( 'Automatic', 'agama' ),
			'button'	=> __( 'Button', 'agama' )
		),
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_infinite_scroll',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> 'button'
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_blog_general_upsell',
        'section'     => 'agama_blog_general_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Featured Images Crop</li>' .  
                         '<li><span class="upsell-pro-label"></span> Images Hover Effect</li>' .   
                         '<li><span class="upsell-pro-label"></span> LightBox</li>' .  
                         '<li><span class="upsell-pro-label"></span> Pagination</li>' .  
                         '</ul>' . 
                         '</div>'
    ] );
	############################################################
	# BLOG SINGLE POST SECTION
	############################################################
	Kirki::add_section( 'agama_blog_single_post_section', array(
		'title'			=> __( 'Single Post', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Featured Image on Single Post', 'agama' ),
		'tooltip'	    => __( 'Turn on to display featured images on single blog posts.', 'agama' ),
		'section'		=> 'agama_blog_single_post_section',
		'settings'		=> 'agama_blog_single_post_thumbnail',
		'type'			=> 'switch',
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_blog_single_post_upsell',
        'section'     => 'agama_blog_single_post_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Post Titles</li>' .  
                         '<li><span class="upsell-pro-label"></span> Post Meta</li>' .   
                         '<li><span class="upsell-pro-label"></span> Post Tags</li>' .  
                         '<li><span class="upsell-pro-label"></span> Post Navigation</li>' .  
                         '</ul>' . 
                         '</div>'
    ] );
	##########################################################
	# BLOG POST META SECTION
	##########################################################
	Kirki::add_section( 'agama_blog_post_meta_section', array(
		'title'			=> __( 'Post Meta', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'panel'			=> 'agama_blog_panel'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta', 'agama' ),
		'tooltip'	    => __( 'Enable blog post meta.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_meta',
		'type'			=> 'switch',
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Author', 'agama' ),
		'tooltip'	    => __( 'Enable single post author section.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_author',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Date', 'agama' ),
		'tooltip'	    => __( 'Enable post publish date.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_date',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Category', 'agama' ),
		'tooltip'	    => __( 'Enable post category.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_category',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Post Meta Comments', 'agama' ),
		'tooltip'	    => __( 'Enable post meta comments counter.', 'agama' ),
		'section'		=> 'agama_blog_post_meta_section',
		'settings'		=> 'agama_blog_post_comments',
		'type'			=> 'switch',
		'active_callback'	=> array(
			array(
				'setting'	=> 'agama_blog_post_meta',
				'operator'	=> '==',
				'value'		=> true
			)
		),
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_blog_post_meta_upsell',
        'section'     => 'agama_blog_post_meta_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Post Views Counter</li>' .    
                         '</ul>' . 
                         '</div>'
    ] );
############################################################
# SOCIAL ICONS
############################################################
	Kirki::add_section( 'agama_social_icons_section', [
		'title'			=> esc_attr__( 'Social Icons', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 90,
	] );
    Kirki::add_field( 'agama_options', [
        'type'          => 'repeater',
        'label'         => esc_attr__( 'Social Icons', 'agama' ),
        'section'       => 'agama_social_icons_section',
        'settings'      => 'agama_social_icons',
        'row_label'     => [
            'type'      => 'field',
            'value'     => esc_attr__( 'Social Icon', 'agama' ),
            'field'     => 'icon'
        ],
        'button_label'  => esc_attr__( 'Add New', 'agama' ),
        'default'       => [
            [
                'target' => '',
                'icon'   => 'rss',
                'url'    => esc_url_raw( get_bloginfo('rss2_url') )
            ]
        ],
        'fields' => [
            'target' => [
                'type'          => 'checkbox',
                'label'         => esc_attr__( 'Open in New Tab ?', 'agama' ),
            ],
            'icon' => [
                'type'          => 'select',
                'label'         => esc_attr__( 'Icon', 'agama' ),
                'description'   => esc_attr__( 'Select social icon.', 'agama' ),
                'choices'       => [
                    ''              => esc_attr__( '-- Select --', 'agama' ),
                    'amazon'        => esc_attr__( 'Amazon', 'agama' ),
                    'android'       => esc_attr__( 'Android', 'agama' ),
                    'behance'       => esc_attr__( 'Behance', 'agama' ),
                    'bitbucket'     => esc_attr__( 'Bitbucket', 'agama' ),
                    'bitcoin'       => esc_attr__( 'BitCoin', 'agama' ),
                    'delicious'     => esc_attr__( 'Delicious', 'agama' ),
                    'deviantart'    => esc_attr__( 'DeviantArt', 'agama' ),
                    'dropbox'       => esc_attr__( 'DropBox', 'agama' ),
                    'dribbble'      => esc_attr__( 'Dribbble', 'agama' ),
                    'digg'          => esc_attr__( 'Digg', 'agama' ),
                    'email'         => esc_attr__( 'Email', 'agama' ),
                    'facebook'      => esc_attr__( 'Facebook', 'agama' ),
                    'flickr'        => esc_attr__( 'Flickr', 'agama' ),
                    'github'        => esc_attr__( 'GitHub', 'agama' ),
                    'google'        => esc_attr__( 'Google', 'agama' ),
                    'instagram'     => esc_attr__( 'Instagram', 'agama' ),
                    'linkedin'      => esc_attr__( 'LinkedIn', 'agama' ),
                    'myspace'       => esc_attr__( 'MySpace', 'agama' ),
                    'paypal'        => esc_attr__( 'PayPal', 'agama' ),
                    'phone'         => esc_attr__( 'Phone', 'agama' ),
                    'pinterest'     => esc_attr__( 'Pinterest', 'agama' ),
                    'reddit'        => esc_attr__( 'Reddit', 'agama' ),
                    'rss'           => esc_attr__( 'RSS', 'agama' ),
                    'skype'         => esc_attr__( 'Skype', 'agama' ),
                    'soundcloud'    => esc_attr__( 'SoundCloud', 'agama' ),
                    'spotify'       => esc_attr__( 'Spotify', 'agama' ),
                    'stack-overflow'=> esc_attr__( 'StackOverflow', 'agama' ),
                    'steam'         => esc_attr__( 'Steam', 'agama' ),
                    'stumbleupon'   => esc_attr__( 'Stumbleupon', 'agama' ),
                    'telegram'      => esc_attr__( 'Telegram', 'agama' ),
                    'tumblr'        => esc_attr__( 'Tumblr', 'agama' ),
                    'twitch'        => esc_attr__( 'Twitch', 'agama' ),
                    'twitter'       => esc_attr__( 'Twitter', 'agama' ),
                    'vimeo'         => esc_attr__( 'Vimeo', 'agama' ),
                    'vk'            => esc_attr__( 'VK', 'agama' ),
                    'yahoo'         => esc_attr__( 'Yahoo', 'agama' ),
                    'youtube'       => esc_attr__( 'YouTube', 'agama' )
                ]
            ],
            'url' => [
                'type'          => 'text',
                'label'         => esc_attr__( 'Page URL', 'agama' ),
                'description'   => esc_attr__( 'Add social icon page url.', 'agama' )
            ]
        ]
    ] );
###################################################################################
# SHARE ICONS
###################################################################################
    Kirki::add_section( 'agama_share_icons_section', array(
		'title'			=> esc_html__( 'Social Share', 'agama' ),
		'capability'	=> 'edit_theme_options',
		'priority'		=> 90,
	) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> esc_html__( 'Enable', 'agama' ),
		'tooltip'	    => esc_html__( 'Enable social share icons ?', 'agama' ),
		'section'		=> 'agama_share_icons_section',
		'settings'		=> 'agama_share_box',
		'type'			=> 'switch',
		'default'		=> true
	) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> esc_html__( 'Visibility', 'agama' ),
		'tooltip'	    => esc_html__( 'Select where to show share box.', 'agama' ),
		'section'		=> 'agama_share_icons_section',
		'settings'		=> 'agama_share_box_visibility',
		'type'			=> 'select',
		'choices'		=> array(
			'posts'		=> esc_html__( 'Posts', 'agama' ),
			'pages'		=> esc_html__( 'Pages', 'agama' ),
			'all'		=> esc_html__( 'Post & Pages', 'agama' )
		),
		'default'		=> 'posts'
	) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Share Icons', 'agama' ),
        'tooltip'       => esc_html__( 'Enable and sort share icons per your own needs.', 'agama' ),
        'section'       => 'agama_share_icons_section',
        'settings'      => 'agama_social_share_icons',
        'type'          => 'sortable',
        'choices'       => array(
            'facebook'  => esc_html__( 'Facebook', 'agama' ),
            'twitter'   => esc_html__( 'Twitter', 'agama' ),
            'pinterest' => esc_html__( 'Pinterest', 'agama' ),
            'linkedin'  => esc_html__( 'LinkedIn', 'agama' ),
            'rss'       => esc_html__( 'RSS', 'agama' ),
            'email'     => esc_html__( 'Email', 'agama' )
        ),
        'default'       => array(
            'facebook',
            'twitter',
            'pinterest',
            'linkedin',
            'rss',
            'email'
        )
    ) );
###################################################################################
# WOOCOMMERCE
###################################################################################
    Kirki::add_panel( 'woocommerce', array(
        'title'     => __( 'WooCommerce', 'agama' ),
        'priority'  => 110
    ) );
###################################################################################
# WIDGETS PANEL
###################################################################################
    Kirki::add_panel( 'widgets', array(
		'title'			=> __( 'Widgets', 'agama' ),
		'priority'		=> 120
	) );
###################################################################################
# FOOTER
###################################################################################
    Kirki::add_panel( 'agama_footer_panel', [
        'title'         => esc_attr__( 'Footer', 'agama' ),
        'priority'      => 130
    ] );
	Kirki::add_section( 'agama_footer_general_section', array(
		'title'			=> __( 'General', 'agama' ),
		'capability'	=> 'edit_theme_options',
        'panel'         => 'agama_footer_panel'
	) );
    Kirki::add_field( 'agama_options', [
		'label'			    => esc_attr__( 'Enable Social Icons', 'agama' ),
		'tooltip'	        => esc_attr__( 'Enable social icons in footer right area.', 'agama' ),
		'section'		    => 'agama_footer_general_section',
		'settings'		    => 'agama_footer_social',
		'type'			    => 'checkbox',
		'default'		    => true,
        'partial_refresh'   => [
            'agama_footer_social' => [
                'selector'        => '#agama-footer div.social',
                'render_callback' => [ 'Agama_Partial_Refresh', 'preview_footer_social_icons' ]
            ]
        ]
	] );
	Kirki::add_field( 'agama_options', array(
		'label'			    => __( 'Copyright', 'agama' ),
		'tooltip'	        => __( 'Add custom copyright text in footer area.', 'agama' ),
		'section'		    => 'agama_footer_general_section',
		'settings'		    => 'agama_footer_copyright',
		'type'			    => 'code',
		'choices'		    => array(
			'language'	    => 'html'
		),
		'default'		    => '',
        'partial_refresh'   => array(
            'agama_footer_copyright' => array(
                'selector'        => '#agama-footer div.site-info',
                'render_callback' => array( 'Agama_Partial_Refresh', 'preview_footer_copyright' )
            )
        )
	) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_footer_general_upsell',
        'section'     => 'agama_footer_general_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Social Icons Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Social Icons Hover Color</li>' . 
                         '<li><span class="upsell-pro-label"></span> Copyright Typography</li>' . 
                         '</ul>' . 
                         '</div>'
    ] );
    ##########################################################
    #   FOOTER STYLING SECTION
    ##########################################################
    Kirki::add_section( 'agama_footer_styling_section', array(
        'title'         => __( 'Styling', 'agama' ),
        'capability'    => 'edit_theme_options',
        'panel'         => 'agama_footer_panel'
    ) );
    Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Widget Area BG Color', 'agama' ),
		'tooltip'	    => __( 'Set footer widget area background color.', 'agama' ),
		'section'		=> 'agama_footer_styling_section',
		'settings'		=> 'agama_footer_widget_bg_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> '.footer-widgets',
				'property'	=> 'background-color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> '.footer-widgets',
				'function'	=> 'css',
				'property'	=> 'background-color'
			)
		),
		'default'		=> '#314150'
	) );
	Kirki::add_field( 'agama_options', array(
		'label'			=> __( 'Footer Area BG Color', 'agama' ),
		'tooltip'	    => __( 'Set footer area background color.', 'agama' ),
		'section'		=> 'agama_footer_styling_section',
		'settings'		=> 'agama_footer_bottom_bg_color',
		'type'			=> 'color',
		'output'		=> array(
			array(
				'element'	=> 'footer[role="contentinfo"]',
				'property'	=> 'background-color'
			)
		),
		'transport'		=> 'postMessage',
		'js_vars'		=> array(
			array(
				'element'	=> 'footer[role="contentinfo"]',
				'function'	=> 'css',
				'property'	=> 'background-color'
			)
		),
		'default'		=> '#293744'
	) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Copyright Links Color', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom color for copyright links in footer area.', 'agama' ),
        'section'       => 'agama_footer_styling_section',
        'settings'      => 'agama_footer_site_info_links_color',
        'type'          => 'color',
        'transport'     => 'auto',
        'output'        => array(
            array(
                'element'   => 'footer .site-info a',
                'property'  => 'color'
            )
        ),
        'default'       => '#cddeee'
    ) );
    Kirki::add_field( 'agama_options', array(
        'label'         => esc_html__( 'Social Icons Color', 'agama' ),
        'tooltip'       => esc_html__( 'Set custom color for social icons in footer area.', 'agama' ),
        'section'       => 'agama_footer_styling_section',
        'settings'      => 'agama_footer_social_icons_color',
        'type'          => 'color',
        'transport'     => 'auto',
        'output'        => array(
            array(
                'element'   => 'footer .social a',
                'property'  => 'color'
            )
        ),
        'default'       => '#cddeee'
    ) );
    Kirki::add_field( 'agama_options', [
        'type'        => 'custom',
        'settings'    => 'agama_footer_styling_upsell',
        'section'     => 'agama_footer_styling_section',
        'default'     => '<div class="themevision-upsell themevision-boxed-section control-subsection">' . 
                         '<ul class="themevision-upsell-features">' . 
                         '<li><span class="upsell-pro-label"></span> Footer Background Image</li>' .  
                         '</ul>' . 
                         '</div>'
    ] );
#######################################
# REMOVE SECTIONS
#######################################
    Kirki::remove_section( 'colors' );

/**
 * Generating Dynamic CSS
 *
 * @since Agama 1.0
 */
function agama_customize_css() { ?>
	<style type="text/css" id="agama-customize-css">
    <?php $mobile_nav = get_theme_mod( 'agama_mobile_navigation_font', array( 'color' => '#757575' ) ); ?>
    #agama-mobile-nav ul > li.menu-item-has-children > .dropdown-toggle,
    #agama-mobile-nav ul > li.menu-item-has-children > .dropdown-toggle.collapsed {
        color: <?php echo $mobile_nav['color']; ?>;
    }
	
	<?php if( get_theme_mod( 'agama_slider_enable', true ) ): ?>
	/* SLIDER
	 *********************************************************************************/
	#agama_slider .slide-content.slide-1 {
		top: <?php echo esc_attr( get_theme_mod( 'agama_slider_content_top_1', '40' ) ); ?>%;
	}
	#agama_slider .slide-content.slide-2 {
		top: <?php echo esc_attr( get_theme_mod( 'agama_slider_content_top_2', '40' ) ); ?>%;
	}
	#agama_slider .slide-content.slide-1 a.button-3d:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_slider_button_bg_color_1', '#ac32e4' ) ); ?> !important;
	}
	#agama_slider .slide-content.slide-2 a.button-3d:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_slider_button_bg_color_2', '#ac32e4' ) ); ?> !important;
	}
	<?php endif; ?>
        
    <?php if( is_page_template( 'page-templates/template-fluid.php' ) ): ?>
    div#page { padding: 0; }
    .vision-row { max-width: 100%; }
    <?php endif; ?>
	
	<?php 
	if( 
		! get_theme_mod( 'agama_blog_post_meta', true ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'list' || 
		! get_theme_mod( 'agama_blog_post_date', true ) && get_theme_mod( 'agama_blog_layout', 'list' ) == 'list'
	): ?>
	.list-style .entry-content { margin-left: 0 !important; }
	<?php endif; ?>
	
	.sm-form-control:focus {
		border: 2px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?> !important;
	}
	
	.entry-content .more-link {
		border-bottom: 1px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
		color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.comment-content .comment-author cite {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
		border: 1px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	#respond #submit {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	<?php if( is_rtl() ): ?>
	blockquote {
		border-right: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	<?php else: ?>
	blockquote {
		border-left: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	<?php endif; ?>
	
	#page-title a:hover { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>; }
	
	.breadcrumb a:hover { color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>; }
	
	<?php if( get_theme_mod('agama_blog_infinite_scroll', false) && get_theme_mod('agama_blog_layout', 'list') == 'grid' ): ?>
	#infscr-loading {
		position: absolute;
		bottom: 0;
		left: 25%;
	}
	<?php endif; ?>
	
	button,
	.button,
	.entry-date .date-box {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.button-3d:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?> !important;
	}
	
	.entry-date .format-box i {
		color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.vision_tabs #tabs li.active a {
		border-top: 3px solid <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	#toTop:hover {
		background-color: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	
	.footer-widgets .widget-title:after {
		background: <?php echo esc_attr( get_theme_mod( 'agama_primary_color', '#ac32e4' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'agama_customize_css' );

/**
 * Styling Agama Support Section
 *
 * @since 1.0.7
 */
function customize_styles_agama_support( $input ) { ?>
	<style type="text/css">
		a:-webkit-any-link {
			text-decoration: none;
		}
        .accordion-section.control-section.control-panel.control-panel-default h3:before,
        .accordion-section.control-section.control-section-kirki-default h3:before {
            font-family: FontAwesome;
        }
        #accordion-section-agama_page_builder_section {
            position: relative;
        }
        #accordion-section-agama_page_builder_section h3:before {
            content: '\f0f7';
        }
        #accordion-section-agama_page_builder_section:after {
            content: '\new' !important;
            position: absolute;
            top: 12px;
            right: 30px;
            color: red;
            z-index: 1;
        }
        #accordion-panel-agama_site_identity_panel h3:before {
            content: '\f2ba';
        }
        #accordion-panel-agama_general_panel h3:before {
            content: '\f085';
        }
        #accordion-panel-agama_layout_panel h3:before {
            content: '\f0db';
        }
        #accordion-panel-agama_header_panel h3:before {
            content: '\f1dc';
        }
        #accordion-panel-agama_nav_panel h3:before {
            content: '\f0c9';
        }
        #accordion-panel-agama_slider_panel h3:before {
            content: '\f1de';
        }
        #accordion-section-agama_breadcrumb_section h3:before {
            content: '\f09d';
        }
        #accordion-panel-agama_frontpage_boxes_panel h3:before {
            content: '\f009';
        }
        #accordion-panel-agama_blog_panel h3:before {
            content: '\f1ad';
        }
        #accordion-panel-agama_styling_panel h3:before {
            content: '\f1fc';
        }
        #accordion-section-agama_social_icons_section h3:before {
            content: '\f230';
        }
        #accordion-section-agama_share_icons_section h3:before {
            content: '\f1e0';
        }
        #accordion-panel-woocommerce h3:before {
            content: '\f291';
        }
        #accordion-panel-agama_footer_panel h3:before {
            content: '\f2d1';
        }
        #accordion-panel-nav_menus h3:before {
            content: '\f0c9';
        }
        #accordion-panel-widgets h3:before {
            content: '\f0ca';
        }
		.theme-headers label > input[type="radio"] {
		  display:none;
		}
		.theme-headers label > input[type="radio"] + img{
		  cursor:pointer;
		  border:2px solid transparent;
		}
		.theme-headers label > input[type="radio"]:checked + img{
		  border:2px solid #f00;
		}
		.agama-customize-heading h3 {
			border: 1px dashed #4A73AA;
			font-weight: 600;
			text-align: center;
			color: #4A73AA;
		}
		/* Override WordPress Customizer Defaults */
		#customize-controls .customize-info .customize-help-toggle:focus, 
		#customize-controls .customize-info .customize-help-toggle:hover, 
		#customize-controls .customize-info.open .customize-help-toggle {
			color: #0085ba;
		}
		#available-menu-items .item-add:focus:before, 
		#customize-controls .customize-info .customize-help-toggle:focus:before, 
		.customize-screen-options-toggle:focus:before, .menu-delete:focus, 
		.menu-item-bar .item-delete:focus:before, 
		.wp-customizer .menu-item .submitbox .submitdelete:focus, 
		.wp-customizer button:focus .toggle-indicator:after {
			-webkit-box-shadow: 0 0 0 1px #0085ba, 0 0 2px 1px <?php echo Agama_Helper::hex2rgba( '#ac32e4', 0.8 ); ?>;
			box-shadow: 0 0 0 1px #0085ba, 0 0 2px 1px <?php echo Agama_Helper::hex2rgba( '#ac32e4', 0.8 ); ?>;
		}
		#customize-controls .control-section .accordion-section-title:focus, 
		#customize-controls .control-section .accordion-section-title:hover, 
		#customize-controls .control-section.open .accordion-section-title, 
		#customize-controls .control-section:hover>.accordion-section-title {
			border-left-color: #0085ba;
			color: #0085ba;
		}
		.customize-panel-back:focus, 
		.customize-panel-back:hover, 
		.customize-section-back:focus, 
		.customize-section-back:hover {
			border-left-color: #0085ba;
			color: #0085ba;
		}
		#customize-theme-controls .control-section .accordion-section-title:focus:after, 
		#customize-theme-controls .control-section .accordion-section-title:hover:after, 
		#customize-theme-controls .control-section.open .accordion-section-title:after, 
		#customize-theme-controls .control-section:hover > .accordion-section-title:after {
			color: #0085ba;
		}
		.customize-controls-close:focus, 
		.customize-controls-close:hover, 
		.customize-controls-preview-toggle:focus, 
		.customize-controls-preview-toggle:hover {
			border-top-color: #0085ba;
			color: #0085ba;
		}
		/* Override Kirki Default Colors */
		.kirki-reset-section:hover, 
		.kirki-reset-section:active {
			background: #ac32e4 !important;
		}
		/* Theme Info */
		ul.theme-info li {
			background: #dedede;
			padding: 5px 10px;
			margin-bottom: 1px;
		}
		ul.theme-info li:hover {
			background: #eee;
		}
		ul.theme-info li a {
			font-weight: 500;
			color: #555d66;
		}
        .dd-options li {
            margin-bottom: 0;
        }
        #input_agama_media_logo {
            display: block;
            text-align: center;
        }
        #input_agama_media_logo label {
            padding-right: 20px;
        }
        #input_agama_media_logo label:last-child {
            padding-right: 0;
        }
        #input_agama_media_logo label img {
            padding: 5px;
        }
	</style>
<?php }
add_action( 'customize_controls_print_styles', 'customize_styles_agama_support');
