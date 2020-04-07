<?php
/**
 * Filters
 *
 * The Agama theme static filters class.
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.5.0
 */

namespace Agama;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Filters {
    
    /**
     * Instance
     *
     * Single instance of this object.
     *
     * @since 1.5.0
     * @access public
     * @return null|object
     */
    public static $instance = null;
    
    /**
     * Get Instance
     *
     * Access the single instance of this class.
     *
     * @since 1.5.0
     * @access public
     * @return object
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     *
     * The filter class constructor.
     *
     * @since 1.5.0
     * @access public
     * @return void
     */
    public function __construct() {
        
        add_filter( 'wp_page_menu_args', [ $this, 'page_menu_args' ] );
        add_filter( 'body_class', [ $this, 'body_class' ] );
        add_filter( 'excerpt_length', [ $this, 'excerpt_length' ], 999 );
        add_filter( 'excerpt_more', [ $this, 'excerpt_more' ] );
        add_filter( 'edit_post_link', [ $this, 'edit_post_link' ] );
        add_filter( 'previous_posts_link_attributes', [ $this, 'previous_posts_link_attributes' ] );
        add_filter( 'next_posts_link_attributes', [ $this, 'next_posts_link_attributes' ] );
        add_filter( 'edit_comment_link', [ $this, 'edit_comment_link' ] );
        add_filter( 'comment_form_default_fields', [ $this, 'comment_form_default_fields' ] );
        add_filter( 'comment_form_defaults', [ $this, 'comment_form_defaults' ] );
        
    }
    
    /**
     * Page Menu Args
     *
     * Filter the page menu arguments.
     * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public function page_menu_args( $args ) {
        if ( ! isset( $args['show_home'] ) )
            $args['show_home'] = true;
        return $args;
    }
    
    /**
     * Body Class
     *
     * Extend the default WordPress body classes.
     *
     * @param array $classes (required) The existing class values.
     *
     * @since 1.0.0
     * @since 1.5.0 Updated the code.
     * @return array Filtered class values.
     */
    public function body_class( $classes ) {
        $background_color = esc_attr( get_background_color() );
        $background_image = esc_url( get_background_image() );
        $header 		  = esc_attr( get_theme_mod( 'agama_header_style', 'transparent' ) );
        $sidebar_position = esc_attr( get_theme_mod( 'agama_sidebar_position', 'right' ) );
        $blog_layout 	  = esc_attr( get_theme_mod('agama_blog_layout', 'list') );

        if( is_customize_preview() ) {
            $classes[] = 'customize-preview';
        }

        if( is_404() ) {
            $classes[] = 'vision-404';
        }

        // Header class.
        switch( $header ) {
            case 'transparent':
                $classes[] = 'header_v1';
            break;
            case 'default':
                $classes[] = 'header_v2';
            break;
            case 'sticky':
                $classes[] = 'header_v3 sticky_header';
            break;
        }

        // Sidebar position class.
        if( $sidebar_position == 'left' ) {
            $classes[] = 'sidebar-left';
        }

        // Blog layout class.
        switch( $blog_layout ) {
            case 'small_thumbs':
                $classes[] = 'blog-small-thumbs';
            break;
            case 'grid':
                $classes[] = 'blog-grid';
            break;
        }

        // Template full-width class.
        if( is_page_template( 'page-templates/template-full-width.php' ) ) { 
            $classes[] = 'template-full-width'; 
        }

        // Template fluid class.
        if( is_page_template( 'page-templates/template-fluid.php' ) ) { 
            $classes[] = 'template-fluid'; 
        }

        // Template empty class.
        if( is_page_template( 'page-templates/template-empty.php' ) ) {
            $classes[] = 'template-empty';
        }

        // Apply empty background class.
        if ( empty( $background_image ) ) {
            if ( empty( $background_color ) )
                $classes[] = 'custom-background-empty';
            elseif ( in_array( $background_color, [ 'fff', 'ffffff' ] ) )
                $classes[] = 'custom-background-white';
        }

        // Single author class.
        if ( ! is_multi_author() )
            $classes[] = 'single-author';

        return $classes;
    }
    
    /**
     * Excerpt Lenght
     *
     * Filters the maximum number of words in a post excerpt.
     *
     * @param num $length (required) The maximum number of words. Default 55.
     *
     * @since 1.0.0
     * @since 1.5.0 Updated the code.
     * @access public
     * @return num
     */
    public function excerpt_length( $length ) {
        $custom = esc_attr( get_theme_mod( 'agama_blog_excerpt', '60' ) );
        return $length = intval( $custom );
    }
    
    /**
     * Excerpt More
     *
     * Filters the string in the “more” link displayed after a trimmed excerpt.
     *
     * @param string $more_string (required) The string shown within the more link.
     *
     * @since 1.1.1
     * @since 1.5.0 Updated the code.
     * @access public
     * @return string
     */
    public function excerpt_more( $more_string ) {
        global $post;
        
        if( get_theme_mod( 'agama_blog_readmore_url', true ) ) {
            return sprintf(
                '<br><br><a class="more-link" href="%s">%s</a>', 
                esc_url( get_permalink( $post->ID ) ), 
                esc_html__( 'Read More', 'agama' )
            );
        }
        
        return;
    }
    
    /**
     * Edit Post Link
     *
     * Filters the post edit link anchor tag.
     *
     * @param mixed $link (required) Anchor tag for the edit link.
     *
     * @since 1.1.1
     * @since 1.5.0 Updated the code.
     * @access public
     * @return string
     */
    public function edit_post_link( $link ) {
        $link = str_replace('class="post-edit-link"', 'class="button button-3d button-mini button-rounded"', $link );
        return $link;
    }
    
    /**
     * Previous Posts Link Attributes
     *
     * Filters the anchor tag attributes for the previous posts page link.
     *
     * @since 1.3.7
     * @access public
     * @return string
     */
    public function previous_posts_link_attributes() {
        return 'class="prev"';
    }
    
    /**
     * Next Posts Link Attributes
     *
     * Filters the anchor tag attributes for the next posts page link.
     *
     * @since 1.3.7
     * @access public
     * @return string
     */
    public function next_posts_link_attributes() {
        return 'class="next"';
    }
    
    /**
     * Edit Comment Link
     *
     * Filters the comment edit link anchor tag.
     *
     * @param mixed $link (required) Anchor tag for the edit link.
     *
     * @since 1.1.1
     * @since 1.5.0 Updated the code.
     * @access public
     * @return string
     */
    public function edit_comment_link( $link ) {
        $link = str_replace( 'class="comment-edit-link"', 'class="button button-3d button-mini button-rounded"', $link );
        return $link;
    }
    
    /**
     * Comment Form Default Fields
     *
     * Filters the default comment form fields.
     *
     * @param array $fields (required) Array of the default comment fields.
     *
     * @since 1.2.4
     * @access public
     * @return mixed
     */
    public function comment_form_default_fields( $fields ) {

        // Get the current commenter if available
        $commenter = wp_get_current_commenter();

        // Core functionality
        $req      = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $html_req = ( $req ? " required='required'" : '' );

        $fields['author']	= '<div class="tv-col-md-4"><label for="author">' . __( 'Name', 'agama' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" class="sm-form-control"' . $aria_req . ' /></div>';
        $fields['email'] 	= '<div class="tv-col-md-4"><label for="email">' . __( 'Email', 'agama' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" class="sm-form-control"' . $aria_req . ' /></div>';
        $fields['url'] 		= '<div class="tv-col-md-4"><label for="url">' . __( 'Website', 'agama' ) . '</label><input id="url" name="url" type="text" value="' . esc_url( $commenter['comment_author_url'] ) . '" class="sm-form-control" /></div>';

        return $fields;
    }
    
    /**
     * Comment Form Defaults
     *
     * Filters the comment form default arguments.
     *
     * @param array $defaults (required) The default comment form arguments.
     *
     * @since 1.2.4
     * @access public
     * @return mixed
     */
    function comment_form_defaults( $defaults ) {
        global $current_user;

        $defaults['logged_in_as'] = '<div class="tv-col-md-12 logged-in-as">' . sprintf(	'%s <a href="%s">%s</a>. <a href="%s" title="%s">%s</a>', __('Logged in as', 'agama'), admin_url( 'profile.php' ), $current_user->display_name, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ), __('Log out of this account', 'agama'), __('Log out?', 'agama') ) . '</div>';
        $defaults['comment_field'] = '<div class="tv-col-md-12"><label for="comment">' . __( 'Comment', 'agama' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" class="sm-form-control"></textarea></div>';

        // HTML Tags Usage Suggestion
        if( get_theme_mod( 'agama_comments_tags_suggestion', true ) ) {
            $defaults['comment_notes_after'] = '<div class="tv-col-md-12" style="margin-top: 15px; margin-bottom: 15px;">' . sprintf( '%s <abbr title="HyperText Markup Language">HTML</abbr> %s: %s', __( 'You may use these', 'agama' ), __( 'tags and attributes', 'agama' ), '<code>' . allowed_tags() . '</code>') . '</div>';
        }

        $defaults['title_reply']	= sprintf( '%s <span>%s</span>', __( 'Leave a', 'agama' ), __( 'Comment', 'agama' ) );
        $defaults['class_submit']	= 'button button-3d button-large button-rounded';

        return $defaults;
    }
    
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
