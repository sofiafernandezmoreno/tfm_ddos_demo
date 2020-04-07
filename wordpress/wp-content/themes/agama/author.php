<?php
/**
 * The template for displaying Author Archive pages
 *
 * Used to display archive-type pages for posts by an author.
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

    <!-- Primary -->
	<section id="primary" class="site-content <?php echo esc_attr( Agama::bs_class() ); ?>">
	
		
		
		<?php if( get_theme_mod('agama_blog_layout', 'list') == 'grid' ) {
                
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
                
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
                
                agama_content_nav( 'nav-above' );
                
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php
					/**
					 * Filter the author bio avatar size.
					 *
					 * @since Agama 1.0
					 *
					 * @param int $size The height and width of the avatar in pixels.
					 */
					$author_bio_avatar_size = apply_filters( 'agama_author_bio_avatar_size', 68 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2><?php printf( esc_html__( 'About %s', 'agama' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>
			<?php } ?>
		
        <!-- Content -->
		<div id="content" role="main" <?php if( get_theme_mod('agama_blog_layout', 'list') == 'grid' && ! is_singular() ): ?>class="js-isotope"  data-isotope-options='{ "itemSelector": ".article-wrapper" }'<?php endif; ?>>
		<?php if ( have_posts() ) : ?>
			<?php if( get_theme_mod('agama_blog_layout', 'list') != 'grid' ) { 
                
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
                
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
    
                agama_content_nav( 'nav-above' );
                
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php
					/**
					 * Filter the author bio avatar size.
					 *
					 * @since Agama 1.0
					 *
					 * @param int $size The height and width of the avatar in pixels.
					 */
					$author_bio_avatar_size = apply_filters( 'agama_author_bio_avatar_size', 68 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h2><?php printf( esc_html__( 'About %s', 'agama' ), get_the_author() ); ?></h2>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>
			<?php } ?>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- Content End -->
        
        <?php agama_content_nav( 'nav-below' ); ?>
        <?php Agama_Helper::get_infinite_scroll_load_more_btn(); ?>
        
	</section><!-- Primary End -->

    <?php if( 'right' == agama_sidebar_position() ): ?>
        <?php get_sidebar(); ?>
    <?php endif; ?>

<?php get_footer(); ?>
