<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Theme-Vision
 * @subpackage Agama
 * @since Agama 1.0
 */

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
} ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( ! is_page_template( 'page-templates/front-page.php' ) ) : ?>
			<?php the_post_thumbnail(); ?>
			<?php endif; ?>
			<?php if( ! is_front_page() && ! get_theme_mod( 'agama_breadcrumb', false ) ): ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php endif; ?>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'agama' ), 'after' => '</div>' ) ); ?>
		</div>
        
        <?php do_action( 'agama_social_share' ); ?>
        
		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'agama' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</article>
