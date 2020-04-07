<?php 
/**
 * The main template file
 *
 * @package Theme-Vision
 * @subpackage Agama Blue
 * @since 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

global $wp_query; ?>

<?php get_header(); ?>

<?php if( get_theme_mod( 'agama_blue_blog', true ) ): ?>

    <div class="section notopmargin notopborder section-blog">
        <div class="container clearfix">
            <div class="heading-block center nomargin">
                <h3><?php echo esc_html( get_theme_mod( 'agama_blue_blog_heading', __( 'Latest from the Blog', 'agama-blue' ) ) ); ?></h3>
            </div>
        </div>
    </div>

    <div class="container container-blog clear-bottommargin clearfix">
        <div id="content" class="tv-row">

            <?php if ( have_posts() ): while ( have_posts() ): the_post(); ?>

                    <div class="article-wrapper tv-col-md-3 tv-col-sm-6 bottommargin">
                        <div class="ipost clearfix">

                            <?php if( has_post_thumbnail() ): ?>
                            <div class="entry-image">
                                <a href="<?php the_permalink(); ?>">
                                    <img class="image_fade" src="<?php echo agama_return_image_src('agama-blog-small'); ?>" alt="<?php the_title(); ?>">
                                </a>
                            </div>
                            <?php endif; ?>

                            <div class="entry-title">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            </div>
                            <ul class="entry-meta clearfix">
                                <li><i class="fa fa-calendar"></i> <?php echo get_the_time('d M, Y'); ?></li>
                                <li><a href="<?php echo get_comments_link(); ?>"><i class="fa fa-comments"></i> <?php echo get_comments_number(); ?></a></li>
                            </ul>
                        </div>
                    </div>

                <?php endwhile; ?>

                <?php if( $wp_query->max_num_pages > 1 ): ?>
                    <nav id="nav-below" class="navigation tv-col-md-12" role="navigation">
                        <h2 class="assistive-text"><?php esc_html_e( 'Post navigation', 'agama' ); ?></h2>
                        <div class="nav-previous">
                            <?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'agama-blue' ) ); ?>
                        </div>
                        <div class="nav-next">
                            <?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'agama-blue' ) ); ?>
                        </div>
                    </nav>
                <?php endif; ?>
                
                <?php wp_reset_query(); ?>

            <?php endif; ?>

        </div>
        
        <?php Agama_Helper::get_infinite_scroll_load_more_btn(); ?>
        
    </div>

<?php endif; ?>

<?php get_footer(); ?>
