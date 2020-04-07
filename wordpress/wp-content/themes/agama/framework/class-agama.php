<?php 

// Prevent direct access to the file
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
/**
 * Agama Class
 *
 * @since 1.1.1
 */
if( ! class_exists( 'Agama' ) ) {
	class Agama {
		
		/**
		 * Class Constructor
		 *
		 * @since 1.1.1
		 */
		function __construct() {}
        
        /**
         * Main Wrapper Class
         *
         * Output main wrapper class.
         *
         * @since 1.4.4
         * @access public
         * @return string
         */
        static function main_wrapper_class() {
            $layout = esc_attr( get_theme_mod( 'agama_layout_style', 'fullwidth' ) );
            switch( $layout ) {
                case 'boxed' :
                    $class = 'tv-container tv-p-0';
                break;
                case 'fullwidth' :
                    $class = 'is-full-width';
                break;
            }
            echo esc_attr( $class );
        }
		
		/**
		 * Header Style Class
		 *
		 * @since 1.2.0
		 */
		static function header_class() {
			$header     = esc_attr( get_theme_mod( 'agama_header_style', 'transparent' ) );
            $desktop    = esc_url( get_theme_mod( 'agama_logo', '' ) );
            $tablet     = esc_url( get_theme_mod( 'agama_tablet_logo', '' ) );
            $mobile     = esc_url( get_theme_mod( 'agama_mobile_logo', '' ) );
            $device     = array();
            
            if( ! empty( $desktop ) ) {
                $device[] = 'has_desktop';
            }
            
            if( ! empty( $tablet ) ) {
                $device[] = 'has_tablet';
            }
            
            if( ! empty( $mobile ) ) {
                $device[] = 'has_mobile';
            }
            
			switch( $header ):
				case 'transparent':
					 $class = 'header_v1 ' . implode( ' ', $device );
				break;
				case 'default':
					 $class = 'header_v2 ' . implode( ' ', $device );
				break;
				case 'sticky':
					 $class = 'header_v3 ' . implode( ' ', $device );
				break;
			endswitch;
			echo $class;
		}
		
		/**
		 * Bootstrap Content Wrapper Class
		 *
		 * @since 1.1.7
		 */
		static function bs_class() {
			if( is_active_sidebar( 'sidebar-1' ) ) {
				$class = 'tv-col-md-9';
			} else {
				$class = 'tv-col-md-12';
			}
			return $class;
		}
		
		/**
		 * Render Menu Content
		 *
		 * @since 1.1.1
		 */
		public static function menu( $location = false, $class = false ) {
			
			// If location not set
			if( ! $location ) {
				return;
            }
			
			$args = array(
				'theme_location' => $location,
				'menu_class'     => $class,
				'container'      => false,
				'echo'           => '0'
			);
			
			$menu = wp_nav_menu( $args );
			
			return $menu;
		}
		
		/**
		 * Social Icons
         *
         * Display social icons.
		 *
         * @param string $tip_position (optional) The position of tooltip.
         * @param string $style (optional) The social icons style name.
         *
		 * @since 1.1.1
		 * @since 1.4.2 Updated the code.
         * @access public
         * @return mixed
		 */
		public static function social_icons( $tip_position = null, $style = null ) {
			$settings = get_theme_mod( 'agama_social_icons', [
                [
                    'target'    => '',
                    'icon'      => 'rss',
                    'url'       => esc_url_raw( get_bloginfo('rss2_url') )
                ] 
            ]);
            if( $settings && is_array( $settings ) ) {
                if( 'animated' == $style ) echo '<ul>';
                foreach( $settings as $setting ) {
                    if( 'animated' == $style ) echo '<li>';
                        
                        // Format VK and RSS icon names.
                        if( 'rss' == $setting['icon'] || 'vk' == $setting['icon'] ) {
                            $title = strtoupper( $setting['icon'] );
                        } 
                        else // Format StackOverflow icon name.
                        if( 'stack-overflow' == $setting['icon'] ) {
                            $title = str_replace( '-', '', $setting['icon'] );
                            $title = ucfirst( $title );
                        } else {
                            $title = ucfirst( $setting['icon'] );
                        }
                    
                        // Format url data.
                        $data  = 'title="'. esc_html( $title ) .'"';
                        if( 'animated' !== $style ) {
                            $data .= ' data-toggle="tooltip"';
                            if( $tip_position ) {
                                $data .= ' data-placement="'. esc_attr( $tip_position ) .'"';
                            }
                        }
                    
                        // Format url target.
                        if( $setting['target'] ) {
                            $target = 'target="_blank"';
                        } else {
                            $target = 'target="_self"';
                        }
                    
                        // Format url class name.
                        'animated' == $style ? $class = 'tv-' . strtolower( $setting['icon'] ) : $class = 'social-icons ' . strtolower( $setting['icon'] );
                    
                        // Format fontawesome class name.
                        $fontawesome = 'fa-' . strtolower( $setting['icon'] );
                    
                        // Format fontawesome email icon class.
                        if( 'email' == $setting['icon'] ) {
                            $fontawesome = 'fa-at';
                        }
                        
                        // Format email url.
                        if( 'email' == $setting['icon'] ) {
                            $setting['url'] = 'mailto:'. esc_attr( $setting['url'] );
                        }
                        else
                        // Format phone url.
                        if( 'phone' == $setting['icon'] ) {
                            $setting['url'] = 'tel:'. esc_attr( $setting['url'] );
                        }
                        else
                        // Format skype url.
                        if( 'skype' == $setting['icon'] ) {
                            $setting['url'] = 'skype:'. esc_attr( $setting['url'] ) .'?call';
                        } else { // Escape all other urls.
                            $setting['url'] = esc_url( $setting['url'] );
                        }
                    
                        echo '<a href="'. $setting['url'] .'" class="'. esc_attr( $class ) .'" ' . $target . $data .'>';
                            if( 'animated' == $style ) echo '<span class="tv-icon"><i class="fa '. esc_attr( $fontawesome ) .'"></i></span>';
                            if( 'animated' == $style ) echo '<span class="tv-text">'. esc_html( $title ) .'</span>';
                        echo '</a>';
                    
                    if( 'animated' == $style ) echo '</li>';
                }
                if( 'animated' == $style ) echo '</ul>';
            }
		}
		
		/**
		 * Get Post Format
		 *
		 * @since 1.1.1
		 */
		public static function post_format() {
			$post_format = get_post_format();
			
			switch( $post_format ) {

				case 'aside':
					$icon = '<i class="fa fa-outdent"></i>';
				break;
				
				case 'chat':
					$icon = '<i class="fa fa-wechat"></i>';
				break;
				
				case 'gallery':
					$icon = '<i class="fa fa-photo"></i>';
				break;
				
				case 'link':
					$icon = '<i class="fa fa-link"></i>';
				break;
				
				case 'image':
					$icon = '<i class="fa fa-image"></i>';
				break;
				
				case 'quote':
					$icon = '<i class="fa fa-quote-left"></i>';
				break;
				
				case 'status':
					$icon = '<i class="fa fa-check-circle"></i>';
				break;
				
				case 'video':
					$icon = '<i class="fa fa-video-camera"></i>';
				break;
				
				case 'audio':
					$icon = '<i class="fa fa-volume-up"></i>';
				break;
				
				default: $icon = '<i class="fa fa-camera-retro"></i>';
				
			}
			
			return $icon;
		}
		
		/**
		 * Count Comments
		 *
		 * @since 1.1.1
		 */
		public static function comments_count() {
			$comments = 0;
			
			if( comments_open() ) {
				$comments = sprintf('<a href="%s">%s</a>', get_comments_link(), get_comments_number() . __( ' comments', 'agama' ) );
			}
			
			return $comments;
		}
		
		/**
		 * Next | Previous - Post Links
		 *
		 * @since 1.0.0
		 */
		public static function post_prev_next_links() {
			if( get_previous_post_link() || get_next_post_link() ) { ?>
				<!-- Posts Navigation -->
				<nav class="nav-single">
					<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'agama' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'agama' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'agama' ) . '</span>' ); ?></span>
				</nav><!-- Post Navigation End -->
			<?php
			}
		}
		
		/**
		 * Render About Author on Single Posts
		 *
		 * @since 1.1.1
		 */
		public static function about_author() { ?>
			<?php 
			if ( 
				 is_singular() && 
				 get_the_author_meta( 'description' ) && 
			     get_theme_mod( 'agama_blog_about_author', true ) 
				) : ?>
				
			<div class="author-info">
				<div class="author-avatar">
					<?php
					/** This filter is documented in author.php */
					$author_bio_avatar_size = apply_filters( 'agama_author_bio_avatar_size', 68 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div>
				<div class="author-description">
					<h2><?php printf( __( 'About %s', 'agama' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
					<div class="author-link">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
							<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'agama' ), get_the_author() ); ?>
						</a>
					</div>
				</div>
			</div>
			
		<?php endif; ?>
		<?php
		}
	}
	new Agama;
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
