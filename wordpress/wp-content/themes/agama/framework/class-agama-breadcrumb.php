<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Agama Breadcrumb Class
 *
 * @since 1.1.6
 * @updated @since 1.2.9
 */
class Agama_Breadcrumb {
	
	/**
	 * Initialize Agama Breadcrumb
	 * 
	 * @since 1.2.9
	 */
	public static function init() {
		if( is_home() || is_front_page() ) {
			self::is_home_or_front_page();
			return;
		}
		if( is_single() || is_page() ) {
			self::is_single_or_page();
			return;
		}
		if( is_category() ) {
			self::is_category();
			return;
		}
		if( is_tag() ) {
			self::is_tag();
			return;
		}
		if( is_search() ) {
			self::is_search();
			return;
		}
		if( class_exists( 'Woocommerce' ) && is_shop() ) {
			self::is_shop();
			return;
		}
		if( is_archive() ) {
			self::is_archive();
			return;
		}
		if( is_404() ) {
			self::is_404();
			return;
		}
	}
	
	/**
	 * Is Home or Front Page
	 *
	 * @since 1.2.9
	 */
	private static function is_home_or_front_page() {
        if( is_home() && is_front_page() ) {
            $h1 = sprintf( '<h1>%s</h1>', __( 'Home', 'agama' ) );
        } else if( is_home() ) {
            $h1 = sprintf( '<h1>%s</h1>', __( 'Blog', 'agama' ) );
        } else if( is_front_page() ) {
            $h1 = sprintf( '<h1>%s</h1>', get_the_title() );
        }
         $output = '';
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Single or Is Page
	 *
	 * @since 1.2.9
	 */
	private static function is_single_or_page() {
		global $post;
		$h1 	= sprintf( '<h1>%s</h1>', $post->post_title );
		$output = sprintf( '<li class="active">%s</li>', $post->post_title );
			
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Category
	 *
	 * @since 1.2.9
	 */
	private static function is_category() {
		$span = '';
		
		if( category_description() ) {
			$cat_desc 	= strip_tags( category_description() );
			$span		= sprintf( '<span>%s</span>', $cat_desc );
		}
		
		$category	= get_the_category();
		$cat_ID		= $category[0]->cat_ID;
		$h1			= sprintf( '<h1>%s</h1>', single_cat_title( '', false ) ) . $span;
		$output		= sprintf( '<li class="active">%s</li>', single_cat_title( '', false ) );
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Tag
	 *
	 * @since 1.2.9
	 */
	private static function is_tag() {
		$h1		= sprintf( '<h1>%s</h1>', __( 'Tag', 'agama' ) );
		$output	= sprintf( '<li class="active">%s</li>', single_tag_title('', false) );
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Search
	 *
	 * @since 1.2.9
	 */
	private static function is_search() {
		$h1		= sprintf( '<h1>%s</h1>', __( 'Search', 'agama' ) );
		$output = sprintf( '<li class="active">%s</li>', __( 'Search', 'agama' ) );
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Shop
	 *
	 * @since 1.2.9
	 */
	private static function is_shop() {
		$h1		= sprintf( '<h1>%s</h1>', __( 'Shop', 'agama' ) );
		$output	= sprintf( '<li class="active">%s</li>', __( 'Shop', 'agama' ) );
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is Archive
	 *
	 * @since 1.2.9
	 */
	private static function is_archive() {
		$span = '';
		if ( is_day() ) :
			$h1 	= sprintf( '<h1>%s</h1> <span>%s</span>', __( 'Daily Archives', 'agama' ), get_the_date() );
			$output	= sprintf( '<li class="active">%s</li>', __( 'Daily Archives', 'agama' ) );
		elseif ( is_month() ) :
			$h1 	= sprintf( '<h1>%s</h1> <span>%s</span>', __( 'Monthly Archives', 'agama' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'agama' ) ) );
			$output	= sprintf( '<li class="active">%s</li>', __( 'Monthly Archives', 'agama' ) );
		elseif ( is_year() ) :
			$h1		= sprintf( '<h1>%s</h1> <span>%s</span>', __( 'Yearly Archives', 'agama' ), get_the_date( _x( 'Y', 'yearly archives date format', 'agama' ) ) );
			$output	= sprintf( '<li class="active">%s</li>', __( 'Yearly Archives', 'agama' ) );
		else :
			$h1		= __( 'Archives', 'agama' );
			$output = sprintf( '<li class="active">%s</li>', __( 'Archives', 'agama' ) );
		endif;
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * Is 404
	 *
	 * @since 1.2.9
	 */
	private static function is_404() {
		$h1		= sprintf( '<h1>%s</h1>', __( 'Page not found', 'agama' ) );
		$output	= sprintf( '<li class="active">%s</li>', __( 'Page not Found', 'agama' ) );
		
		self::html_markup( $h1, $output );
	}
	
	/**
	 * HTML Markup
	 *
	 * @since 1.2.9
	 */
	private static function html_markup( $heading = false, $title = false ) {
		$enabled 	 = esc_attr( get_theme_mod( 'agama_breadcrumb', false ) );
		$on_homepage = esc_attr( get_theme_mod( 'agama_breadcrumb_homepage', true ) );
		$style 		 = get_theme_mod( 'agama_breadcrumb_style', 'mini' ) == 'mini' ? ' class="'. esc_attr( 'page-title-mini' ) .'"' : '';
		
		if( ! $on_homepage && is_home() || ! $on_homepage && is_front_page() ) {
			$enabled = false;
		}
		
		if( $enabled ) {
			echo '<!-- Breadcrumb -->';
			echo '<section id="page-title"'. $style .'">';
				echo '<div class="tv-container">';
                    echo '<div class="tv-row">';
                        echo '<div class="tv-col-md-6 tv-d-flex tv-justify-content-md-start tv-justify-content-center">';
                            echo $heading;
                        echo '</div>';
                        echo '<div class="tv-col-md-6 tv-d-flex tv-justify-content-md-end tv-justify-content-center">';
                            echo '<ol class="breadcrumb tv-d-flex">';
                                echo '<li><a href="'. esc_url( home_url( '/' ) ) .'"><i class="fa fa-home"></i></a></li>';
                                    echo $title;
                            echo '</ol>';
                        echo '</div>';
                    echo '</div>';
				echo '</div>';
			echo '</section><!-- / Breadcrumb -->';
		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
