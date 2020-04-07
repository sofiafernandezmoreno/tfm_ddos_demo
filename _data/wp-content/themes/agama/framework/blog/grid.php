<?php 

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} 

$search_post_thumbnails = esc_attr( get_theme_mod( 'agama_search_page_thumbnails', '' ) );
$has_post_thumbnail     = ! post_password_required() && ! is_attachment() && get_the_post_thumbnail() && ! is_search() || 
                          is_search() && has_post_thumbnail() && $search_post_thumbnails; ?>

<header class="entry-header">
	<?php if( $has_post_thumbnail ): ?>
		<figure class="hover1">
			<?php if( get_theme_mod( 'agama_blog_thumbnails_permalink', true ) ): ?>
            <a href="<?php the_permalink(); ?>">
                 <img src="<?php echo agama_return_image_src('post-thumbnail'); ?>" class="img-responsive">
            </a>
			<?php else: ?>
                <img src="<?php echo agama_return_image_src('post-thumbnail'); ?>" class="img-responsive">
            <?php endif; ?>
		</figure>
	<?php endif; ?>
	
	<h1 class="entry-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h1>
	
	<?php do_action( 'agama_blog_post_meta' ); ?>
</header>

    <?php if( ! is_sticky() ): ?>
	<div class="entry-sep"></div>
    <?php endif; ?>

<div class="article-entry-wrapper">

	<?php if ( is_sticky() && is_home() && ! is_paged() ) { // Sticky post ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'agama' ); ?>
		</div>
	<?php } ?>
	
	<div class="entry-content">
		<?php the_excerpt(); ?>
			
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'agama' ), 'after' => '</div>' ) ); ?>
	</div>
	
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'agama' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>

</div>