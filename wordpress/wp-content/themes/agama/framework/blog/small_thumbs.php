<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

$search_post_thumbnails = esc_attr( get_theme_mod( 'agama_search_page_thumbnails', '' ) );
$has_post_thumbnail     = has_post_thumbnail() && ! is_search() || 
                          is_search() && has_post_thumbnail() && $search_post_thumbnails; ?>

<!-- Small Thumbs -->
<div class="small-thumbs">

	 <div class="entry">
		
		<?php if( $has_post_thumbnail ): ?>
		<div class="entry-image">
		
			<?php if( get_theme_mod( 'agama_blog_thumbnails_permalink', true ) ): ?>
				<a href="<?php the_permalink(); ?>">
                    <img class="image_fade img-responsive image-grow" src="<?php echo agama_return_image_src('agama-blog-small'); ?>" alt="<?php the_title(); ?>">
                </a>
			<?php else: ?>
				<img class="image_fade img-responsive image-grow" src="<?php echo agama_return_image_src('agama-blog-small'); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
			
		</div>
		<?php endif; ?>
		
		<div class="entry-c">
			
			<!-- Entry Title -->
			<div class="entry-title">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			</div><!--.entry-title-->
			
			<?php if( get_theme_mod( 'agama_blog_post_meta', true ) ): ?>
			<!-- Entry Meta -->
			<ul class="entry-meta tv-d-flex">
				
				<?php if( get_theme_mod( 'agama_blog_post_author', true ) ): ?>
				<li><a href="<?php the_author_link(); ?>"><i class="fa fa-user"></i> <?php the_author(); ?></a></li>
				<?php endif; ?>
				
				<?php if( get_theme_mod( 'agama_blog_post_date', true ) ): ?>
				<li><i class="fa fa-calendar"></i> <?php the_time('m, Y'); ?></li>
				<?php endif; ?>

				<?php if( get_theme_mod( 'agama_blog_post_category', true ) ): ?>
				<li><i class="fa fa-folder-open"></i> <?php echo get_the_category_list(', '); ?></li>
				<?php endif; ?>
				
				<?php if( get_theme_mod( 'agama_blog_post_comments', true ) ): ?>
				<li><a href="<?php the_permalink(); ?>#comments"><i class="fa fa-comments"></i> <?php echo Agama::comments_count(); ?></a></li>
				<?php endif; ?>

			</ul><!--.entry-meta-->
			<?php endif; ?>
			
			<!-- Entry Content -->
			<div class="entry-content">
				
				<?php the_excerpt(); ?>

			</div><!--.entry-content -->
			
		</div>
	
	</div>

</div><!--.small_thumbs-->