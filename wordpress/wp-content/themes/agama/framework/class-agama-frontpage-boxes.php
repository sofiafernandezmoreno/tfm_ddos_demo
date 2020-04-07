<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Agama Frontpage Boxes Class
 *
 * @since 1.1.6
 * @rewritten @since 1.2.9
 */
class Agama_Front_Page_Boxes {
	
	/**
	 * Class Initialization
	 *
	 * @since 1.2.9
	 */
	public static function init() {
		self::render();
	}
	
	/**
	 * Get Slider Options
	 * 
	 * @since 1.2.9
	 */
	private static function get_options() {
		global $boxes, $box, $enabled, $global;
		
		$enabled				= esc_attr( get_theme_mod( 'agama_frontpage_boxes', false ) );
		$boxes['visibility'] 	= esc_attr( get_theme_mod( 'agama_frontpage_boxes_visibility', 'homepage' ) );
        $boxes['heading']       = esc_html( get_theme_mod( 'agama_frontpage_boxes_heading', esc_html__( 'Front Page Boxes', 'agama' ) ) );
		
		$box[1]['enable'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_1_enable', false ) );
		$box[2]['enable'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_2_enable', false ) );
		$box[3]['enable']		= esc_attr( get_theme_mod( 'agama_frontpage_box_3_enable', false ) );
		$box[4]['enable'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_4_enable', false ) );
		
		if( $box[1]['enable'] || $box[2]['enable'] || $box[3]['enable'] || $box[4]['enable'] ) {
			$boxes['enabled'] = true;
		} else {
			$boxes['enabled'] = false;
		}
		
		if( $boxes['enabled'] ) {
			$box['count'] = 0;
			if( $box[1]['enable'] ) 
				$box['count']++;
			if( $box[2]['enable'] ) 
				$box['count']++;
			if( $box[3]['enable'] ) 
				$box['count']++;
			if( $box[4]['enable'] ) 
				$box['count']++;
			switch( $box['count'] ) {
				case '1':
					$box['class'] = esc_attr( 'tv-col-md-12' );
				break;
				case '2':
					$box['class'] = esc_attr( 'tv-col-md-6' );
				break;
				case '3':
					$box['class'] = esc_attr( 'tv-col-md-4' );
				break;
				default: $box['class'] = esc_attr( 'tv-col-md-6 tv-col-lg-3' );
			}
			
			$box[1]['title'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_1_title', 'Responsive Layout' ) );
			$box[2]['title'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_2_title', 'Endless Possibilities' ) );
			$box[3]['title'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_3_title', 'Boxed & Wide Layouts' ) );
			$box[4]['title'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_4_title', 'Powerful Performance' ) );
			
			$box[1]['icon'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_1_icon', 'fa-tablet' ) );
			$box[2]['icon'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_2_icon', 'fa-cogs' ) );
			$box[3]['icon'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_3_icon', 'fa-laptop' ) );
			$box[4]['icon'] 		= esc_attr( get_theme_mod( 'agama_frontpage_box_4_icon', 'fa-magic' ) );
			
			$box[1]['img'] 			= esc_url( get_theme_mod( 'agama_frontpage_1_img', '' ) );
			$box[2]['img'] 			= esc_url( get_theme_mod( 'agama_frontpage_2_img', '' ) );
			$box[3]['img'] 			= esc_url( get_theme_mod( 'agama_frontpage_3_img', '' ) );
			$box[4]['img'] 			= esc_url( get_theme_mod( 'agama_frontpage_4_img', '' ) );
			
			$box[1]['iurl'] 		= esc_url( get_theme_mod( 'agama_frontpage_box_1_icon_url', '' ) );
			$box[2]['iurl'] 		= esc_url( get_theme_mod( 'agama_frontpage_box_2_icon_url', '' ) );
			$box[3]['iurl'] 		= esc_url( get_theme_mod( 'agama_frontpage_box_3_icon_url', '' ) );
			$box[4]['iurl'] 		= esc_url( get_theme_mod( 'agama_frontpage_box_4_icon_url', '' ) );
			
			$box[1]['desc'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_1_text', 'Powerful Layout with Responsive functionality that can be adapted to any screen size.' ) );
			$box[2]['desc'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_2_text', 'Complete control on each & every element that provides endless customization possibilities.' ) );
			$box[3]['desc'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_3_text', 'Stretch your Website to the Full Width or make it boxed to surprise your visitors.' ) );
			$box[4]['desc'] 		= esc_html( get_theme_mod( 'agama_frontpage_box_4_text', 'Optimized code that are completely customizable and deliver unmatched fast performance.' ) ); 
			
			$box[1]['animated'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_1_animated', true ) );
			$box[2]['animated'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_2_animated', true ) );
			$box[3]['animated'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_3_animated', true ) );
			$box[4]['animated'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_4_animated', true ) );
			$box[1]['animation'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_1_animation', 'fadeInLeft' ) );
			$box[2]['animation'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_2_animation', 'fadeInDown' ) );
			$box[3]['animation'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_3_animation', 'fadeInUp' ) );
			$box[4]['animation'] 	= esc_attr( get_theme_mod( 'agama_frontpage_box_4_animation', 'fadeInRight' ) );
			
			$box[1]['data-animated'] = '';
			if( $box[1]['animated'] && ! is_single() ) {
				$box[1]['data-animated'] = ' data-animate="'. $box[1]['animation'] .'" data-delay="200"';
			} 
			
			$box[2]['data-animated'] = '';
			if( $box[2]['animated'] && ! is_single() ) {
				$box[2]['data-animated'] = ' data-animate="'. $box[2]['animation'] .'" data-delay="400"';
			}
			
			$box[3]['data-animated'] = '';
			if( $box[3]['animated'] && ! is_single() ) {
				$box[3]['data-animated'] = ' data-animate="'. $box[3]['animation'] .'" data-delay="600"';
			}
			
			$box[4]['data-animated'] = '';
			if( $box[4]['animated'] && ! is_single() ) {
				$box[4]['data-animated'] = ' data-animate="'. $box[4]['animation'] .'" data-delay="800"';
			}
		}
	}
	
	/**
	 * Render Frontpage Boxes
	 *
	 * @since 1.2.9
	 */
	private static function render() {
		global $boxes, $box, $enabled, $global;
		
		self::get_options();
		
		if( $enabled && $boxes['enabled'] && $boxes['visibility'] == 'homepage' && is_home() || 
			$enabled && $boxes['enabled'] && $boxes['visibility'] == 'frontpage' && is_front_page() || 
			$enabled && $boxes['enabled'] && $boxes['visibility'] == 'allpages' 
		) {
			echo '<div id="frontpage-boxes" class="tv-row">';
                if( $boxes['heading'] ) {
                    echo '<div class="tv-col-md-12">';
                        echo '<h1>'. $boxes['heading'] .'</h1>';
                    echo '</div>';
                }
                if( $box[1]['enable'] ) {
                    echo '<!-- Frontpage Box 1 -->';
                    echo '<div class="'. $box['class'] .' fbox-1"'. $box[1]['data-animated'] .'>';
                        if( $box[1]['iurl'] ) {
                            echo '<a href="'. $box[1]['iurl'] .'">';
                        }
                        if( $box[1]['img'] ) {
                            echo '<img src="'. $box[1]['img'] .'" alt="'. $box[1]['title'] .'">';
                        } else {
                            if( is_customize_preview() ) { 
                                echo '<span class="fbox-icon" style="display:block;text-align:center;">';
                                    echo '<i class="fa '. $box[1]['icon'] .'"></i>';
                                echo '</span>';
                            } else {
                                echo '<i class="fa '. $box[1]['icon'] .'"></i>';
                            }
                        }
                        if( $box[1]['iurl'] ) {
                            echo '</a>';
                        }
                        if( $box[1]['title'] ) {
                            echo '<h2>'. $box[1]['title'] .'</h2>';
                        }
                        if( $box[1]['desc'] ) {
                            echo '<p>'. $box[1]['desc'] .'</p>';
                        }
                    echo '</div><!-- End Frontpage Box 1 -->';
                }
                if( $box[2]['enable'] ) {
                    echo '<!-- Frontpage Box 2 -->';
                    echo '<div class="'. $box['class'] .' fbox-2"'. $box[2]['data-animated'] .'>';
                        if( $box[2]['iurl'] ) {
                            echo '<a href="'. $box[2]['iurl'] .'">';
                        }
                        if( $box[2]['img'] ) {
                            echo '<img src="'. $box[2]['img'] .'" alt="'. $box[2]['title'] .'">';
                        } else {
                            if( is_customize_preview() ) { 
                                echo '<span class="fbox-icon" style="display:block;text-align:center;">';
                                    echo '<i class="fa '. $box[2]['icon'] .'"></i>';
                                echo '</span>';
                            } else {
                                echo '<i class="fa '. $box[2]['icon'] .'"></i>';
                            }
                        }
                        if( $box[2]['iurl'] ) {
                            echo '</a>';
                        }
                        if( $box[2]['title'] ) {
                            echo '<h2>'. $box[2]['title'] .'</h2>';
                        }
                        if( $box[2]['desc'] ) {
                            echo '<p>'. $box[2]['desc'] .'</p>';
                        }
                    echo '</div><!-- End Frontpage Box 2 -->';
                }
                if( $box[3]['enable'] ) {
                    echo '<!-- Frontpage Box 3 -->';
                    echo '<div class="'. $box['class'] .' fbox-3"'. $box[3]['data-animated'] .'>';
                        if( $box[3]['iurl'] ) {
                            echo '<a href="'. $box[3]['iurl'] .'">';
                        }
                        if( $box[3]['img'] ) {
                            echo '<img src="'. $box[3]['img'] .'" alt="'. $box[3]['title'] .'">';
                        } else {
                            if( is_customize_preview() ) { 
                                echo '<span class="fbox-icon" style="display:block;text-align:center;">';
                                    echo '<i class="fa '. $box[3]['icon'] .'"></i>';
                                echo '</span>';
                            } else {
                                echo '<i class="fa '. $box[3]['icon'] .'"></i>';
                            }
                        }
                        if( $box[3]['iurl'] ) {
                            echo '</a>';
                        }
                        if( $box[3]['title'] ) {
                            echo '<h2>'. $box[3]['title'] .'</h2>';
                        }
                        if( $box[3]['desc'] ) {
                            echo '<p>'. $box[3]['desc'] .'</p>';
                        }
                    echo '</div><!-- End Frontpage Box 3 -->';
                }
                if( $box[4]['enable'] ) {
                    echo '<!-- Frontpage Box 4 -->';
                    echo '<div class="'. $box['class'] .' fbox-4"'. $box[4]['data-animated'] .'>';
                        if( $box[4]['iurl'] ) {
                            echo '<a href="'. $box[4]['iurl'] .'">';
                        }
                        if( $box[4]['img'] ) {
                            echo '<img src="'. $box[4]['img'] .'" alt="'. $box[4]['title'] .'">';
                        } else {
                            if( is_customize_preview() ) { 
                                echo '<span class="fbox-icon" style="display:block;text-align:center;">';
                                    echo '<i class="fa '. $box[4]['icon'] .'"></i>';
                                echo '</span>';
                            } else {
                                echo '<i class="fa '. $box[4]['icon'] .'"></i>';
                            }
                        }
                        if( $box[4]['iurl'] ) {
                            echo '</a>';
                        }
                        if( $box[4]['title'] ) {
                            echo '<h2>'. $box[4]['title'] .'</h2>';
                        }
                        if( $box[4]['desc'] ) {
                            echo '<p>'. $box[4]['desc'] .'</p>';
                        }
                    echo '</div><!-- End Frontpage Box 4 -->';
                }
			echo '</div>';
		}
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
