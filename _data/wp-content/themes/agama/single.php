<?php
/**
 * The Template for displaying all single posts
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>

    <?php if( 'left' == agama_sidebar_position() ): ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>

	<div id="primary" class="site-content <?php echo esc_attr( Agama::bs_class() ); ?>">
	
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php if( get_theme_mod( 'agama_blog_single_post_thumbnail', true ) ): ?>
                    <?php if ( ! post_password_required() && ! is_attachment() && get_the_post_thumbnail() && ! is_search() ): ?>
                        <header class="entry-header">
                            <figure class="hover1">
                                <img src="<?php echo agama_return_image_src('agama-blog-large'); ?>" class="img-responsive">
                            </figure>
                        </header>
                     <?php endif; ?>
				<?php endif; ?>

				<div class="article-entry-wrapper">

					<?php if ( is_sticky() && is_home() && ! is_paged() ) { // Sticky post ?>
						<div class="featured-post">
							<?php _e( 'Featured post', 'agama' ); ?>
						</div>
					<?php } ?>
					
					<?php do_action( 'agama_blog_post_date_and_format' ); ?>
					
					<div class="entry-content">
					   
                        <?php if( ! get_theme_mod( 'agama_breadcrumb', false ) ): ?>
				            <h1 class="entry-title"><?php the_title(); ?></h1>
                        <?php endif; ?>
						
						<?php do_action( 'agama_blog_post_meta' ); ?>

						<?php the_content(); ?>
						
                        <?php if( get_the_tags() ): ?>
						<!-- Tags -->
						<div class="tagcloud tv-d-flex bottommargin">
							<i class="fa fa-tags"></i> <?php the_tags( false, false, false ); ?>
						</div><!-- Tags End -->
                        <?php endif; ?>
                        
                        <?php do_action( 'agama_social_share' ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'agama' ), 'after' => '</div>' ) ); ?>
						
					</div>
					
					<!-- Content Footer -->
					<footer class="entry-meta">
						
						<?php edit_post_link( __( '<i class="fa fa-edit"></i> Edit', 'agama' ), '<span class="edit-link">', '</span>' ); ?>
						
						<?php Agama::about_author(); ?>
						
					</footer><!-- .entry-meta -->
					
				</div>
				
				<?php Agama::post_prev_next_links(); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>
	</div>

    <?php if( 'right' == agama_sidebar_position() ): ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>

<?php get_footer(); ?>