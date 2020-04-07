<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Agama Slider Class
 *
 * @since 1.2.9
 */
class Agama_Slider {
	
	/**
	 * Slider Initialization
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
		global $button, $enabled, $visibility, $particles, $slide;
		
		$enabled 	= esc_attr( get_theme_mod( 'agama_slider_enable', false ) );
		$visibility	= esc_attr( get_theme_mod( 'agama_slider_visibility', 'homepage' ) );
		$particles	= esc_attr( get_theme_mod( 'agama_slider_particles', true ) );
		
		$slide['1']['img']			= esc_url( get_theme_mod( 'agama_slider_image_1' ) );
		$slide['2']['img']			= esc_url( get_theme_mod( 'agama_slider_image_2' ) );
		$slide['1']['title']		= esc_attr( get_theme_mod( 'agama_slider_title_1', 'Welcome to Agama' ) );
		$slide['2']['title']		= esc_attr( get_theme_mod( 'agama_slider_title_2', 'Welcome to Agama' ) );
		$slide['1']['animate'] 		= esc_attr( get_theme_mod( 'agama_slider_title_animation_1', 'bounceInLeft' ) );
		$slide['2']['animate'] 		= esc_attr( get_theme_mod( 'agama_slider_title_animation_2', 'bounceInLeft' ) );
		$slide['1']['title_color']	= esc_attr( get_theme_mod( 'agama_slider_title_color_1', '#fff' ) );
		$slide['2']['title_color']	= esc_attr( get_theme_mod( 'agama_slider_title_color_2', '#fff' ) );
		$button['1']['title'] 		= esc_attr( get_theme_mod( 'agama_slider_button_title_1', 'Learn More' ) );
		$button['2']['title'] 		= esc_attr( get_theme_mod( 'agama_slider_button_title_2', 'Learn More' ) );
		$button['1']['animate']		= esc_attr( get_theme_mod( 'agama_slider_button_animation_1', 'bounceInRight' ) );
		$button['2']['animate']		= esc_attr( get_theme_mod( 'agama_slider_button_animation_2', 'bounceInRight' ) );
		$button['1']['url'] 		= esc_url( get_theme_mod( 'agama_slider_button_url_1', '#' ) );
		$button['2']['url'] 		= esc_url( get_theme_mod( 'agama_slider_button_url_2', '#' ) );
	}
	
	/**
	 * Render Agama Slider
	 *
	 * @since 1.2.9
	 */
	private static function render() {
		global $button, $enabled, $visibility, $particles, $slide;
		
		self::get_options();
		
		if( $enabled && $visibility == 'homepage' && is_home() || 
			$enabled && $visibility == 'frontpage' && is_front_page() 
		) {
			echo '<div id="agama-slider-wrapper">';
				if( $particles ) {
					echo '<div id="particles-js" class="agama-particles"></div>';
				}
				echo '<div id="agama_slider" class="camera_wrap">';
					if( $slide['1']['img'] ) {
						echo '<div data-src="'. $slide['1']['img'] .'" data-alt="'. $slide['1']['title'] .'">';
							echo '<div class="slide-content slide-1">';
								echo '<div class="slide-content-cell">';
									echo '<div class="tv-container">';
										echo '<div class="tv-row">';
											echo '<div class="tv-col-md-12 tv-col-sm-12 tv-col-xs-12">';
												if( $slide['1']['title'] ) {
													echo '<h2 class="slide-title animated '. $slide['1']['animate'] .'" style="color:'. $slide['1']['title_color'] .';">';
														echo $slide['1']['title'];
													echo '</h2>';
												}
												if( $button['1']['title'] ) {
													echo '<a href="'. $button['1']['url'] .'" class="button button-3d button-rounded button-xlarge animated '. $button['1']['animate'] .'">';
														echo $button['1']['title'];
													echo '</a>';
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
					if( $slide['2']['img'] ) {
						echo '<div data-src="'. $slide['2']['img'] .'" data-alt="'. $slide['2']['title'] .'">';
							echo '<div class="slide-content slide-2">';
								echo '<div class="slide-content-cell">';
									echo '<div class="tv-container">';
										echo '<div class="tv-row">';
											echo '<div class="tv-col-md-12 tv-col-sm-12 tv-col-xs-12">';
												if( $slide['2']['title'] ) {
													echo '<h2 class="slide-title animated '. $slide['2']['animate'] .'" style="color:'. $slide['2']['title_color'] .';">';
														echo $slide['2']['title'];
													echo '</h2>';
												}
												if( $button['2']['title'] ) {
													echo '<a href="'. $button['2']['url'] .'" class="button button-3d button-rounded button-xlarge animated '. $button['2']['animate'] .'">';
														echo $button['2']['title'];
													echo '</a>';
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
			echo '</div>';
		}
	}
	
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
