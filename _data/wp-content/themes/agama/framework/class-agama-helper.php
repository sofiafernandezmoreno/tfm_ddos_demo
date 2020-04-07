<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Agama Helper Class
 *
 * @since 1.2.9
 */
class Agama_Helper {
	
	/**
	 * Render Agama Header
	 *
	 * @since 1.2.9
	 */
	public static function get_header() {
        global $top_nav, $social_icons;
		$header       = esc_attr( get_theme_mod( 'agama_header_style', 'transparent' ) );
        $top_nav      = esc_attr( get_theme_mod( 'agama_top_navigation', true ) );
        $social_icons = esc_attr( get_theme_mod( 'agama_top_nav_social', true ) );
		switch( $header ):
			case 'transparent':
				get_template_part( 'framework/headers/header-transparent' );
			break;
			case 'sticky':
				get_template_part( 'framework/headers/header-sticky' );
			break;
			case 'default':
				get_template_part( 'framework/headers/header-default' );
			break;
		endswitch;
	}
	
	/**
	 * Render Mobile Menu Toggle Icon
	 *
	 * @since 1.2.9.2
	 */
	public static function get_mobile_menu_toggle_icon() {
		echo '<button class="mobile-menu-toggle toggle--elastic" type="button" aria-label="'. esc_attr__( 'Menu', 'agama' ) .'" aria-controls="navigation" aria-expanded="false">';
			echo '<span class="mobile-menu-toggle-box">';
				echo '<span class="mobile-menu-toggle-inner"></span>';
			echo '</span>';
			if( get_theme_mod( 'agama_nav_mobile_icon_title', false ) ) {
				echo '<span class="mobile-menu-toggle-label">';
					echo esc_html( get_theme_mod( 'agama_nav_mobile_icon_title', false ) );
				echo '</span>';
			}
		echo '</button><!-- .mobile-menu-toggle -->';
	}
	
	/**
	 * Render Agama Frontpage Boxes
	 *
	 * @since 1.2.9
	 */
	public static function get_front_page_boxes() {
		Agama_Front_Page_Boxes::init();
	}
	
	/**
	 * Data Animate
	 *
	 * @since 1.2.8
	 */
	public static function get_data_animated() {
		$animated    = esc_attr( get_theme_mod( 'agama_blog_posts_load_animated', true ) );
		$animation   = esc_attr( get_theme_mod( 'agama_blog_posts_load_animation', 'bounceInUp' ) );
        $blog_layout = esc_attr( get_theme_mod( 'agama_blog_layout', 'list' ) ); 
		
		if( $animated && $blog_layout !== 'grid' && ! is_single()) {
			echo ' data-animate="'. $animation .'" data-delay="100"';
		}
	}
    
    /**
     * Get Blog Grid Wrapper Isotope Data
     *
     * @since 1.3.1
     */
    public static function get_blog_isotope_class() {
        if( ! is_single() && get_theme_mod( 'agama_blog_layout', 'list' ) == 'grid' ) {
            echo 'class="js-isotope"';
        }
    }
    
    /**
     * Infinite Scroll Load More Button
     *
     * @since 1.3.2
     */
    public static function get_infinite_scroll_load_more_btn() {
        $enabled = esc_attr( get_theme_mod( 'agama_blog_infinite_scroll', false ) );
        $trigger = esc_attr( get_theme_mod( 'agama_blog_infinite_trigger', 'button' ) );
        if( $enabled ) {
            echo '<div class="infscr-load-status">';
                echo '<div class="loader-ellips infinite-scroll-request">';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                    echo '<span class="loader-ellips__dot"></span>';
                echo '</div>';
            echo '</div>';
        }
        if( $enabled && $trigger == 'button' ) {
            echo '<a id="infinite-loadmore" class="button button-3d button-rounded">';
                echo '<i class="fa fa-spinner fa-spin"></i> '. __( 'Load More', 'agama' );
            echo '</a>';
        }
    }
	
	/**
	 * Generate Footer Widgets Bootstrap Class
	 *
	 * @since 1.2.9
	 */
	public static function get_fwidgets_bs_class() {
		$count = 0;
		if( is_active_sidebar( 'footer-widget-1' ) ) {
			$count++;
		}
		if( is_active_sidebar( 'footer-widget-2' ) ) {
			$count++;
		}
		if( is_active_sidebar( 'footer-widget-3' ) ) {
			$count++;
		}
		if( is_active_sidebar( 'footer-widget-4' ) ) {
			$count++;
		}
		switch( $count ) {
			case '1':
				echo esc_attr( 'tv-col-md-12' );
			break;
			case '2':
				echo esc_attr( 'tv-col-md-6' );
			break;
			case '3':
				echo esc_attr( 'tv-col-md-4' );
			break;
			case '4':
				echo esc_attr( 'tv-col-md-6 tv-col-lg-3' );
			break;
		}
	}
	
	/**
	 * Convert hexdec color string to rgb(a) string.
	 *
	 * @since 1.2.9
	 */
	public static function hex2rgba( $color, $opacity = false ) {
		$default = 'rgb(0,0,0)';
 
		//Return default if no color provided
		if( empty( $color ) )
			  return $default; 
	 
		//Sanitize $color if "#" is provided 
		if( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}
 
		//Check if color has 6 or 3 characters and get values
		if( strlen( $color ) == 6) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}
 
		// Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );
 
		//Check if opacity is set(rgba or rgb)
		if( $opacity ){
			if( abs( $opacity ) > 1)
				$opacity = 1.0;
			$output = 'rgba('. implode(",",$rgb) .','. $opacity .')';
		} else {
			$output = 'rgb('. implode(",",$rgb) .')';
		}
 
		//Return rgb(a) color string
		return $output;
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
