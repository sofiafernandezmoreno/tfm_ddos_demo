<?php

// Direct access to the file not allowed.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register the Widget
 *
 * @since 1.3.8
 */
function agama_widget_about_register() {
    
    register_widget( 'agama_widget_about' );
    
}
add_action( 'widgets_init', 'agama_widget_about_register' );

/**
 * About Widget
 *
 * @since 1.3.8
 */
class Agama_Widget_About extends WP_Widget {
    
    /**
     * Register Wdiget with WordPress
     */
    function __construct() {
        
        if( is_customize_preview() ) {
            $widgetName = esc_html__( 'About', 'agama' );
        } else {
            $widgetName = esc_html__( 'Agama: About', 'agama' );
        }
        
        parent::__construct( 'agama_widget_about', $widgetName, array(
            'classname' => 'agama-widget-about agama-widget',
            'description' => esc_html__( 'Agama About Section widget.', 'agama' ),
            'customize_selective_refresh' => true
        ) );
        
        add_action( 'wp_enqueue_scripts', [ $this, 'inline_css' ] );
    }
    
    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
        extract( $args );
        
        $title          = isset( $instance['title'] ) ? wp_kses_post( $instance['title'] ) : 'LOREM IPSUM';
        $subtitle       = isset( $instance['subtitle'] ) ? wp_kses_post( $instance['subtitle'] ) : esc_html__( 'a little about..', 'agama' );
        $content        = isset( $instance['content'] ) ? apply_filters( 'wp_editor_widget_content', $instance['content'] ) : '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus mollis est ut neque tempus, id venenatis purus suscipit. Integer egestas ut orci sit amet interdum. Cras egestas erat vel enim dapibus egestas. Quisque at orci vel lectus consectetur congue et vel nulla. Nulla facilisi. Curabitur consequat efficitur magna ut cursus.</p>';
        $divider        = isset( $instance['divider'] ) ? esc_html( $instance['divider'] ) : 'fa-stop';
        $title_color    = isset( $instance['title_color'] ) ? esc_html( $instance['title_color'] ) : '#222222';
        $content_color  = isset( $instance['content_color'] ) ? esc_html( $instance['content_color'] ) : '#a8b4bf';
        $content_bg     = isset( $instance['content_bg'] ) ? esc_html( $instance['content_bg'] ) : '#ffffff';
        
        echo $before_widget;
        
            $wrapper = '';
        
            if( is_customize_preview() ) {
                echo '<span class="widget-name">'. esc_html( $this->name ) .'</span>';
            }
            
            // Inner Wrapper
            echo '<div class="about-inner-wrapper">';
        
                if( is_page_template( 'page-templates/template-fluid.php' ) ) {
                    echo '<div class="tv-container">';
                }
                
                    // Sub Title
                    if( ! empty( $subtitle ) ) {
                        echo '<span class="about-subtitle">'. $subtitle .'</span>';
                    }

                    // Title
                    if( ! empty( $title ) ) {
                        echo '<h2 class="about-title">'. $title .'</h2>';
                    }

                    // Divider
                    if( $divider !== 'none' ) {
                        $divider == 'underline' ? $underline = ' title-underline' : $underline = '';
                        echo '<div class="agama-divider'. esc_attr( $underline ) .'">';
                            echo '<span class="agama-divider-left"></span><span class="agama-divider-middle"><i class="fa '. $divider .'"></i></span><span class="agama-divider-right"></span>';
                        echo '</div>';
                    }

                    // Content
                    if( ! empty( $content ) ) {
                        echo '<div class="about-content">';
                            echo do_shortcode( $content );
                        echo '</div>';
                    }
        
                if( is_page_template( 'page-templates/template-fluid.php' ) ) {
                    echo '</div>';   
                }
        
            echo '</div>';
        
        echo $after_widget;
    }
    
    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        $defaults = array(
		  'title'         => 'LOREM IPSUM',
		  'subtitle'      => esc_html__( 'a little about..', 'agama' ),
		  'content'       => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus mollis est ut neque tempus, id venenatis purus suscipit. Integer egestas ut orci sit amet interdum. Cras egestas erat vel enim dapibus egestas. Quisque at orci vel lectus consectetur congue et vel nulla. Nulla facilisi. Curabitur consequat efficitur magna ut cursus.',
		  'divider'       => 'fa-stop',
		  'title_color'   => '#222222',
		  'content_color' => '#a8b4bf',
		  'content_bg'    => '#ffffff',
		);
        
        $instance = wp_parse_args( ( array ) $instance, $defaults ); ?>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php esc_html_e( 'Subtitle:', 'agama' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo htmlspecialchars( $instance['subtitle'], ENT_QUOTES, "UTF-8" ); ?>" type="text" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'agama' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo htmlspecialchars( $instance['title'], ENT_QUOTES, "UTF-8" ); ?>" type="text" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php esc_html_e( 'Content:', 'agama' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr( $instance['content'] ); ?>" type="hidden" />
            <a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button edit-content-button"><?php esc_html_e( 'Edit content', 'agama' ) ?></a>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'divider' ); ?>"><?php esc_html_e( 'Title Divider:', 'agama' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'divider' ); ?>" name="<?php echo $this->get_field_name( 'divider' ); ?>" class="widefat">
            	<option value="underline"       <?php selected( 'underline', $instance['divider'] ); ?>><?php esc_html_e( 'Underline', 'agama' ); ?></option>
				<option value="fa-stop"         <?php selected( 'fa-stop', $instance['divider'] ); ?>><?php esc_html_e( 'Rhombus', 'agama' ); ?></option>
				<option value="fa-star"         <?php selected( 'fa-star', $instance['divider'] ); ?>><?php esc_html_e( 'Star', 'agama' ); ?></option>
                <option value="fa-times"        <?php selected( 'fa-times', $instance['divider'] ); ?>><?php esc_html_e( 'Cross', 'agama' ); ?></option>
				<option value="fa-bolt"         <?php selected( 'fa-bolt', $instance['divider'] ); ?>><?php esc_html_e( 'Bolt', 'agama' ); ?></option>
				<option value="fa-asterisk"     <?php selected( 'fa-asterisk', $instance['divider'] ); ?>><?php esc_html_e( 'Asterisk', 'agama' ); ?></option>
                <option value="fa-chevron-down" <?php selected( 'fa-chevron-down', $instance['divider'] ); ?>><?php esc_html_e( 'Chevron', 'agama' ); ?></option>
				<option value="fa-heart"        <?php selected( 'fa-heart', $instance['divider'] ); ?>><?php esc_html_e( 'Heart', 'agama' ); ?></option>
				<option value="fa-plus"         <?php selected( 'fa-plus', $instance['divider'] ); ?>><?php esc_html_e( 'Plus', 'agama' ); ?></option>
                <option value="fa-bookmark"     <?php selected( 'fa-bookmark', $instance['divider'] ); ?>><?php esc_html_e( 'Bookmark', 'agama' ); ?></option>
				<option value="fa-circle-o"     <?php selected( 'fa-circle-o', $instance['divider'] ); ?>><?php esc_html_e( 'Circle', 'agama' ); ?></option>
                <option value="fa-th-large"     <?php selected( 'fa-th-large', $instance['divider'] ); ?>><?php esc_html_e( 'Blocks', 'agama' ); ?></option>
				<option value="fa-minus"        <?php selected( 'fa-minus', $instance['divider'] ); ?>><?php esc_html_e( 'Sides', 'agama' ); ?></option>
				<option value="fa-cog"          <?php selected( 'fa-cog', $instance['divider'] ); ?>><?php esc_html_e( 'Cog', 'agama' ); ?></option>
                <option value="fa-reorder"      <?php selected( 'fa-reorder', $instance['divider'] ); ?>><?php esc_html_e( 'Blinds', 'agama' ); ?></option>
                <option value="none"            <?php selected( 'none', $instance['divider'] ); ?>><?php esc_html_e( 'Hide Divider', 'agama' ); ?></option>
			</select>
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'title_color' ); ?>"><?php esc_html_e( 'Title Color', 'agama' ) ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'title_color' ); ?>" name="<?php echo $this->get_field_name( 'title_color' ); ?>" value="<?php echo esc_attr( $instance['title_color'] ); ?>" type="text" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'content_color' ); ?>"><?php esc_html_e( 'Text Color', 'agama' ) ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_color' ); ?>" name="<?php echo $this->get_field_name( 'content_color' ); ?>" value="<?php echo esc_attr( $instance['content_color'] ); ?>" type="text" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'content_bg' ); ?>"><?php esc_html_e( 'Background Color', 'agama' ) ?></label>
			<input class="widefat color-picker" id="<?php echo $this->get_field_id( 'content_bg' ); ?>" name="<?php echo $this->get_field_name( 'content_bg' ); ?>" value="<?php echo esc_attr( $instance['content_bg'] ); ?>" type="text" />
		</p>
        

    <?php
    }
    
    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        
        $instance['title']         = wp_kses_post( $new_instance['title'] );
        $instance['subtitle']      = wp_kses_post( $new_instance['subtitle'] );
		$instance['content']       = wp_kses_post( $new_instance['content'] );
		$instance['divider']       = wp_kses_post( $new_instance['divider'] );
		$instance['title_color']   = sanitize_hex_color( $new_instance['title_color'] );
		$instance['content_color'] = sanitize_hex_color( $new_instance['content_color'] );
		$instance['content_bg']    = sanitize_hex_color( $new_instance['content_bg'] );

		return $instance;
	}
    
    /**
     * Enqueue Widget CSS
     */
    public function inline_css() {
        $settings = get_option( $this->option_name );
        
        if ( empty( $settings ) ) {
			return;
		}
        
        foreach ( $settings as $instance_id => $instance ) {
			$id = $this->id_base . '-' . $instance_id;

			if ( ! is_active_widget( false, $id, $this->id_base ) ) {
				continue;
			}
			
			if ( ! empty( $instance['content_bg'] ) ) {
				$content_bg = 'background-color:' . esc_html( $instance['content_bg'] ) . '!important;';
			}
			
            if ( ! empty( $instance['title_color'] ) ) {
				$title_color = esc_html( $instance['title_color'] ) . '!important;';
			}
			
            if ( ! empty( $instance['content_color'] ) ) {
				$content_color = 'color:' . esc_html( $instance['content_color'] ) . '!important;';
			}
            
            $widget_style  = '#'. $id .'{'. $content_bg .'}';
            $widget_style .= '#'. $id .' .about-title, #'. $id .' .about-subtitle, #'. $id .' span.agama-divider-middle{color:'. $title_color .'}';
            $widget_style .= '#'. $id .' span.agama-divider-left, #'. $id .' span.agama-divider-right{background-color:'. $title_color .'}';
            $widget_style .= '#'. $id .' .about-content{'. $content_color .'}';
			
            wp_add_inline_style( 'agama-style', $widget_style );
        }
        
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
