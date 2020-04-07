<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$is_sticky              = is_sticky() && is_home() && ! is_paged();
$search_post_thumbnails = esc_attr( get_theme_mod( 'agama_search_page_thumbnails', '' ) );
$has_post_thumbnail     = has_post_thumbnail() && ! is_search() || 
                          is_search() && has_post_thumbnail() && $search_post_thumbnails; ?>

	<?php if ( $has_post_thumbnail ): ?>
	<header class="entry-header">
		<figure class="hover1">
			<?php if( get_theme_mod( 'agama_blog_thumbnails_permalink', true ) ): ?>
            <a href="<?php the_permalink(); ?>">
                 <img src="<?php echo agama_return_image_src('agama-blog-large'); ?>" class="img-responsive">
            </a>
			<?php else: ?>
				<img src="<?php echo agama_return_image_src('agama-blog-large'); ?>" class="img-responsive">
            <?php endif; ?>
		</figure>
	</header>
	<?php endif; ?>

	<div class="article-entry-wrapper">

		<?php if ( $is_sticky ):  ?>
        <div class="featured-post">
            <?php _e( 'Featured post', 'agama' ); ?>
        </div>
		<?php endif; ?>
		
		<?php do_action( 'agama_blog_post_date_and_format' ); ?>
		
		<div class="entry-content">
			
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			
			<?php do_action( 'agama_blog_post_meta' ); ?>
			
			<?php the_excerpt(); ?>
				
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'agama' ), 'after' => '</div>' ) ); ?>
		</div>
		
		<!-- Content Footer -->
		<footer class="entry-meta">
			<?php edit_post_link( __( '<i class="fa fa-edit"></i> Edit', 'agama' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</div>