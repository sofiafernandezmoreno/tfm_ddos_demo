<?php
/**
 * Template Name: Template Full Width
 *
 * @package Theme Vision
 * @subpackage Agama
 * @since 1.0.0
 */

get_header(); ?>
	
	<div id="primary" class="site-content tv-container tv-p-0">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); $widget = 'page-widget-' . esc_attr( get_the_ID() ); ?>
            
                <?php if( is_active_sidebar( $widget ) ): ?>
                
                    <?php dynamic_sidebar( $widget ); ?>
            
                    <?php do_action( 'agama_add_widget', get_the_ID() ); ?>
            
                <?php else: ?>
				    
                    <?php get_template_part( 'content', 'page' ); ?>
				    
                    <?php if( comments_open() ) : ?>
				        <?php comments_template( '', true ); ?>
                    <?php endif; ?>
            
                <?php endif; ?>
            
            
			<?php endwhile; // end of the loop. ?>

		</div>
	</div>

<?php get_footer(); ?>